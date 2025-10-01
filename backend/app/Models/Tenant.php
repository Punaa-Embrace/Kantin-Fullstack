<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tenant extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'building_id',
        'name',
        'slug',
        'description',
        'is_open',
    ];

    // Spatie Media Library collections for logo and QRIS
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
        $this->addMediaCollection('qris')->singleFile();
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}