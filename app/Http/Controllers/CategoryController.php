<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /** LIST CATEGORY */
    public function index()
    {
        $categories = ProductCategory::latest()->get();

        return view('seller.categories.index', compact('categories'));
    }

    /** FORM TAMBAH */
    public function create()
    {
        return view('seller.categories.create');
    }

    /** SIMPAN KATEGORI */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        ProductCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);

        return redirect()
            ->route('seller.categories.index')
            ->with('success', 'Category berhasil ditambahkan!');
    }

    /** FORM EDIT */
    public function edit(ProductCategory $category)
    {
        return view('seller.categories.edit', compact('category'));
    }

    /** UPDATE */
    public function update(Request $request, ProductCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);

        return redirect()
            ->route('seller.categories.index')
            ->with('success', 'Category berhasil diperbarui!');
    }

    /** HAPUS */
    public function destroy(ProductCategory $category)
    {
        $category->delete();

        return back()->with('success', 'Category berhasil dihapus.');
    }
}
