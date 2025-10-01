<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens; // PERBAIKI: huruf kecil 'l' jadi 'L'
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, InteractsWithMedia, HasApiTokens; // TAMBAHKAN: HasApiTokens

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'fcm_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_photo')
            ->singleFile();
    }

    /**
     * Get the user's role.
     *
     * @return string
     */
    public function getRoleStringAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Admin',
            'tenant_manager' => 'Pengelola Kantin',
            'student' => 'Civitas',
            default => 'Tidak Dikenal',
        };
    }

    /**
     * Get all available role options for forms.
     *
     * @return array
     */
    public static function getRoleOptions(): array
    {
        return [
            'admin' => 'Admin',
            'tenant_manager' => 'Pengelola Kantin',
            'student' => 'Civitas',
        ];
    }

    /**
     * Route notifications for the WhatsApp channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForWhatsapp($notification)
    {
        return $this->phone;
    }

    public function tenant()
    {
        return $this->hasOne(Tenant::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'student_id');
    }

    /**
     * Get the cart items for the user (student)
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is tenant manager
     */
    public function isTenantManager(): bool
    {
        return $this->role === 'tenant_manager';
    }

    /**
     * Check if user is student
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }
}