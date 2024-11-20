<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AttributeValue extends Model
{
    //
	protected $table = 'attribute_values';

    private $lang = LaravelLocalization::getCurrentLocale();

    protected $fillable = [
        'name_ar',        // Arabic name of the attribute
        'name_en',        // English name of the attribute
        'attribute_id',   // Foreign key to the attributes table
        'description_ar', // Arabic description
        'description_en', // English description
        'status',         // Status of the record
    ];
    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }

    public function getNameAttribute(){
        return $this->{'name_'.$this->lang}  ;
    }

    public function getAttributeNameAttribute(){
        return $this->attribute?->name;
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



