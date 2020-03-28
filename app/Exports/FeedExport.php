<?php

namespace App\Exports;

use App\Feed;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FeedExport implements FromCollection, WithHeadings
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
        return Feed::join('farms', 'farms.id', '=', 'feeds.farm_id')
            ->select('farms.farm_name', 'feeds.name',
                'feeds.price', 'feeds.quantity', 'feeds.description', 'feeds.supplier', 'feeds.date')
            ->where('farms.id', $this->farm_id)->get();
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