<?php

namespace App\Exports;

use App\EggSale;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EggSaleExport implements FromCollection, WithHeadings, WithMapping
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
        return EggSale::join('farms', 'farms.id', '=', 'egg_sales.farm_id')
            ->select('farms.farm_name', 'egg_sales.price_per_dozen', 'egg_sales.weight_per_dozen',
                'egg_sales.quantity', 'egg_sales.egg_type', 'egg_sales.date')->where('egg_sales.egg_type', $this->type)
            ->where('egg_sales.farm_id', $this->farm_id)->get();
    }
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "Farm",
            "Price",
            "Weight",
            "Quantity",
            "Egg Type",
            "Date",
        ];
    }

    public function map($sale): array
    {
        return [
            $sale->farm_name,
            number_format($sale->price_per_dozen, 2),
            number_format($sale->weight_per_dozen, 2) . " kg",
            $sale->quantity,
            $sale->egg_type,
            (new Carbon($sale->date))->format('l, d M Y H:i A'),
        ];
    }
}