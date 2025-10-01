<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Order extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'order_code',
        'student_id',
        'tenant_id',
        'total_price',
        'payment_method',
        'payment_status',
        'order_status',
        'student_notes',
    ];

    // Spatie Media Library collection for payment proofs
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('payment_proof')->singleFile();
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}