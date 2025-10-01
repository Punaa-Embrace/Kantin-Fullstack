<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Building extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name'];

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('building_images')
            ->singleFile();
    }
}
