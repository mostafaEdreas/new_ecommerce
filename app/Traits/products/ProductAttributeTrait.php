<?php
namespace App\Traits\Products;

use App\Models\Attribute;
use App\Models\Product;

trait ProductAttributeTrait {
    public function getAttributes($id){
        $product = Product::with(['attributes.values' , 'attributes.attribute'])->find($id) ;
        if( $product){
            $data['product'] =  $product;
            return view('admin.products.attributes.index',$data);
        }
        return redirect()->back()->withErrors(__('home.not_found'));
    }


    public function storeValuesToAttributes($id)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return redirect()->back()->withErrors(__('home.product not found'));
        }
    
        foreach ($product->attributes as $attribute) {
            $newValues = request($attribute->id, []);
    
            $currentValues = $attribute->values->pluck('value_id')->toArray();
    
            $valuesToDelete = array_diff($currentValues, $newValues);
            $attribute->values()->whereIn('value_id', $valuesToDelete)->delete();
    
            $valuesToAdd = array_diff($newValues, $currentValues);
            foreach ($valuesToAdd as $value) {
                $attribute->values()->create(['value_id' => $value]);
            }
        }
    
        return redirect()->back()->with('success', __('home.your_items_added_successfully'));
    }
    
}