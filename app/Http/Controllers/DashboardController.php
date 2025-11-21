<?php

namespace App\Http\Controllers;

use App\Services\Finance\TransactionServiceInterface;
use App\Services\Finance\BudgetServiceInterface;
use App\Services\Finance\ReportServiceInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private TransactionServiceInterface $transactionService,
        private BudgetServiceInterface $budgetService,
        private ReportServiceInterface $reportService
    ) {}

    public function index(Request $request)
    {
        $userId = auth()->id();
        $isAdmin = auth()->user()->role->value === 'admin';
        
        // Admin sees all data, regular users see only their own
        if ($isAdmin) {
            $userId = null; // null means all users
        }
        
        // Handle date filtering
        $startDate = null;
        $endDate = null;
        
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
        } elseif ($request->has('period')) {
            $period = $request->period;
            switch ($period) {
                case 'this_month':
                    $startDate = now()->startOfMonth()->format('Y-m-d');
                    $endDate = now()->endOfMonth()->format('Y-m-d');
                    break;
                case 'last_month':
                    $startDate = now()->subMonth()->startOfMonth()->format('Y-m-d');
                    $endDate = now()->subMonth()->endOfMonth()->format('Y-m-d');
                    break;
                case 'this_year':
                    $startDate = now()->startOfYear()->format('Y-m-d');
                    $endDate = now()->endOfYear()->format('Y-m-d');
                    break;
                case 'all':
                    $startDate = null;
                    $endDate = null;
                    break;
            }
        } else {
            // Default: this month
            $startDate = now()->startOfMonth()->format('Y-m-d');
            $endDate = now()->endOfMonth()->format('Y-m-d');
        }
        
        // Get transaction stats with date filter
        $stats = $this->transactionService->getTransactionStats($userId, $startDate, $endDate);
        
        // Get budget summary
        $budgetSummary = $this->budgetService->getBudgetSummary($userId);
        
        // Get recent transactions
        $recentTransactions = $this->transactionService->getRecentTransactions($userId, 3);
        
        // Get chart data - use filtered date range if available, otherwise 6 months trend
        if ($startDate && $endDate) {
            $chartData = $this->reportService->getTrendDataByDateRange($userId, $startDate, $endDate);
        } else {
            $chartData = $this->reportService->getTrendData($userId, 6);
        }
        
        return view('dashboard', [
            'totalSales' => $stats['balance'],
            'totalIncome' => $stats['totalIncome'],
            'totalExpense' => $stats['totalExpense'],
            'budgetPercentage' => $budgetSummary['percentage'] ?? 0,
            'recentTransactions' => $recentTransactions,
            'chartData' => $chartData,
        ]);
    }
}
