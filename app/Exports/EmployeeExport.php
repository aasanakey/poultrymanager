<?php

namespace App\Exports;

use App\Employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class EmployeeExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct($farm_id, $type)
    {
        $this->farm_id = $farm_id;
        $this->employee_type = $type;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if ($this->employee_type == "all") {
            return Employee::all();

        } else {
            return Employee::select('id', 'full_name', 'dob', 'email', 'contact', 'hire_date', 'jd', 'farm_category')
                ->where('farm_id', $this->farm_id)->where('farm_category', $this->employee_type)
                ->get();

        }
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "ID",
            //   "Farm_id",
            "Name",
            "Age",
            "Email",
            "Contact",
            "Appointment Date",
            "Job Description",
            $this->employee_type == "all" ? "Farm Category" : '',
        ];
    }

    public function map($employee): array
    {
        return [
            $employee->id,
            $employee->full_name,
            date_diff(date_create($employee->dob), date_create('today'))->y,
            $employee->email,
            $employee->contact,
            (new Carbon($employee->hire_date))->format('l, d M Y'),
            $employee->jd,
            $this->employee_type == "all" ? $employee->farm_category : '',
        ];
    }
}