<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function packages() {
        return $this->belongsTo('App\Package', 'package_id');
    }

    public function package() {
        return $this->packages()->first();
    }

    public function isExist() {
        if($this->package() != null) return true;

        return false;
    }

    public function users() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function statuses() {
        return $this->belongsTo('App\OrderStatus', 'status_id');
    }

    public function updatedMonth() {
        return date('m', strtotime($this->updated_at));
    }
}
