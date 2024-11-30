<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $table='addresses';
    private $lang ;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set the current locale dynamically
        $this->lang = Helper::getLang();

    }

    public function delete()
    {
        $errors = [] ;
        if ($this->orders()->exists()) {
             $errors[] = 'Cannot delete an address that has related orders.';
        }

        if(count( $errors)){
            return $errors;
        }
           
           return parent::delete();
    }
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

    public function getCountryNameAttribute(){
        return $this->country?->{'name_'.$this->lang} ;
    }

    public function getRegionNameAttribute(){
        return $this->region?->{'name_'.$this->lang} ;
    }

    public function getAreaNameAttribute(){
        return $this->area?->{'name_'.$this->lang} ;
    }

    public function getFullAddressAttribute(){
        return $this->address .' - ' .  $this->area_name .' - ' .$this->region_name .' - ' .$this->country_name .' ( ' .$this->land_mark .' )'  ;
    }
}
