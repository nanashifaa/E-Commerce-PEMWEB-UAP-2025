<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | INDEX — LIST PRODUK SELLER
    |----------------------------------------------------------------------
    */
    public function index()
{
    $store = auth()->user()->store;

    if (!$store) {
        $products = collect(); 
    } else {
        $products = $store->products()->latest()->get();
    }

    return view('seller.products.index', compact('products'));
}
    /*
    |----------------------------------------------------------------------
    | SHOW — DETAIL PRODUK UNTUK PEMBELI
    |----------------------------------------------------------------------
    */
    public function show($slug)
    {
        $product = Product::with([
            'productImages',
            'productCategory',
            'store',
            'productReviews.user'
        ])
        ->where('slug', $slug)
        ->firstOrFail();

        return view('product.show', compact('product'));
    }

    /*
    |----------------------------------------------------------------------
    | CREATE — FORM TAMBAH PRODUK (SELLER)
    |----------------------------------------------------------------------
    */
    public function create()
    {
        $categories = ProductCategory::all();

        return view('seller.products.create', compact('categories'));
    }

    /*
    |----------------------------------------------------------------------
    | STORE — SIMPAN PRODUK BARU
    |----------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name'                => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'description'         => 'required',
            'price'               => 'required|numeric|min:1',
            'stock'               => 'required|integer|min:1',
            'condition'           => 'required|in:new,second',
            'weight'              => 'required|integer|min:1',
        ]);

        $product = Product::create([
            'store_id'            => auth()->user()->store->id,
            'product_category_id' => $request->product_category_id,
            'name'                => $request->name,
            'slug'                => Str::slug($request->name) . '-' . rand(1000,9999),
            'description'         => $request->description,
            'price'               => $request->price,
            'stock'               => $request->stock,
            'condition'           => $request->condition,
            'weight'              => $request->weight,
        ]);

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Product berhasil ditambahkan!');
    }

    /*
    |----------------------------------------------------------------------
    | EDIT — FORM EDIT PRODUK
    |----------------------------------------------------------------------
    */
    public function edit(Product $product)
    {
        if ($product->store->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = ProductCategory::all();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    /*
    |----------------------------------------------------------------------
    | UPDATE — UPDATE PRODUK
    |----------------------------------------------------------------------
    */
    public function update(Request $request, Product $product)
    {
        if ($product->store->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name'                => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'description'         => 'required',
            'price'               => 'required|numeric|min:1',
            'stock'               => 'required|integer|min:1',
            'condition'           => 'required|in:new,second',
            'weight'              => 'required|integer|min:1',
        ]);

        $product->update([
            'product_category_id' => $request->product_category_id,
            'name'                => $request->name,
            'slug'                => Str::slug($request->name) . '-' . rand(1000,9999),
            'description'         => $request->description,
            'price'               => $request->price,
            'stock'               => $request->stock,
            'condition'           => $request->condition,
            'weight'              => $request->weight,
        ]);

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Product berhasil diperbarui!');
    }

    /*
    |----------------------------------------------------------------------
    | DESTROY — HAPUS PRODUK
    |----------------------------------------------------------------------
    */
    public function destroy(Product $product)
    {
        if ($product->store->user_id !== auth()->id()) {
            abort(403);
        }

        $product->delete();

        return back()->with('success', 'Product berhasil dihapus.');
    }
}
