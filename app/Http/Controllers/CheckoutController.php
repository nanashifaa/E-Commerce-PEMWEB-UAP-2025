<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index($slug)
    {
        $product = Product::with(['productImages', 'store'])->where('slug', $slug)->firstOrFail();
        return view('checkout.index', compact('product'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'product_id'     => 'required',
            'address'        => 'required|string',
            'city'           => 'required|string',
            'postal_code'    => 'required|string',
            'shipping_type'  => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        $shipping_cost = $request->shipping_type === 'express' ? 20000 : 10000;

        $subtotal = $product->price;
        $grand_total = $subtotal + $shipping_cost;

        $address_id = 'ADDR-' . strtoupper(Str::random(6));
        $payment_status = $request->payment_method === 'wallet' ? 'paid' : 'unpaid';

        $transaction = Transaction::create([
            'code'          => 'TRX-' . strtoupper(Str::random(10)),
            'buyer_id'      => Auth::id(),
            'store_id'      => $product->store_id,

            'address'       => $request->address,
            'address_id'    => $address_id,
            'city'          => $request->city,
            'postal_code'   => $request->postal_code,

            'shipping'      => 'Standard Courier',
            'shipping_type' => $request->shipping_type,
            'shipping_cost' => $shipping_cost,

            'tax'           => 0,
            'grand_total'   => $grand_total,
            'payment_status' => $payment_status,
        ]);

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id'     => $product->id,
            'qty'            => 1,
            'subtotal'       => $subtotal,
        ]);

        // ====== TAMBAHKAN ORDER UNTUK SELLER ======
        Order::create([
            'seller_id' => $product->store->user_id,
            'buyer_id'  => Auth::id(),
            'code'      => $transaction->code,
            'total'     => $grand_total,
            'status'    => 'pending',
        ]);

        if ($request->payment_method === 'wallet') {
            return redirect('/dashboard')->with('success', 'Pembayaran via wallet berhasil!');
        }

        if ($request->payment_method === 'va') {
            return redirect('/payment?trx=' . $transaction->id)
                    ->with('success', 'Silakan selesaikan pembayaran VA.');
        }

        return redirect('/dashboard')->with('success', 'Transaksi berhasil dibuat.');
    }
}
