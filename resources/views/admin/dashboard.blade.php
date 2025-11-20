@extends('layouts.app')

@section('title', 'Admin Dashboard - FinanceFlow')
@section('page-title', 'Admin Dashboard')
@section('page-subtitle', 'Monitor aktivitas pengguna dan sistem')

@section('content')
<div class="p-8">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Users</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $stats['totalUsers'] }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Registered users</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Active Users -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Active Users</p>
                    <h3 class="text-3xl font-bold text-green-600">{{ $stats['activeUsers'] }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Last 30 days</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-check text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Transactions -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Transactions</p>
                    <h3 class="text-3xl font-bold text-purple-600">{{ number_format($stats['totalTransactions']) }}</h3>
                    <p class="text-xs text-gray-400 mt-1">All time</p>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exchange-alt text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Today Transactions -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Today</p>
                    <h3 class="text-3xl font-bold text-orange-600">{{ $stats['todayTransactions'] }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Transactions today</p>
                </div>
                <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-day text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800">Recent Users</h3>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="space-y-4">
                @foreach($recentUsers as $user)
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 last:border-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="px-2 py-1 bg-{{ $user->role->value === 'admin' ? 'purple' : 'blue' }}-100 text-{{ $user->role->value === 'admin' ? 'purple' : 'blue' }}-700 text-xs rounded-full font-medium">
                            {{ ucfirst($user->role->value) }}
                        </span>
                        <p class="text-xs text-gray-400 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Most Active Users -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-800">Most Active Users</h3>
                <p class="text-sm text-gray-500">Last 30 days activity</p>
            </div>
            <div class="space-y-4">
                @foreach($activeUsers as $user)
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 last:border-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-green-600">{{ $user->transactions_count }}</p>
                        <p class="text-xs text-gray-400">transactions</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
