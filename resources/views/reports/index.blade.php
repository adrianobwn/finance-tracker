@extends('layouts.app')

@section('title', 'Laporan - FinanceFlow')
@section('page-title', 'Laporan Keuangan')
@section('page-subtitle', 'Analisis dan ringkasan keuangan Anda')

@section('content')
<div class="p-8">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-gray-500">Total Pemasukan</p>
                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-arrow-up text-green-600"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ format_currency($summary['totalIncome'], auth()->user()->currency) }}</h3>
            <p class="text-xs text-gray-400 mt-1">Total tahun ini</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-gray-500">Total Pengeluaran</p>
                <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-arrow-down text-red-600"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ format_currency($summary['totalExpense'], auth()->user()->currency) }}</h3>
            <p class="text-xs text-gray-400 mt-1">Total tahun ini</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-gray-500">Tabungan Bersih</p>
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-piggy-bank text-blue-600"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ format_currency($summary['netSavings'], auth()->user()->currency) }}</h3>
            <p class="text-xs text-gray-400 mt-1">Total tahun ini</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-gray-500">Tingkat Tabungan</p>
                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-percentage text-purple-600"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $summary['savingsRate'] }}%</h3>
            <p class="text-xs text-gray-400 mt-1">Dari total pemasukan</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <form action="{{ route('reports.index') }}" method="GET" id="filterForm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800">Filter Laporan</h3>
                <a href="{{ route('reports.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                    <i class="fas fa-file-excel mr-2"></i>
                    Export Excel
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Periode</label>
                    <select id="periodSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" onchange="updateDateRange()">
                        <option value="custom">Custom</option>
                        <option value="today">Hari Ini</option>
                        <option value="this_week">Minggu Ini</option>
                        <option value="this_month">Bulan Ini</option>
                        <option value="this_year" selected>Tahun Ini</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" name="start_date" id="startDate" value="{{ $startDate }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="endDate" value="{{ $endDate }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition text-sm font-medium">
                        <i class="fas fa-filter mr-2"></i>
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Monthly Trend Chart -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-800">Tren Bulanan</h3>
                <p class="text-sm text-gray-500">Perbandingan pemasukan dan pengeluaran per bulan</p>
            </div>
            <div class="h-80">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Category Breakdown -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-800">Kategori Pengeluaran</h3>
                <p class="text-sm text-gray-500">Breakdown per kategori</p>
            </div>
            <div class="space-y-4">
                @foreach($categoryExpenses as $cat)
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-700">{{ $cat['category'] }}</span>
                        <span class="text-sm font-bold text-gray-800">{{ $cat['percentage'] }}%</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full transition-all duration-300" style="width: {{ $cat['percentage'] }}%"></div>
                        </div>
                        <span class="text-sm text-gray-600 whitespace-nowrap">{{ format_currency($cat['amount'], auth()->user()->currency) }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pie Chart -->
            <div class="mt-8 h-64">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Breakdown Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mt-8">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800">Rincian Bulanan</h3>
            <p class="text-sm text-gray-500">Detail pemasukan dan pengeluaran per bulan</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Bulan</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Pemasukan</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Pengeluaran</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Tabungan</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Tingkat Tabungan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($monthlyData['labels'] as $index => $month)
                    @php
                        $income = $monthlyData['income'][$index];
                        $expense = $monthlyData['expense'][$index];
                        $savings = $income - $expense;
                        $rate = $income > 0 ? round(($savings / $income) * 100) : 0;
                    @endphp
                    @if($income > 0)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">{{ $month }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-green-600 font-semibold">
                            +{{ format_currency($income, auth()->user()->currency) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-red-600 font-semibold">
                            -{{ format_currency($expense, auth()->user()->currency) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-gray-800">
                            {{ format_currency($savings, auth()->user()->currency) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $rate >= 50 ? 'bg-green-100 text-green-700' : ($rate >= 30 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ $rate }}%
                            </span>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const currencySymbol = '{{ currency_symbol(auth()->user()->currency) }}';
    // Monthly Trend Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: @json($monthlyData['labels']),
            datasets: [
                {
                    label: 'Pemasukan',
                    data: @json($monthlyData['income']),
                    backgroundColor: 'rgba(34, 197, 94, 0.8)',
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 2,
                },
                {
                    label: 'Pengeluaran',
                    data: @json($monthlyData['expense']),
                    backgroundColor: 'rgba(239, 68, 68, 0.8)',
                    borderColor: 'rgb(239, 68, 68)',
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
                        font: { size: 12, family: 'Inter' }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + currencySymbol + ' ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return currencySymbol + ' ' + (value / 1000000) + 'jt';
                        }
                    }
                }
            }
        }
    });

    // Category Pie Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: @json(array_column($categoryExpenses, 'category')),
            datasets: [{
                data: @json(array_column($categoryExpenses, 'amount')),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(251, 146, 60, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(156, 163, 175, 0.8)',
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: { size: 11, family: 'Inter' },
                        generateLabels: function(chart) {
                            const data = chart.data;
                            return data.labels.map((label, i) => {
                                const value = data.datasets[0].data[i];
                                const percentage = @json(array_column($categoryExpenses, 'percentage'))[i];
                                return {
                                    text: label + ' (' + percentage + '%)',
                                    fillStyle: data.datasets[0].backgroundColor[i],
                                    hidden: false,
                                    index: i
                                };
                            });
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const percentage = @json(array_column($categoryExpenses, 'percentage'))[context.dataIndex];
                            return context.label + ': ' + currencySymbol + ' ' + context.parsed.toLocaleString('id-ID') + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Period selector functionality
    function updateDateRange() {
        const period = document.getElementById('periodSelect').value;
        const today = new Date();
        let startDate, endDate;

        switch(period) {
            case 'today':
                startDate = endDate = today.toISOString().split('T')[0];
                break;
            case 'this_week':
                const firstDayOfWeek = new Date(today.setDate(today.getDate() - today.getDay()));
                startDate = firstDayOfWeek.toISOString().split('T')[0];
                endDate = new Date().toISOString().split('T')[0];
                break;
            case 'this_month':
                startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
                endDate = new Date().toISOString().split('T')[0];
                break;
            case 'this_year':
                startDate = new Date(today.getFullYear(), 0, 1).toISOString().split('T')[0];
                endDate = new Date().toISOString().split('T')[0];
                break;
            default:
                return; // Custom - do nothing
        }

        document.getElementById('startDate').value = startDate;
        document.getElementById('endDate').value = endDate;
    }
</script>
@endsection
