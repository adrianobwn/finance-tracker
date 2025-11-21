<?php

namespace App\Services\Finance;

use App\Enums\TransactionType;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class ReportService implements ReportServiceInterface
{
    public function getMonthlyReport(?int $userId, int $year): array
    {
        $months = [];
        $income = [];
        $expense = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $startDate = "{$year}-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01";
            $endDate = date('Y-m-t', strtotime($startDate));
            
            $months[] = date('M', strtotime($startDate));
            
            $incomeQuery = Transaction::query()->byType(TransactionType::INCOME)->inDateRange($startDate, $endDate);
            if ($userId !== null) {
                $incomeQuery->forUser($userId);
            }
            $monthIncome = $incomeQuery->sum('amount');
            
            $expenseQuery = Transaction::query()->byType(TransactionType::EXPENSE)->inDateRange($startDate, $endDate);
            if ($userId !== null) {
                $expenseQuery->forUser($userId);
            }
            $monthExpense = $expenseQuery->sum('amount');
            
            $income[] = (float) $monthIncome;
            $expense[] = (float) $monthExpense;
        }
        
        return [
            'labels' => $months,
            'income' => $income,
            'expense' => $expense,
        ];
    }
    
    public function getCategoryBreakdown(?int $userId, string $startDate, string $endDate): array
    {
        $query = Transaction::with('category')
            ->byType(TransactionType::EXPENSE)
            ->inDateRange($startDate, $endDate);
        
        if ($userId !== null) {
            $query->forUser($userId);
        }
        
        $breakdown = $query
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->get();
        
        $totalExpense = $breakdown->sum('total');
        
        return $breakdown->map(function ($item) use ($totalExpense) {
            $percentage = $totalExpense > 0 ? round(($item->total / $totalExpense) * 100, 2) : 0;
            
            return [
                'category' => $item->category->name,
                'amount' => (float) $item->total,
                'percentage' => $percentage,
                'color' => $item->category->color,
            ];
        })->toArray();
    }
    
    public function getFinancialSummary(?int $userId, string $startDate, string $endDate): array
    {
        $incomeQuery = Transaction::query()->byType(TransactionType::INCOME)->inDateRange($startDate, $endDate);
        if ($userId !== null) {
            $incomeQuery->forUser($userId);
        }
        $totalIncome = $incomeQuery->sum('amount');
        
        $expenseQuery = Transaction::query()->byType(TransactionType::EXPENSE)->inDateRange($startDate, $endDate);
        if ($userId !== null) {
            $expenseQuery->forUser($userId);
        }
        $totalExpense = $expenseQuery->sum('amount');
        
        $netSavings = $totalIncome - $totalExpense;
        $savingsRate = $totalIncome > 0 ? round(($netSavings / $totalIncome) * 100, 2) : 0;
        
        return [
            'totalIncome' => (float) $totalIncome,
            'totalExpense' => (float) $totalExpense,
            'netSavings' => (float) $netSavings,
            'savingsRate' => $savingsRate,
        ];
    }
    
    public function getTrendData(?int $userId, int $months = 6): array
    {
        $labels = [];
        $income = [];
        $expense = [];
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $startDate = $date->startOfMonth()->format('Y-m-d');
            $endDate = $date->endOfMonth()->format('Y-m-d');
            
            $labels[] = $date->format('M');
            
            $incomeQuery = Transaction::query()->byType(TransactionType::INCOME)->inDateRange($startDate, $endDate);
            $expenseQuery = Transaction::query()->byType(TransactionType::EXPENSE)->inDateRange($startDate, $endDate);
            
            if ($userId !== null) {
                $incomeQuery->forUser($userId);
                $expenseQuery->forUser($userId);
            }
            
            $monthIncome = $incomeQuery->sum('amount');
            $monthExpense = $expenseQuery->sum('amount');
            
            $income[] = (float) $monthIncome;
            $expense[] = (float) $monthExpense;
        }
        
        return [
            'labels' => $labels,
            'income' => $income,
            'expense' => $expense,
        ];
    }
    
    public function getTrendDataByDateRange(?int $userId, string $startDate, string $endDate): array
    {
        $labels = [];
        $income = [];
        $expense = [];
        
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        
        // Calculate difference in days
        $diffInDays = $start->diffInDays($end);
        
        // If range is more than 60 days, group by month, otherwise by day
        if ($diffInDays > 60) {
            // Group by month
            $currentDate = $start->copy()->startOfMonth();
            $endMonth = $end->copy()->endOfMonth();
            
            while ($currentDate <= $endMonth) {
                $monthStart = $currentDate->format('Y-m-d');
                $monthEnd = $currentDate->copy()->endOfMonth()->format('Y-m-d');
                
                // Don't go beyond the end date
                if ($currentDate->copy()->endOfMonth() > $end) {
                    $monthEnd = $end->format('Y-m-d');
                }
                
                $labels[] = $currentDate->format('M Y');
                
                $incomeQuery = Transaction::query()->byType(TransactionType::INCOME)->inDateRange($monthStart, $monthEnd);
                $expenseQuery = Transaction::query()->byType(TransactionType::EXPENSE)->inDateRange($monthStart, $monthEnd);
                
                if ($userId !== null) {
                    $incomeQuery->forUser($userId);
                    $expenseQuery->forUser($userId);
                }
                
                $income[] = (float) $incomeQuery->sum('amount');
                $expense[] = (float) $expenseQuery->sum('amount');
                
                $currentDate->addMonth();
            }
        } else {
            // Group by day
            $currentDate = $start->copy();
            
            while ($currentDate <= $end) {
                $dayDate = $currentDate->format('Y-m-d');
                
                $labels[] = $currentDate->format('d M');
                
                $incomeQuery = Transaction::query()->byType(TransactionType::INCOME)->whereDate('transaction_date', $dayDate);
                $expenseQuery = Transaction::query()->byType(TransactionType::EXPENSE)->whereDate('transaction_date', $dayDate);
                
                if ($userId !== null) {
                    $incomeQuery->forUser($userId);
                    $expenseQuery->forUser($userId);
                }
                
                $income[] = (float) $incomeQuery->sum('amount');
                $expense[] = (float) $expenseQuery->sum('amount');
                
                $currentDate->addDay();
            }
        }
        
        return [
            'labels' => $labels,
            'income' => $income,
            'expense' => $expense,
        ];
    }
}
