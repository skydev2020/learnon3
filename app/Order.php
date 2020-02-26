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
}
