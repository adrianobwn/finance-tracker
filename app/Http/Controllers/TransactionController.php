<?php

namespace App\Http\Controllers;

use App\Services\Finance\TransactionServiceInterface;
use App\Models\Category;
use App\Enums\TransactionType;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionServiceInterface $transactionService
    ) {}

    public function index()
    {
        // Admin can see all users' data, regular users see only their own
        $userId = auth()->user()->role->value === 'admin' ? null : auth()->id();
        
        $transactions = $this->transactionService->getAllTransactions($userId);
        $stats = $this->transactionService->getTransactionStats($userId);

        return view('transactions.index', compact('transactions', 'stats'));
    }

    public function create()
    {
        $userId = auth()->id();
        
        $categories = [
            'income' => Category::forUser($userId)->byType(TransactionType::INCOME)->get(),
            'expense' => Category::forUser($userId)->byType(TransactionType::EXPENSE)->get(),
        ];

        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $userId = auth()->id();
        
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'transaction_date' => 'required|date',
        ]);

        try {
            $this->transactionService->createTransaction($validated, $userId);
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan transaksi: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $userId = auth()->id();
        
        $transaction = $this->transactionService->getTransactionById($id, $userId);
        
        if (!$transaction) {
            return redirect()->route('transactions.index')->with('error', 'Transaksi tidak ditemukan!');
        }

        $categories = [
            'income' => Category::forUser($userId)->byType(TransactionType::INCOME)->get(),
            'expense' => Category::forUser($userId)->byType(TransactionType::EXPENSE)->get(),
        ];

        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $userId = auth()->id();
        
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'transaction_date' => 'required|date',
        ]);

        try {
            $result = $this->transactionService->updateTransaction($id, $validated, $userId);
            
            if ($result) {
                return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diupdate!');
            }
            
            return back()->with('error', 'Transaksi tidak ditemukan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate transaksi: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $userId = auth()->id();
        
        try {
            $result = $this->transactionService->deleteTransaction($id, $userId);
            
            if ($result) {
                return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
            }
            
            return back()->with('error', 'Transaksi tidak ditemukan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
