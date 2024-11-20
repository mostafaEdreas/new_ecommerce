<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Menu extends Model
{
    //
    protected $table = 'menus';

    private $lang = LaravelLocalization::getCurrentLocale();

    public $timestamps = false;


    protected $fillable = [
        'name_ar',
        'name_en',
        'status',
        'parent_id',
        'segment',
        'type',
        'order',
    ];

    public function children(){
        return $this->hasMany(self::class,'parent_id','id');
    }

    public function parent(){
        return $this->belongsTo(self::class,'parent_id','id');
    }


    public function getParentNameAttribute(){
        return  $this->parent?->name ;
    }
    public function getNameAttribute(){
        $this->{'name_'.$this->lang} ;
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
