<?php

namespace App\Exports;

use App\Medicine;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MedicineExport implements FromCollection, WithHeadings, WithMapping
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
            return Medicine::join('farms', 'farms.id', '=', 'medicines.farm_id')
                ->select('farms.farm_name', 'medicines.name',
                    'medicines.price', 'medicines.quantity', 'medicines.description', 'medicines.supplier', 'medicines.date')
                ->where('farms.id', $this->farm_id)->get();
        } else {
            return Medicine::join('farms', 'farms.id', '=', 'medicines.farm_id')
                ->select('farms.farm_name', 'medicines.*')->where('medicines.animal', $this->type)
                ->where('medicines.farm_id', $this->farm_id)->get();

        }
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
            "Description",
            "Supplier",
            "Purchase Date",
        ];
    }
    /**
     * @return array
     */
    public function map($medicine): array
    {
        return [
            $medicine->farm_name,
            $medicine->name,
            number_format($medicine->price, 2),
            number_format((int) $medicine->quantity),
            $medicine->description ?? "N/A",
            $medicine->supplier ?? "N/A",
            (new Carbon($medicine->date))->format('l, d M Y H:i A'),
        ];
    }
}