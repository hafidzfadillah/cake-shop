@extends('layouts.admin')
@section('title', 'Edit Product')
@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6">Edit Product</h2>
    <form action="{{ route('admin.products.update', $product->prod_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label for="prod_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" name="prod_name" id="prod_name"
                        value="{{ old('prod_name', $product->prod_name) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('prod_name') border-red-500 @enderror">
                    @error('prod_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="prod_desc" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="prod_desc" id="prod_desc" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('prod_desc') border-red-500 @enderror">{{ old('prod_desc', $product->prod_desc) }}</textarea>
                    @error('prod_desc')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="prod_price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="prod_price" id="prod_price"
                            value="{{ old('prod_price', $product->prod_price) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('prod_price') border-red-500 @enderror">
                        @error('prod_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="prod_price_promo" class="block text-sm font-medium text-gray-700">Promo Price</label>
                        <input type="number" name="prod_price_promo" id="prod_price_promo"
                            value="{{ old('prod_price_promo', $product->prod_price_promo) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('prod_price_promo') border-red-500 @enderror">
                        @error('prod_price_promo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="prod_stock" class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="prod_stock" id="prod_stock"
                        value="{{ old('prod_stock', $product->prod_stock) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('prod_stock') border-red-500 @enderror">
                    @error('prod_stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="prod_category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="prod_category_id" id="prod_category_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('prod_category_id') border-red-500 @enderror">
                        @foreach ($categories as $category)
                            <option value="{{ $category->prod_category_id }}"
                                {{ old('prod_category_id', $product->prod_category_id) == $category->prod_category_id ? 'selected' : '' }}>
                                {{ $category->prod_category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('prod_category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-4">
                <div>
                <center><label for="prod_image" class="block text-sm font-medium text-gray-700">Product Image</label>
                </center>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <div class="flex flex-col items-center">
                                <img id="image_preview" src="{{ $product->prod_img_url }}"
                                    alt="Product preview" class="mb-4 w-full h-48 object-cover rounded-lg">
                                <label for="prod_image" class="cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                    <!-- <span>Upload a new image</span> -->
                                    <input id="prod_image" name="prod_image" type="file" class="sr-only" accept="image/*">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                    @error('prod_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.products') }}"
                class="bg-gray-100 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Cancel
            </a>
            <button type="submit"
                class="bg-blue-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Update Product
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('prod_image').onchange = function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image_preview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
};
</script>
@endsection
