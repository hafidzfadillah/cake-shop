@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="space-y-6">
    <!-- Categories -->
    <div>
        <h2 class="text-2xl font-bold mb-4">Categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($categories as $category)
            <a href="{{ route('category.products', $category->prod_category_id) }}"
               class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                <h3 class="font-semibold text-lg">{{ $category->prod_category_name }}</h3>
                <p class="text-gray-600 text-sm">{{ $category->products_count }} products</p>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Featured Products -->
    <div>
        <h2 class="text-2xl font-bold mb-4">Featured Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <img src="{{ asset('uploads/'.$product->image) }}"
                     alt="{{ $product->prod_name }}"
                     class="w-full h-48 object-cover"
                     loading="lazy">
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">{{ $product->prod_name }}</h3>
                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->prod_desc, 100) }}</p>
                    <div class="flex justify-between items-center">
                        <div>
                            @if($product->prod_price_promo != 0 && $product->prod_price_promo < $product->prod_price)
                            <p class="text-gray-500 line-through">Rp {{ number_format($product->prod_price) }}</p>
                            <p class="text-lg font-bold text-red-600">Rp {{ number_format($product->prod_price_promo) }}</p>
                            @else
                            <p class="text-lg font-bold">Rp {{ number_format($product->prod_price) }}</p>
                            @endif
                        </div>
                        <a href="{{ route('products.show', $product->prod_id) }}"
                           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
