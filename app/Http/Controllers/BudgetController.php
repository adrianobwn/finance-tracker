<?php

namespace App\Http\Controllers;

use App\Services\Finance\BudgetServiceInterface;
use App\Models\Category;
use App\Enums\TransactionType;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function __construct(
        private BudgetServiceInterface $budgetService
    ) {}

    public function index()
    {
        $userId = auth()->id();
        
        $budgets = $this->budgetService->getAllBudgets($userId);
        $summary = $this->budgetService->getBudgetSummary($userId);

        return view('budgets.index', compact('budgets', 'summary'));
    }

    public function create()
    {
        $userId = auth()->id();
        
        $categories = Category::forUser($userId)
            ->byType(TransactionType::EXPENSE)
            ->get();

        return view('budgets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $userId = auth()->id();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'period' => 'required|in:weekly,monthly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        try {
            $this->budgetService->createBudget($validated, $userId);
            return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan anggaran: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $userId = auth()->id();
        
        $budget = $this->budgetService->getBudgetById($id, $userId);
        
        if (!$budget) {
            return redirect()->route('budgets.index')->with('error', 'Anggaran tidak ditemukan!');
        }

        $categories = Category::forUser($userId)
            ->byType(TransactionType::EXPENSE)
            ->get();

        return view('budgets.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $userId = auth()->id();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'period' => 'required|in:weekly,monthly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        try {
            $result = $this->budgetService->updateBudget($id, $validated, $userId);
            
            if ($result) {
                return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil diupdate!');
            }
            
            return back()->with('error', 'Anggaran tidak ditemukan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate anggaran: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $userId = auth()->id();
        
        try {
            $result = $this->budgetService->deleteBudget($id, $userId);
            
            if ($result) {
                return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil dihapus!');
            }
            
            return back()->with('error', 'Anggaran tidak ditemukan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus anggaran: ' . $e->getMessage());
        }
    }
}
