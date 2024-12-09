@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Checkout</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Order Summary -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Order Summary</h3>
                <div class="space-y-4">
                    @foreach($cartItems as $item)
                        <div class="flex justify-between">
                            <div>
                                <p class="font-medium">{{ $item->product->prod_name }}</p>
                                <p class="text-sm text-gray-600">Qty: {{ $item->item_qty }}</p>
                            </div>
                            <p class="font-medium">
                                Rp {{ number_format($item->item_qty * ($item->product->prod_price_promo ?: $item->product->prod_price)) }}
                            </p>
                        </div>
                    @endforeach

                    <div class="border-t pt-4">
                        <div class="flex justify-between font-bold">
                            <p>Total</p>
                            <p>Rp {{ number_format($total) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div>
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Customer Name
                        </label>
                        <p class="text-gray-600">{{ $customer->cust_name }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Email
                        </label>
                        <p class="text-gray-600">{{ $customer->cust_email }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Phone
                        </label>
                        <p class="text-gray-600">{{ $customer->cust_nohp }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="shipping_address">
                            Shipping Address
                        </label>
                        <textarea name="shipping_address"
                                  id="shipping_address"
                                  rows="3"
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('shipping_address') border-red-500 @enderror"
                                  required></textarea>
                        @error('shipping_address')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Payment Method
                        </label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="transfer" class="mr-2" required>
                                Bank Transfer
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="cod" class="mr-2" required>
                                Cash on Delivery
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-600">
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
