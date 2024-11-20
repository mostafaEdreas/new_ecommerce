<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Category extends Model
{
    protected $table = 'categories';
    private $lang = LaravelLocalization::getCurrentLocale();
    protected $fillable = [
        'name_ar',
        'name_en',
        'order',
        'parent_id',
        'text_ar',
        'text_en',
        'image',
        'icon',
        'status',
        'link_ar',
        'link_en',
        'mete_title_ar',
        'mete_title_en',
        'mete_description_ar',
        'mete_description_en',
        'index',
    ];

    public function children(){
        return $this->hasMany(self::class,'parent_id','id');
    }



    public function parent(){
        return $this->belongsTo(self::class,'parent_id','id');
    }

     public function products(){
        return $this->hasMany(Product::class);
     }

     public function getNameAttribute(){
        return $this->{'name_'.$this->lang} ;
    }

    public function getTextAttribute(){
        return $this->{'text_'.$this->lang} ;
    }

    public function getLinkAttribute(){
        return $this->{'link_'.$this->lang} ;
    }


    public function getParentNameAttribute(){
        return  $this->parent?->name ;
    }

    public function getParentTextAttribute(){
        return $this->parent?->text ;

    }

    public function getParentLinkAttribute(){
        return  $this->parent?->link  ;
    }

    public function getImageAttribute($value){

        return Helper::imageIsExists($this->image ,'categories') ? $this->image : Helper::$noimage ;

    }

    public function getIconAttribute(){

        return Helper::imageIsExists($this->icon ,'categories') ? $this->icon : Helper::$noimage ;
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
