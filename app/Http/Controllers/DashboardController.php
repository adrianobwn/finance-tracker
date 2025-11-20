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
        
        // Get transaction stats
        $stats = $this->transactionService->getTransactionStats($userId);
        
        // Get budget summary
        $budgetSummary = $this->budgetService->getBudgetSummary($userId);
        
        // Get recent transactions
        $recentTransactions = $this->transactionService->getRecentTransactions($userId, 3);
        
        // Get chart data (6 months trend)
        $chartData = $this->reportService->getTrendData($userId, 6);
        
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
