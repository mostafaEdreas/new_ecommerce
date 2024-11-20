<?php

namespace App\Models;
use App\Models\ProductImage;

use Illuminate\Database\Eloquent\Model;
use DB;


class Color extends Model
{
	protected $table='colors';


    //////////// function return product color images///////
    public function images($produtId){
        return ProductImage::where('product_id',$produtId)->where('color_id',$this->id)->get();
    }

}
