<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST PRODUK UNTUK PEMBELI (PUBLIC)
    |--------------------------------------------------------------------------
    */
    public function list()
    {
        $products = Product::with(['productImages', 'store', 'productCategory'])
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        return view('product.index', compact('products'));
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX — LIST PRODUK SELLER
    |--------------------------------------------------------------------------
    */
    public function sellerIndex()
    {
        $store = auth()->user()->store;
        $products = $store ? $store->products()->latest()->get() : collect();

        return view('seller.products.index', compact('products'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW — DETAIL PRODUK UNTUK PEMBELI
    |--------------------------------------------------------------------------
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
    |--------------------------------------------------------------------------
    | CREATE — FORM TAMBAH PRODUK (SELLER)
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $categories = ProductCategory::all();
        return view('seller.products.create', compact('categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE — SIMPAN PRODUK BARU
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        // validasi field produk (tanpa foto dulu)
        $request->validate([
            'name'                => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'description'         => 'required',
            'price'               => 'required|numeric|min:1',
            'stock'               => 'required|integer|min:1',
            'condition'           => 'required|in:new,used',
            'weight'              => 'required|integer|min:1',
        ]);

        // ambil file & filter aman (hindari image[0] = {})
        $files = $request->file('image');
        if (is_array($files)) {
            $files = array_values(array_filter($files, fn ($f) => $f instanceof UploadedFile));
        } else {
            $files = [];
        }

        // validasi foto hanya kalau ada file beneran
        if (!empty($files)) {
            $request->validate([
                'image'   => 'array',
                'image.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);
        }

        $product = Product::create([
            'store_id'            => auth()->user()->store->id,
            'product_category_id' => $request->product_category_id,
            'name'                => $request->name,
            'slug'                => Str::slug($request->name) . '-' . rand(1000, 9999),
            'description'         => $request->description,
            'price'               => $request->price,
            'stock'               => $request->stock,
            'condition'           => $request->condition,
            'weight'              => $request->weight,
        ]);

        // simpan foto (kalau ada)
        foreach ($files as $file) {
            if (!$file->isValid()) continue;

            $path = $file->store('products', 'public');

            $product->productImages()->create([
                'image' => $path, // sesuai DB
            ]);
        }

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Product berhasil ditambahkan!');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT — FORM EDIT PRODUK
    |--------------------------------------------------------------------------
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
    |--------------------------------------------------------------------------
    | UPDATE — UPDATE PRODUK
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Product $product)
    {
        if ($product->store->user_id !== auth()->id()) {
            abort(403);
        }

        // validasi field produk (tanpa foto dulu)
        $request->validate([
            'name'                => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'description'         => 'required',
            'price'               => 'required|numeric|min:1',
            'stock'               => 'required|integer|min:1',
            'condition'           => 'required|in:new,used',
            'weight'              => 'required|integer|min:1',
        ]);

        // update data produk
        $product->update([
            'product_category_id' => $request->product_category_id,
            'name'                => $request->name,
            'slug'                => Str::slug($request->name) . '-' . rand(1000, 9999),
            'description'         => $request->description,
            'price'               => $request->price,
            'stock'               => $request->stock,
            'condition'           => $request->condition,
            'weight'              => $request->weight,
        ]);

        // ambil file & filter aman
        $files = $request->file('image');
        if (is_array($files)) {
            $files = array_values(array_filter($files, fn ($f) => $f instanceof UploadedFile));
        } else {
            $files = [];
        }

        // validasi foto hanya kalau ada file beneran
        if (!empty($files)) {
            $request->validate([
                'image'   => 'array',
                'image.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            foreach ($files as $file) {
                if (!$file->isValid()) continue;

                $path = $file->store('products', 'public');

                $product->productImages()->create([
                    'image' => $path,
                ]);
            }
        }

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Product berhasil diperbarui!');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY — HAPUS PRODUK
    |--------------------------------------------------------------------------
    */
    public function destroy(Product $product)
    {
        if ($product->store->user_id !== auth()->id()) {
            abort(403);
        }

        $product->delete();
        return back()->with('success', 'Product berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH — PENCARIAN PRODUK (PUBLIC)
    |--------------------------------------------------------------------------
    */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return redirect()->back()->with('info', 'Masukkan kata kunci pencarian');
        }

        $products = Product::with(['productImages', 'store', 'productCategory'])
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(20);

        return view('product.search', compact('products', 'query'));
    }
}
