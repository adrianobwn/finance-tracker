<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data dummy untuk demo
        $data = [
            'totalSales' => 15750000,
            'totalIncome' => 25000000,
            'totalExpense' => 9250000,
            'budgetPercentage' => 75,
            'recentTransactions' => [
                [
                    'id' => 1,
                    'description' => 'Gaji Bulanan',
                    'category' => 'Gaji',
                    'amount' => 10000000,
                    'type' => 'income',
                    'date' => '2024-11-16'
                ],
                [
                    'id' => 2,
                    'description' => 'Makan siang tim',
                    'category' => 'Makanan',
                    'amount' => -150000,
                    'type' => 'expense',
                    'date' => '2024-11-17'
                ],
                [
                    'id' => 3,
                    'description' => 'Grab ke kantor',
                    'category' => 'Transport',
                    'amount' => -75000,
                    'type' => 'expense',
                    'date' => '2024-11-18'
                ],
            ],
            'chartData' => [
                'labels' => ['Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'income' => [18000000, 19500000, 20000000, 22000000, 25000000],
                'expense' => [6500000, 7000000, 7500000, 8000000, 9250000]
            ]
        ];

        return view('dashboard', $data);
    }
}
