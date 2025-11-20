<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ReportController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Transactions
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

// Budgets
Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets.index');
Route::get('/budgets/create', [BudgetController::class, 'create'])->name('budgets.create');
Route::post('/budgets', [BudgetController::class, 'store'])->name('budgets.store');
Route::get('/budgets/{id}/edit', [BudgetController::class, 'edit'])->name('budgets.edit');
Route::put('/budgets/{id}', [BudgetController::class, 'update'])->name('budgets.update');
Route::delete('/budgets/{id}', [BudgetController::class, 'destroy'])->name('budgets.destroy');

// Reports
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
