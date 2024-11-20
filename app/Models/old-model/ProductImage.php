<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    //
    protected $table = 'product_images';
    
    public function color(){
        return $this->belongsTo('App\Models\Color','color_id');
    }
}
