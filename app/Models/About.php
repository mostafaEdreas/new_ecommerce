<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class About extends Model
{
    protected $table = 'about';
    private $lang = LaravelLocalization::getCurrentLocale();



    protected $fillable = [
        'title_ar',    // Arabic title
        'title_en',    // English title
        'text_ar',     // Arabic text content
        'text_en',     // English text content
        'video_link',  // Link to video (optional)
        'image',       // Image filename or path (optional)
        'icon',        // Icon filename or path (optional)
    ];


    public function getTilteAttribute(){
        $this->{'title_'.$this->lang} ;
    }

    public function getTexteAttribute(){
        $this->{'title_'.$this->lang} ;
    }

    public function getImageAttribute(){
        Helper::imageIsExists($this->image ,'about-us') ? $this->image : Helper::$noimage ;
    }

    public function getIconAttribute(){
        Helper::imageIsExists($this->icon ,'about-us') ? $this->icon : Helper::$noimage ;
    }
}
