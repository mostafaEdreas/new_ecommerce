<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'deliveries';

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    public function phones(){
        return $this->morphMany(Phone::class,'phonable');
    }

}
