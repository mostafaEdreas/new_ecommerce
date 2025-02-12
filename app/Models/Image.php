<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Helpers\SaveImageTo3Path;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $fillable = [
        'image',
        'imageable_id',
        'imageable_type',
    ];


    public function delete()
    {
        
        SaveImageTo3Path::deleteImage($this->image, 'images');

        return parent::delete();
    }

    protected $table = 'images' ;

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getImageSourceAttribute(){

        return Helper::imageIsExists($this->image ,'images') ? Helper::uploadedImagesPath('images',$this->image)  : Helper::noImage() ;

    }

    public function getImage200Attribute(){

        return Helper::imageIsExists($this->image ,'images') ? Helper::uploadedImages200Path('images',$this->image)  : Helper::noImage() ;

    }
}
