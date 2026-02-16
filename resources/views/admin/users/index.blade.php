<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-800">&larr; Back to Dashboard</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-center">Admin</th>
                            <th class="px-4 py-2 text-right">Orders</th>
                            <th class="px-4 py-2 text-left">Joined</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $user->id }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:underline">{{ $user->name }}</a>
                                </td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2 text-center">
                                    @if ($user->is_admin)
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Yes</span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">No</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-right">{{ $user->orders->count() }}</td>
                                <td class="px-4 py-2">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="px-3 py-1 bg-blue-500 text-white rounded text-xs">View</a>
                                    @if (!$user->is_admin)
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete this user? This will also delete their orders and cart.')"
                                                    class="px-3 py-1 bg-red-600 text-white rounded text-xs">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-4 text-center text-gray-500">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
