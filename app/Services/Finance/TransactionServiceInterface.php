<?php

namespace App\Services\Finance;

use App\Models\Transaction;
use Illuminate\Support\Collection;

interface TransactionServiceInterface
{
    public function getAllTransactions(?int $userId): Collection;
    
    public function getTransactionById(int $id, int $userId): ?Transaction;
    
    public function createTransaction(array $data, int $userId): Transaction;
    
    public function updateTransaction(int $id, array $data, int $userId): bool;
    
    public function deleteTransaction(int $id, int $userId): bool;
    
    public function getTransactionStats(?int $userId, ?string $startDate = null, ?string $endDate = null): array;
    
    public function getRecentTransactions(?int $userId, int $limit = 5): Collection;
    
    public function getTransactionsByDateRange(int $userId, string $startDate, string $endDate): Collection;
}
