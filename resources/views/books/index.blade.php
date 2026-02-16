<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Books') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search & Filter Form -->
            <div class="bg-white shadow-sm sm:rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('books.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                   placeholder="Title, author, or category..."
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <select name="category" id="category"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Categories</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Min Price -->
                        <div>
                            <label for="min_price" class="block text-sm font-medium text-gray-700">Min Price</label>
                            <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}"
                                   step="0.01" min="0" placeholder="0.00"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- Max Price -->
                        <div>
                            <label for="max_price" class="block text-sm font-medium text-gray-700">Max Price</label>
                            <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}"
                                   step="0.01" min="0" placeholder="99999.99"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center space-x-2">
                            <label class="inline-flex items-center text-sm">
                                <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-1 text-gray-700">In Stock</span>
                            </label>
                            <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                                Filter
                            </button>
                            <a href="{{ route('books.index') }}"
                               class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md text-sm hover:bg-gray-400">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            @if (auth()->user()->is_admin)
            <div class="mb-4 flex justify-end">
                <a href="{{ route('books.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded">
                    + Add Book
                </a>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2 text-left">Author</th>
                            <th class="px-4 py-2 text-left">Category</th>
                            <th class="px-4 py-2 text-right">Price</th>
                            <th class="px-4 py-2 text-right">Stock</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                            <tr class="border-t">
                                <td class="px-4 py-2">
                                    <a href="{{ route('books.show', $book) }}" class="text-blue-600">
                                        {{ $book->title }}
                                    </a>
                                </td>
                                <td class="px-4 py-2">{{ $book->author }}</td>
                                <td class="px-4 py-2">{{ $book->category }}</td>
                                <td class="px-4 py-2 text-right">{{ number_format($book->price, 2) }}</td>
                                <td class="px-4 py-2 text-right">{{ $book->stock }}</td>
                                <td class="px-4 py-2 text-right space-x-2">
    {{-- Add to Cart --}}
    <form action="{{ route('cart.add', $book) }}" method="POST" class="inline">
        @csrf
        <button type="submit"
                class="px-3 py-1 bg-green-600 text-white rounded">
            Add to Cart
        </button>
    </form>

    @if (auth()->user()->is_admin)
    {{-- Edit --}}
    <a href="{{ route('books.edit', $book) }}"
       class="px-3 py-1 bg-yellow-500 text-white rounded">
        Edit
    </a>

    {{-- Delete --}}
    <form action="{{ route('books.destroy', $book) }}"
          method="POST"
          class="inline">
        @csrf
        @method('DELETE')
        <button type="submit"
                onclick="return confirm('Delete this book?')"
                class="px-3 py-1 bg-red-600 text-white rounded">
            Delete
        </button>
    </form>
    @endif
</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                    No books found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
