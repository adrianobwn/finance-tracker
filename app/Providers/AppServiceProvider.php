<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind Service Interfaces to Implementations
        $this->app->bind(
            \App\Services\Finance\TransactionServiceInterface::class,
            \App\Services\Finance\TransactionService::class
        );
        
        $this->app->bind(
            \App\Services\Finance\BudgetServiceInterface::class,
            \App\Services\Finance\BudgetService::class
        );
        
        $this->app->bind(
            \App\Services\Finance\ReportServiceInterface::class,
            \App\Services\Finance\ReportService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
