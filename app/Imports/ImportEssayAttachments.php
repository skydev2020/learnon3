<?php

namespace App\Imports;

use App\EssayAssignmentAttachment;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportEssayAttachments implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new EssayAssignmentAttachment([
            
        ]);
    }
}
