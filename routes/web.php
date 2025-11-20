<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;

// Guest Routes (Login & Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard - Redirect admin to admin dashboard
    Route::get('/', function() {
        if (auth()->user()->role->value === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return app(DashboardController::class)->index();
    })->name('dashboard');

    // Transactions
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/create', [TransactionController::class, 'create'])->name('create');
        Route::post('/', [TransactionController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TransactionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TransactionController::class, 'update'])->name('update');
        Route::delete('/{id}', [TransactionController::class, 'destroy'])->name('destroy');
    });

    // Budgets
    Route::prefix('budgets')->name('budgets.')->group(function () {
        Route::get('/', [BudgetController::class, 'index'])->name('index');
        Route::get('/create', [BudgetController::class, 'create'])->name('create');
        Route::post('/', [BudgetController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BudgetController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BudgetController::class, 'update'])->name('update');
        Route::delete('/{id}', [BudgetController::class, 'destroy'])->name('destroy');
    });

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');

    // Profile
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/category', [\App\Http\Controllers\SettingsController::class, 'storeCategory'])->name('settings.category.store');
    Route::put('/settings/category/{id}', [\App\Http\Controllers\SettingsController::class, 'updateCategory'])->name('settings.category.update');
    Route::delete('/settings/category/{id}', [\App\Http\Controllers\SettingsController::class, 'destroyCategory'])->name('settings.category.destroy');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // User Management
        Route::resource('users', UserManagementController::class);
        Route::post('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
    });
});
