<?php

namespace App\Enums;

enum TransactionType: string
{
    case INCOME = 'income';
    case EXPENSE = 'expense';

    public function label(): string
    {
        return match($this) {
            self::INCOME => 'Pemasukan',
            self::EXPENSE => 'Pengeluaran',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::INCOME => 'green',
            self::EXPENSE => 'red',
        };
    }
}
