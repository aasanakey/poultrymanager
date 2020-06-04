<?php

namespace App\Exports;

use App\Vaccine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VaccineExport implements FromCollection, WithHeadings, WithMapping
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
        if (is_null($this->type) || $this->type == 'all') {
            return Vaccine::join('farms', 'farms.id', '=', 'vaccines.farm_id')
                ->select('farms.farm_name', 'vaccines.age', 'vaccines.disease',
                    'vaccines.mode', 'vaccines.type')
                ->where('farms.id', $this->farm_id)->get();
        } else {
            return Vaccine::join('farms', 'farms.id', '=', 'vaccines.farm_id')
                ->select('farms.farm_name', 'vaccines.*')->where('vaccines.animal', $this->type)
                ->where('vaccines.farm_id', $this->farm_id)->get();

        }

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

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->farm_name,
            $row->age,
            $row->disease,
            $row->mode,
            $row->type,
        ];
    }
}
