<?php

namespace App\Exports;

use App\BirdMortality;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BirdMortalityExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct($farm_id, $type = null)
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
            return BirdMortality::join('farms', 'farms.id', '=', 'bird_mortality.farm_id')
                ->select('farms.farm_name', 'bird_mortality.pen_id', 'bird_mortality.batch_id',
                    'bird_mortality.number', 'bird_mortality.dod', 'bird_mortality.unit_price', 'bird_mortality.cause', 'bird_mortality.observation')
                ->where('farms.id', $this->farm_id)->get();
        } else {
            return BirdMortality::join('farms', 'farms.id', '=', 'bird_mortality.farm_id')
                ->join('birds', 'birds.batch_id', '=', 'bird_mortality.batch_id')
                ->select('farms.farm_name', 'bird_mortality.*')
                ->where('birds.bird_category', $this->type)
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
            "Pen",
            "Batch",
            "Number of Birds",
            "Date",
            "Unit Price",
            "Cause",
            "Observation",
        ];
    }
    public function map($mortality): array
    {
        return [
            $mortality->farm_name,
            $mortality->pen_id,
            $mortality->batch_id,
            $mortality->number,
            (new Carbon($mortality->dod))->format('l, d M Y H:i A'),
            number_format((float) $mortality->unit_price, 2),
            $mortality->cause,
            $mortality->observation ?? "N/A",
        ];
    }
}