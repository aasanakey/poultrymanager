<?php

namespace App\Exports;

use App\EggProduction;
use Maatwebsite\Excel\Concerns\FromCollection;

class EggProductionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return EggProduction::all();
    }
}
