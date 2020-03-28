<?php

namespace App\Exports;

use App\BirdMortality;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BirdMortalityExport implements FromCollection, WithHeadings
{
    public function __construct($farm_id)
    {
        $this->farm_id = $farm_id;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return BirdMortality::join('farms', 'farms.id', '=', 'bird_mortality.farm_id')
            ->select('farms.farm_name', 'bird_mortality.pen_id', 'bird_mortality.batch_id',
                'bird_mortality.number', 'bird_mortality.dod', 'bird_mortality.unit_price', 'bird_mortality.cause', 'bird_mortality.observation')
            ->where('farms.id', $this->farm_id)->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "Farm",
            "Pen",
            "Batch",
            "Number of Birds",
            "Date",
            "Unit Price",
            "Cause",
            "Observation",
        ];
    }
}