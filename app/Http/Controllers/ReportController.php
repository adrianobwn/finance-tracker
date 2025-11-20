<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $monthlyData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'income' => [15000000, 18000000, 16000000, 19000000, 17000000, 20000000, 22000000, 21000000, 23000000, 24000000, 25000000, 0],
            'expense' => [8000000, 8500000, 7500000, 9000000, 8200000, 9500000, 10000000, 9800000, 10500000, 11000000, 9250000, 0]
        ];

        $categoryExpenses = [
            ['category' => 'Makanan', 'amount' => 3000000, 'percentage' => 32],
            ['category' => 'Transport', 'amount' => 2000000, 'percentage' => 22],
            ['category' => 'Belanja', 'amount' => 1500000, 'percentage' => 16],
            ['category' => 'Entertainment', 'amount' => 1250000, 'percentage' => 14],
            ['category' => 'Tagihan', 'amount' => 1000000, 'percentage' => 11],
            ['category' => 'Lainnya', 'amount' => 500000, 'percentage' => 5],
        ];

        $summary = [
            'totalIncome' => 220000000,
            'totalExpense' => 101250000,
            'netSavings' => 118750000,
            'savingsRate' => 54
        ];

        return view('reports.index', compact('monthlyData', 'categoryExpenses', 'summary'));
    }
}
