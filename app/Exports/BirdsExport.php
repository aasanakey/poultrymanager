<?php

namespace App\Exports;

use App\Birds;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class BirdsExport implements FromCollection,WithHeadings
{
    public function __construct( $farm_id,$type)
    {
        $this->farm_id = $farm_id;
        $this->bird_type = $type;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Birds::where('bird_category',$this->bird_type)
        ->join('farms','farms.id','=','birds.farm_id')
        ->select('birds.batch_id','farms.farm_name','birds.bird_category',
        'birds.date','birds.type','birds.unit_price')
        ->where('farms.id',$this->farm_id)->get();
    }

     /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "Batch",
            "Farm",
            "Pen",
            "Number of Birds",
            "Species",
            "Date",
            "Type",
        ];
    }
}
