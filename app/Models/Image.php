<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $fillable = [
        'image',
        'imageable_id',
        'imageable_type',
    ];

    protected $table = 'images' ;

    public function imageable()
    {
        return $this->morphTo();
    }

    public function image(){

        return Helper::imageIsExists($this->second_image ,'images') ? $this->second_image : Helper::$noimage ;

    }
}
