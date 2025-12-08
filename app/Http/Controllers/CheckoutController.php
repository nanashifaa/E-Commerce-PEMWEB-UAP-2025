<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index($slug)
    {
        // Ambil product berdasarkan slug
        $product = Product::with(['store', 'productImages'])->where('slug', $slug)->firstOrFail();
        
        return view('checkout.index', compact('product'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'product_id'     => 'required',
            'address'        => 'required|string',
            'shipping_type'  => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        // SHIPPING COST SEDERHANA
        $shipping_cost = $request->shipping_type === 'express' ? 20000 : 10000;

        $subtotal = $product->price * 1;
        $grand_total = $subtotal + $shipping_cost;

        // TRANSACTION
        $transaction = Transaction::create([
            'code'           => 'TRX-' . strtoupper(Str::random(8)),
            'buyer_id'       => Auth::id(),
            'store_id'       => $product->store_id,

            'address'        => $request->address,
            'shipping_type'  => $request->shipping_type,
            'shipping_cost'  => $shipping_cost,

            'grand_total'    => $grand_total,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_method === 'wallet' ? 'paid' : 'pending',
        ]);

        // TRANSACTION DETAIL
        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id'     => $product->id,
            'qty'            => 1,
            'subtotal'       => $subtotal,
        ]);

        // PAYMENT FLOW
        if ($request->payment_method === 'wallet') {
            // Nanti dipotong di step selanjutnya
            return redirect('/dashboard')->with('success', 'Transaksi berhasil menggunakan saldo!');
        }

        if ($request->payment_method === 'va') {
            // Akan lanjut ke halaman input kode VA
            return redirect('/payment?trx=' . $transaction->id);
        }

        return redirect('/dashboard')->with('success', 'Transaksi berhasil.');
    }
}
