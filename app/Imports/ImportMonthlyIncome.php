<?php

namespace App\Imports;

use App\MonthlyIncome;
use Maatwebsite\Excel\Concerns\ToModel;
use DateTime;

class ImportMonthlyIncome implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (DateTime::createFromFormat('Y-m-d', $row[0]) == false)
        {
            return NULL;
        } 

        if ($row[0] != NULL && date("Y-m-d", strtotime($row[0])) <= '2011-08-31')
        {
            return new MonthlyIncome([
                'date'              => date("Y-m-d", strtotime($row[0])),
                'tutoring_revenue'  => floatval($row[1]),
                'homework_revenue'  => floatval($row[2]),
                'other_revenue'     => floatval($row[3])
            ]);
        }
        return NULL;
    }
}
