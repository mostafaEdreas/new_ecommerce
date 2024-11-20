<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use DB;


class Slider extends Model
{
	protected $table='sliders';

    protected $fillable = [
        'title_ar',
        'title_en',
        'text_ar',
        'text_en',
        'video_link',
        'image',
        'order',
        'type',
    ];


    public function getTilteAttribute(){
        $this->{'title_'.$this->lang} ;
    }

    public function getTexteAttribute(){
        $this->{'title_'.$this->lang} ;
    }

    public function getImageAttribute(){
        Helper::imageIsExists($this->image ,'sliders') ? $this->image : Helper::$noimage ;
    }






}
