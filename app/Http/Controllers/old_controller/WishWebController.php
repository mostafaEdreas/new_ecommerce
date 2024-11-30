<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishRequest;
use App\Models\Wishlist;
use App\Models\Stock;

class WishWebController extends Controller
{
    public function index(){
        $data['wishes'] = Wishlist::whereNotNull('group_id')->where('user_id',auth()->user()->id)->with('group')->get();
        return view('userBoard.wish_list', $data);
    }


    public function store(WishRequest $request){
        try {
            $group = Stock::find(request('group_id'));
            if ($group) {
                $status =  $this->addToProductwish();
               if(!$status ){
                   return response()->json(['status'=>false,'message'=>__('home.Your product already exists.') ]);
               }
               return response()->json(['status'=>true
                ,'message'=>__('home.your_product_successfully_added_to_your_wishList')
                ,'count'=> Wishlist::where('user_id',auth()->user()->id)->count()]);
            }
            return response()->json(['status'=>false,'message'=>__('home.an error occurred') ]);
        } catch (\Exception $ex ){
            if(request()->ajax()){
                return response()->json(['status'=>false,'message'=>$ex->getMessage()]);
            }
            if(env('APP_DEBUG')){
                dd($ex->getMessage());
            }

            return abort(500,__('home.an error occurred please connect with developer to solve it'));
        }

    }

    public function destroy($id){
        try {
            $cart = Wishlist::find($id);
            if($cart){
                $cart->delete();
               
                return response()->json(['status'=>true
                ,'message'=>__('home.your_product_deleted_successfully_from_your_wishList')
                ,'count'=> Wishlist::where('user_id',auth()->user()->id)->count()]);
            }
        return response()->json(['status'=>false,'message'=>__('home.an error occurred')]);
        } catch (\Exception $ex) {
            if(request()->ajax()){
                return response()->json(['status'=>false,'message'=>$ex->getMessage()]);
            }
            if(env('APP_DEBUG')){
                dd($ex->getMessage());
            }

            return abort(500,__('home.an error occurred please connect with developer to solve it'));
        }
            
    }


    private function addToProductWish(){
        $user_id = auth()->user()->id;
        $group_id = request('group_id');
        $wish_product = Wishlist::where('user_id',$user_id)->where('group_id',$group_id)->first();
        if ($wish_product) {
            return false;
        }
        return Wishlist::create(['group_id'=>$group_id,'user_id'=>$user_id]);
    }
}
