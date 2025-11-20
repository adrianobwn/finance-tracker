@extends('layouts.app')

@section('title', 'Tambah Transaksi - FinanceFlow')
@section('page-title', 'Tambah Transaksi')
@section('page-subtitle', 'Buat transaksi baru')

@section('content')
<div class="p-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                
                <!-- Type Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Tipe Transaksi</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative">
                            <input type="radio" name="type" value="income" class="peer sr-only" checked>
                            <div class="flex items-center justify-center space-x-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 transition">
                                <i class="fas fa-arrow-up text-green-600 text-xl"></i>
                                <span class="font-semibold text-gray-700">Pemasukan</span>
                            </div>
                        </label>
                        <label class="relative">
                            <input type="radio" name="type" value="expense" class="peer sr-only">
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
                        <span class="absolute left-4 top-3 text-gray-500 font-medium">Rp</span>
                        <input type="number" name="amount" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="0" required>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <input type="text" name="description" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Contoh: Gaji bulanan" required>
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Pilih Kategori</option>
                        <optgroup label="Pemasukan">
                            @foreach($categories['income'] as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Pengeluaran">
                            @foreach($categories['expense'] as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>

                <!-- Date -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <!-- Buttons -->
                <div class="flex items-center space-x-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Transaksi
                    </button>
                    <a href="{{ route('transactions.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
