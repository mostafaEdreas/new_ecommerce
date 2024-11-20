<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;


class Brand extends Model
{
	protected $table='brands';
	
	public function products(){
	    return Product::where('brand_id',$this->id)->where('status',1)->get()->shuffle();
	}

}
