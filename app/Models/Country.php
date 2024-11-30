<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;


class Country extends Model
{
    //
	protected $table='countries';

    public function delete()
    {
        if ( $this->addresses()->exists()) {
            $errors[] = 'Cannot delete an country that has related addresses that has related orders.';
        }

        return parent::delete();
    }
    public function addresses(){
        return $this->hasMany('App\Models\Address','country_id');
    }

    public function regions(){
        return $this->hasMany('App\Models\Region');
    }
}
