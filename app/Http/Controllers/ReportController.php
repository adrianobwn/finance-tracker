<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Services\Finance\ReportServiceInterface;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct(
        private ReportServiceInterface $reportService
    ) {}

    public function index(Request $request)
    {
        // Admin can see all users' data, regular users see only their own
        $userId = auth()->user()->role->value === 'admin' ? null : auth()->id();
        
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

        return view('reports.index', compact('monthlyData', 'categoryExpenses', 'summary', 'startDate', 'endDate'));
    }

    public function export(Request $request)
    {
        // Admin can see all users' data, regular users see only their own
        $userId = auth()->user()->role->value === 'admin' ? null : auth()->id();
        
        $startDate = $request->input('start_date', date('Y-01-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        $filename = 'Laporan_Keuangan_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new ReportExport($userId, $startDate, $endDate), $filename);
    }
}
