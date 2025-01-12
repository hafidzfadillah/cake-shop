@extends('layouts.app')

@section('title', $product->prod_name)

@section('content')
<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="md:flex">
        <!-- Product Image -->
        <div class="md:w-1/2">
            <img src="{{ asset('uploads/'.$product->image) }}"
                 alt="{{ $product->prod_name }}"
                 class="w-full h-96 object-cover"
                 loading="lazy">
        </div>

        <!-- Product Details -->
        <div class="p-8 md:w-1/2">
            <div class="mb-4">
                <span class="text-sm text-blue-500">{{ $product->category->prod_category_name }}</span>
                <h1 class="text-3xl font-bold mt-2">{{ $product->prod_name }}</h1>
            </div>

            <div class="mb-6">
                @if($product->prod_price_promo != 0 && $product->prod_price_promo < $product->prod_price)
                    <p class="text-gray-500 line-through">Rp {{ number_format($product->prod_price) }}</p>
                    <p class="text-3xl font-bold text-red-600">Rp {{ number_format($product->prod_price_promo) }}</p>
                @else
                    <p class="text-3xl font-bold">Rp {{ number_format($product->prod_price) }}</p>
                @endif
            </div>

            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Description</h2>
                <p class="text-gray-600">{{ $product->prod_desc }}</p>
            </div>

            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Stock</h2>
                <p class="text-gray-600">{{ $product->prod_stock }} available</p>
            </div>

            @auth
                <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="prod_id" value="{{ $product->prod_id }}">

                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number"
                               name="item_qty"
                               id="quantity"
                               min="1"
                               max="{{ $product->prod_stock }}"
                               value="1"
                               class="mt-1 block w-20 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition-colors"
                            {{ $product->prod_stock < 1 ? 'disabled' : '' }}>
                        {{ $product->prod_stock < 1 ? 'Out of Stock' : 'Add to Cart' }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="block text-center bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition-colors">
                    Login to Purchase
                </a>
            @endauth
        </div>
    </div>
</div>

<!-- Related Products -->
<div class="mt-12">
    <h2 class="text-2xl font-bold mb-6">Related Products</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @foreach($product->category->products->where('prod_id', '!=', $product->prod_id)->take(4) as $relatedProduct)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <img src="{{ asset('uploads/'.$relatedProduct->image) }}"
                     alt="{{ $relatedProduct->prod_name }}"
                     class="w-full h-48 object-cover"
                     loading="lazy">
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">{{ $relatedProduct->prod_name }}</h3>
                    <div class="flex justify-between items-center">
                        <div>
                            @if($relatedProduct->prod_price_promo < $relatedProduct->prod_price)
                                <p class="text-gray-500 line-through">Rp {{ number_format($relatedProduct->prod_price) }}</p>
                                <p class="text-lg font-bold text-red-600">Rp {{ number_format($relatedProduct->prod_price_promo) }}</p>
                            @else
                                <p class="text-lg font-bold">Rp {{ number_format($relatedProduct->prod_price) }}</p>
                            @endif
                        </div>
                        <a href="{{ route('products.show', $relatedProduct->prod_id) }}"
                           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            View
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
