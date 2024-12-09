<?php
namespace App\Traits\products;

use App\Http\Requests\StockRequest;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductStock;

trait productStockTrait {
    public function getStocks($id){
        $product = Product::with(['stocks.values'])->find($id) ;
        if( $product){
            $data['product'] =  $product;
            return view('admin.products.stocks.index',$data);
        }
        return redirect()->back()->withErrors(__('home.not_found'));    
    }


    public function storeStock(StockRequest $request ,$id){
        $product = Product::with(['stocks.values'])->find($id) ;
        $data = $request->validated();
      
        if( $product){
            $stock = $product->stocks()->create( $data);
            foreach ($data['values'] ?? [] as  $value) {
                $stock->values()->create(['product_attribute_value_id' => $value]);
            }
            return redirect()->back()->with('success',__('home.your_item_added_successfully'));  
        }
        return redirect()->back()->withErrors(__('home.not_found'));    
    }


    public function updateStock(StockRequest $request ,$id){
        $stock = ProductStock::with(['values'])->find($id) ;
        $data = $request->validated();
        if( $stock){
            $stock->update($data);
            $stock = $stock->refresh();
            $newValues = $data['values'] ?? [] ;
            $currentValues =  $stock->values->pluck('product_attribute_value_id')->toArray();
            $valuestoDelete = array_diff($currentValues , $newValues);
            $stock->values()->whereIn('product_attribute_value_id' ,$valuestoDelete)->delete();
            $valuesToAdd = array_diff($newValues , $currentValues);

            foreach ($valuesToAdd as  $value) {
                $stock->values()->create(['product_attribute_value_id' => $value]);
            }

            return redirect()->back()->with('success',__('home.your_item_added_successfully'));  
        }
        return redirect()->back()->withErrors(__('home.not_found'));    
    }


    public function destoryStock($id){
        if( request('id')){
            request()->validate([
                'id' => 'array|min:1|',
                'id.*' => 'exists:product_stock,id'
            ]);
            $ids =  request('id') ;
            $delete = ProductStock::whereIn('id',$ids)->delete();
            // check if comming from ajax
            if(request()->ajax()){
                // check is is deleted or has any exception
                if( !$delete || is_array($delete) ){
                    return response()->json(['message'=> $delete??__('home.an messages.error entering data')],422);
                }
                return response()->json(['message'=>trans('home.your_items_deleted_successfully')]);
            }
            if( !$delete || is_array($delete)){
                return redirect()->back()->withErrors( $delete??__('home.an error has occurred. Please contact the developer to resolve the issue'));
            }
            return redirect()->back()->with('success',trans('home.your_items_deleted_successfully'));
        }elseif($productStock = ProductStock::find($id)){
               // check is is deleted or has any exception
               $delete = $productStock->delete();
            if(request()->ajax()){
                if( !$delete || is_array($delete) ){
                    return response()->json(['message'=> $delete??__('home.an messages.error entering data')],422);
                }
                return response()->json(['message'=>trans('home.your_item_deleted_successfully')]);
            }
            if( !$delete || is_array($delete)){
                return redirect()->back()->withErrors( $delete??__('home.an error has occurred. Please contact the developer to resolve the issue'));
            }
            return redirect()->back()->with('success',trans('home.your_item_deleted_successfully'));
        }
    }
}