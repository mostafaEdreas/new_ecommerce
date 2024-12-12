<?php

namespace App\Models;

use App\Helpers\Helper;
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

    private $lang ;
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set the current locale dynamically
        $this->lang = Helper::getLang();

    }

    public function region(){
        return $this->belongsTo('App\Models\Region','region_id');
    }

    public function addresses(){
        return $this->hasMany('App\Models\Address','area_id');
    }


    public function getNameAttribute(){
        return $this->{'name_'.$this->lang};
    }

}
