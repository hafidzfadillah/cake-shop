<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::withCount('products')->get();
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('home', compact('categories', 'products'));
    }

    public function productsByCategory($categoryId)
    {
        $category = ProductCategory::findOrFail($categoryId);
        $products = Product::where('prod_category_id', $categoryId)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('products.by_category', compact('category', 'products'));
    }
}
