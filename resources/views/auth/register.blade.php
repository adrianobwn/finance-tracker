<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - FinanceFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-purple-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-2xl mb-4">
                <i class="fas fa-wallet text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">FinanceFlow</h1>
            <p class="text-gray-600">Mulai kelola keuangan Anda hari ini</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Buat Akun Baru</h2>

            @if ($errors->any())
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

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user mr-1"></i> Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="John Doe"
                        required
                    >
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-1"></i> Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="nama@email.com"
                        required
                    >
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-1"></i> Password
                    </label>
                    <input 
                        type="password" 
                        name="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Minimal 8 karakter"
                        required
                    >
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i> Minimal 8 karakter
                    </p>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-1"></i> Konfirmasi Password
                    </label>
                    <input 
                        type="password" 
                        name="password_confirmation"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Ketik ulang password"
                        required
                    >
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition transform hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-blue-200"
                >
                    <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">atau</span>
                </div>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:text-blue-700">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>

        <!-- Features -->
        <div class="mt-6 grid grid-cols-2 gap-3">
            <div class="bg-white rounded-lg p-3 border border-gray-100 text-center">
                <i class="fas fa-chart-line text-blue-600 text-xl mb-1"></i>
                <p class="text-xs text-gray-600 font-medium">Laporan Real-time</p>
            </div>
            <div class="bg-white rounded-lg p-3 border border-gray-100 text-center">
                <i class="fas fa-bell text-blue-600 text-xl mb-1"></i>
                <p class="text-xs text-gray-600 font-medium">Notifikasi Anggaran</p>
            </div>
        </div>
    </div>
</body>
</html>
