<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $userId;
    protected $startDate;
    protected $endDate;

    public function __construct($userId, $startDate, $endDate)
    {
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Transaction::with('category')
            ->whereBetween('transaction_date', [$this->startDate, $this->endDate])
            ->orderBy('transaction_date', 'desc');

        if ($this->userId !== null) {
            $query->where('user_id', $this->userId);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Deskripsi',
            'Kategori',
            'Tipe',
            'Jumlah',
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->transaction_date->format('d-m-Y'),
            $transaction->description,
            $transaction->category->name ?? '-',
            $transaction->type->value === 'income' ? 'Pemasukan' : 'Pengeluaran',
            number_format($transaction->amount, 0, ',', '.'),
        ];
    }
}
