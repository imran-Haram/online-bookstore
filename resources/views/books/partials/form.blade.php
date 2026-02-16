@php
    $book = $book ?? null;
@endphp

<div class="grid grid-cols-1 gap-4">
    <div>
        <label class="block text-sm font-medium">Title</label>
        <input type="text" name="title" value="{{ old('title', $book->title ?? '') }}"
               class="mt-1 block w-full border-gray-300 rounded">
        @error('title') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium">Author</label>
        <input type="text" name="author" value="{{ old('author', $book->author ?? '') }}"
               class="mt-1 block w-full border-gray-300 rounded">
        @error('author') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium">Category</label>
        <input type="text" name="category" value="{{ old('category', $book->category ?? '') }}"
               class="mt-1 block w-full border-gray-300 rounded">
        @error('category') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium">Price</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $book->price ?? '') }}"
               class="mt-1 block w-full border-gray-300 rounded">
        @error('price') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium">Stock</label>
        <input type="number" name="stock" value="{{ old('stock', $book->stock ?? 0) }}"
               class="mt-1 block w-full border-gray-300 rounded">
        @error('stock') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium">Image URL</label>
        <input type="url" name="image_url" value="{{ old('image_url', $book->image_url ?? '') }}"
               class="mt-1 block w-full border-gray-300 rounded">
        @error('image_url') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium">Description</label>
        <textarea name="description" rows="4"
                  class="mt-1 block w-full border-gray-300 rounded">{{ old('description', $book->description ?? '') }}</textarea>
        @error('description') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
    </div>
</div>
