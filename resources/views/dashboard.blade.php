@extends('layouts.app')

@section('title', 'Dashboard - FinanceFlow')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan keuangan Anda bulan ini')

@section('content')
<div class="p-8">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Saldo Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Saldo</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ format_currency($totalSales, auth()->user()->currency) }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Saldo saat ini</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-wallet text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Pemasukan Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Pemasukan</p>
                    <h3 class="text-2xl font-bold text-green-600">{{ format_currency($totalIncome, auth()->user()->currency) }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Bulan ini</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-arrow-up text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Pengeluaran Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Pengeluaran</p>
                    <h3 class="text-2xl font-bold text-red-600">{{ format_currency($totalExpense, auth()->user()->currency) }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Bulan ini</p>
                </div>
                <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-arrow-down text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Anggaran Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Anggaran</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $budgetPercentage }}%</h3>
                    <p class="text-xs text-gray-400 mt-1">Dari total anggaran</p>
                </div>
                <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-pie text-orange-600 text-xl"></i>
                </div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                <div class="bg-orange-500 h-2 rounded-full transition-all duration-300" style="width: {{ $budgetPercentage }}%"></div>
            </div>
        </div>
    </div>

    <!-- Budget Warning Alert -->
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8 rounded-lg flex items-start space-x-3">
        <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
        <div>
            <p class="text-sm text-yellow-800">
                <span class="font-semibold">Peringatan Anggaran</span><br>
                Pengeluaran anggaran Anda sudah mencapai {{ $budgetPercentage }}%. Pertimbangkan untuk mengatur pengeluaran.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Tren Keuangan Chart -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-800">Tren Keuangan</h3>
                <p class="text-sm text-gray-500">Grafik pemasukan dan pengeluaran 6 bulan terakhir</p>
            </div>
            <div class="h-80">
                <canvas id="financeChart"></canvas>
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-800">Transaksi Terbaru</h3>
                <p class="text-sm text-gray-500">5 transaksi terakhir Anda</p>
            </div>
            <div class="space-y-4">
                @forelse($recentTransactions as $transaction)
                <div class="flex items-start justify-between pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 {{ $transaction->type->value === 'income' ? 'bg-green-50' : 'bg-red-50' }} rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas {{ $transaction->type->value === 'income' ? 'fa-plus text-green-600' : 'fa-minus text-red-600' }}"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $transaction->description }}</p>
                            <p class="text-xs text-gray-500">{{ $transaction->category->name }} • {{ $transaction->transaction_date->format('d-m-Y') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-semibold {{ $transaction->type->value === 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type->value === 'income' ? '+' : '-'}}{{ format_currency($transaction->amount, auth()->user()->currency) }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-2"></i>
                    <p>Belum ada transaksi</p>
                </div>
                @endforelse
            </div>
            <button class="w-full mt-6 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                Lihat Semua Transaksi
            </button>
        </div>
    </div>
</div>

<script>
    const currencySymbol = '{{ currency_symbol(auth()->user()->currency) }}';
    // Chart.js Configuration
    const ctx = document.getElementById('financeChart').getContext('2d');
    
    // Parse data dan pastikan dalam format number yang benar
    const chartLabels = @json($chartData['labels']);
    const incomeData = @json($chartData['income']).map(val => parseFloat(val) || 0);
    const expenseData = @json($chartData['expense']).map(val => parseFloat(val) || 0);
    
    // Debug: Log data ke console
    console.log('Labels:', chartLabels);
    console.log('Income:', incomeData);
    console.log('Expense:', expenseData);
    
    const financeChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: incomeData,
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                },
                {
                    label: 'Pengeluaran',
                    data: expenseData,
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: {
                            size: 12,
                            family: 'Inter'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 13,
                        family: 'Inter'
                    },
                    bodyFont: {
                        size: 12,
                        family: 'Inter'
                    },
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y >= 1000000) {
                                label += currencySymbol + ' ' + (context.parsed.y / 1000000).toFixed(1) + ' jt';
                            } else if (context.parsed.y >= 1000) {
                                label += currencySymbol + ' ' + (context.parsed.y / 1000).toFixed(0) + ' rb';
                            } else {
                                label += currencySymbol + ' ' + context.parsed.y.toLocaleString('id-ID');
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) {
                                return currencySymbol + ' ' + (value / 1000000).toFixed(1) + 'jt';
                            } else if (value >= 1000) {
                                return currencySymbol + ' ' + (value / 1000).toFixed(0) + 'rb';
                            } else if (value === 0) {
                                return currencySymbol + ' 0';
                            } else {
                                return currencySymbol + ' ' + value.toLocaleString('id-ID');
                            }
                        },
                        font: {
                            size: 11,
                            family: 'Inter'
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11,
                            family: 'Inter'
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
