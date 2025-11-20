<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // Data dummy transaksi
        $transactions = [
            [
                'id' => 1,
                'description' => 'Gaji Bulanan',
                'category' => 'Gaji',
                'amount' => 10000000,
                'type' => 'income',
                'date' => '2024-11-16'
            ],
            [
                'id' => 2,
                'description' => 'Makan siang tim',
                'category' => 'Makanan',
                'amount' => 150000,
                'type' => 'expense',
                'date' => '2024-11-17'
            ],
            [
                'id' => 3,
                'description' => 'Grab ke kantor',
                'category' => 'Transport',
                'amount' => 75000,
                'type' => 'expense',
                'date' => '2024-11-18'
            ],
            [
                'id' => 4,
                'description' => 'Freelance Project',
                'category' => 'Pendapatan Lain',
                'amount' => 5000000,
                'type' => 'income',
                'date' => '2024-11-19'
            ],
            [
                'id' => 5,
                'description' => 'Belanja groceries',
                'category' => 'Belanja',
                'amount' => 500000,
                'type' => 'expense',
                'date' => '2024-11-20'
            ],
        ];

        $stats = [
            'totalIncome' => 15000000,
            'totalExpense' => 725000,
            'balance' => 14275000,
        ];

        return view('transactions.index', compact('transactions', 'stats'));
    }

    public function create()
    {
        $categories = [
            'income' => ['Gaji', 'Freelance', 'Investasi', 'Pendapatan Lain'],
            'expense' => ['Makanan', 'Transport', 'Belanja', 'Tagihan', 'Entertainment', 'Kesehatan']
        ];

        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Simulasi store
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $transaction = [
            'id' => $id,
            'description' => 'Gaji Bulanan',
            'category' => 'Gaji',
            'amount' => 10000000,
            'type' => 'income',
            'date' => '2024-11-16'
        ];

        $categories = [
            'income' => ['Gaji', 'Freelance', 'Investasi', 'Pendapatan Lain'],
            'expense' => ['Makanan', 'Transport', 'Belanja', 'Tagihan', 'Entertainment', 'Kesehatan']
        ];

        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Simulasi update
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diupdate!');
    }

    public function destroy($id)
    {
        // Simulasi delete
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
