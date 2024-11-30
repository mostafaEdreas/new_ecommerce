<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;


class Area extends Model
{
    //
	protected $table='areas';


    public function delete()
    {
        $errors = [] ;
        if ( $this->addresses &&$this->addresses()->exists() ) {
      
            $errors[] = 'Cannot delete an area that has related addresses.';

        }
        if(count( $errors)){
            return $errors;
           }
           
           return parent::delete();
    }
    public function region(){
        return $this->belongsTo('App\Models\Region','region_id');
    }

    public function addresses(){
        return $this->hasMany('App\Models\Address','area_id');
    }

}
