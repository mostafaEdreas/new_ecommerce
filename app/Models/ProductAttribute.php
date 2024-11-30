<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttribute extends Model
{

    use HasFactory;
    protected $table = 'product_attributes';

    protected $fillable = [
        'product_id',
        'attribute_id',
    ];

    public function delete()
    {
        $errors = [] ;
        if ($this->values()->exists()) {
            foreach ($this->values as $value) {
                if($value->variants()->exists()){
                    foreach ($value->variants as $key => $variant) {
                        if($variant->stock()->exists() && $variant->stock->orders()->exists()){
                            $errors[] = 'Cannot delete an product Attribute that has related orders.';
                        }
                    }
                }
            }
        }
      
        if(count( $errors)){
            return $errors;
           } 
        return parent::delete();
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }

    public function getAttributeNameAttribute(){
        return $this->attribute?->name;
    }

    public function getAttributeIdAttribute(){
        return $this->attribute?->id;
    }
    public function values(){
        return $this->hasMany(ProductAttributeValue::class);
    }
}
