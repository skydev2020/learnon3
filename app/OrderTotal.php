<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTotal extends Model
{
    public function orders() {
        return $this->belonsTo('App\Order', 'order_id');
    }
}
