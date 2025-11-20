<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalUsers' => User::count(),
            'activeUsers' => User::whereHas('transactions', function ($query) {
                $query->where('transaction_date', '>=', now()->subDays(30));
            })->count(),
            'totalTransactions' => Transaction::count(),
            'todayTransactions' => Transaction::whereDate('transaction_date', today())->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $activeUsers = User::withCount(['transactions' => function ($query) {
            $query->where('transaction_date', '>=', now()->subDays(30));
        }])->orderBy('transactions_count', 'desc')->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'activeUsers'));
    }
}
