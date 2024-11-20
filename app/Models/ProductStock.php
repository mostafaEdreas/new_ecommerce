<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class ProductStock extends Model
{
    use HasFactory;
    protected $table = 'product_stock';
    protected $fillable = [
        'product_id',
        'stock',
        'price',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function values(){
        return $this->hasMany(ProductVariant::class);
    }
}
