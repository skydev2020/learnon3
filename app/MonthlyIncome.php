<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthlyIncome extends Model
{
    protected $fillable = [
        'date', 'tutoring_revenue', 'homework_revenue', 'other_revenue'
    ];
}
