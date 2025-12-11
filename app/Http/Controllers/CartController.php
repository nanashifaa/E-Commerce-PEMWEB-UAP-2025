<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
  public function add(Request $request)
{
    $request->validate([
        'product_id' => 'required'
    ]);

    $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();

    if ($cart) {
        $cart->qty++;
        $cart->save();
    } else {
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'qty' => 1
        ]);
    }

    // KEMBALI KE HALAMAN SEBELUMNYA
    return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
}


    public function index()
{
    $carts = Cart::with('product')->where('user_id', Auth::id())->get();

    $total = $carts->sum(fn($c) => $c->qty * $c->product->price);

    return view('cart.index', compact('carts', 'total'));
}

public function update(Request $request, $id)
{
    $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

    $request->validate([
        'qty' => 'required|integer|min:1'
    ]);

    $cart->qty = $request->qty;
    $cart->save();

    return back()->with('success', 'Kuantitas diperbarui!');
}

public function delete($id)
{
    Cart::where('id', $id)->where('user_id', Auth::id())->delete();

    return back()->with('success', 'Produk dihapus dari keranjang!');
}

}
