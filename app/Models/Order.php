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
        'grand_total',
        'payment_status',
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
