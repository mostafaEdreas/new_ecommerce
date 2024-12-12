<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;

use App\Models\Region;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\User;


class CouponController extends Controller
{

    public function index()
    {
        $coupons = Coupon::get();
        return view('admin.coupons.coupons',compact('coupons'));
    }


    public function create()
    {
        return view('admin.coupons.addCoupon');
    }

    public function store(CouponRequest $request)
    {
        $data = $request->validated();
        Coupon::create($data);
        return redirect()->back()->with('success',trans('home.your_item_added_successfully'));
    }


    public function edit($id)
    {
        $data['coupon'] = Coupon::find($id);
        return view('admin.coupons.editCoupon' , $data);
    }
    public function update(CouponRequest $request, $id)
    {

        $add = Coupon::find($id);
        $data = $request->validated();
        $add->update($data);
        return redirect()->back()->with('success',trans('home.your_item_updated_successfully'));
    }


    public function destroy($id)
    {
        if( request('id')){
            request()->validate([
                'id' => 'array|min:1|',
                'id.*' => 'exists:coupons,id'
            ]);
            $ids =  request('id') ;
            $delete = Coupon::whereIn('id',$ids)->delete();
            // check if comming from ajax
            if(request()->ajax()){
                // check is is deleted or has any exception
                if( !$delete ){
                    return response()->json(['message'=> $delete??__('home.an messages.error entering data')],422);
                }
                return response()->json(['message'=>trans('home.your_items_deleted_successfully')]);
            }
            if( !$delete ){
                return redirect()->back()->withErrors( $delete??__('home.an error has occurred. Please contact the developer to resolve the issue'));
            }
            return redirect()->back()->with('success',trans('home.your_items_deleted_successfully'));
        }elseif($coupon = Coupon::find($id)){
               // check is is deleted or has any exception
               $delete = $coupon->delete();
            if(request()->ajax()){
                if( !$delete ){
                    return response()->json(['message'=> $delete??__('home.an messages.error entering data')],422);
                }
                return response()->json(['message'=>trans('home.your_item_deleted_successfully')]);
            }
            if( !$delete ){
                return redirect()->back()->withErrors( $delete??__('home.an error has occurred. Please contact the developer to resolve the issue'));
            }
            return redirect()->back()->with('success',trans('home.your_item_deleted_successfully'));
        }
    }


    public function couponType(){
        $type=$_POST['type'];

        $categories=Category::where('status',1)->get();
        $brands=Brand::where('status',1)->get();
        $products=Product::where('status',1)->get();
        $users=User::where('status','active')->get();
        $regions=Region::where('status',1)->get();
        return response()->json([
            'html' => view('admin.coupons.couponTypes', compact('type','categories','brands','users','regions','products'))->render(),
        ]);

    }

}
