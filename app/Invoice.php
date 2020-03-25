<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function users() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function orders() {
        return $this->hasMany('App\Order', 'invoice_pk');
    }
}
