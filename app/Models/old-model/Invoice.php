<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;


class Invoice extends Model
{
	protected $table='invoices';

    public function order (){
        return $this->belongsTo('App\Models\Order','order_id');
    }
}
