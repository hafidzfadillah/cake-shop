@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Total Sales</h3>
            <p class="text-2xl font-bold">Rp {{ number_format($totalSales) }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Pending Orders</h3>
            <p class="text-2xl font-bold">{{ $pendingOrders }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Total Products</h3>
            <p class="text-2xl font-bold">{{ $totalProducts }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Total Customers</h3>
            <p class="text-2xl font-bold">{{ $totalCustomers }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Transactions -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold">Recent Transactions</h2>
            </div>
            <div class="p-6">
                @if($recentTransactions->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentTransactions as $transaction)
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium">{{ $transaction->customer->cust_name }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $transaction->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">Rp {{ number_format($transaction->rp_total) }}</p>
                                    <span class="text-sm px-2 py-1 rounded
                                        @if($transaction->transaction_status == 'completed') bg-green-100 text-green-800
                                        @elseif($transaction->transaction_status == 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($transaction->transaction_status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center">No recent transactions</p>
                @endif
            </div>
        </div>

        <!-- Low Stock Products -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold">Low Stock Products</h2>
            </div>
            <div class="p-6">
                @if($lowStockProducts->count() > 0)
                    <div class="space-y-4">
                        @foreach($lowStockProducts as $product)
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium">{{ $product->prod_name }}</p>
                                    <p class="text-sm text-gray-500">
                                        Category: {{ $product->category->cat_name }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">Stock: {{ $product->prod_stock }}</p>
                                    <p class="text-sm text-gray-500">
                                        Rp {{ number_format($product->prod_price) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center">No low stock products</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
