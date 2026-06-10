<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'company_name',
        'job_title',
        'avatar',
        'logo',
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
    ];

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    public function isManager(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'manager']);
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function defaultBillingAddress()
    {
        return $this->hasMany(UserAddress::class)
            ->where('type', 'billing')
            ->where('is_default', 1)
            ->first();
    }

    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function courseAccesses()
    {
        return $this->hasMany(UserCourseAccess::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
