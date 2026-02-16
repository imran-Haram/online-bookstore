<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order #') . $order->id }}
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
                <p><strong>Date:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                <p class="mt-2"><strong>Total:</strong> {{ number_format($order->total, 2) }}</p>

                <h3 class="text-lg font-semibold mt-6 mb-2">Items</h3>

                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Book</th>
                            <th class="px-4 py-2 text-right">Price</th>
                            <th class="px-4 py-2 text-center">Qty</th>
                            <th class="px-4 py-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $item->book->title }}</td>
                                <td class="px-4 py-2 text-right">{{ number_format($item->price, 2) }}</td>
                                <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 text-right">{{ number_format($item->line_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    <a href="{{ route('orders.index') }}" class="text-gray-600">
                        ← Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
