<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $fillable = [
        'order_id', 'status_id', 'notify', 'comment'
    ];

    public function statuses(){
        return $this->belongsTo('App\OrderStatus', 'status_id');
    }
}
