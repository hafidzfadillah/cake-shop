@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="max-w-6xl mx-auto mt-6 px-4">
    <!-- Hero Section -->
    <header class="bg-orange-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="flex flex-col md:flex-row items-center md:space-x-10">
                    <!-- Image Section -->
                    <div class="flex justify-center">
                        <img src="{{ asset('assets/cakebg.png') }}" alt="Cakes" class="h-64 w-auto rounded-lg shadow-lg">
                    </div>
                    <!-- Text Section -->
                    <div class="text-center md:text-left mt-8 md:mt-0">
                        <h1 class="text-2xl font-semibold text-gray-800">
                            Kue Ulang Tahun, Wedding Cake, Bachelorette Cake, & Pudding
                        </h1>
                        <p class="mt-4 text-gray-600">
                            Pesan cake, pudding, kue ulang tahun kekinian, wedding cake, bachelorette cake.
                            Bisa custom dan same day delivery.
                        </p>
                    </div>
                </div>
            </div>
        </header>

    <div class="space-y-6 mt-4">
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="bg-white p-6 rounded-lg shadow overflow-hidden">
                <div class="flex justify-center items-center mb-4">
                    <img src="{{ $product->prod_img_url }}" alt="{{ $product->prod_name }}" class="w-full h-48 object-cover" loading="lazy">
                </div>
                <h3 class="font-bold text-lg mb-2 text-center">{{ $product->prod_name }}</h3>
                <div class="mb-2 text-center">
                    @if($product->prod_price_promo != 0 && $product->prod_price_promo < $product->prod_price)
                        <p class="text-gray-500 line-through">Rp {{ number_format($product->prod_price) }}</p>
                        <p class="text-lg font-bold text-red-600">Rp {{ number_format($product->prod_price_promo) }}</p>
                    @else
                        <p class="text-lg font-bold">Rp {{ number_format($product->prod_price) }}</p>
                    @endif
                </div>
                <div class="flex justify-center">
                    <a href="{{ route('products.show', $product->prod_id) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        View Details
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
