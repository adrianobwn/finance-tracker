@extends('layouts.app')

@section('title', 'Edit Anggaran - FinanceFlow')
@section('page-title', 'Edit Anggaran')
@section('page-subtitle', 'Ubah data anggaran')

@section('content')
<div class="p-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('budgets.update', $budget['id']) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Name -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Anggaran</label>
                    <input type="text" name="name" value="{{ $budget['name'] }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Contoh: Belanja Bulanan" required>
                </div>

                <!-- Amount -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Anggaran</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-500 font-medium">Rp</span>
                        <input type="number" name="amount" value="{{ $budget['amount'] }}" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="0" required>
                    </div>
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ $budget['category'] === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Period -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Periode</label>
                    <select name="period" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Pilih Periode</option>
                        <option value="weekly" {{ $budget['period'] === 'weekly' ? 'selected' : '' }}>Mingguan</option>
                        <option value="monthly" {{ $budget['period'] === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                        <option value="yearly" {{ $budget['period'] === 'yearly' ? 'selected' : '' }}>Tahunan</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ $budget['start_date'] }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Selesai</label>
                        <input type="date" name="end_date" value="{{ $budget['end_date'] }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center space-x-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-save mr-2"></i>
                        Update Anggaran
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
