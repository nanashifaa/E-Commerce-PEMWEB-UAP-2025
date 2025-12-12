<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product.productImages')
            ->where('user_id', Auth::id())
            ->get();

        $total = $carts->sum(function ($c) {
            return ($c->qty ?? 0) * ($c->product->price ?? 0);
        });

        return view('cart.index', compact('carts', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ((int) $product->stock < 1) {
            return back()->with('error', 'Stok habis.');
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            if ((int) $cart->qty >= (int) $product->stock) {
                return back()->with('error', 'Jumlah sudah mencapai stok maksimal.');
            }

            $cart->qty = (int) $cart->qty + 1;
            $cart->save();
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'qty'        => 1
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
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

        $stock = (int) ($cart->product->stock ?? 0);
        $qty   = (int) $request->qty;

        if ($stock < 1) {
            $cart->delete();
            return back()->with('error', 'Stok habis. Item dihapus dari keranjang.');
        }

        if ($qty > $stock) {
            $qty = $stock;
        }

        $cart->qty = $qty;
        $cart->save();

        return back()->with('success', 'Kuantitas diperbarui!');
    }

    public function delete($id)
    {
        Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Produk dihapus dari keranjang!');
    }
}
