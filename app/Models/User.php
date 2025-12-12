<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Store;
use App\Models\Product;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'balance', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'balance' => 'decimal:2',
        ];
    }

    public function transactions()
    {
        return $this->hasMany(\App\Models\Transaction::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMember()
    {
        return $this->role === 'member';
    }

    public function isSeller()
    {
        return $this->role === 'seller';
    }

    public function dashboardRedirectPath(): string
    {
        return match ($this->role) {
            'admin' => route('admin.dashboard'),
            'seller' => route('seller.dashboard'),
            default => route('home'),
        };
    }

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }
}
