<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Helpers\SaveImageTo3Path;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class About extends Model
{
    use HasFactory;
    protected $table = 'about';
    private $lang ;



    public function delete()
    {
        SaveImageTo3Path::deleteImage($this->icon, 'aboutStrucs');
        SaveImageTo3Path::deleteImage($this->image, 'aboutStrucs');
        return parent::delete();
    }

    protected $fillable = [
        'title_ar',    // Arabic title
        'title_en',    // English title
        'text_ar',     // Arabic text content
        'text_en',     // English text content
        'video_link',  // Link to video (optional)
        'image',       // Image filename or path (optional)
        'banner',        // Icon filename or path (optional)
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set the current locale dynamically
        $this->lang = Helper::getLang();

    }
    public function getTilteAttribute(){
      return  $this->{'title_'.$this->lang} ;
    }

    public function getTexteAttribute(){
        return  $this->{'title_'.$this->lang} ;
    }

    public function getImageAttribute($value)
    {
        return Helper::imageIsExists($value, 'about-us') ? $value : Helper::$noimage;
    }

    public function getIconAttribute($value){
        return Helper::imageIsExists($value ,'about-us') ? $value : Helper::$noimage ;
    }
}
