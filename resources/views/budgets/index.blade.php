@extends('layouts.app')

@section('title', 'Anggaran - FinanceFlow')
@section('page-title', 'Anggaran')
@section('page-subtitle', 'Kelola dan pantau anggaran keuangan Anda')

@section('content')
<div class="p-8">
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-lg flex items-start space-x-3">
        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
        <p class="text-sm text-green-800">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Summary Card -->
    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg p-8 text-white mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <p class="text-indigo-100 text-sm mb-1">Total Anggaran</p>
                <h3 class="text-3xl font-bold">Rp {{ number_format($summary['totalBudget'], 0, ',', '.') }}</h3>
            </div>
            <div>
                <p class="text-indigo-100 text-sm mb-1">Total Terpakai</p>
                <h3 class="text-3xl font-bold">Rp {{ number_format($summary['totalSpent'], 0, ',', '.') }}</h3>
            </div>
            <div>
                <p class="text-indigo-100 text-sm mb-1">Sisa Anggaran</p>
                <h3 class="text-3xl font-bold">Rp {{ number_format($summary['remaining'], 0, ',', '.') }}</h3>
            </div>
            <div>
                <p class="text-indigo-100 text-sm mb-1">Persentase</p>
                <h3 class="text-3xl font-bold">{{ $summary['percentage'] }}%</h3>
                <div class="w-full bg-white bg-opacity-20 rounded-full h-2 mt-2">
                    <div class="bg-white h-2 rounded-full transition-all duration-300" style="width: {{ $summary['percentage'] }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Button -->
    <div class="flex justify-end mb-6">
        <a href="{{ route('budgets.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold flex items-center space-x-2 shadow-lg">
            <i class="fas fa-plus"></i>
            <span>Tambah Anggaran</span>
        </a>
    </div>

    <!-- Budget Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
        @forelse($budgets as $budget)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-1">
                        <h4 class="text-lg font-bold text-gray-800">{{ $budget->name }}</h4>
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">{{ ucfirst($budget->period) }}</span>
                    </div>
                    <p class="text-sm text-gray-500">{{ $budget->category->name ?? 'Semua Kategori' }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('budgets.edit', $budget->id) }}" class="text-blue-600 hover:text-blue-800 transition p-2">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus anggaran ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 transition p-2">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mb-4">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <span class="text-xs text-gray-500">Terpakai</span>
                        <p class="text-sm font-bold text-gray-800">Rp {{ number_format($budget->spent, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-gray-500">Target</span>
                        <p class="text-sm font-bold text-gray-800">Rp {{ number_format($budget->amount, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="relative w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                    @php
                        $percentage = min($budget->percentage, 100);
                        $color = $budget->percentage >= 100 ? 'bg-red-500' : ($budget->percentage >= 90 ? 'bg-orange-500' : ($budget->percentage >= 70 ? 'bg-yellow-500' : 'bg-green-500'));
                    @endphp
                    <div class="h-4 rounded-full transition-all duration-300 {{ $color }} flex items-center justify-center" style="width: {{ $percentage }}%">
                        @if($percentage >= 15)
                        <span class="text-xs font-bold text-white">{{ $budget->percentage }}%</span>
                        @endif
                    </div>
                    @if($percentage < 15 && $budget->percentage > 0)
                    <span class="absolute left-2 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-600">{{ $budget->percentage }}%</span>
                    @endif
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Sisa Budget</p>
                    <p class="text-sm font-bold {{ $budget->remaining < 0 ? 'text-red-600' : 'text-green-600' }}">
                        Rp {{ number_format(abs($budget->remaining), 0, ',', '.') }}
                        @if($budget->remaining < 0)
                        <span class="text-xs">(Lebih)</span>
                        @endif
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 mb-1">Status</p>
                    @if($budget->percentage >= 100)
                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full font-medium">
                        <i class="fas fa-times-circle"></i> Melebihi
                    </span>
                    @elseif($budget->percentage >= 90)
                    <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs rounded-full font-medium">
                        <i class="fas fa-exclamation-circle"></i> Kritis
                    </span>
                    @elseif($budget->percentage >= 70)
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full font-medium">
                        <i class="fas fa-exclamation-triangle"></i> Peringatan
                    </span>
                    @else
                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">
                        <i class="fas fa-check-circle"></i> Aman
                    </span>
                    @endif
                </div>
            </div>

            <!-- Period -->
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-500">
                    <i class="fas fa-calendar mr-1"></i>
                    {{ $budget->start_date->format('d M Y') }} - {{ $budget->end_date->format('d M Y') }}
                </p>
            </div>
        </div>
        @empty
        @endforelse
    </div>

    @if(count($budgets) === 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
        <i class="fas fa-wallet text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Anggaran</h3>
        <p class="text-gray-600 mb-6">Mulai kelola keuangan Anda dengan membuat anggaran pertama</p>
        <a href="{{ route('budgets.create') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
            <i class="fas fa-plus mr-2"></i>
            Buat Anggaran Baru
        </a>
    </div>
    @endif
</div>
@endsection
