@extends('layouts.app')

@section('title', 'Pengaturan - FinanceFlow')
@section('page-title', 'Pengaturan')
@section('page-subtitle', 'Pengaturan akun admin')

@section('content')
<div class="p-8">
    <div class="max-w-4xl mx-auto space-y-6">
        
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
            <div class="flex items-start">
                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Admin Settings Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user-shield text-blue-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Pengaturan Admin</h3>
                <p class="text-gray-600 max-w-md mx-auto mb-6">
                    Sebagai admin, Anda memiliki akses penuh ke sistem. Pengaturan kategori dan preferensi dikelola oleh masing-masing user.
                </p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-chart-bar mr-2"></i> Admin Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">
                        <i class="fas fa-users-cog mr-2"></i> User Management
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Profil Saya</h4>
                        <p class="text-sm text-gray-600 mb-3">Kelola informasi profil dan keamanan akun Anda</p>
                        <a href="{{ route('profile.edit') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                            Lihat Profil <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Keamanan</h4>
                        <p class="text-sm text-gray-600 mb-3">Update password dan pengaturan keamanan</p>
                        <a href="{{ route('profile.edit') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                            Pengaturan Keamanan <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
