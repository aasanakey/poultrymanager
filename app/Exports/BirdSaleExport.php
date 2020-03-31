<?php

namespace App\Exports;

use App\BirdSale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
class BirdSaleExport implements FromCollection, WithHeadings, WithMapping
{

    public function __construct($farm_id, $type)
    {
        $this->farm_id = $farm_id;
        $this->bird_type = $type;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return BirdSale::where('bird_category', $this->bird_type)
            ->join('farms', 'farms.id', '=', 'bird_sales.farm_id')
            ->select('farms.farm_name', 'bird_sales.bird_batch_id','bird_sales.number' ,'bird_sales.weight', 'bird_sales.price',
                'bird_sales.date')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "Farm",
            "Batch",
            "Number",
            "Weight",
            'Price',
            "Date",
        ];
    }

    public function map($sale): array
    {
        return [
            $sale->farm_name,
            $sale->bird_batch_id,
            $sale->number,
            "$sale->weight kg",
            $sale->price,
            (new Carbon($sale->date))->format('l, d M Y H:i A'),
        ];
    }
}