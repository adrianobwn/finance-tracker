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
            // Income Categories - Pemasukan
            [
                'name' => 'Gaji',
                'type' => TransactionType::INCOME,
                'icon' => 'fa-money-bill-wave',
                'color' => '#10B981',
                'is_default' => true,
            ],
            [
                'name' => 'Bonus',
                'type' => TransactionType::INCOME,
                'icon' => 'fa-gift',
                'color' => '#059669',
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
                'name' => 'Bisnis',
                'type' => TransactionType::INCOME,
                'icon' => 'fa-briefcase',
                'color' => '#6366F1',
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
                'name' => 'Dividen',
                'type' => TransactionType::INCOME,
                'icon' => 'fa-coins',
                'color' => '#A855F7',
                'is_default' => true,
            ],
            [
                'name' => 'Hadiah',
                'type' => TransactionType::INCOME,
                'icon' => 'fa-hand-holding-heart',
                'color' => '#14B8A6',
                'is_default' => true,
            ],
            [
                'name' => 'Pendapatan Lain',
                'type' => TransactionType::INCOME,
                'icon' => 'fa-plus-circle',
                'color' => '#06B6D4',
                'is_default' => true,
            ],
            
            // Expense Categories - Pengeluaran
            [
                'name' => 'Makanan & Minuman',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-utensils',
                'color' => '#EF4444',
                'is_default' => true,
            ],
            [
                'name' => 'Belanja Kebutuhan',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-shopping-basket',
                'color' => '#F97316',
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
                'name' => 'Bensin',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-gas-pump',
                'color' => '#EAB308',
                'is_default' => true,
            ],
            [
                'name' => 'Tagihan Listrik',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-bolt',
                'color' => '#FBBF24',
                'is_default' => true,
            ],
            [
                'name' => 'Tagihan Air',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-water',
                'color' => '#3B82F6',
                'is_default' => true,
            ],
            [
                'name' => 'Internet & Pulsa',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-wifi',
                'color' => '#6366F1',
                'is_default' => true,
            ],
            [
                'name' => 'Sewa Rumah',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-home',
                'color' => '#8B5CF6',
                'is_default' => true,
            ],
            [
                'name' => 'Entertainment',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-film',
                'color' => '#EC4899',
                'is_default' => true,
            ],
            [
                'name' => 'Olahraga',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-dumbbell',
                'color' => '#10B981',
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
                'name' => 'Obat-obatan',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-pills',
                'color' => '#DC2626',
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
                'name' => 'Buku & Kursus',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-book',
                'color' => '#2563EB',
                'is_default' => true,
            ],
            [
                'name' => 'Pakaian',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-tshirt',
                'color' => '#EC4899',
                'is_default' => true,
            ],
            [
                'name' => 'Asuransi',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-shield-alt',
                'color' => '#6366F1',
                'is_default' => true,
            ],
            [
                'name' => 'Donasi',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-hand-holding-usd',
                'color' => '#10B981',
                'is_default' => true,
            ],
            [
                'name' => 'Pajak',
                'type' => TransactionType::EXPENSE,
                'icon' => 'fa-file-invoice',
                'color' => '#F59E0B',
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
