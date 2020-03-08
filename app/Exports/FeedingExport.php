<?php

namespace App\Exports;

use App\Feeding;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class FeedingExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Feeding::all();
    }

      /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "Farm",
            "Name",
            "Price (GHS)",
            "Quantity (Kg)",
            "Description",
            "Supplier",
            "Date",
        ];
    }
}
