<?php
namespace App\Services;

use App\Models\AttributeValue;

class AttributeValueServices {
    public function store(array $data){
        return AttributeValue::craete($data);
    }
 

    public function destory($id){
        return AttributeValue::find($id)?->delete();
    }

}