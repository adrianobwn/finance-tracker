@extends('layouts.app')

@section('title', 'Profil Saya - FinanceFlow')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi akun Anda')

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

        @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3"></i>
                <div>
                    @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-700">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Profile Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <div class="flex items-center space-x-6 mb-8">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-3xl">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <div class="mt-2">
                        <span class="px-3 py-1 bg-{{ $user->role->value === 'admin' ? 'purple' : 'blue' }}-100 text-{{ $user->role->value === 'admin' ? 'purple' : 'blue' }}-700 text-xs rounded-full font-medium">
                            {{ ucfirst($user->role->value) }}
                        </span>
                        <span class="ml-2 text-sm text-gray-500">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Bergabung {{ $user->created_at->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user mr-1"></i> Nama Lengkap
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name', $user->name) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            required
                        >
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-1"></i> Email
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            required
                        >
                    </div>
                </div>

                <div class="flex justify-end">
                    <button 
                        type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold"
                    >
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Update Password -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6">
                <i class="fas fa-lock mr-2"></i> Ubah Password
            </h3>

            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4 mb-6">
                    <!-- Current Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password Saat Ini</label>
                        <input 
                            type="password" 
                            name="current_password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            required
                        >
                    </div>

                    <!-- New Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                        <input 
                            type="password" 
                            name="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            required
                        >
                        <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <input 
                            type="password" 
                            name="password_confirmation"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            required
                        >
                    </div>
                </div>

                <div class="flex justify-end">
                    <button 
                        type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold"
                    >
                        <i class="fas fa-key mr-2"></i> Update Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Account -->
        <div class="bg-white rounded-xl shadow-sm border border-red-200 p-8">
            <h3 class="text-xl font-bold text-red-600 mb-4">
                <i class="fas fa-exclamation-triangle mr-2"></i> Zona Berbahaya
            </h3>
            <p class="text-gray-600 mb-6">Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen.</p>

            <button 
                onclick="document.getElementById('deleteModal').classList.remove('hidden')"
                class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold"
            >
                <i class="fas fa-trash mr-2"></i> Hapus Akun
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Hapus Akun?</h3>
            <p class="text-gray-600">Apakah Anda yakin ingin menghapus akun? Semua data akan hilang permanen.</p>
        </div>

        <form action="{{ route('profile.destroy') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Masukkan password untuk konfirmasi
                </label>
                <input 
                    type="password" 
                    name="password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                    required
                >
            </div>

            <div class="flex space-x-4">
                <button 
                    type="button"
                    onclick="document.getElementById('deleteModal').classList.add('hidden')"
                    class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold"
                >
                    Batal
                </button>
                <button 
                    type="submit"
                    class="flex-1 px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold"
                >
                    Hapus Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
