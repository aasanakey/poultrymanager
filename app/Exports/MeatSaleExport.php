<?php

namespace App\Exports;

use App\MeatSale;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MeatSaleExport implements FromCollection, WithHeadings, WithMapping
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
        return MeatSale::join('farms', 'farms.id', '=', 'meat_sales.farm_id')
            ->select('farms.farm_name', 'meat_sales.type', 'meat_sales.part', 'meat_sales.price',
                'meat_sales.quantity', 'meat_sales.date')->where('meat_sales.type', $this->type)
            ->where('meat_sales.farm_id', $this->farm_id)->get();
    }

    /**
     * @return array
     */

    public function headings(): array
    {
        return [
            "Farm",
            "Type",
            "Part",
            "Price",
            "Quantity",
            "Date",
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->farm_name,
            $row->type,
            $row->part,
            number_format($row->price, 2),
            number_format($row->quantity, 2) . " kg",
            (new Carbon($row->date))->format('l, d M Y H:i A'),
        ];

    }
}