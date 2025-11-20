<?php

namespace App\Services\Finance;

use App\Enums\TransactionType;
use App\Models\Transaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransactionService implements TransactionServiceInterface
{
    public function getAllTransactions(int $userId): Collection
    {
        return Transaction::with('category')
            ->forUser($userId)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    public function getTransactionById(int $id, int $userId): ?Transaction
    {
        return Transaction::with('category')
            ->forUser($userId)
            ->find($id);
    }
    
    public function createTransaction(array $data, int $userId): Transaction
    {
        $data['user_id'] = $userId;
        
        DB::beginTransaction();
        try {
            $transaction = Transaction::create($data);
            
            // Update budget spent if transaction is expense
            if ($transaction->type === TransactionType::EXPENSE) {
                $this->updateBudgetSpent($transaction);
            }
            
            DB::commit();
            return $transaction->load('category');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    public function updateTransaction(int $id, array $data, int $userId): bool
    {
        $transaction = $this->getTransactionById($id, $userId);
        
        if (!$transaction) {
            return false;
        }
        
        DB::beginTransaction();
        try {
            $oldAmount = $transaction->amount;
            $oldType = $transaction->type;
            $oldCategoryId = $transaction->category_id;
            
            $transaction->update($data);
            
            // Update budget if needed
            if ($oldType === TransactionType::EXPENSE || $transaction->type === TransactionType::EXPENSE) {
                $this->recalculateBudgetSpent($userId, $oldCategoryId);
                if ($transaction->category_id != $oldCategoryId) {
                    $this->recalculateBudgetSpent($userId, $transaction->category_id);
                }
            }
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    public function deleteTransaction(int $id, int $userId): bool
    {
        $transaction = $this->getTransactionById($id, $userId);
        
        if (!$transaction) {
            return false;
        }
        
        DB::beginTransaction();
        try {
            $categoryId = $transaction->category_id;
            $isExpense = $transaction->type === TransactionType::EXPENSE;
            
            $transaction->delete();
            
            // Update budget if it was expense
            if ($isExpense) {
                $this->recalculateBudgetSpent($userId, $categoryId);
            }
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    public function getTransactionStats(int $userId, ?string $startDate = null, ?string $endDate = null): array
    {
        $query = Transaction::forUser($userId);
        
        if ($startDate && $endDate) {
            $query->inDateRange($startDate, $endDate);
        }
        
        $totalIncome = (clone $query)->byType(TransactionType::INCOME)->sum('amount');
        $totalExpense = (clone $query)->byType(TransactionType::EXPENSE)->sum('amount');
        
        return [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $totalIncome - $totalExpense,
        ];
    }
    
    public function getRecentTransactions(int $userId, int $limit = 5): Collection
    {
        return Transaction::with('category')
            ->forUser($userId)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
    
    public function getTransactionsByDateRange(int $userId, string $startDate, string $endDate): Collection
    {
        return Transaction::with('category')
            ->forUser($userId)
            ->inDateRange($startDate, $endDate)
            ->orderBy('transaction_date', 'desc')
            ->get();
    }
    
    private function updateBudgetSpent(Transaction $transaction): void
    {
        if ($transaction->type !== TransactionType::EXPENSE) {
            return;
        }
        
        $budget = DB::table('budgets')
            ->where('user_id', $transaction->user_id)
            ->where('category_id', $transaction->category_id)
            ->where('is_active', true)
            ->where('start_date', '<=', $transaction->transaction_date)
            ->where('end_date', '>=', $transaction->transaction_date)
            ->first();
        
        if ($budget) {
            $this->recalculateBudgetSpent($transaction->user_id, $transaction->category_id);
        }
    }
    
    private function recalculateBudgetSpent(int $userId, int $categoryId): void
    {
        $budgets = DB::table('budgets')
            ->where('user_id', $userId)
            ->where('category_id', $categoryId)
            ->where('is_active', true)
            ->get();
        
        foreach ($budgets as $budget) {
            $spent = Transaction::forUser($userId)
                ->byCategory($categoryId)
                ->byType(TransactionType::EXPENSE)
                ->inDateRange($budget->start_date, $budget->end_date)
                ->sum('amount');
            
            DB::table('budgets')
                ->where('id', $budget->id)
                ->update(['spent' => $spent]);
        }
    }
}
