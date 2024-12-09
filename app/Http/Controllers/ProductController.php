<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prod_name' => 'required|string|max:255',
            'prod_desc' => 'required|string',
            'prod_price' => 'required|integer',
            'prod_price_promo' => 'required|integer',
            'prod_stock' => 'required|integer',
            'prod_img_url' => 'required|string',
            'prod_category_id' => 'required|exists:tb_prod_category,prod_category_id'
        ]);

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'prod_name' => 'string|max:255',
            'prod_desc' => 'string',
            'prod_price' => 'integer',
            'prod_price_promo' => 'integer',
            'prod_stock' => 'integer',
            'prod_img_url' => 'string',
            'prod_category_id' => 'exists:tb_prod_category,prod_category_id'
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(null, 204);
    }

    public function showCategories()
    {
        $categories = ProductCategory::withCount('products')->get();
        return view('products.category', compact('categories'));
    }

    public function showProductsByCategory($id)
    {
        $category = ProductCategory::findOrFail($id);
        $products = Product::where('prod_category_id', $id)
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        return view('products.by_category', compact('category', 'products'));
    }
}
