@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<!-- <div class="container mx-auto px-4 py-6"> -->
<div class="relative bg-white rounded-lg shadow-lg mx-4 p-6">
    <h2 class="text-2xl font-bold mb-6">Add Product</h2>
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label for="prod_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" name="prod_name" id="prod_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('prod_name') border-red-500 @enderror" required>
                </div>
                <div class="mb-4">
                    <label for="prod_desc" class="block text-sm font-medium text-gray-700">Description</label>
                    <input type="text" name="prod_desc" id="prod_desc" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('prod_desc') border-red-500 @enderror" required>
                </div>
                <div class="mb-4">
                    <label for="prod_price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="prod_price" id="prod_price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('prod_price') border-red-500 @enderror" required>
                </div>
                <div class="mb-4">
                    <label for="prod_price_promo" class="block text-sm font-medium text-gray-700">Price Promo</label>
                    <input type="number" name="prod_price_promo" id="prod_price_promo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('prod_price_promo') border-red-500 @enderror">
                </div>
                <div class="mb-4">
                    <label for="prod_stock" class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="prod_stock" id="prod_stock" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('prod_stock') border-red-500 @enderror" required>
                    </div>
                <div class="mb-4">
                    <label for="prod_category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="prod_category_id" id="prod_category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('prod_category_id') border-red-500 @enderror" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->prod_category_id }}">{{ $category->prod_category_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col mb-3">
                <label for="prod_image" class="form-label">Gambar</label>
                <div class="w-48 h-48 rounded overflow-hidden">
                    <img id="preview" src="#" alt="Preview" class="w-48 h-48 object-cover hidden">
                </div>
                <input type="file"
                    name="prod_image"
                    id="prod_image"
                    accept="image/*"
                    class="mt-4"
                    required>
                @error('prod_image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.products.index') }}"
                class="bg-gray-100 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Cancel
            </a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Product</button>
        </div>
    </form>
</div>
<script>
document.getElementById('prod_image').onchange = function(evt) {
    const [file] = this.files;
    if (file) {
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    }
};
</script>
@endsection
