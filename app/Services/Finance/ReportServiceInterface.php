<?php

namespace App\Services\Finance;

interface ReportServiceInterface
{
    public function getMonthlyReport(?int $userId, int $year): array;
    
    public function getCategoryBreakdown(?int $userId, string $startDate, string $endDate): array;
    
    public function getFinancialSummary(?int $userId, string $startDate, string $endDate): array;
    
    public function getTrendData(?int $userId, int $months = 6): array;
    
    public function getTrendDataByDateRange(?int $userId, string $startDate, string $endDate): array;
}
