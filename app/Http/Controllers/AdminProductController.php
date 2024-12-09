<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prod_name' => 'required|string|max:255',
            'prod_desc' => 'required|string|max:255',
            'prod_price' => 'required|numeric',
            'prod_price_promo' => 'nullable|numeric',
            'prod_stock' => 'required|integer',
            'prod_category_id' => 'required|exists:tb_prod_category,prod_category_id',
            'prod_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = new Product($request->except('prod_image'));

        if ($request->hasFile('prod_image')) {
            $path = $request->file('prod_image')->store('products', 'public');
            $product->prod_img_url = $path;
        }

        $product->save();

        return redirect()->route('admin.products')->with('success', 'Product added successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'prod_name' => 'required|string|max:255',
            'prod_desc' => 'required|string|max:255',
            'prod_price' => 'required|numeric',
            'prod_price_promo' => 'nullable|numeric',
            'prod_stock' => 'required|integer',
            'prod_category_id' => 'required|exists:tb_prod_category,prod_category_id',
            'prod_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->fill($request->except('prod_image'));

        if ($request->hasFile('prod_image')) {
            $path = $request->file('prod_image')->store('products', 'public');
            $product->prod_img_url = $path;
        }

        $product->save();

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully.');
    }

    public function filter(Request $request)
    {
        $products = Product::filter($request->all())->get();
        $search = $request->search ?? null;
        return view('admin.products.index', compact('products', 'search'));
    }
}
