<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttributeValue extends Model
{
    use HasFactory;
    protected $table = 'product_attribute_values';
    private $lang ;

    protected $fillable = [
        'product_attribute_id',
        'value_id',
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
      
        if($this->variants()->exists()){
            foreach ($this->variants as $key => $variant) {
                if($variant->stock()->exists() && $variant->stock->orders()->exists()){
                    $errors[] = 'Cannot delete an product Attribute value that has related orders.';
                }
            }
           
        }
      
        if(count( $errors)){
            return $errors;
           } 
        return parent::delete();
    }

    public function attribute(){
        return $this->belongsTo(ProductAttribute::class) ;
    }


    public function value(){
        return $this->belongsTo(AttributeValue::class) ;
    }


    public function getValueNameAttribute(){
        return $this->value?->value ;
    }

    public function getValueIdAttribute(){
        return $this->value?->id ;
    }

    public function variants(){
        return $this->hasMany(ProductVariant::class) ;
    }

}
