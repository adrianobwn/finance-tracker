<?php

namespace App\Services\Finance;

use App\Models\Budget;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BudgetService implements BudgetServiceInterface
{
    public function getAllBudgets(int $userId): Collection
    {
        return Budget::with('category')
            ->forUser($userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    public function getActiveBudgets(int $userId): Collection
    {
        return Budget::with('category')
            ->forUser($userId)
            ->active()
            ->get();
    }
    
    public function getBudgetById(int $id, int $userId): ?Budget
    {
        return Budget::with('category')
            ->forUser($userId)
            ->find($id);
    }
    
    public function createBudget(array $data, int $userId): Budget
    {
        $data['user_id'] = $userId;
        $data['spent'] = 0;
        
        return Budget::create($data);
    }
    
    public function updateBudget(int $id, array $data, int $userId): bool
    {
        $budget = $this->getBudgetById($id, $userId);
        
        if (!$budget) {
            return false;
        }
        
        return $budget->update($data);
    }
    
    public function deleteBudget(int $id, int $userId): bool
    {
        $budget = $this->getBudgetById($id, $userId);
        
        if (!$budget) {
            return false;
        }
        
        return $budget->delete();
    }
    
    public function getBudgetSummary(int $userId): array
    {
        $budgets = $this->getActiveBudgets($userId);
        
        $totalBudget = $budgets->sum('amount');
        $totalSpent = $budgets->sum('spent');
        $remaining = $totalBudget - $totalSpent;
        $percentage = $totalBudget > 0 ? round(($totalSpent / $totalBudget) * 100, 2) : 0;
        
        return [
            'totalBudget' => $totalBudget,
            'totalSpent' => $totalSpent,
            'remaining' => $remaining,
            'percentage' => $percentage,
        ];
    }
    
    public function checkBudgetAlerts(int $userId): Collection
    {
        return Budget::with('category')
            ->forUser($userId)
            ->active()
            ->get()
            ->filter(function ($budget) {
                return $budget->percentage >= 90;
            });
    }
}
