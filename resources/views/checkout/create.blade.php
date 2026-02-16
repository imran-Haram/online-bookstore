<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Order Summary</h3>

                <table class="min-w-full text-sm mb-4">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Book</th>
                            <th class="px-4 py-2 text-right">Price</th>
                            <th class="px-4 py-2 text-center">Qty</th>
                            <th class="px-4 py-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $item->book->title }}</td>
                                <td class="px-4 py-2 text-right">{{ number_format($item->price, 2) }}</td>
                                <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 text-right">
                                    {{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mb-6">
                    <p class="text-lg font-semibold">
                        Total: {{ number_format($total, 2) }}
                    </p>
                </div>

                <form method="POST" action="{{ route('checkout.store') }}">
                    @csrf

                    {{-- You can add address / notes fields here later --}}

                    <button class="px-4 py-2 bg-green-600 text-white rounded">
                        Place Order
                    </button>
                    <a href="{{ route('cart.index') }}" class="ml-2 text-gray-600">
                        Back to Cart
                    </a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
