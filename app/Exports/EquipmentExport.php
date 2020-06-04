<?php

namespace App\Exports;

use App\Equipment;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EquipmentExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct($farm_id, $type)
    {
        $this->farm_id = $farm_id;
        $this->farm_category = $type;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if (is_null($this->farm_category) || $this->farm_category) {
            return Equipment::join('farms', 'farms.id', '=', 'equipment.farm_id')
                ->select('farms.farm_name', 'equipment.*')
                ->where('equipment.farm_id', $this->farm_id)->get();
        } else {
            return Equipment::join('farms', 'farms.id', '=', 'equipment.farm_id')
                ->select('farms.farm_name', 'equipment.*')
                ->where('farm_category', $this->farm_category)->where('equipment.farm_id', $this->farm_id)->get();
        }
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "Farm",
            "Equipment",
            "Type",
            "Price",
            "Description",
            "Supplier",
            "Purchase Date",
            "State",
        ];
    }
    /**
     * @return array
     */
    public function map($equipment): array
    {
        return [
            $equipment->farm_name,
            $equipment->equipment,
            $equipment->type,
            number_format((float) $equipment->price, 2),
            $equipment->description ?? "N/A",
            $equipment->supplier ?? "N/A",
            (new Carbon($equipment->date_aquired))->format('l, d M Y'),
            $equipment->status ?? "Operational",
        ];
    }
}