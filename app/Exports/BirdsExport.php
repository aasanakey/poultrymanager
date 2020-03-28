<?php

namespace App\Exports;

use App\Birds;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class BirdsExport implements FromCollection, WithHeadings, WithMapping
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
        return Birds::where('bird_category', $this->bird_type)
            ->join('farms', 'farms.id', '=', 'birds.farm_id')
            ->select('birds.batch_id', 'farms.farm_name', 'birds.pen_id', 'birds.bird_category',
                'birds.number', 'birds.unit_price', 'birds.species', 'birds.type', 'birds.date', )
            ->where('farms.id', $this->farm_id)->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "Batch",
            "Farm",
            "Pen",
            'Category',
            "Number of Birds",
            'Price',
            "Species",
            "Type",
            "Date",
        ];
    }

    public function map($bird): array
    {
        return [
            $bird->batch_id,
            $bird->farm_name,
            $bird->pen_id,
            $bird->category,
            number_format($bird->number),
            number_format((float) $bird->unit_price, 2),
            $bird->species,
            $bird->type,
            (new Carbon($bird->date))->format('l, d M Y H:i A'),
        ];
    }
}