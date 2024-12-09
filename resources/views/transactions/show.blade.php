@extends('layouts.app')

@section('title', 'Transaction Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-start mb-6">
            <h2 class="text-2xl font-bold">Transaction Details</h2>
            <span class="px-3 py-1 rounded-full text-sm
                @if($transaction->trans_status == 'completed') bg-green-100 text-green-800
                @elseif($transaction->transaction_status == 'pending') bg-yellow-100 text-yellow-800
                @else bg-red-100 text-red-800 @endif">
                {{ ucfirst($transaction->transaction_status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Transaction Info -->
            <div>
                <div class="mb-4">
                    <h3 class="font-semibold mb-2">Transaction Information</h3>
                    <p class="text-sm text-gray-600">Transaction #{{ $transaction->transaction_id }}</p>
                    <p class="text-sm text-gray-600">Date: {{ $transaction->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-sm text-gray-600">Payment Method: {{ ucfirst($transaction->payment_method) }}</p>
                </div>

                <div class="mb-4">
                    <h3 class="font-semibold mb-2">Shipping Address</h3>
                    <p class="text-sm text-gray-600">{{ $transaction->ship_address }}</p>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">Customer Information</h3>
                    <p class="text-sm text-gray-600">{{ $transaction->customer->cust_name }}</p>
                    <p class="text-sm text-gray-600">{{ $transaction->customer->cust_email }}</p>
                    <p class="text-sm text-gray-600">{{ $transaction->customer->cust_nohp }}</p>
                </div>
            </div>

            <!-- Order Items -->
            <div>
                <h3 class="font-semibold mb-4">Order Items</h3>
                <div class="space-y-4">
                    @foreach($transaction->transactionItems as $item)
                        <div class="flex justify-between">
                            <div>
                                <p class="font-medium">{{ $item->product->prod_name }}</p>
                                <p class="text-sm text-gray-600">
                                    Rp {{ number_format($item->unit_price) }} x {{ $item->qty }}
                                </p>
                            </div>
                            <p class="font-medium">
                                Rp {{ number_format($item->unit_price * $item->qty) }}
                            </p>
                        </div>
                    @endforeach

                    <div class="border-t pt-4 mt-4">
                        <div class="flex justify-between font-bold">
                            <p>Total</p>
                            <p>Rp {{ number_format($transaction->rp_total) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('transactions.index') }}"
               class="text-blue-500 hover:text-blue-700">
                ← Back to Transaction History
            </a>
        </div>
    </div>
</div>
@endsection
