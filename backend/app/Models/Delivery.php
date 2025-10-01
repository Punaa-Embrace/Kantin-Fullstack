<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'driver_id',
        'status',
        'current_latitude',
        'current_longitude',
        'current_address',
        'location_updated_at',
        'picked_up_at',
        'on_the_way_at',
        'arrived_at',
        'completed_at',
        'cancelled_at',
        'cancellation_reason'
    ];

    protected $casts = [
        'location_updated_at' => 'datetime',
        'picked_up_at' => 'datetime',
        'on_the_way_at' => 'datetime',
        'arrived_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function statusHistory()
    {
        return $this->hasMany(DeliveryStatusHistory::class);
    }

    public function locationHistory()
    {
        return $this->hasMany(DeliveryLocationHistory::class);
    }
}