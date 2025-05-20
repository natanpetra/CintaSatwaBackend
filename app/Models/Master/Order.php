<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\User;

class Order extends Model
{
    protected $fillable = [
        'user_id', 
        'total_price', 
        'status', 
        'created_at', 
        'updated_at'
    ];

    // Relasi ke OrderItem
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}