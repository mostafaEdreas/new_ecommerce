<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;


class Country extends Model
{
    //
	protected $table='countries';

    public function addresses(){
        return $this->hasMany('App\Models\Address','country_id');
    }

    public function regions(){
        return $this->hasMany('App\Models\Region');
    }

    function scopeCheckBeforDelete($query){
        return $query->whereHas('addresses')
        ->orWhereHas('regions') ;
    }
}
