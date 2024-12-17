<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Helpers\SaveImageTo3Path;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AttributeValue extends Model
{
    //
    use HasFactory;
	protected $table = 'attribute_values';

    private $lang ;

    protected $fillable = [
        'value_ar',        // Arabic name of the attribute
        'value_en',        // English name of the attribute
        'attribute_id',   // Foreign key to the attributes table
        'description_ar', // Arabic description
        'description_en', // English description
        'status',         // Status of the record
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
            $errors[] = __('home.cannot delete an attribute that has related products');
        }

        if(count( $errors)){
            return $errors;
           }

           return parent::delete();
    }

    public function products(){
        return $this->hasMany(ProductAttributeValue::class);
    }
    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }

    public function getValueAttribute(){
        return $this->{'value_'.$this->lang}  ;
    }

    public function getDescAttribute(){
        return $this->{'description_'.$this->lang}  ;
    }

    public function getAttributeNameAttribute(){
        return $this->attribute?->value;
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



