@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Manage Products</h2>
        <div class="flex justify-end space-x-4">
            <form action="{{ route('admin.products') }}" method="GET" class="flex">
                <input type="text"
                    name="search"
                    placeholder="Search products..."
                    value="{{ request('search') }}"
                    class="rounded-l-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <button type="submit"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-r-md border border-l-0 border-gray-300">
                    Search
                </button>
            </form>
            <a href="{{ route('admin.products.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New Product
            </a>
        </div>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $product)
            @php
                $found = false;
                if (!request('search') || str_contains($product->prod_name, request('search'))) {
                    $found = true;
            @endphp
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-center items-center">
                    <img src="{{ asset('uploads/'.$product->image) }}" alt="{{ $product->prod_name }}" class="w-32 h-32 object-cover" loading="lazy">
                </div>
                <h3 class="font-bold text-lg mb-2">{{ $product->prod_name }}</h3>
                <div class="mb-2">
                    <span class="text-gray-600">Price:</span>
                    <span class="font-medium">Rp {{ number_format($product->prod_price) }}</span>
                </div>
                <div class="mb-4">
                    <span class="text-gray-600">Stock:</span>
                    <span class="font-medium">{{ $product->prod_stock }}</span>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.products.edit', $product->prod_id) }}"
                       class="text-blue-500 hover:text-blue-700">Edit</a>

                    <form action="{{ route('admin.products.destroy', $product->prod_id) }}"
                          method="POST"
                          class="inline-block"
                          onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-red-500 hover:text-red-700">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @php
                }
                if (!$found && $loop->last) {
            @endphp
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-500 text-lg">No results found</p>
                </div>
            @php
                }
            @endphp
        @endforeach
    </div>
</div>
@endsection
