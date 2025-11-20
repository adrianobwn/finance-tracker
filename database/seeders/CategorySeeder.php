<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Enums\TransactionType;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Income Categories
            [
                'name' => 'Gaji',
                'type' => TransactionType::INCOME,
                'icon' => 'fa-money-bill-wave',
                'color' => '#10B981',
                'is_default' => true,
            ],
            [
                'name' => 'Freelance',
                'type' => TransactionType::INCOME,
                'icon' => 'fa-laptop-code',
                'color' => '#3B82F6',
                'is_default' => true,
            ],
            [
                'name' => 'Investasi',
                'type' => TransactionType::INCOME,
                'icon' => 'fa-chart-line',
                'color' => '#8B5CF6',
                'is_default' => true,
            ],
            [
                'name' => 'Pendapatan Lain',
                'type' => TransactionType::INCOME,
                'icon' => 'fa-plus-circle',
                'color' => '#14B8A6',
                'is_default' => true,
            ],
            
            // Expense Categories
            [
                'name' => 'Makanan & Minuman',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-utensils',
                'color' => '#EF4444',
                'is_default' => true,
            ],
            [
                'name' => 'Transport',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-car',
                'color' => '#F59E0B',
                'is_default' => true,
            ],
            [
                'name' => 'Belanja',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-shopping-cart',
                'color' => '#EC4899',
                'is_default' => true,
            ],
            [
                'name' => 'Tagihan',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-file-invoice-dollar',
                'color' => '#6366F1',
                'is_default' => true,
            ],
            [
                'name' => 'Entertainment',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-film',
                'color' => '#8B5CF6',
                'is_default' => true,
            ],
            [
                'name' => 'Kesehatan',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-heartbeat',
                'color' => '#EF4444',
                'is_default' => true,
            ],
            [
                'name' => 'Pendidikan',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-graduation-cap',
                'color' => '#3B82F6',
                'is_default' => true,
            ],
            [
                'name' => 'Lainnya',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-ellipsis-h',
                'color' => '#6B7280',
                'is_default' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
