<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $table = 'setting' ;
    protected $guarded = [] ;
    public const IMAGES = ['logo' ,'logo_footer', 'favicon' , 'inspection_image'] ;
    public const SHIPPING = [
        'doesnt_use',
        'free',
        'one_cost',
        'by_place',
    ];

    public const SHIPPING_DOESNT_HAVE_FEES = [
        'doesnt_use',
    ];


    public function getRealValueAttribute($value){
        if(in_array( $this->key ,self::IMAGES)){
            return Helper::imageIsExists($this->value ,'settings') ? Helper::uploadedImagesPath('settings',$this->value)   : Helper::noImage() ;
        }

        return $this->value;
    }


    public function getValue200Attribute($value){
        if(in_array( $this->key ,self::IMAGES)){
            return Helper::imageIsExists($this->value ,'settings') ? Helper::uploadedImages200Path('settings',$this->value)   : Helper::noImage() ;
        }

        return $this->value;
    }




}
