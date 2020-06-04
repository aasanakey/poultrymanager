<?php

namespace App\Exports;

use App\Feeding;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FeedingExport implements FromCollection, WithHeadings, WithMapping
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
            return Feeding::join('farms', 'farms.id', '=', 'feedings.farm_id')
                ->join('feeds', 'feeds.id', '=', 'feedings.feed_id')
                ->select('farms.farm_name', 'feeds.name',
                    'feedings.pen_id', 'feedings.feed_quantity', 'feedings.water_quantity', 'feedings.date')
                ->where('farms.id', $this->farm_id)->get();
        } else {
            return Feeding::join('farms', 'farms.id', '=', 'feedings.farm_id')
                ->join('feeds', 'feeds.id', '=', 'feedings.feed_id')
                ->join('pen_houses', 'pen_houses.pen_id', '=', 'feedings.pen_id')
                ->select('farms.farm_name', 'feeds.name', 'feedings.*')
                ->where('pen_houses.bird_type', $this->type)
                ->where('feedings.farm_id', $this->farm_id)->get();

        }
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "Farm",
            "Feed",
            "Pen",
            "Quantity (Kg)",
            "Water (L)",
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
            $feed->pen_id,
            number_format((float) $feed->feed_quantity, 2),
            number_format($feed->water_quantity, 2),
            (new Carbon($feed->date))->format('l, d M Y H:i A'),
        ];
    }
}
