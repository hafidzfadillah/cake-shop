@extends('layouts.app')

@section('title', 'Product Categories')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6">Product Categories</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <a href="{{ route('category.products', $category->prod_category_id) }}"
               class="block bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-2">{{ $category->prod_category_name }}</h3>
                <p class="text-gray-600">
                    {{ $category->products_count ?? 0 }} Products
                </p>
            </a>
        @endforeach
    </div>
</div>
@endsection
