@extends('layouts.app')

@section('title', $category->cat_name . ' - Products')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold">{{ $category->cat_name }}</h2>
        <p class="text-gray-600">Browse all products in this category</p>
    </div>

    @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if($product->prod_img_url)
                    <img src="{{ $product->prod_img_url }}" alt="{{ $product->prod_name }}"
                        class="w-full h-48   object-cover" loading="lazy">

                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500">No image</span>
                        </div>
                    @endif

                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">{{ $product->prod_name }}</h3>

                        <div class="mb-2">
                            @if($product->prod_price_promo)
                                <span class="text-red-600 font-bold">
                                    Rp {{ number_format($product->prod_price_promo) }}
                                </span>
                                <span class="text-gray-500 line-through text-sm ml-2">
                                    Rp {{ number_format($product->prod_price) }}
                                </span>
                            @else
                                <span class="text-gray-800 font-bold">
                                    Rp {{ number_format($product->prod_price) }}
                                </span>
                            @endif
                        </div>

                        <div class="mb-4">
                            <span class="text-sm text-gray-600">
                                Stock: {{ $product->prod_stock }}
                            </span>
                        </div>

                        <a href="{{ route('products.show', $product->prod_id) }}"
                           class="block w-full text-center bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-600">No products found in this category.</p>
            <a href="{{ route('categories.index') }}"
               class="text-blue-500 hover:text-blue-700 mt-2 inline-block">
                Browse other categories
            </a>
        </div>
    @endif
</div>
@endsection
