<?php

namespace App\Exports;

use App\Assignment;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportBaseRates implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Assignment::has('tutors') -> has('students') -> get();
    }
}
