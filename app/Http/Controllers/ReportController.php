<?php

namespace App\Http\Controllers;

use App\Services\Finance\ReportServiceInterface;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        private ReportServiceInterface $reportService
    ) {}

    public function index(Request $request)
    {
        $userId = auth()->id();
        
        // Default to current year
        $year = $request->input('year', date('Y'));
        $startDate = $request->input('start_date', date('Y-01-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        // Get monthly report for the year
        $monthlyData = $this->reportService->getMonthlyReport($userId, $year);
        
        // Get category breakdown for date range
        $categoryExpenses = $this->reportService->getCategoryBreakdown($userId, $startDate, $endDate);
        
        // Get financial summary for date range
        $summary = $this->reportService->getFinancialSummary($userId, $startDate, $endDate);

        return view('reports.index', compact('monthlyData', 'categoryExpenses', 'summary'));
    }
}
