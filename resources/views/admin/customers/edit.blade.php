@extends('layouts.admin')

@section('title', 'Edit Customer')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">Edit Customer</h2>

    <form action="{{ route('admin.customers.update', $customer->cust_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="cust_name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="cust_name" id="cust_name" value="{{ $customer->cust_name }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="cust_email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="cust_email" id="cust_email" value="{{ $customer->cust_email }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="cust_nohp" class="block text-sm font-medium text-gray-700">Phone</label>
            <input type="text" name="cust_nohp" id="cust_nohp" value="{{ $customer->cust_nohp }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save Changes</button>
        <a href="{{ route('admin.customers') }}" class="ml-4 text-gray-700 hover:text-gray-900">Cancel</a>
    </form>
</div>
@endsection
