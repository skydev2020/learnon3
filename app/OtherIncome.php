<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherIncome extends Model
{
    protected $fillable = [
        'name', 'date', 'amount', 'notes'
    ];
}
