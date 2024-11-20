<?php

namespace App\Models;

use App\Models\ProductAttribute;
use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Model;
use DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Attribute extends Model
{
    private $lang = LaravelLocalization::getCurrentLocale();
	protected $table = 'attributes';

    protected $fillable = [
        'name_ar',
        'name_en',
        'status',
    ];
    public function values(){
        return $this->hasMany(AttributeValue::class);
    }


    public function getNameAttribute(){
        return $this->{'name_'.$this->lang};
    }

    public function getActiveAttribute(){
        $this->status ? __('home.yes') : __( 'home.no') ;
     }

     public function scopeActive($query){
         $query->whereStatus(1);
      }

      public function scopeUnactive($query){
         $query->whereStatus(0);
      }
}



