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

    $products = Product::with(['store', 'productImages'])
        ->when($request->category, function ($query) use ($request) {
            $query->whereHas('productCategory', function ($cat) use ($request) {
                $cat->where('slug', $request->category);
            });
        })
        ->latest()
        ->get();

    return view('home', compact('products', 'categories'));
}
}
