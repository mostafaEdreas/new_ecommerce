<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Menu extends Model
{
    //
    protected $table = 'menus';
    protected $types = ['main', 'other', 'special']; // Example types array
    private $lang ;

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


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set the current locale dynamically
        $this->lang = Helper::getLang();

    }

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
        return $this->{'name_'.$this->lang} ;
    }

    public function getActiveAttribute(){
        return   $this->status ? __('home.yes') : __( 'home.no') ;
     }

     public function scopeActive($query){
        return  $query->whereStatus(1);
      }

      public function scopeUnactive($query){
        return   $query->whereStatus(0);
      }


}
