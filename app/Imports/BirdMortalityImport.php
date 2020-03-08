<?php

namespace App\Imports;

use App\BirdMortality;
use Maatwebsite\Excel\Concerns\ToModel;

class BirdMortalityImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BirdMortality([
            //
        ]);
    }
}
