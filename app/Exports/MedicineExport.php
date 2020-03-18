<?php

namespace App\Exports;

use App\Medicine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MedicineExport implements FromCollection, WithHeadings
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
        return Medicine::join('farms', 'farms.id', '=', 'medicines.farm_id')
            ->select('farms.farm_name', 'medicines.name',
                'medicines.price', 'medicines.quantity', 'medicines.supplier', 'medicines.supplier', 'medicines.date')
            ->where('farms.id', $this->farm_id)->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "Farm",
            "Medicine",
            "Price",
            "Quantity",
            "Supplier",
            "Date",
        ];
    }
}