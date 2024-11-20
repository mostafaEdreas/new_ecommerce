<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProductOption extends Model
{
    //
    protected $table='order_product_options';
    public $timestamps = false;
    
    public function option(){
        return $this->belongsTo('App\Models\ProductOption','option_id');
    }
    

}
