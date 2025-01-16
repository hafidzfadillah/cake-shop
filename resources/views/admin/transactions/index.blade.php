@extends('layouts.admin')

@section('title', 'Manage Transactions')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Filter Transactions</h2>
    <form action="{{ route('admin.transactions') }}" method="GET" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search by Customer Name</label>
                <input type="text"
                    name="search"
                    id="search"
                    placeholder="Enter customer name..."
                    value="{{ request('search') }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2">
            </div>
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Filter by Date</label>
                <input type="date"
                    name="date"
                    id="date"
                    value="{{ request('date') }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Filter by Status</label>
                <select name="status"
                    id="status"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end space-x-4">

        <a href="{{ route('admin.transactions') }}"
                class="bg-transparent hover:bg-red-700 text-red-500 font-bold py-2 px-4 rounded border border-red-500">
                Reset Filters
            </a>
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Apply Filters
            </button>
        </div>
    </form>
</div>
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Manage Transactions</h2>
    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">

                @foreach($transactions as $transaction)

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">#{{ $transaction->transaction_id }}</div>
                                <div class="text-sm text-gray-500">{{ $transaction->created_at->format('d M Y H:i') }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->customer->cust_name }} <br> {{ $transaction->customer->cust_email }} <br> {{ $transaction->customer->cust_nohp }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($transaction->rp_total) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.transactions.updateStatus', $transaction->transaction_id) }}">
                                @csrf
                                <select name="transaction_status"
                                        onchange="this.form.submit()"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2
                                        {{ $transaction->transaction_status == 'pending' ? 'bg-yellow-50 text-yellow-600' : '' }}
                                        {{ $transaction->transaction_status == 'completed' ? 'bg-green-50 text-green-600' : '' }}
                                        {{ $transaction->transaction_status == 'cancelled' ? 'bg-red-50 text-red-600' : '' }}">
                                    <option value="pending" {{ $transaction->transaction_status == 'pending' ? 'selected' : '' }}
                                            class="bg-yellow-50 text-yellow-600">Pending</option>
                                    <option value="completed" {{ $transaction->transaction_status == 'completed' ? 'selected' : '' }}
                                            class="bg-green-50 text-green-600">Completed</option>
                                    <option value="cancelled" {{ $transaction->transaction_status == 'cancelled' ? 'selected' : '' }}
                                            class="bg-red-50 text-red-600">Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('admin.transactions.show', $transaction->transaction_id) }}"
                               class="text-blue-500 hover:text-blue-700">
                               View Details
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
        </table>
    </div>
</div>
@endsection
