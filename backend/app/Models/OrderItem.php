<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_item_id',
        'item_name',
        'price',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Original menu item, which could be null if deleted
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}