<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingFees extends Model
{
    use HasFactory;

    protected $table = 'shipping_area_feeses' ;
    protected $fillable = ['area_id','fees'];


    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function getAreaNameAttribute(){
        return $this->area?->name;
    }
}
