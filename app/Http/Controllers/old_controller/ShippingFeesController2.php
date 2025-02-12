<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingFeesRequest;
use App\Models\ShippingFees;
use App\Models\ShippingMethod;


class ShippingFeesController2 extends Controller
{

    public function __construct(){
        $this->middleware(['permission:shipping-fees']);
    }

    public function index()
    {
        $shippingFees = ShippingFees::query();
        if(request('area_id')){
            $shippingFees->where('area_id' , request('area_id'));
        }

        if(request('region_id')){
            $shippingFees->whereHas('area' , function($q){
                $q->where('region_id' , request('region_id'));
            });
        }

        if(request('country_id')){
            $shippingFees->whereHas('area' , function($q){
                $q->whereHas('region' , function($q){
                    $q->where('country_id' , request('country_id'));
                });
            });
        }

        $data['shippingFees'] = $shippingFees->get();
        return view('admin.shippingFees.index',$data);
    }

    public function update(ShippingFeesRequest $request)
    {

        $data = $request->validated() ;
        foreach ($data['ids'] as $index =>  $id) {
            $area_fees = ShippingMethod::find($id);
            $area_fees->update(['fees' => $data['fees'][$index]]);
        }

        return redirect()->back()->with('success',trans('home.your_item_updated_successfully'));
    }

}
