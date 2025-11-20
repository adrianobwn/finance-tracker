<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = [
            [
                'id' => 1,
                'name' => 'Belanja Bulanan',
                'amount' => 5000000,
                'spent' => 3750000,
                'percentage' => 75,
                'category' => 'Belanja',
                'period' => 'Bulanan',
                'start_date' => '2024-11-01',
                'end_date' => '2024-11-30'
            ],
            [
                'id' => 2,
                'name' => 'Transport & Bensin',
                'amount' => 2000000,
                'spent' => 1200000,
                'percentage' => 60,
                'category' => 'Transport',
                'period' => 'Bulanan',
                'start_date' => '2024-11-01',
                'end_date' => '2024-11-30'
            ],
            [
                'id' => 3,
                'name' => 'Entertainment',
                'amount' => 1500000,
                'spent' => 500000,
                'percentage' => 33,
                'category' => 'Entertainment',
                'period' => 'Bulanan',
                'start_date' => '2024-11-01',
                'end_date' => '2024-11-30'
            ],
            [
                'id' => 4,
                'name' => 'Makan & Minum',
                'amount' => 3000000,
                'spent' => 2800000,
                'percentage' => 93,
                'category' => 'Makanan',
                'period' => 'Bulanan',
                'start_date' => '2024-11-01',
                'end_date' => '2024-11-30'
            ],
        ];

        $summary = [
            'totalBudget' => 11500000,
            'totalSpent' => 8250000,
            'remaining' => 3250000,
            'percentage' => 72
        ];

        return view('budgets.index', compact('budgets', 'summary'));
    }

    public function create()
    {
        $categories = ['Belanja', 'Transport', 'Makanan', 'Entertainment', 'Tagihan', 'Kesehatan', 'Pendidikan'];
        return view('budgets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $budget = [
            'id' => $id,
            'name' => 'Belanja Bulanan',
            'amount' => 5000000,
            'category' => 'Belanja',
            'period' => 'monthly',
            'start_date' => '2024-11-01',
            'end_date' => '2024-11-30'
        ];

        $categories = ['Belanja', 'Transport', 'Makanan', 'Entertainment', 'Tagihan', 'Kesehatan', 'Pendidikan'];
        return view('budgets.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil diupdate!');
    }

    public function destroy($id)
    {
        return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil dihapus!');
    }
}
