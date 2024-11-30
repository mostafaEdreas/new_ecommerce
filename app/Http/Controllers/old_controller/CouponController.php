<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponBrand;
use App\Models\CouponProduct;
use App\Models\CouponUser;
use App\Models\CouponCategory;
use App\Models\CouponRegion;
use App\Models\CouponShipping;
use App\Models\Region;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\User;
use File;
use Image;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $coupons = Coupon::get();
        return view('admin.coupons.coupons',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.coupons.addCoupon');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $add=new Coupon();
        $add->name=$request->name;
        $add->code=$request->code;
        $add->expire_date=$request->expire_date;
        $add->value=$request->value;
        $add->value_type=$request->value_type;
        $add->order_min_price=$request->order_min_price;
        $add->max_used=$request->max_used;
        $add->coupon_type=$request->coupon_type;
        $add->save();
        
        if($request->coupon_type == 'category'){
            
            $categoryIds=$request->category_id;
            foreach($categoryIds as $categoryId){
                $catCoupon=new CouponCategory();
                $catCoupon->coupon_id=$add->id;
                $catCoupon->category_id=$categoryId;
                $catCoupon->save();
            }
        }elseif($request->coupon_type == 'brand'){
            
            $brandIds=$request->brand_id;
            foreach($brandIds as $brandId){
                $brandCoupon=new CouponBrand();
                $brandCoupon->coupon_id=$add->id;
                $brandCoupon->brand_id=$brandId;
                $brandCoupon->save();
            }
        }elseif($request->coupon_type == 'product'){
            
            $productIds=$request->product_id;
            foreach($productIds as $productId){
                $prodCoupon=new CouponProduct();
                $prodCoupon->coupon_id=$add->id;
                $prodCoupon->product_id=$productId;
                $prodCoupon->save();
            }
            
            
        }elseif($request->coupon_type == 'user'){
            
            $userIds=$request->user_id;
            foreach($userIds as $userId){
                 $userCoupon=new CouponUser();
                $userCoupon->coupon_id=$add->id;
                $userCoupon->user_id=$userId;
                $userCoupon->save();
            }
           
            
        }elseif($request->coupon_type == 'region'){
            
            $regionIds=$request->region_id;
            foreach($regionIds as $regionId){
                $regCoupon=new CouponRegion();
                $regCoupon->coupon_id=$add->id;
                $regCoupon->region_id=$regionId;
                $regCoupon->save();
            }
            
            
        }elseif($request->coupon_type == 'free_shipping'){
            
            $regionIds=$request->shipping_id;
            foreach($regionIds as $regionId){
                    $shipCoupon=new Couponshipping();
                    $shipCoupon->coupon_id=$add->id;
                    $shipCoupon->region_id=$regionId;
                    $shipCoupon->save();
            }
        }
        return redirect()->route('coupons.index')->with('success',trans('home.your_item_added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::find($id);
        if($coupon){

            if($coupon->coupon_type == 'category'){
                $values = Category::where('status',1)->get();
                $selectedValueIds = CouponCategory::where('coupon_id',$id)->pluck('category_id')->toArray();
            }elseif($coupon->coupon_type == 'product'){
                $values = Product::where('status',1)->get();
                $selectedValueIds = CouponProduct::where('coupon_id',$id)->pluck('product_id')->toArray();
            }elseif($coupon->coupon_type == 'brand'){
                $values = Brand::where('status',1)->get();
                $selectedValueIds = CouponBrand::where('coupon_id',$id)->pluck('brand_id')->toArray();
            }elseif($coupon->coupon_type == 'user'){
                $values = User::where('status','active')->get();
                $selectedValueIds = CouponUser::where('coupon_id',$id)->pluck('user_id')->toArray();
            }elseif($coupon->coupon_type == 'region' ){
                $values = Region::where('status',1)->get();
                $selectedValueIds = CouponRegion::where('coupon_id',$id)->pluck('region_id')->toArray();
            }elseif($coupon->coupon_type == 'free_shipping'){
                $values = Region::where('status',1)->get();
                $selectedValueIds = CouponShipping::where('coupon_id',$id)->pluck('region_id')->toArray();
            }elseif($coupon->coupon_type == 'general'){
                return view('admin.coupons.editCoupon',compact('coupon'));
            }
            
            return view('admin.coupons.editCoupon',compact('coupon','values','selectedValueIds'));
    
        }else{
            abort('404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $add = Coupon::find($id);

        ///////// remove old selectd values ////
        if($add->coupon_type == 'category'){
            CouponCategory::where('coupon_id',$id)->delete();
        }elseif($add->coupon_type == 'brand'){
            CouponBrand::where('coupon_id',$id)->delete();
        }elseif($add->coupon_type == 'product'){
            CouponProduct::where('coupon_id',$id)->delete();
        }elseif($add->coupon_type == 'user'){
            CouponUser::where('coupon_id',$id)->delete();
        }elseif($add->coupon_type == 'region'){
            CouponRegion::where('coupon_id',$id)->delete();
        }elseif($add->coupon_type == 'free_shipping'){
            CouponShipping::where('coupon_id',$id)->delete();
        }

        $add->name=$request->name;
        $add->code=$request->code;
        $add->expire_date=$request->expire_date;
        $add->value=$request->value;
        $add->value_type=$request->value_type;
        $add->order_min_price=$request->order_min_price;
        $add->max_used=$request->max_used;
        $add->coupon_type=$request->coupon_type;
        $add->save();

        if($request->coupon_type == 'category'){
            
            $categoryIds=$request->category_id;
            foreach($categoryIds as $categoryId){
                $catCoupon=new CouponCategory();
                $catCoupon->coupon_id=$add->id;
                $catCoupon->category_id=$categoryId;
                $catCoupon->save();
            }
        }elseif($request->coupon_type == 'brand'){
            
            $brandIds=$request->brand_id;
            foreach($brandIds as $brandId){
                $brandCoupon=new CouponBrand();
                $brandCoupon->coupon_id=$add->id;
                $brandCoupon->brand_id=$brandId;
                $brandCoupon->save();
            }
        }elseif($request->coupon_type == 'product'){
            
            $productIds=$request->product_id;
            foreach($productIds as $productId){
                $prodCoupon=new CouponProduct();
                $prodCoupon->coupon_id=$add->id;
                $prodCoupon->product_id=$productId;
                $prodCoupon->save();
            }
            
            
        }elseif($request->coupon_type == 'user'){
            
            $userIds=$request->user_id;
            foreach($userIds as $userId){
                $userCoupon=new CouponUser();
                $userCoupon->coupon_id=$add->id;
                $userCoupon->user_id=$userId;
                $userCoupon->save();
            }
           
            
        }elseif($request->coupon_type == 'region'){
            
            $regionIds=$request->region_id;
            foreach($regionIds as $regionId){
                $regCoupon=new CouponRegion();
                $regCoupon->coupon_id=$add->id;
                $regCoupon->region_id=$regionId;
                $regCoupon->save();
            }
            
            
        }elseif($request->coupon_type == 'free_shipping'){
            
            $regionIds=$request->shipping_id;
            foreach($regionIds as $regionId){
                    $shipCoupon=new Couponshipping();
                    $shipCoupon->coupon_id=$add->id;
                    $shipCoupon->region_id=$regionId;
                    $shipCoupon->save();
            }
        }
        return redirect()->route('coupons.index')->with('success',trans('home.your_item_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        $ids = explode(',', $ids);
        if ($ids[0] == 'on') {
            unset($ids[0]);
        }
        foreach ($ids as $id) {
            Coupon::findOrFail($id)->delete();
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
