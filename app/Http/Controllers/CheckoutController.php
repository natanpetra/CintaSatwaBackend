<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\Order;
use App\Models\Master\OrderItem;
use App\Models\Master\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'user_id' => $request->user_id,
                'total_price' => $request->total_price,
                'status' => 'pending'
            ]);

            // Process items
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Check stock
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }

                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity']
                ]);

                // Update stock
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully',
                'order_id' => $order->id,
                'total_price' => $order->total_price
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Order processing failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function getOrderHistory($user_id)
    {
        $orders = Order::with('orderItems.product') // Eager load orderItems dan product
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function getOrderDetails($orderId)
    {
        $order = Order::with('items.product')->find($orderId);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $order
        ]);
    }
}