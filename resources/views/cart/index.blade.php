<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Cart') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if($items->isEmpty())
                    <p class="text-gray-500">Your cart is empty.</p>
                @else
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Book</th>
                                <th class="px-4 py-2 text-right">Price</th>
                                <th class="px-4 py-2 text-center">Qty</th>
                                <th class="px-4 py-2 text-right">Subtotal</th>
                                <th class="px-4 py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr class="border-t">
                                    <td class="px-4 py-2">
                                        {{ $item->book->title }}
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        {{ number_format($item->price, 2) }}
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <form action="{{ route('cart.update', $item) }}"
                                              method="POST"
                                              class="inline-flex">
                                            @csrf
                                            <input type="number" name="quantity" min="1"
                                                   value="{{ $item->quantity }}"
                                                   class="w-16 border-gray-300 rounded text-center">
                                            <button class="ml-2 px-2 py-1 bg-blue-600 text-white rounded text-xs">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        {{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        <form action="{{ route('cart.remove', $item) }}"
                                              method="POST"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1 bg-red-600 text-white rounded text-xs"
                                                    onclick="return confirm('Remove this item?')">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4 text-right">
                        <p class="text-lg font-semibold">
                            Total: {{ number_format($total, 2) }}
                        </p>
                    </div>

                    <div class="mt-6 text-right">
                        <a href="{{ route('checkout.create') }}"
                           class="inline-block px-4 py-2 bg-green-600 text-white rounded">
                            Proceed to Checkout
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
