<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use DB;


class Region extends Model
{
    //
    protected $table='regions';

    private $lang ;
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set the current locale dynamically
        $this->lang = Helper::getLang();

    }
    public function delete()
    {
        if ( $this->addresses) {
            foreach ($this->addresses as  $value) {
               if ($value->orders) {
                    throw new \Exception('Cannot delete an region that has related addresses that has related orders.');
               }
            }
        }

        return parent::delete();
    }


    public function country(){
        return $this->belongsTo('App\Models\Country','country_id');
    }

    public function addresses(){
        return $this->hasMany('App\Models\Address','region_id');
    }

    public function areas(){
        return $this->hasMany('App\Models\Area');
    }


    function scopeCheckBeforDelete($query){
        return $query->whereHas('addresses')
        ->orWhereHas('areas');
    }

    public function getNameAttribute(){
        return $this->{'name_'.$this->lang};
    }
}
