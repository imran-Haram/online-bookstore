<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $book->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p><strong>Author:</strong> {{ $book->author }}</p>
                <p><strong>Category:</strong> {{ $book->category }}</p>
                <p><strong>Price:</strong> {{ number_format($book->price, 2) }}</p>
                <p><strong>Stock:</strong> {{ $book->stock }}</p>

                @if ($book->image_url)
                    <div class="mt-4">
                        <img src="{{ $book->image_url }}" alt="{{ $book->title }}" class="max-w-xs">
                    </div>
                @endif

                <div class="mt-4">
                    <p>{{ $book->description }}</p>
                </div>

                <div class="mt-4">
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('books.edit', $book) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Edit</a>
                    @endif
                    <a href="{{ route('books.index') }}" class="ml-2 text-gray-600">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
