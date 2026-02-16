<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500">Total Users</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500">Total Books</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['total_books'] }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500">Total Orders</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['total_orders'] }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500">Total Revenue</div>
                    <div class="mt-1 text-3xl font-bold text-green-600">{{ number_format($stats['total_revenue'], 2) }}</div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="mb-8 flex space-x-4">
                <a href="{{ route('admin.users') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Manage Users</a>
                <a href="{{ route('admin.books') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Manage Books</a>
                <a href="{{ route('admin.orders') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Manage Orders</a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Orders -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Orders</h3>
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 text-left">Order #</th>
                                <th class="px-3 py-2 text-left">User</th>
                                <th class="px-3 py-2 text-right">Total</th>
                                <th class="px-3 py-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recent_orders as $order)
                                <tr class="border-t">
                                    <td class="px-3 py-2">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600">#{{ $order->id }}</a>
                                    </td>
                                    <td class="px-3 py-2">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td class="px-3 py-2 text-right">{{ number_format($order->total, 2) }}</td>
                                    <td class="px-3 py-2">
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Recent Users -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Users</h3>
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 text-left">Name</th>
                                <th class="px-3 py-2 text-left">Email</th>
                                <th class="px-3 py-2 text-left">Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recent_users as $user)
                                <tr class="border-t">
                                    <td class="px-3 py-2">
                                        <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600">{{ $user->name }}</a>
                                    </td>
                                    <td class="px-3 py-2">{{ $user->email }}</td>
                                    <td class="px-3 py-2">{{ $user->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
