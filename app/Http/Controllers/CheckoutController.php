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

        // FIX: Manual Assignment to ensure all fields are saved (avoid mass assignment issues)
        $transaction = new Transaction();
        $transaction->code          = 'TRX-' . strtoupper(Str::random(10));
        $transaction->buyer_id      = Auth::id();
        $transaction->store_id      = $product->store_id;
        $transaction->address       = $request->address;
        $transaction->address_id    = $address_id;
        $transaction->city          = $request->city;
        $transaction->postal_code   = $request->postal_code;
        
        $transaction->shipping      = 'Standard Courier';
        $transaction->shipping_type = $request->shipping_type;
        $transaction->shipping_cost = $shipping_cost;
        
        $transaction->tax           = 0;
        $transaction->grand_total   = $grand_total;
        $transaction->payment_status = $payment_status;
        
        $transaction->save();

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id'     => $product->id,
            'qty'            => 1,
            'subtotal'       => $subtotal,
        ]);

        // ====== TAMBAHKAN ORDER UNTUK SELLER ======
        Order::create([
    'buyer_id'       => Auth::id(),
    'store_id'       => $product->store_id,
    'code'           => $transaction->code,
    'address'        => $request->address,
    'address_id'     => $address_id,
    'city'           => $request->city,
    'postal_code'    => $request->postal_code,
    'shipping'       => 'Standard Courier',
    'shipping_type'  => $request->shipping_type,
    'shipping_cost'  => $shipping_cost,
    'tax'            => 0,
    'grand_total'    => $grand_total,
    'payment_status' => $payment_status,
]);

       if ($request->payment_method === 'wallet') {

    // Kurangi saldo user (kalau mau)
    $user = auth()->user();
    if ($user->balance < $grand_total) {
        return back()->withErrors("Saldo tidak cukup untuk pembayaran.");
    }

    // KURANGI SALDO
    $user->balance -= $grand_total;
    $user->save();

    // SET STATUS TRANSAKSI MENJADI PAID
    $transaction->payment_status = 'paid';
    $transaction->save();

    return redirect('/checkout/success')->with('success', 'Pembayaran wallet berhasil!');
}


        if ($request->payment_method === 'va') {
            return redirect('/payment?trx=' . $transaction->id)
                    ->with('success', 'Silakan selesaikan pembayaran VA.');
        }
        
        return redirect('/dashboard')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function cartCheckout()
    {
        $carts = \App\Models\Cart::with(['product.store', 'product.productImages'])
                    ->where('user_id', Auth::id())
                    ->get();
        
        if($carts->isEmpty()) {
            return redirect()->route('cart.index')->withErrors('Keranjang masih kosong.');
        }

        $total = 0;
        foreach($carts as $c) {
            $total += $c->qty * $c->product->price;
        }

        return view('checkout.cart', compact('carts', 'total'));
    }

    public function processCart(Request $request)
    {
        $request->validate([
            'address'        => 'required|string',
            'city'           => 'required|string',
            'postal_code'    => 'required|string',
            'shipping_type'  => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $user = Auth::user();
        $carts = \App\Models\Cart::with(['product.store'])
                    ->where('user_id', $user->id)
                    ->get();

        if($carts->isEmpty()) {
            return redirect()->back()->withErrors('Keranjang kosong.');
        }

        // Hitung Grand Total (Subtotal produk + Ongkir per Toko??)
        // Simplifikasi: 1 Transaksi per Toko.
        
        $cartsByStore = $carts->groupBy(fn($cart) => $cart->product->store_id);
        $totalPaymentNeeded = 0;
        $transactionsCreated = [];

        // 1. Calculate Total first to check balance if Wallet
        foreach($cartsByStore as $storeId => $storeCarts) {
            $subtotalStore = 0;
            foreach($storeCarts as $c) {
                $subtotalStore += $c->qty * $c->product->price;
            }
            $shipping_cost = $request->shipping_type === 'express' ? 20000 : 10000;
            $totalPaymentNeeded += $subtotalStore + $shipping_cost;
        }

        if ($request->payment_method === 'wallet') {
            if ($user->balance < $totalPaymentNeeded) {
                return back()->withErrors("Saldo tidak cukup for total Rp " . number_format($totalPaymentNeeded));
            }
            $user->balance -= $totalPaymentNeeded;
            $user->save();
        }

        // 2. Process Transactions
        foreach($cartsByStore as $storeId => $storeCarts) {
            $subtotalStore = 0;
            foreach($storeCarts as $c) {
                $subtotalStore += $c->qty * $c->product->price;
            }
            $shipping_cost = $request->shipping_type === 'express' ? 20000 : 10000;
            $grand_total = $subtotalStore + $shipping_cost;

            $address_id = 'ADDR-' . strtoupper(Str::random(6));
            $payment_status = $request->payment_method === 'wallet' ? 'paid' : 'unpaid';

            $transaction = new Transaction();
            $transaction->code = 'TRX-' . strtoupper(Str::random(10));
            $transaction->buyer_id = $user->id;
            $transaction->store_id = $storeId;
            $transaction->address = $request->address;
            $transaction->address_id = $address_id;
            $transaction->city = $request->city;
            $transaction->postal_code = $request->postal_code;
            $transaction->shipping = 'Standard Courier';
            $transaction->shipping_type = $request->shipping_type;
            $transaction->shipping_cost = $shipping_cost;
            $transaction->tax = 0;
            $transaction->grand_total = $grand_total;
            $transaction->payment_status = $payment_status;
            $transaction->save();

            foreach($storeCarts as $c) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $c->product_id,
                    'qty'            => $c->qty,
                    'subtotal'       => $c->qty * $c->product->price,
                ]);
            }

             // Order untuk Seller
             Order::create([
    'buyer_id'       => $user->id,
    'store_id'       => $storeId,
    'code'           => $transaction->code,
    'address'        => $request->address,        // ← TAMBAHKAN
    'address_id'     => $address_id,              // ← TAMBAHKAN
    'city'           => $request->city,           // ← TAMBAHKAN
    'postal_code'    => $request->postal_code,    // ← TAMBAHKAN
    'shipping'       => 'Standard Courier',       // ← TAMBAHKAN
    'shipping_type'  => $request->shipping_type,  // ← TAMBAHKAN
    'shipping_cost'  => $shipping_cost,           // ← TAMBAHKAN
    'tax'            => 0,                        // ← TAMBAHKAN
    'grand_total'    => $grand_total,
    'payment_status' => $payment_status,
]);

            $transactionsCreated[] = $transaction->id;
        }

        // Clear Cart
        \App\Models\Cart::where('user_id', $user->id)->delete();

        if ($request->payment_method === 'va') {
            // Redirect to payment page of the FIRST transaction (simplification)
            // Or a bulk payment page? Given existing logic, let's just pick one or show success.
             return redirect('/payment?trx=' . $transactionsCreated[0])
                    ->with('success', 'Silakan selesaikan pembayaran VA.');
        }

        return redirect('/checkout/success')->with('success', 'Semua transaksi berhasil dibuat!');
    }
}
