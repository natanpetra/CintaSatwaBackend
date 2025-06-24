<?php

namespace App\Http\Controllers\History;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Master\Order;

class HistoryPurchaseController extends Controller
{
    private $route = 'history/history-purchase';
    private $routeView = 'history.history-purchase';
    private $params = [];

    public function __construct ()
    {
      $this->model = new Order();
      $this->params['route'] = $this->route;
      $this->params['routeView'] = $this->routeView;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // Load user dengan profile (untuk nomor telepon) dan orderItems dengan product
      $this->params['history'] = $this->model->with(['user.profile', 'orderItems.product'])->orderBy('created_at', 'desc')->get();
      return view($this->routeView . '.index', $this->params);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->params['model'] = $this->model;
        return view($this->routeView . '.create', $this->params);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Method ini tidak digunakan untuk pembelian
        // Pembelian dilakukan melalui API checkout
        return redirect($this->route);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->params['order'] = $this->model->with(['user.profile', 'orderItems.product'])->find($id);
        return view($this->routeView . '.show', $this->params);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->params['model'] = $this->model->find($id);
        return view($this->routeView . '.edit', $this->params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Method ini hanya untuk update status
        return $this->updateStatus($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $order = $this->model->find($id);
            
            if (!$order) {
                return response()->json(['message' => 'Order tidak ditemukan'], 404);
            }
            
            // Hapus order items terlebih dahulu
            $order->orderItems()->delete();
            
            // Hapus order
            $order->delete();
            
            DB::commit();
            return response()->json(['message' => 'Order berhasil dihapus'], 200);
            
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => 'Error: ' . $th->getMessage()], 500);
        }
    }

    /**
     * Update status order
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,completed,canceled',
        ]);

        try {
            $order = Order::findOrFail($id);
            $order->status = $request->status;
            $order->save();

            if ($request->ajax()) {
                return response()->json(['message' => 'Status berhasil diperbarui'], 200);
            }

            return back()->with('success', 'Status berhasil diperbarui.');
            
        } catch (\Throwable $th) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Error: ' . $th->getMessage()], 500);
            }
            
            return back()->with('error', 'Gagal memperbarui status: ' . $th->getMessage());
        }
    }

    /**
     * Search orders
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
      $where = "1=1";
      $response = [];

      if ($request->searchKey) {
        $where .= " and user_id IN (SELECT id FROM users WHERE name LIKE '%{$request->searchKey}%')";
      }

      try {
        $results = $this->model->with(['user.profile', 'orderItems.product'])
                   ->whereRaw($where)
                   ->get()
                   ->makeHidden(['created_at', 'updated_at']);

        $response['results'] = $results;
      } catch (\Exception $e) {
        return response(['message' => $e->getMessage()], 500);
      }

      return response()->json($response, 200);
    }

    /**
     * Search order by ID
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchById($id)
    {
      $order = $this->model->with(['user.profile', 'orderItems.product'])->find($id);
      return response()->json($order, 200);
    }

    /**
     * Export orders to PDF
     *
     * @return \Illuminate\Http\Response
     */
    public function exportPdf()
    {
        $orders = $this->model->with(['user.profile', 'orderItems.product'])->get();
        
        // Implementasi export PDF bisa ditambahkan di sini
        // Menggunakan library seperti DomPDF atau TCPDF
        
        return response()->json(['message' => 'Export PDF feature coming soon'], 200);
    }
}