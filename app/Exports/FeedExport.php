<?php

namespace App\Exports;

use App\Feed;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FeedExport implements FromCollection, WithHeadings, WithMapping
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
            return Feed::join('farms', 'farms.id', '=', 'feeds.farm_id')
                ->select('farms.farm_name', 'feeds.name',
                    'feeds.price', 'feeds.quantity', 'feeds.description', 'feeds.supplier', 'feeds.date')
                ->where('farms.id', $this->farm_id)->get();
        } else {
            return Feed::join('farms', 'farms.id', '=', 'feeds.farm_id')
                ->select('farms.farm_name', 'feeds.name',
                    'feeds.price', 'feeds.quantity', 'feeds.description', 'feeds.supplier', 'feeds.date')
                ->where('feed_type', $this->type)
                ->where('farms.id', $this->farm_id)->get();
        }
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

    /**
     * @return array
     */
    public function map($feed): array
    {
        return [
            $feed->farm_name,
            $feed->name,
            number_format((float) $feed->price, 2),
            number_format((float) $feed->quantity, 2),
            $feed->description ?? "N/A",
            $feed->supplier ?? "N/A",
            (new Carbon($feed->date))->format('l, d M Y H:i A'),
        ];
    }
}