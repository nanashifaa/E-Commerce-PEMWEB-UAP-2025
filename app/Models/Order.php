<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'transactions'; // WAJIB!

    protected $fillable = [
        'buyer_id',
        'store_id',
        'code',
        'address',          // ← TAMBAHKAN
        'address_id',       // ← TAMBAHKAN
        'city',             // ← TAMBAHKAN
        'postal_code',      // ← TAMBAHKAN
        'shipping',         // ← TAMBAHKAN
        'shipping_type',    // ← TAMBAHKAN
        'shipping_cost',    // ← TAMBAHKAN
        'tax',              // ← TAMBAHKAN
        'grand_total',
        'payment_status',
        'tracking_number',  // ← OPTIONAL
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
