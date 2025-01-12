<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
        'prod_desc' => 'required|string|max:65535', // Menyesuaikan tipe `text`
        'prod_price' => 'required|integer',
        'prod_price_promo' => 'nullable|integer',
        'prod_stock' => 'required|integer',
        'prod_category_id' => 'required|exists:tb_prod_category,prod_category_id',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Gambar wajib
    ]);

    $input = $request->all();

    // Handle image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $imageName);

        $input['image'] = $imageName;
    } else {
        return redirect()->back()->withErrors(['image' => 'Product image is required.']);
    }

    // Simpan data ke tabel `tb_product`
    Product::create([
        'prod_name' => $input['prod_name'],
        'prod_desc' => $input['prod_desc'],
        'prod_price' => $input['prod_price'],
        'prod_price_promo' => $input['prod_price_promo'] ?? null,
        'prod_stock' => $input['prod_stock'],
        'prod_category_id' => $input['prod_category_id'],
        'image' => $input['image'], // Pastikan tidak null
    ]);

    return redirect()->route('admin.products')->with('success', 'Product added successfully');
}


        // $product = new Product($request->except('prod_image'));

        // if ($request->hasFile('prod_image')) {
        //     $path = $request->file('prod_image')->store('products', 'public');
        //     $product->prod_img_url = $path;
        // }

        // $product->save();

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, string $id)
    {
    
        $product = Product::findOrFail($id);
  
        $product->update($request->all());
  
        return redirect()->route('admin.products.index')->with('success', 'product updated successfully');
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
