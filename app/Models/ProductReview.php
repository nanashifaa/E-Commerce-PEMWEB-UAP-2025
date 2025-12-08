<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = [
        'transaction_id',
        'product_id',
        'rating',
        'review',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Tambahkan relasi user
    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Transaction::class,
            'id',            // transaction.id
            'id',            // users.id
            'transaction_id', // product_reviews.transaction_id
            'buyer_id'        // transactions.buyer_id
        );
    }
}
