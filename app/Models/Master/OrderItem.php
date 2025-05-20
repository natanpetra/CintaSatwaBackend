<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 
        'product_id', 
        'quantity', 
        'subtotal', 
        'created_at', 
        'updated_at'
    ];

    // Relasi ke Order
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke Product (jika ada model Product)
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}