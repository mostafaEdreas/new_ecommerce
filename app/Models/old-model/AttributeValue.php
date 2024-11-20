<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AttributeValue extends Model
{
    //
	protected $table = 'attribute_values';

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }
    public function product_count($value_id){
        $attribute_value = ProductAttribute::where('attribute_value_id',$value_id)
                ->groupBy('attribute_value_id')
                ->select('attribute_value_id', DB::raw('count(*) as count'))
                ->first();
        return $attribute_value ?? (object)['count' => 0];
    }

    public function productAttribute(){
        return  $this->hasMany(ProductAttribute::class,'attribute_value_id')->get();
     }

}



