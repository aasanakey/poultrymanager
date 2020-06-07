<?php

namespace App\Exports;

use App\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithMapping, WithHeadings
{

    public function __construct($farm_id, $type)
    {
        $this->farm_id = $farm_id;
        $this->type = $type;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if ($this->type == 'all' || is_null($this->type)) {
            return Transation::join('farms', 'farms.id', '=', 'transactions.farm_id')
                ->select('farms.farm_name', 'transactions.*')
                ->where('transactions.farm_id', $this->farm_id)->get();
        } else {
            return Transaction::join('farms', 'farms.id', '=', 'transactions.farm_id')
                ->select('farms.farm_name', 'transactions.*')
                ->where('transactions.farm_category', $this->type)
                ->where('transactions.farm_id', $this->farm_id)->get();
        }
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "Farm",
            "Type",
            "Date",
            "Amount (GHS)",
            "Category",
            "Account Name",
            "Description",
        ];
    }

    /**
     * @return array
     */
    public function map($transaction): array
    {
        return [
            $transaction->farm_name,
            $transaction->type ? ucfirst($transaction->type) : $transaction->type,
            (new Carbon($transaction->date))->format('l, d M Y'),
            number_format((float) $transaction->amount, 2),
            $transaction->category,
            $transaction->account,
            $transaction->description,
        ];
    }
}