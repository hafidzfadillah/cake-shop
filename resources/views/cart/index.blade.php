@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6">Shopping Cart</h2>

    @if($cartItems->count() > 0)
        <div class="space-y-4">
            @foreach($cartItems as $item)
                <div class="flex items-center justify-between border-b pb-4">
                    <div class="flex items-center space-x-4 relative">
                        @if($item->product)
                            <img src="{{ asset('uploads/'.$item->product->image) }}"
                                 alt="{{ $item->product->prod_name }}"
                                 class="w-20 h-20 object-cover rounded"
                                 loading="lazy">
                            <div>
                                <h3 class="font-semibold">{{ $item->product->prod_name }}</h3>
                                <p class="text-gray-600">
                                    Rp {{ number_format($item->product->prod_price_promo ?: $item->product->prod_price) }}
                                </p>
                            </div>
                        @else
                            <div class="absolute inset-0 bg-gray-100/80 backdrop-blur-sm rounded flex items-center justify-center z-10">
                                <div class="text-center">
                                    <h3 class="font-semibold text-gray-600">Product Deleted</h3>
                                    <p class="text-red-500 text-sm">This product is no longer available</p>
                                </div>
                            </div>
                            <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                <span class="text-gray-400">No image</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-400">Product Deleted</h3>
                                <p class="text-gray-400 text-sm">Item details not available</p>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center space-x-4">
                        @if($item->product && !$item->product->deleted_at)
                            <form action="{{ route('cart.update', $item->shop_cart_id) }}"
                                  method="POST"
                                  class="flex items-center space-x-2">
                                @csrf
                                @method('PUT')
                                <input type="number"
                                       name="item_qty"
                                       value="{{ $item->item_qty }}"
                                       min="1"
                                       max="{{ $item->product->prod_stock }}"
                                       class="w-16 rounded border-gray-300">
                                <button type="submit"
                                        class="text-blue-500 hover:text-blue-700">
                                    Update
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('cart.destroy', $item->shop_cart_id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-500 hover:text-red-700">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

            <div class="mt-6 flex justify-between items-center">
                <div class="text-lg font-semibold">
                    Total: Rp {{ number_format($total) }}
                </div>
                <a href="{{
                route('checkout') }}"
                   class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-600">Your cart is empty</p>
            <a href="{{ route('home') }}"
               class="text-blue-500 hover:text-blue-700 mt-2 inline-block">
                Continue Shopping
            </a>
        </div>
    @endif
</div>
