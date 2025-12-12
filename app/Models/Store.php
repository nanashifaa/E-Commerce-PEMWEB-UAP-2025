<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'about',
        'phone',
        'city',
        'address',
        'postal_code',
        'is_verified',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function balance()
    {
        return $this->hasOne(StoreBalance::class);
    }

    public function storeBalance()
    {
        return $this->hasOne(StoreBalance::class);
    }
}
