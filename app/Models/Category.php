<?php

namespace App\Models;

use App\Helpers\Helper;
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
            $errors[] =  'Cannot delete a category that has related products.';
        }

        // Check if the category has children, and if any child has related products
        if ($this->children()->exists() ) {
             $errors[] = 'Cannot delete a category that has related child products.';
           
        }
        if(count( $errors)){
         return $errors;
        }
        
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
        return  $this->parent?->name ;
    }

    public function getParentTextAttribute(){
        return $this->parent?->text ;

    }

    public function getParentLinkAttribute(){
        return  $this->parent?->link  ;
    }

    public function getImageAttribute($value){

        return Helper::imageIsExists($this->image ,'categories') ? $this->image : Helper::$noimage ;

    }

    public function getIconAttribute(){

        return Helper::imageIsExists($this->icon ,'categories') ? $this->icon : Helper::$noimage ;
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
