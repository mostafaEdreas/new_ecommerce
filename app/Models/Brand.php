<?php

namespace App\Models;

use App\Helpers\Helper;
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

    public function getImageAttribute(){
        Helper::imageIsExists($this->image ,'brands') ? $this->image : Helper::noImage() ;
    }

    public function getIconAttribute(){
        Helper::imageIsExists($this->icon ,'brands') ? $this->icon : Helper::noImage() ;
    }


    public function getImageSourceAttribute(){
        Helper::imageIsExists($this->image ,'brands') ? $this->image : Helper::noImage() ;
    }

    public function getIcon200Attribute(){
        Helper::imageIsExists($this->icon ,'brands') ? $this->icon : Helper::noImage() ;
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
