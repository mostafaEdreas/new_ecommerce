<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Helpers\SaveImageTo3Path;
use App\Models\ProductAttribute;
use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Attribute extends Model
{

    use HasFactory;

	protected $table = 'attributes';

    protected $fillable = [
        'name_ar',
        'name_en',
        'status',
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
}



