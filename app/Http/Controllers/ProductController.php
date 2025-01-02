<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
            'prod_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'prod_category_id' => 'required|exists:tb_prod_category,prod_category_id'
        ]);

        try{
            $uploadedFile = cloudinary()->upload($request->file('prod_image')->getRealPath(), [
                'folder'=>'cake-shop/products'
            ])->getSecurePath();


            // Create product with all data including the Cloudinary URL
            $product = Product::create([
                'prod_name' => $request->prod_name,
                'prod_desc' => $request->prod_desc,
                'prod_price' => $request->prod_price,
                'prod_price_promo' => $request->prod_price_promo,
                'prod_stock' => $request->prod_stock,
                'prod_img_url' => $uploadedFile,
                'prod_category_id' => $request->prod_category_id,
                'cloudinary_public_id' => $uploadedFile->getPublicId() // Store this for future deletion
            ]);
            return response()->json($product, 201);
        } catch(\Exception $e) {
            return response()->json(['error'=>$e->getMessage()],500);
        }
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
            'prod_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', // Changed validation
            'prod_category_id' => 'exists:tb_prod_category,prod_category_id'
        ]);

        try{
            $product = Product::findOrFail($id);
            $data = $request->except('prod_image');

            if($request->hasFile('prod_image')) {
                // Delete old image if exists
                if ($product->cloudinary_public_id) {
                    Cloudinary::destroy($product->cloudinary_public_id);
                }

                // Upload new image
                $uploadedFile = Cloudinary::upload($request->file('prod_image')->getRealPath(), [
                    'folder' => 'cake-shop/products'
                ]);

                $data['prod_img_url'] = $uploadedFile->getSecurePath();
                $data['cloudinary_public_id'] = $uploadedFile->getPublicId();
            }

            $product->update($request->all());
            return response()->json($product);
        } catch(\Exception $e) {
            return response()->json(['error'=>$e->getMessage()],500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Delete image from Cloudinary if exists
            if ($product->cloudinary_public_id) {
                Cloudinary::destroy($product->cloudinary_public_id);
            }

            $product->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
