<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultWage extends Model
{
    protected $fillable = [
        'wage_usa', 'wage_canada', 'wage_alberta', 'invoice_usa', 'invoice_canada', 'invoice_alberta'
    ];
}
