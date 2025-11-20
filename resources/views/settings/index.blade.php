@extends('layouts.app')

@section('title', 'Pengaturan - FinanceFlow')
@section('page-title', 'Pengaturan')
@section('page-subtitle', 'Kelola preferensi dan kategori kustom')

@section('content')
<div class="p-8">
    <div class="max-w-6xl mx-auto space-y-6">
        
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
            <div class="flex items-start">
                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3"></i>
                <p class="text-sm text-red-700">{{ session('error') }}</p>
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

        <!-- Categories Management -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-tags mr-2"></i> Kategori Transaksi
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Kelola kategori untuk transaksi Anda</p>
                </div>
                <button 
                    onclick="document.getElementById('addCategoryModal').classList.remove('hidden')"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold"
                >
                    <i class="fas fa-plus mr-2"></i> Tambah Kategori
                </button>
            </div>

            <!-- Categories List -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @php
                    $incomeCategories = $categories->where('type', App\Enums\TransactionType::INCOME);
                    $expenseCategories = $categories->where('type', App\Enums\TransactionType::EXPENSE);
                @endphp

                <!-- Income Categories -->
                <div>
                    <h4 class="text-sm font-bold text-green-600 mb-3 flex items-center">
                        <i class="fas fa-arrow-up mr-2"></i> Pemasukan
                    </h4>
                    <div class="space-y-2">
                        @foreach($incomeCategories as $category)
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:border-green-300 transition">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ $category->color }}20;">
                                    <i class="fas {{ $category->icon }}" style="color: {{ $category->color }};"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $category->name }}</p>
                                    @if($category->is_default)
                                    <span class="text-xs text-gray-500">
                                        <i class="fas fa-star text-yellow-500"></i> Default
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @if(!$category->is_default)
                            <div class="flex items-center space-x-1">
                                <button 
                                    onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->icon }}', '{{ $category->color }}')"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded transition"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('settings.category.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Expense Categories -->
                <div>
                    <h4 class="text-sm font-bold text-red-600 mb-3 flex items-center">
                        <i class="fas fa-arrow-down mr-2"></i> Pengeluaran
                    </h4>
                    <div class="space-y-2">
                        @foreach($expenseCategories as $category)
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:border-red-300 transition">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ $category->color }}20;">
                                    <i class="fas {{ $category->icon }}" style="color: {{ $category->color }};"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $category->name }}</p>
                                    @if($category->is_default)
                                    <span class="text-xs text-gray-500">
                                        <i class="fas fa-star text-yellow-500"></i> Default
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @if(!$category->is_default)
                            <div class="flex items-center space-x-1">
                                <button 
                                    onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->icon }}', '{{ $category->color }}')"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded transition"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('settings.category.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Preferences -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6">
                <i class="fas fa-cog mr-2"></i> Preferensi
            </h3>

            <div class="space-y-6">
                <!-- Currency - Fixed to Rupiah -->
                <div class="flex items-center justify-between pb-6 border-b border-gray-200">
                    <div>
                        <p class="font-semibold text-gray-800">Mata Uang</p>
                        <p class="text-sm text-gray-600">Mata uang yang digunakan untuk transaksi</p>
                    </div>
                    <div class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-700 font-semibold">
                        IDR - Rupiah Indonesia
                    </div>
                </div>

                <!-- Language - Fixed to Indonesian -->
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">Bahasa</p>
                        <p class="text-sm text-gray-600">Bahasa tampilan aplikasi</p>
                    </div>
                    <div class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-700 font-semibold">
                        Bahasa Indonesia
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div id="addCategoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Tambah Kategori Baru</h3>

        <form action="{{ route('settings.category.store') }}" method="POST">
            @csrf

            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
                    <input 
                        type="text" 
                        name="name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh: Investasi"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe</label>
                    <select name="type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        <option value="income">Pemasukan</option>
                        <option value="expense">Pengeluaran</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Icon (Font Awesome)</label>
                    <select 
                        name="icon"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required
                    >
                        <option value="fa-wallet">💰 Wallet</option>
                        <option value="fa-money-bill">💵 Money</option>
                        <option value="fa-credit-card">💳 Credit Card</option>
                        <option value="fa-shopping-bag">🛍️ Shopping</option>
                        <option value="fa-utensils">🍴 Food</option>
                        <option value="fa-car">🚗 Car</option>
                        <option value="fa-home">🏠 Home</option>
                        <option value="fa-plane">✈️ Travel</option>
                        <option value="fa-heart">❤️ Health</option>
                        <option value="fa-gamepad">🎮 Entertainment</option>
                        <option value="fa-book">📚 Education</option>
                        <option value="fa-gift">🎁 Gift</option>
                        <option value="fa-chart-line">📈 Investment</option>
                        <option value="fa-briefcase">💼 Work</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Warna</label>
                    <input 
                        type="color" 
                        name="color"
                        class="w-full h-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        value="#3B82F6"
                        required
                    >
                </div>
            </div>

            <div class="flex space-x-4">
                <button 
                    type="button"
                    onclick="document.getElementById('addCategoryModal').classList.add('hidden')"
                    class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold"
                >
                    Batal
                </button>
                <button 
                    type="submit"
                    class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold"
                >
                    Tambah
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="editCategoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Edit Kategori</h3>

        <form id="editCategoryForm" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
                    <input 
                        type="text" 
                        id="edit_name"
                        name="name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Icon (Font Awesome)</label>
                    <select 
                        id="edit_icon"
                        name="icon"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required
                    >
                        <option value="fa-wallet">💰 Wallet</option>
                        <option value="fa-money-bill">💵 Money</option>
                        <option value="fa-credit-card">💳 Credit Card</option>
                        <option value="fa-shopping-bag">🛍️ Shopping</option>
                        <option value="fa-utensils">🍴 Food</option>
                        <option value="fa-car">🚗 Car</option>
                        <option value="fa-home">🏠 Home</option>
                        <option value="fa-plane">✈️ Travel</option>
                        <option value="fa-heart">❤️ Health</option>
                        <option value="fa-gamepad">🎮 Entertainment</option>
                        <option value="fa-book">📚 Education</option>
                        <option value="fa-gift">🎁 Gift</option>
                        <option value="fa-chart-line">📈 Investment</option>
                        <option value="fa-briefcase">💼 Work</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Warna</label>
                    <input 
                        type="color" 
                        id="edit_color"
                        name="color"
                        class="w-full h-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>
            </div>

            <div class="flex space-x-4">
                <button 
                    type="button"
                    onclick="document.getElementById('editCategoryModal').classList.add('hidden')"
                    class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold"
                >
                    Batal
                </button>
                <button 
                    type="submit"
                    class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function editCategory(id, name, icon, color) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_icon').value = icon;
    document.getElementById('edit_color').value = color;
    document.getElementById('editCategoryForm').action = `/settings/category/${id}`;
    document.getElementById('editCategoryModal').classList.remove('hidden');
}
</script>
@endsection
