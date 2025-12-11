<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{

    protected $fillable = [
        'store_balance_id',
        'amount',
        'bank_account_name',
        'bank_account_number',
        'bank_name',
        'status',
    ];
    protected $table = 'withdrawals';
    
    public function storeBalance()
    {
        return $this->belongsTo(StoreBalance::class);
    }
}
