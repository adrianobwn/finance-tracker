@extends('layouts.app')

@section('title', 'Edit Transaksi - FinanceFlow')
@section('page-title', 'Edit Transaksi')
@section('page-subtitle', 'Ubah data transaksi')

@section('content')
<div class="p-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('transactions.update', $transaction['id']) }}" method="POST" id="transactionForm">
                @csrf
                @method('PUT')
                
                <!-- Type Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Tipe Transaksi</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative">
                            <input type="radio" name="type" value="income" class="peer sr-only transaction-type" {{ $transaction['type'] === 'income' ? 'checked' : '' }} onchange="filterCategories()">
                            <div class="flex items-center justify-center space-x-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 transition">
                                <i class="fas fa-arrow-up text-green-600 text-xl"></i>
                                <span class="font-semibold text-gray-700">Pemasukan</span>
                            </div>
                        </label>
                        <label class="relative">
                            <input type="radio" name="type" value="expense" class="peer sr-only transaction-type" {{ $transaction['type'] === 'expense' ? 'checked' : '' }} onchange="filterCategories()">
                            <div class="flex items-center justify-center space-x-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-500 peer-checked:bg-red-50 transition">
                                <i class="fas fa-arrow-down text-red-600 text-xl"></i>
                                <span class="font-semibold text-gray-700">Pengeluaran</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Amount -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-500 font-medium">{{ currency_symbol(auth()->user()->currency) }}</span>
                        <input type="text" id="amountDisplay" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="0" value="{{ number_format($transaction['amount'], 0, ',', '.') }}" oninput="formatAmount(this)" required>
                        <input type="hidden" name="amount" id="amountValue" value="{{ $transaction['amount'] }}" required>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Contoh: 1.000.000 untuk satu juta</p>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <input type="text" name="description" value="{{ $transaction['description'] }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Contoh: Gaji bulanan" required>
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="category_id" id="categorySelect" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories['income'] as $cat)
                        <option value="{{ $cat->id }}" data-type="income" {{ $transaction->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                        @foreach($categories['expense'] as $cat)
                        <option value="{{ $cat->id }}" data-type="expense" {{ $transaction->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i> Kelola kategori di menu Pengaturan
                    </p>
                </div>

                <!-- Date -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="transaction_date" value="{{ $transaction['date'] }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <!-- Buttons -->
                <div class="flex items-center space-x-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-save mr-2"></i>
                        Update Transaksi
                    </button>
                    <a href="{{ route('transactions.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function filterCategories() {
    const selectedType = document.querySelector('input[name="type"]:checked').value;
    const categorySelect = document.getElementById('categorySelect');
    const options = categorySelect.querySelectorAll('option[data-type]');
    const currentValue = categorySelect.value;
    
    // Show/hide options based on type
    options.forEach(option => {
        if (option.dataset.type === selectedType) {
            option.style.display = '';
        } else {
            option.style.display = 'none';
            // Deselect if hidden
            if (option.value === currentValue) {
                categorySelect.value = '';
            }
        }
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    filterCategories();
});

// Format amount with thousand separators
function formatAmount(input) {
    let value = input.value.replace(/\D/g, ''); // Remove non-digits
    
    if (value === '') {
        document.getElementById('amountValue').value = '';
        input.value = '';
        return;
    }
    
    // Format with thousand separator
    let formatted = new Intl.NumberFormat('id-ID').format(value);
    input.value = formatted;
    
    // Store raw value in hidden input
    document.getElementById('amountValue').value = value;
}
</script>

@endsection
