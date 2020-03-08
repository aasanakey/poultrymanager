<?php

namespace App\Exports;

use App\EggProduction;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class EggProductionExport implements FromCollection,WithHeadings
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

        return EggProduction::where('bird_category',$this->bird_type)
        ->join('farms','farms.id','=','egg_productions.farm_id')
        ->select('farms.farm_name','egg_productions.pen_id',
        'egg_productions.layer_batch_id','egg_productions.bird_category','egg_productions.quantity',
        'egg_productions.bad_eggs','egg_productions.date_collected')
        ->where('farms.id',$this->farm_id)->get();
    }

     /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "Farm",
            "Pen",
            "Bird Batch",
            'Bird Category',
            "Number of Eggs",
            "Number of Bad Eggs",
            "Date",
        ];
    }
}
