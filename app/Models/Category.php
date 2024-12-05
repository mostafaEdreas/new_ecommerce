<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Helpers\SaveImageTo3Path;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    private $lang ;

    public function delete()
    {
        $errors = [] ;
        // Check if the category has related products
        if ($this->products()->exists()) {
            $errors[] =  __('home.cannot delete a category that has related products');
        }

        // Check if the category has children, and if any child has related products
        if ($this->children()->exists() ) {
             $errors[] = __( 'home.cannot delete a category that has related child child');

        }
        if(count( $errors)){
            return $errors;
        }

        SaveImageTo3Path::deleteImage($this->image,'categories');
        SaveImageTo3Path::deleteImage($this->icon,'categories');
        return parent::delete();
    }
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


    public function getParentNameAttribute(){
        return  $this->parent?->name ?? trans('home.main_category');
    }

    public function getParentTextAttribute(){
        return $this->parent?->text ;

    }

    public function getParentLinkAttribute(){
        return  $this->parent?->link  ;
    }

    public function getImageSourceAttribute($value){

        return Helper::imageIsExists($this->image ,'categories') ?  Helper::uploadedImagesPath('categories',$this->image)   : Helper::noImage() ;

    }

    public function getImage200Attribute($value){

        return Helper::imageIsExists($this->image ,'categories') ?  Helper::uploadedImages200Path('categories',$this->image)  : Helper::noImage();

    }

    public function getIconSourceAttribute(){

        return Helper::imageIsExists($this->icon ,'categories') ? Helper::uploadedImagesPath('categories',$this->icon) : Helper::noImage();
    }

    public function getIcon200Attribute(){

        return Helper::imageIsExists($this->icon ,'categories') ?Helper::uploadedImages200Path('categories',$this->icon) : Helper::noImage();
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
