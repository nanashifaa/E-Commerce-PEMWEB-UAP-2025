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
    // ============================================================
    // SINGLE PRODUCT CHECKOUT
    // ============================================================

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

        // Create transaction
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
            'payment_status'=> $payment_status,
        ]);

        // Save detail
        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id'     => $product->id,
            'qty'            => 1,
            'subtotal'       => $subtotal,
        ]);


        // ============================================================
        // PAYMENT: WALLET
        // ============================================================

        if ($request->payment_method === 'wallet') {

            $user = auth()->user();

            if ($user->balance < $grand_total) {
                return back()->withErrors("Saldo tidak cukup untuk pembayaran.");
            }

            // Deduct wallet
            $user->balance -= $grand_total;
            $user->save();

            // Mark transaction as paid
            $transaction->update(['payment_status' => 'paid']);

            // ============= ADD STORE INCOME (FINAL FIX) =============
            $store = $transaction->store;
            $storeBalance = $store->storeBalance()->firstOrCreate(
                ['store_id' => $store->id], // FIX TERPENTING
                ['balance' => 0]
            );

            $storeBalance->increment('balance', $grand_total);

            $storeBalance->storeBalanceHistories()->create([
                'type'           => 'income',
                'amount'         => $grand_total,
                'remarks'        => 'Income from Transaction ' . $transaction->code,
                'reference_type' => 'transaction',
                'reference_id'   => $transaction->id
            ]);
            // =======================================================

            return redirect('/checkout/success')->with('success', 'Pembayaran wallet berhasil!');
        }

        // ============================================================
        // PAYMENT: VA
        // ============================================================

        if ($request->payment_method === 'va') {
            return redirect('/payment?trx=' . $transaction->id)
                ->with('success', 'Silakan selesaikan pembayaran VA.');
        }

        return redirect('/checkout/success')->with('success', 'Transaksi berhasil dibuat.');
    }


    // ============================================================
    // CART CHECKOUT (MULTI-TOKO SUPPORT)
    // ============================================================

    public function cartCheckout()
    {
        $carts = \App\Models\Cart::with(['product.store', 'product.productImages'])
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->withErrors('Keranjang masih kosong.');
        }

        $total = $carts->sum(fn($c) => $c->qty * $c->product->price);

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

        if ($carts->isEmpty()) {
            return back()->withErrors("Keranjang kosong.");
        }

        $cartsByStore = $carts->groupBy(fn($c) => $c->product->store_id);

        $totalPaymentNeeded = 0;

        foreach ($cartsByStore as $storeCarts) {
            $subtotal = $storeCarts->sum(fn($c) => $c->qty * $c->product->price);
            $shipping_cost = $request->shipping_type === 'express' ? 20000 : 10000;
            $totalPaymentNeeded += $subtotal + $shipping_cost;
        }

        // Wallet payment
        if ($request->payment_method === 'wallet') {

            if ($user->balance < $totalPaymentNeeded) {
                return back()->withErrors("Saldo tidak cukup.");
            }

            $user->balance -= $totalPaymentNeeded;
            $user->save();
        }

        $transactionsCreated = [];


        // ============================================================
        // CREATE TRANSACTIONS PER STORE
        // ============================================================

        foreach ($cartsByStore as $storeId => $storeCarts) {

            $subtotal = $storeCarts->sum(fn($c) => $c->qty * $c->product->price);
            $shipping_cost = $request->shipping_type === 'express' ? 20000 : 10000;
            $grand_total = $subtotal + $shipping_cost;

            $payment_status = $request->payment_method === 'wallet' ? 'paid' : 'unpaid';

            // Create transaction
            $transaction = Transaction::create([
                'code'          => 'TRX-' . strtoupper(Str::random(10)),
                'buyer_id'      => $user->id,
                'store_id'      => $storeId,
                'address'       => $request->address,
                'address_id'    => 'ADDR-' . strtoupper(Str::random(6)),
                'city'          => $request->city,
                'postal_code'   => $request->postal_code,
                'shipping'      => 'Standard Courier',
                'shipping_type' => $request->shipping_type,
                'shipping_cost' => $shipping_cost,
                'tax'           => 0,
                'grand_total'   => $grand_total,
                'payment_status'=> $payment_status,
            ]);

            // Save detail
            foreach ($storeCarts as $c) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $c->product_id,
                    'qty'            => $c->qty,
                    'subtotal'       => $c->qty * $c->product->price,
                ]);
            }

            // ============= ADD STORE INCOME (FINAL FIX) =============
            if ($payment_status === 'paid') {

                $store = $transaction->store;

                $storeBalance = $store->storeBalance()->firstOrCreate(
                    ['store_id' => $store->id], // FIX TERPENTING
                    ['balance' => 0]
                );

                $storeBalance->increment('balance', $grand_total);

                $storeBalance->storeBalanceHistories()->create([
                    'type'           => 'income',
                    'amount'         => $grand_total,
                    'remarks'        => 'Income from Transaction ' . $transaction->code,
                    'reference_type' => 'transaction',
                    'reference_id'   => $transaction->id
                ]);
            }

            $transactionsCreated[] = $transaction->id;
        }


        \App\Models\Cart::where('user_id', $user->id)->delete();

        if ($request->payment_method === 'va') {
            return redirect('/payment?trx=' . $transactionsCreated[0]);
        }

        return redirect('/checkout/success')->with('success', 'Semua transaksi berhasil dibuat!');
    }
}
