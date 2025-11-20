@extends('layouts.app')

@section('title', 'User Management - FinanceFlow')
@section('page-title', 'User Management')
@section('page-subtitle', 'Kelola pengguna sistem')

@section('content')
<div class="p-8">
    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
        <div class="flex items-start">
            <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3"></i>
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Header Actions -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold text-gray-800">All Users</h3>
            <p class="text-sm text-gray-500">Total {{ $users->total() }} users</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
            <i class="fas fa-plus mr-2"></i> Add New User
        </a>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase">User</th>
                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase">Email</th>
                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase">Role</th>
                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase">Transactions</th>
                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase">Joined</th>
                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-4 px-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                    </td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-{{ $user->role->value === 'admin' ? 'purple' : 'blue' }}-100 text-{{ $user->role->value === 'admin' ? 'purple' : 'blue' }}-700 text-xs rounded-full font-medium">
                            {{ ucfirst($user->role->value) }}
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <p class="text-sm font-semibold text-gray-800">{{ $user->transactions_count }}</p>
                    </td>
                    <td class="py-4 px-6">
                        <p class="text-sm text-gray-600">{{ $user->created_at->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-800 transition p-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition p-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
