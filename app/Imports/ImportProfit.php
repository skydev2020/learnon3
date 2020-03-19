<?php

namespace App\Imports;

use App\Profit;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportProfit implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (count($row) < 40)
        {
            return NULL;
        }
        $record['date'] = $row[0];
        $record['Tutor Payments'] = $row[1];
        $record['Drew Payments'] = $row[2];
        $record['Google Adwords'] = $row[3];
        $record['google adwords cards'] = $row[4];
        $record['Facebook Advertising'] = $row[5];
        $record['Yahoo Advertising'] = $row[6];
        $record['Print Advertising'] = $row[7];
        $record['Flyer Delivery'] = $row[8];
        $record['Other Advertising'] = $row[9];
        $record['Tutor Recruitment Cost'] = $row[10];
        $record['Printed Materials Expense'] = $row[11];
        $record['Website Expense'] = $row[12];
        $record['Website Domains'] = $row[13];
        $record['Website Maintenance'] = $row[14];
        $record['Website SEO monthly fee'] = $row[15];
        $record['Art & Designer Fees'] = $row[16];
        $record['LearnOn! Software'] = $row[17];
        $record['Computer Expense'] = $row[18];
        $record['Telephone Expense'] = $row[19];
        $record['1800 number Expense'] = $row[20];
        $record['Postage Expense'] = $row[21];
        $record['Office Supplies'] = $row[22];
        $record['Interest Expense'] = $row[23];
        $record['Bank Fees'] = $row[24];
        $record['Accountant Expense'] = $row[25];
        $record['Collections Expense'] = $row[26];
        $record['Legal Expense'] = $row[27];
        $record['Tax Expense'] = $row[28];
        $record['Auto: Depreciation'] = $row[29];
        $record['Auto: Parking and Tolls'] = $row[30];
        $record['Auto: Gasoline'] = $row[31];
        $record['Auto: Service and Reg'] = $row[32];
        $record['Auto: Public Transport'] = $row[33];
        $record['Auto: Misc'] = $row[34];
        $record['Gift Expense'] = $row[35];
        $record['Charity'] = $row[36];
        $record['Entertainment'] = $row[37];
        $record['Medical Expense'] = $row[38];
        $record['Travel Expense'] = $row[39];
        $record['Miscelanous Expense'] = $row[40];
        $profits = Array();
        foreach ($record as $key => $value)
        {
            if ($key != 'date')
            {
                if (isset($record['date']) && date("Y-m-d", strtotime($record['date'])) <= '2011-08-13')
                $profits[] = new Profit([
                    'date'      => date('Y-m-d', strtotime($record['date'])),
                    'name'      => $key,
                    'amount'    => floatval($value),
                    'detail'    => "Excel Upload"
                ]);
            }
        }
        
        return $profits;
    }
}
