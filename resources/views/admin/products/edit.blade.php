@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6">Edit Product</h2>
    <form action="{{ route('admin.products.update', $product->prod_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="prod_name" class="block text-sm font-medium text-gray-700">Product Name</label>
            <input type="text" name="prod_name" id="prod_name" value="{{ $product->prod_name }}" class="mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <label for="prod_desc" class="block text-sm font-medium text-gray-700">Description</label>
            <input type="text" name="prod_desc" id="prod_desc" value="{{ $product->prod_desc }}" class="mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <label for="prod_price" class="block text-sm font-medium text-gray-700">Price</label>
            <input type="number" name="prod_price" id="prod_price" value="{{ $product->prod_price }}" class="mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <label for="prod_price_promo" class="block text-sm font-medium text-gray-700">Price Promo</label>
            <input type="number" name="prod_price_promo" id="prod_price_promo" value="{{ $product->prod_price_promo }}" class="mt-1 block w-full">
        </div>
        <div class="mb-4">
            <label for="prod_stock" class="block text-sm font-medium text-gray-700">Stock</label>
            <input type="number" name="prod_stock" id="prod_stock" value="{{ $product->prod_stock }}" class="mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <label for="prod_category_id" class="block text-sm font-medium text-gray-700">Category</label>
            <select name="prod_category_id" id="prod_category_id" class="mt-1 block w-full" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->prod_category_id }}" {{ $product->prod_category_id == $category->prod_category_id ? 'selected' : '' }}>{{ $category->prod_category_name }}</option>
                @endforeach
            </select>
        </div>
            <div class="mb-4">
            <label for="prod_image" class="block text-sm font-medium text-gray-700">Image</label>
            <input type="file" name="prod_image" id="prod_image" class="mt-1 block w-full">
            @if($product->prod_image)
                <img src="{{ asset('storage/' . $product->prod_image) }}" alt="{{ $product->prod_name }}" class="mt-2 w-32 h-32 object-cover">
            @endif
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update Product</button>
        </div>
    </form>
</div>
@endsection
