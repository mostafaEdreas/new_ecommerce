<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Models\ProductDiscount;
use App\Models\ProductImage;
use App\Models\CartProduct;
use App\Models\ProductReview;
use App\Models\Wishlist;
use Carbon\Carbon;
use App\Models\ProductAttribute;
use App\Models\Attribute;
use App\Models\ProductColor;
use App\Models\Color;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Product extends Model
{
   protected $table = 'products' ;
   private $lang = LaravelLocalization::getCurrentLocale();

   protected $fillable = [
        'name_ar',
        'name_en',
        'category_id',
        'brand_id',
        'order',
        'text_ar',
        'text_en',
        'short_text_ar',
        'short_text_en',
        'main_image',
        'second_image',
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


    public function getNameAttribute(){
        return $this->{'name_'.$this->lang} ;
    }

    public function getTextAttribute(){
        return $this->{'text_'.$this->lang} ;
    }

    public function getLinkAttribute(){
        return $this->{'link_'.$this->lang} ;
    }

    public function getShortTextAttribute(){
        return $this->{'text_text_'.$this->lang} ;
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function getBrandNameAttribute(){
        return $this->brand?->name;
    }

    public function getBrandTextAttribute(){
        return $this->brand?->text;
    }

    public function getBrandLinkAttribute(){
        return $this->brand?->link;
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }



    public function getCategoryNameAttribute(){
        return $this->category?->name;
    }

    public function getCategoryTextAttribute(){
        return $this->category?->text;
    }

    public function getCategoryLinkAttribute(){
        return $this->category?->link;
    }


    public function getImageAttribute($value){

        return Helper::imageIsExists($this->main_image ,'products') ? $this->main_image : Helper::$noimage ;

    }

    public function getIconAttribute(){

        return Helper::imageIsExists($this->second_image ,'products') ? $this->second_image : Helper::$noimage ;
    }

    public function images(){

        return $this->morphMany(Image::class,'imageable'); ;
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
