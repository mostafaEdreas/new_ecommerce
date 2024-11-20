<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $table='addresses';

    public function country(){
        return $this->belongsTo('App\Models\Country','country_id');
    }

    public function region(){
        return $this->belongsTo('App\Models\Region','region_id');
    }

    public function area(){
        return $this->belongsTo('App\Models\Area','area_id');
    }

    public function uesr(){
        return $this->belongsTo('App\Models\users','user_id');
    }

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    function scopeCheckBeforDelete($query){
        return $query ->whereHas('orders') ;
    }
}
