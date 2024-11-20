<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

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

    public function subCategories(){
        return $this->hasMany(self::class,'parent_id','id');
    }



    public function parent(){
        return $this->belongsTo(self::class,'parent_id','id');
    }

     public function products(){
        return $this->hasMany(Product::class);
     }

    

}
