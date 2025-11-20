<?php

namespace App\Services\Finance;

use App\Models\Budget;
use Illuminate\Support\Collection;

interface BudgetServiceInterface
{
    public function getAllBudgets(int $userId): Collection;
    
    public function getActiveBudgets(int $userId): Collection;
    
    public function getBudgetById(int $id, int $userId): ?Budget;
    
    public function createBudget(array $data, int $userId): Budget;
    
    public function updateBudget(int $id, array $data, int $userId): bool;
    
    public function deleteBudget(int $id, int $userId): bool;
    
    public function getBudgetSummary(int $userId): array;
    
    public function checkBudgetAlerts(int $userId): Collection;
}
