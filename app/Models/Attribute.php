<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Models\ProductAttribute;
use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{

    use HasFactory;

	protected $table = 'attributes';

    protected $fillable = [
        'name_ar',
        'name_en',
        'status',
    ];
    public const STATIC_ATTRIBUTE = [
        'color',
        'اللون',
    ];

    private $lang ;
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
            $errors[] = __('home.cannot delete an attribute that has related products');
        }

        if(count( $errors)){
                return $errors;
           }
           return parent::delete();
    }

    public function products(){
        return $this->hasMany(ProductAttribute::class);
    }

    public function values(){
        return $this->hasMany(AttributeValue::class);
    }


    public function getNameAttribute(){
        return $this->{'name_'.$this->lang};
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

    public function getIsColorAttribute(){
       return in_array($this->name_en ,self::STATIC_ATTRIBUTE ) || in_array($this->name_ar ,self::STATIC_ATTRIBUTE ) ;
    }


    public static function hasColor(){
        return  self::whereIn('name_ar' , self::STATIC_ATTRIBUTE)->orWhereIn('name_en' , self::STATIC_ATTRIBUTE)->exists() ;
    }

}



