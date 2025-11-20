@extends('layouts.app')

@section('title', 'Edit User - FinanceFlow')
@section('page-title', 'Edit User')
@section('page-subtitle', 'Update informasi user')

@section('content')
<div class="p-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            
            @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
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

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- User Info (Read Only) -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Lengkap</label>
                            <p class="text-gray-800 font-medium">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Email</label>
                            <p class="text-gray-800 font-medium">{{ $user->email }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">
                        <i class="fas fa-info-circle mr-1"></i> Data user hanya bisa diubah oleh user yang bersangkutan
                    </p>
                </div>

                <!-- Role (Only editable field) -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user-tag mr-1"></i> Role
                    </label>
                    <select 
                        name="role"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        required
                    >
                        <option value="user" {{ old('role', $user->role->value) === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role', $user->role->value) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i> Admin memiliki akses penuh ke sistem
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex items-center space-x-4">
                    <button 
                        type="submit"
                        class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold"
                    >
                        <i class="fas fa-save mr-2"></i> Update Role
                    </button>
                    <a 
                        href="{{ route('admin.users.index') }}"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
