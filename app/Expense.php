<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'date', 'name', 'amount', 'detail', 'type', 'status'
    ];
}
