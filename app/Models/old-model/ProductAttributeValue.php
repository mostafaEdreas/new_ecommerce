<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    protected $table = 'product_attributes';
    protected $fillable = ['price'];
    protected $appends = ['name'];
   
}
