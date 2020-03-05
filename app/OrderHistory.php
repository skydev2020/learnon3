<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    public function statuses(){
        return $this->belongsTo('App\OrderStatus', 'status_id');
    }
}
