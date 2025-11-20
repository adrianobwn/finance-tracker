@extends('layouts.app')

@section('title', 'Tambah Anggaran - FinanceFlow')
@section('page-title', 'Tambah Anggaran')
@section('page-subtitle', 'Buat anggaran baru')

@section('content')
<div class="p-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('budgets.store') }}" method="POST">
                @csrf
                
                <!-- Name -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Anggaran</label>
                    <input type="text" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Contoh: Belanja Bulanan" required>
                </div>

                <!-- Amount -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Budget</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-500 font-medium">Rp</span>
                        <input type="number" name="amount" min="0" step="0.01" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="0" required>
                    </div>
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="category_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Kosongkan untuk anggaran semua kategori</p>
                </div>

                <!-- Period -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Periode</label>
                    <select name="period" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Pilih Periode</option>
                        <option value="weekly">Mingguan</option>
                        <option value="monthly">Bulanan</option>
                        <option value="yearly">Tahunan</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ date('Y-m-01') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Selesai</label>
                        <input type="date" name="end_date" value="{{ date('Y-m-t') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center space-x-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Anggaran
                    </button>
                    <a href="{{ route('budgets.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
