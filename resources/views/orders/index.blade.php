<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if($orders->isEmpty())
                    <p class="text-gray-500">You have no orders yet.</p>
                @else
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Order #</th>
                                <th class="px-4 py-2 text-left">Date</th>
                                <th class="px-4 py-2 text-right">Total</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="border-t">
                                    <td class="px-4 py-2">#{{ $order->id }}</td>
                                    <td class="px-4 py-2">{{ $order->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-2 text-right">{{ number_format($order->total, 2) }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                                    <td class="px-4 py-2 text-right">
                                        <a href="{{ route('orders.show', $order) }}"
                                           class="px-3 py-1 bg-blue-600 text-white rounded text-xs">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
