<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Helpers\SaveImageTo3Path;
use Illuminate\Database\Eloquent\Model;
use DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;
	protected $table='brands';

    private $lang ;

    protected $fillable = [
        'name_ar',
        'name_en',
        'order',
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set the current locale dynamically
        $this->lang = Helper::getLang();

    }

    public function delete()
    {
        $errors = [] ;
        if ($this->products()->exists()) {
            $errors[] = 'Cannot delete an value that has related products.';
        }

        if(count( $errors)){
            return $errors;
           }

           SaveImageTo3Path::deleteImage($this->image,'brands');
           SaveImageTo3Path::deleteImage($this->icon,'brands');
           return parent::delete();
    }
	public function products(){
	    return $this->hasMany(Product::class)->inRandomOrder();
	}

    public function activeProducts(){
	    return $this->hasMany(Product::class)->whereStatus(1)->inRandomOrder();
	}


    public function getNameAttribute(){
        return $this->{'name_'.$this->lang} ;
    }

    public function getTextAttribute(){
        return $this->{'text_'.$this->lang} ;
    }

    public function getLinkAttribute(){
        return $this->{'link_'.$this->lang} ;
    }

    public function getImageSourceAttribute($value){

        return Helper::imageIsExists($this->image ,'brands') ?  Helper::uploadedImagesPath('brands',$this->image)   : Helper::noImage() ;

    }

    public function getImage200Attribute($value){

        return Helper::imageIsExists($this->image ,'brands') ?  Helper::uploadedImages200Path('brands',$this->image)  : Helper::noImage();

    }

    public function getIconSourceAttribute(){

        return Helper::imageIsExists($this->icon ,'brands') ? Helper::uploadedImagesPath('brands',$this->icon) : Helper::noImage();
    }

    public function getIcon200Attribute(){

        return Helper::imageIsExists($this->icon ,'brands') ?Helper::uploadedImages200Path('brands',$this->icon) : Helper::noImage();
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
