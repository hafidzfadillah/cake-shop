@extends('layouts.app')

@section('title', 'Transaction History')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6">Transaction History</h2>

    @if($transactions->count() > 0)
        <div class="space-y-6">
            @foreach($transactions as $transaction)
                <div class="border rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-semibold">Transaction #{{ $transaction->transaction_id }}</h3>
                            <p class="text-sm text-gray-600">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm
                            @if($transaction->transaction_status == 'completed') bg-green-100 text-green-800
                            @elseif($transaction->transaction_status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($transaction->transaction_status) }}
                        </span>
                    </div>

                    <div class="space-y-2 mb-4">
                        @foreach($transaction->transactionItems as $item)
                            @if($item->product)
                            <div class="flex justify-between text-sm">
                                <span>{{ $item->product->prod_name }} (x{{ $item->qty }})</span>
                                <span>Rp {{ number_format($item->unit_price * $item->qty) }}</span>
                            </div>
                            @else
                            <div class="flex justify-between text-sm">
                                <span>This product is no longer available</span>
                                <span>Rp 0</span>
                            </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t">
                        <div class="font-semibold">
                            Total: Rp {{ number_format($transaction->rp_total) }}
                        </div>
                        <a href="{{ route('transactions.show', $transaction->transaction_id) }}"
                           class="text-blue-500 hover:text-blue-700">
                            View Details →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-600">No transactions found</p>
            <a href="{{ route('home') }}"
               class="text-blue-500 hover:text-blue-700 mt-2 inline-block">
                Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection
