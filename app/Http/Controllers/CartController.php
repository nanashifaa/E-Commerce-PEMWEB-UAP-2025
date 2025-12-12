<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);

        $product = Product::findOrFail($request->product_id);

        // kalau stok 0, jangan bisa masuk cart
        if ($product->stock < 1) {
            return back()->with('error', 'Stok habis.');
        }

        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $product->id)
                    ->first();

        if ($cart) {
            // jangan boleh lebih dari stok
            if ($cart->qty >= $product->stock) {
                return back()->with('error', 'Jumlah sudah mencapai stok maksimal.');
            }

            $cart->qty += 1;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'qty' => 1
            ]);
        }

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
        $cart = Cart::with('product')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $stock = (int) $cart->product->stock;
        $qty   = (int) $request->qty;

        // kalau stok 0, hapus cart (opsional tapi recommended)
        if ($stock < 1) {
            $cart->delete();
            return back()->with('error', 'Stok habis. Item dihapus dari keranjang.');
        }

        // clamp qty ke 1..stock
        if ($qty > $stock) {
            $qty = $stock;
        }

        $cart->qty = $qty;
        $cart->save();

        return back()->with('success', 'Kuantitas diperbarui!');
    }

    public function delete($id)
    {
        Cart::where('id', $id)->where('user_id', Auth::id())->delete();

        return back()->with('success', 'Produk dihapus dari keranjang!');
    }
}
