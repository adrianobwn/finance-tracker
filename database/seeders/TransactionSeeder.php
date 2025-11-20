<?php

namespace Database\Seeders;

use App\Enums\TransactionType;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $userId = 2; // User demo
        
        // Get categories
        $incomeCategories = Category::where('type', TransactionType::INCOME)->pluck('id')->toArray();
        $expenseCategories = Category::where('type', TransactionType::EXPENSE)->pluck('id')->toArray();
        
        // Transaksi 6 bulan terakhir
        for ($monthAgo = 5; $monthAgo >= 0; $monthAgo--) {
            $date = now()->subMonths($monthAgo);
            
            // Income transactions (2-3 per bulan)
            $incomeCount = rand(2, 3);
            for ($i = 0; $i < $incomeCount; $i++) {
                Transaction::create([
                    'user_id' => $userId,
                    'category_id' => $incomeCategories[array_rand($incomeCategories)],
                    'type' => TransactionType::INCOME,
                    'amount' => rand(3000000, 8000000), // 3-8 juta
                    'description' => $this->getIncomeDescription(),
                    'transaction_date' => $date->copy()->addDays(rand(1, 28)),
                ]);
            }
            
            // Expense transactions (5-10 per bulan)
            $expenseCount = rand(5, 10);
            for ($i = 0; $i < $expenseCount; $i++) {
                Transaction::create([
                    'user_id' => $userId,
                    'category_id' => $expenseCategories[array_rand($expenseCategories)],
                    'type' => TransactionType::EXPENSE,
                    'amount' => rand(50000, 2000000), // 50rb - 2jt
                    'description' => $this->getExpenseDescription(),
                    'transaction_date' => $date->copy()->addDays(rand(1, 28)),
                ]);
            }
        }
    }
    
    private function getIncomeDescription(): string
    {
        $descriptions = [
            'Gaji Bulanan',
            'Bonus Kinerja',
            'Freelance Project',
            'Komisi Penjualan',
            'Dividen Investasi',
            'Pendapatan Sewa',
        ];
        
        return $descriptions[array_rand($descriptions)];
    }
    
    private function getExpenseDescription(): string
    {
        $descriptions = [
            'Belanja Bulanan',
            'Makan Siang',
            'Bensin Motor',
            'Tagihan Listrik',
            'Internet',
            'Belanja Online',
            'Bayar Parkir',
            'Kopi & Snack',
            'Transportasi Online',
            'Isi Pulsa',
            'Perawatan Kendaraan',
            'Obat & Vitamin',
        ];
        
        return $descriptions[array_rand($descriptions)];
    }
}
