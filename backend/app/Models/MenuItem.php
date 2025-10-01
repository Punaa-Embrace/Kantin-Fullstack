<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MenuItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'tenant_id',
        'name',
        'description',
        'price',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_available' => 'boolean',
        ];
    }

    // Spatie Media Library collection for the menu item image
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('menu_item_photo')->singleFile();
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_menu_item');
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->price >= 1000) {
            return number_format($this->price / 1000, 0, ',', '.') . 'K';
        }
        return number_format($this->price, 0, ',', '.');
    }
}
