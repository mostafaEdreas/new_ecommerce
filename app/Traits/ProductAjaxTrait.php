<?php
namespace App\Traits;

use App\Models\Attribute;

trait ProductAjaxTrait {
    public function getValues(){

        $attribute_id  = request('attributes_id') ;
        $data['attributes'] = Attribute::whereIn('id' , $attribute_id)->with('values')->get();
        return response()->json(['html' => view('admin.products.componats.add-Attribute-values-to-select',$data)->render()]) ;
    }
}