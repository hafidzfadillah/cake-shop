@extends('layouts.admin')

@section('title', 'Transaction Details')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Transaction Details</h1>

        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-gray-600 text-sm">Transaction ID & Date</p>
                <p class="font-semibold">#{{ $transaction->transaction_id }} | {{ $transaction->created_at->format('d M Y H:i') }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-gray-600 text-sm">Customer Name</p>
                <p class="font-semibold">{{ $transaction->customer->cust_name }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-gray-600 text-sm">Total Amount</p>
                <p class="font-semibold">Rp {{ number_format($transaction->rp_total) }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-gray-600 text-sm">Status</p>
                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                    {{ $transaction->transaction_status === 'completed' ? 'bg-green-100 text-green-800' :
                       ($transaction->transaction_status === 'cancelled' ? 'bg-red-100 text-red-800' :
                       'bg-yellow-100 text-yellow-800') }}">
                    {{ ucfirst($transaction->transaction_status) }}
                </span>
            </div>
        </div>

        <h2 class="text-xl font-bold mb-4 text-gray-800">Order Items</h2>
        <div class="space-y-4">
            @foreach ($transactionDetails as $detail)
                <div class="bg-gray-50 p-4 rounded flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold">{{ $detail->product ? $detail->product->prod_name : 'Product Deleted' }}</h3>
                        <p class="text-gray-600">Quantity: {{ $detail->qty }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold">Rp {{ number_format($detail->unit_price) }}</p>
                        <p class="text-gray-600 text-sm">Subtotal: Rp {{ number_format($detail->unit_price * $detail->qty) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
