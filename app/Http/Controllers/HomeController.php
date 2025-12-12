<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProductCategory::orderBy('name')->get();
        $query = $request->input('q');

        $products = Product::with(['store', 'productImages', 'productCategory'])
            ->where('stock', '>', 0)
            ->when($query, function ($q) use ($query) {
                $q->where(function($subQuery) use ($query) {
                    $subQuery->where('name', 'LIKE', "%{$query}%")
                            ->orWhere('description', 'LIKE', "%{$query}%");
                });
            })
            ->when($request->category, function ($q) use ($request) {
                $q->whereHas('productCategory', function ($cat) use ($request) {
                    $cat->where('slug', $request->category);
                });
            })
            ->latest()
            ->paginate(20);

        return view('home', compact('products', 'categories', 'query'));
    }
}