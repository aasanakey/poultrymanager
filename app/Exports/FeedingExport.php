<?php

namespace App\Exports;

use App\Feeding;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class FeedingExport implements FromCollection,WithHeadings
{
    public function __construct( $farm_id)
    {
        $this->farm_id = $farm_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Feeding::join('farms','farms.id','=','feedings.farm_id')
        ->join('feeds','feeds.id','=','feedings.feed_id')
        ->select('farms.farm_name','feeds.name',
        'feedings.pen_id','feedings.feed_quantity','feedings.water_quantity','feedings.date')
        ->where('farms.id',$this->farm_id)->get();
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
}
