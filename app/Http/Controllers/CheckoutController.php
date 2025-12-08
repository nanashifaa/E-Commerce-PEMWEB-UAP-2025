<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->get();
        return view('checkout');
    }

    public function process(Request $request)
{
    $user = Auth::user();
    $buyer = $user->buyer ?? null;

    if (!$buyer) {
        return redirect('/')->with('error', 'Akun ini tidak memiliki data buyer.');
    }

    $request->validate([
        'address' => 'required',
        'city' => 'required',
        'postal_code' => 'required',
        'shipping_type' => 'required',
        'shipping_cost' => 'required|numeric',
        'payment_method' => 'required',
    ]);

    $cart = Cart::where('buyer_id', $buyer->id)->with('product')->get();

    if ($cart->isEmpty()) {
        return back()->withErrors("Cart is empty.");
    }

    $subtotal = $cart->sum(fn($c) => $c->product->price * $c->qty);
    $tax = 0;
    $grandTotal = $subtotal + $request->shipping_cost + $tax;

    $transaction = Transaction::create([
        'code' => 'TRX-' . strtoupper(Str::random(8)),
        'buyer_id' => $buyer->id,
        'store_id' => $cart->first()->product->store_id ?? 1,

        'address' => $request->address,
        'city' => $request->city,
        'postal_code' => $request->postal_code,

        'shipping_type' => $request->shipping_type,
        'shipping_cost' => $request->shipping_cost,

        'tax' => $tax,
        'grand_total' => $grandTotal,

        'payment_status' => $request->payment_method == 'saldo'
            ? 'paid'
            : 'pending',
    ]);

    foreach ($cart as $item) {
        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $item->product_id,
            'qty' => $item->qty,
            'subtotal' => $item->product->price * $item->qty,
        ]);
    }

    Cart::where('buyer_id', $buyer->id)->delete();

    return redirect('/dashboard')->with('success', 'Transaction created successfully.');
}

}
