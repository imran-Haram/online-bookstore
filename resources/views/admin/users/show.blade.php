<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a href="{{ route('admin.users') }}" class="text-gray-600 hover:text-gray-800">&larr; Back to Users</a>
            </div>

            <!-- User Info -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">User Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="font-medium">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Role</p>
                        <p class="font-medium">
                            @if ($user->is_admin)
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Admin</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">Customer</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Joined</p>
                        <p class="font-medium">{{ $user->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- User Orders -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Order History ({{ $user->orders->count() }})</h3>

                @if ($user->orders->isEmpty())
                    <p class="text-gray-500">This user has no orders.</p>
                @else
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Order #</th>
                                <th class="px-4 py-2 text-right">Total</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Date</th>
                                <th class="px-4 py-2 text-left">Items</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->orders as $order)
                                <tr class="border-t">
                                    <td class="px-4 py-2">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600">#{{ $order->id }}</a>
                                    </td>
                                    <td class="px-4 py-2 text-right">{{ number_format($order->total, 2) }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 text-xs rounded-full
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                            @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">{{ $order->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 py-2">
                                        <ul class="list-disc list-inside text-gray-600">
                                            @foreach ($order->orderItems as $item)
                                                <li>{{ $item->book->title ?? 'Deleted Book' }} (x{{ $item->quantity }}) - {{ number_format($item->line_total, 2) }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
