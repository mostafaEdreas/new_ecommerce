<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use DB;


class Slider extends Model
{
	protected $table='sliders';
    private $lang ;

    protected $fillable = [
        'title_ar',
        'title_en',
        'text_ar',
        'text_en',
        'video_link',
        'image',
        'order',
        'type',
        'status',
    ];

public const TYPES = ['home'];

public function __construct(array $attributes = [])
{
    parent::__construct($attributes);

    // Set the current locale dynamically
    $this->lang = Helper::getLang();

}
    public function getTitleAttribute(){
        return $this->{'title_'.$this->lang} ;
    }

    public function getTexteAttribute(){
        return $this->{'text_'.$this->lang} ;
    }

    public function getImageSourceAttribute(){
        return  Helper::imageIsExists($this->image ,'sliders') ? Helper::uploadedImagesPath('sliders',$this->image) : Helper::noImage() ;
    }

    public function getImage200Attribute(){
        return Helper::imageIsExists($this->image ,'sliders') ? Helper::uploadedImages200Path('sliders',$this->image) : Helper::noImage() ;
    }

    public function getViewAttribute(){
       return $this->video_link ?  Helper::videoImage() :  $this->image_200 ;
    }



    public function scopeActive($query){
        return  $query->whereStatus(1);
      }

      public function scopeUnactive($query){
        return   $query->whereStatus(0);
      }




}
