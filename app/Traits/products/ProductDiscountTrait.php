<?php
namespace App\Traits\Products;

use App\Http\Requests\DiscountRequest;
use App\Models\Discount;
use App\Models\Product;

trait ProductDiscountTrait {
    public function discountIndex($id){
        $product = Product::with(['discounts'=>function($q){
            $q->latest();
        }])->find($id);
        if($product)
            return view('admin.products.discounts.index',compact('product'));

        return redirect()->back()->withError(__('home.product_not_found'));
    }


    public function discountStore(DiscountRequest $request){
        $data = $request->validated();
        Discount::create($data);
        return  redirect()->back()->with('success',__('home.your_item_added_successfully'));
    }


    public function discountUpdate(DiscountRequest $request,$discount_id){
        $discount = Discount::find($discount_id);
        $data = $request->validated();
        $discount->update($data);
        return  redirect()->back()->with('success',__('home.your_item_added_successfully'));
    }

    public function discountDestroy($id)
    {

        if( request('id')){
            $ids =  request('id') ;
            $ids = is_array(   $ids ) ?    $ids  : [ $ids ];
            Discount::whereIn('id',$ids)->delete();
            if(request()->ajax()){
                return response()->json(['message'=>trans('home.your_items_deleted_successfully')]);
            }
            return redirect()->back()->with('success',trans('home.your_items_deleted_successfully'));
        }elseif($discount = Discount::find($id)){
            $discount->delete();
            if(request()->ajax()){
                return response()->json(['message'=>trans('home.your_item_deleted_successfully')]);
            }
            return redirect()->back()->with('success',trans('home.your_item_deleted_successfully'));
        }
    }
}