<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreBalanceHistory extends Model
{
    protected $fillable = [
        'store_balance_id',
        'type',
        'amount',
        'remarks',
        'reference_type',
        'reference_id'
    ];

    public function storeBalance()
    {
        return $this->belongsTo(StoreBalance::class);
    }
}
