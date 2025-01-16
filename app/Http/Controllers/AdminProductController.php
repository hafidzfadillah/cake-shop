<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        // $products = Product::all();
        $query = Product::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('prod_name', 'LIKE', "%{$search}%");
        }

        $products = $query->get();
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
            'prod_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try{
            $uploadedFile = cloudinary()->upload($request->file('prod_image')->getRealPath(), [
                'folder'=>'cake-shop/products'
            ]);

            // Create product with all data including the Cloudinary URL
            $product = Product::create([
                'prod_name' => $request->prod_name,
                'prod_desc' => $request->prod_desc,
                'prod_price' => $request->prod_price,
                'prod_price_promo' => $request->prod_price_promo,
                'prod_stock' => $request->prod_stock,
                'prod_img_url' => $uploadedFile->getSecurePath(),
                'prod_category_id' => $request->prod_category_id,
                'cloudinary_public_id' => $uploadedFile->getPublicId() // Store this for future deletion
            ]);

            $product->save();

            return redirect()->route('admin.products.index')->with('success', 'Product added successfully.');
        } catch(\Exception $e) {
            return redirect()->route('admin.products.create')->with('error', $e->getMessage());
        }
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
            'prod_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try{
            $product = Product::findOrFail($id);
            $product->fill($request->except('prod_image'));

            if ($request->hasFile('prod_image')) {
                // Delete old image if exists
                if ($product->cloudinary_public_id) {
                    cloudinary()->destroy($product->cloudinary_public_id);
                }

                // Upload new image
                $uploadedFile = cloudinary()->upload($request->file('prod_image')->getRealPath(), [
                    'folder' => 'cake-shop/products'
                ]);

                $product['prod_img_url'] = $uploadedFile->getSecurePath();
                $product['cloudinary_public_id'] = $uploadedFile->getPublicId();
            }

            $product->update($request->all());

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
        } catch(\Exception $e) {
            return redirect()->route('admin.products.edit',$id)->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function filter(Request $request)
    {
        $products = Product::filter($request->all())->get();
        $search = $request->search ?? null;
        return view('admin.products.index', compact('products', 'search'));
    }
}
