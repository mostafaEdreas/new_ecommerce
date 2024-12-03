<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Helpers\SaveImageTo3Path;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AboutStruc extends Model
{
    //
    protected $table = 'about_strucs';
    private $lang ;

    public $timestamps = false;



    protected $fillable = [
        'name_ar',
        'name_en',
        'text_ar',
        'text_en',
        'status',
        'parent_id',
        'image',
        'order',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set the current locale dynamically
        $this->lang = Helper::getLang();

    }


    public function delete()
    {
        SaveImageTo3Path::deleteImage($this->image, 'aboutStrucs');
        return parent::delete();
    }

    public function children(){
        return $this->hasMany(self::class,'parent_id','id');
    }

    public function parent(){
        return $this->belongsTo(self::class,'parent_id','id');
    }

    public function getNameAttribute(){
        return $this->{'name_'.$this->lang} ;
    }
    public function getTextAttribute(){
        return $this->{'text_'.$this->lang} ;
    }
    public function getParentNameAttribute(){
        return  $this->parent?->name ;
    }
    public function getParentTextAttribute(){
        return  $this->parent?->text ;
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

    public function getImageSourceAttribute($image){
        return Helper::imageIsExists($this->image ,'aboutStrucs') ?  Helper::uploadedImagesPath('aboutStrucs',$this->image) : Helper::noImage() ;
    }

    public function getImage200Attribute(){
        return Helper::imageIsExists($this->image ,'aboutStrucs') ?  Helper::uploadedImages200Path('aboutStrucs',$this->image) : Helper::noImage() ;
    }

    

}
