@extends('layouts.admin')

@section('title', 'Manage Customers')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Filter Customers</h2>
        <div class="flex space-x-4">
            <form action="{{ route('admin.customers') }}" method="GET" class="flex">
                <input type="text"
                    name="search"
                    placeholder="Search customers..."
                    value="{{ request('search') }}"
                    class="rounded-l-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <button type="submit"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-r-md border border-l-0 border-gray-300">
                    Search
                </button>
            </form>
            <a href="{{ route('admin.customers') }}"
                class="bg-transparent hover:bg-red-700 text-red-500 font-bold py-2 px-4 rounded border border-red-500">
                Reset
            </a>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6">Manage Customers</h2>
    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @php
                    $found = false;
                @endphp
                @foreach($customers as $customer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->cust_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->cust_email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->cust_nohp }}</td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-4">
                            <!-- Link Edit -->
                            <a href="{{ route('admin.customers.edit', $customer->cust_id) }}" 
                            class="text-blue-500 hover:text-blue-700">
                            Edit
                            </a>

                            <!-- Form Delete -->
                            <form action="{{ route('admin.customers.destroy', $customer->cust_id) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                            </form>

                        </td>
                    </tr>
                @endforeach


                @if(!$found)
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            No customers found matching the search
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
