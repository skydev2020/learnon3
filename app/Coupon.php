<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'name', 'description', 'code', 'type', 'discount', 'date_start', 'date_end', 'uses_total', 'uses_customer', 'status'
    ];

    public function status(){
        return $this->status == 1 ? "Enabled" : "Disabled";
    }
}
