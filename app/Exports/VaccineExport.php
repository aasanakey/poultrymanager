<?php

namespace App\Exports;

use App\Vaccine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VaccineExport implements FromCollection, WithHeadings
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
        return Vaccine::join('farms', 'farms.id', '=', 'vaccines.farm_id')
            ->select('farms.farm_name', 'vaccines.age', 'vaccines.disease',
                'vaccines.mode', 'vaccines.type')
            ->where('farms.id', $this->farm_id)->get();

    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "Farm",
            "Age",
            "Disease",
            "Mode",
            "Type",
        ];
    }
}