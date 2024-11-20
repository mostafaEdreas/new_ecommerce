<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Region;
use App\Models\Area;
use App\Models\Category;
use App\Models\Product;
use App\Models\OrderProduct;
use DB;
use App\Models\Vendor;
use App\Models\Brand;
use App\Models\CategoryAttribute;
use App\Models\Attribute;
use App\Models\Wishlist;
use Auth;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\ProductOption;
use App\Models\ProductPrice;
use App\Models\Address;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\CartProductOption;
use App\Models\CartProductAttributeValue;
use App\Models\ProductDiscount;
use App\Models\Coupon;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use App\Models\OrderStatus;
use File;
use Image;
use App\Models\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ComapreList;
use Session;
use App\Models\GuestCart;
use App\Models\GuestCartProduct;
use App\Models\GuestCartProductAttribute;
use App\Models\GuestCartProductOption;
use Mail;
use App\Models\Setting;
use App\Models\Stock;
use GuzzleHttp\Client;
use App\Services\BostaService;


class UserBoardController extends Controller
{
    //////// FUNCTION RETURN VIEW OF ACCOUNT SETTINGS///
    public function accountSettings(){
        $user=Auth::user();
        return view('userBoard.account_settings',compact('user'));
    }

    ////////////////////function return wishList view////////////////
    public function wishList(){
        $user=Auth::user();
        if(Auth::check()){
            $wisheProductIds=Wishlist::where('user_id',$user->id)->pluck('product_id')->toArray();
        }else{
            $wisheProductIds=[];
            $wisheProductIds= Session::get('wishlist');
        }

        if($wisheProductIds){
            $wishProducts=Product::whereIn('id',$wisheProductIds)->get();
        }else{
            $wishProducts=[];
        }

        if(count($wishProducts) > 0){
            return view('userBoard.wish_list',compact('user','wishProducts'));
        }else{
            return view('userBoard.emptyWishlist');
        }
    }

    //////////////// ajax function that add product to wishlist///////////
    public function addWishlist(){
        $productId=$_POST['productId'];

        if(Auth::check()){
            $check=Wishlist::where('product_id',$productId)->where('user_id',Auth::user()->id)->first();
            if(! $check){
                $add= new Wishlist();
                $add->user_id =Auth::user()->id ;
                $add->product_id=$productId;
                $add->save();
            }else{
                $check->delete();
            }
            $wishCount =Wishlist::where('user_id',Auth::user()->id)->count();
            return response()->json(['wishCount'=>$wishCount]);
        }else{

            if(!Session::has('wishlist')){
                Session::put('wishlist', []);
            }
            $guestWishlist = Session::get('wishlist');

            if(!in_array($productId,$guestWishlist)){
                Session::push('wishlist',$productId);
                Session::save();
                $guestWishlist = Session::get('wishlist');
            }else{
                if (($key = array_search($productId, $guestWishlist)) !== false) {
                    unset($guestWishlist[$key]);
                    Session::put('wishlist', $guestWishlist);
                }
            }
            $wishCount =count($guestWishlist);
            return response()->json(['wishCount'=>$wishCount]);
        }
    }


    /////////////// function that remove wishlist////////////
    public function removeWishlist($id){
        if(Auth::check()){
            $wishlist=Wishlist::where('user_id',Auth::user()->id)->where('product_id',$id)->delete();
        }else{

            //// remove wishlist from guest session//////
            $guestWishlist = Session::get('wishlist');
            if (($key = array_search($id, $guestWishlist)) !== false) {
                unset($guestWishlist[$key]);
                Session::put('wishlist', $guestWishlist);
            }
        }
        return back()->with('success',trans('home.product_removed_from_wishlist'));
    }

    ////////////////////function return shippingAddress view////////////////
    public function shippingAddresses(){
        $user = Auth::user();
        $addresses=Address::where('user_id',$user->id)->get();
        return view('userBoard.shipping_addresses',compact('user','addresses'));
    }

    ////////////////////function return add shipping Address view////////////////
    public function addShippingAddress(){
        $user = Auth::user();
        $countries=Country::where('status',1)->get();

        session()->put('address','shipping_address');
        return view('userBoard.addAddress',compact('user','countries'));
    }


    public function storeAddress(Request $request){

        $userAddresses=Address::where('user_id',Auth::user()->id)->get();
        if(count($userAddresses)>0){
            foreach($userAddresses as $address){
                $address->is_primary=0;
                $address->save();
            }
                $address=new Address();
                $address->user_id=Auth::user()->id;
                $address->country_id=$request->country_id;
                $address->region_id=$request->region_id;
                $address->area_id=$request->area_id;
                $address->is_primary=1;
                $address->phone1=$request->phone1;
                $address->phone2=$request->phone2;
                $address->address=$request->address;
                $address->lat=$request->latitude;
                $address->lng=$request->longtude;
                $address->land_mark=$request->landmark;
                $address->save();
                return redirect('user/shipping-addresses')->with('success',trans('home.new address created successfully'));
        }else{
                $address=new Address();
                $address->user_id=Auth::user()->id;
                $address->country_id=$request->country_id;
                $address->region_id=$request->region_id;
                $address->area_id=$request->area_id;
                $address->is_primary=1;
                $address->phone1=$request->phone1;
                $address->phone2=$request->phone2;
                $address->address=$request->address;
                $address->lat=$request->latitude;
                $address->lng=$request->longtude;
                $address->land_mark=$request->landmark;
                $address->save();

                if(session()->has('return-to-checkout')){
                    session()->forget('return-to-checkout');
                    return redirect('/order-checkOut')->with('success',trans('home.new address created successfully'));
                }else{
                    return redirect('user/shipping-addresses')->with('success',trans('home.new address created successfully'));
                }

            }
    }

   ////////////////////function return edit shipping Address view////////////////
    public function editshippingAddress($id){
        $user = Auth::user();
        $address=Address::where('id',$id)->where('user_id',$user->id)->first();
        if($address){
            $countries=Country::where('status',1)->get();
            $regions=Region::where('country_id',$address->country_id)->where('status',1)->get();
            $areas=Area::where('region_id',$address->region_id)->get();
            return view('userBoard.editAddress',compact('user','regions','areas','countries','address'));

        }else{
            abort('404');
        }
    }

      //////////////////////////////// edit user existing address//////////////////////////////////////////////////
      public function updateAddress($id,Request $request){
        $address= Address::find($id);
        $address->country_id=$request->country_id;
        $address->region_id=$request->region_id;
        $address->area_id=$request->area_id;
        $address->phone1=$request->phone1;
        $address->phone2=$request->phone2;
        $address->address=$request->address;
        $address->lat=$request->latitude;
        $address->lng=$request->longtude;
        $address->land_mark=$request->landmark;
        $address->save();
        if(session()->has('return-to-checkout')){
            return redirect('order-checkOut');
        }
        return redirect('user/shipping-addresses')->with('success',trans('home.address updated successfully'));
    }

    ////////////////////////////// make user adress is aprimary address //////////////////////////////
    public function makeAddressPrimary($id){
        $userAddresses=Address::where('user_id',Auth::user()->id)->get();
        foreach($userAddresses as $address){
            $address->is_primary=0;
            $address->save();
        }
        $address=Address::where('user_id',Auth::user()->id)->where('id',$id)->first();
        $address->is_primary=1;
        $address->save();
        return back()->with('success',trans('home.primary address changed successfully'));

    }

    ///////// delete user address ///////////////////////////////////////////////
    public function deleteAddress($id){
        $address=Address::where('user_id',Auth::user()->id)->where('id',$id)->delete();
        return back()->with('success',trans('home.address deleted successfully'));
    }

    public function editAccount(){
        $user = Auth::user();
        return view('userBoard.editAccount',compact('user'));
    }

    public function updateAccountSetting(Request $request){
        $request->validate([
            'email' => 'string|email|max:150|unique:users,email,'.auth()->user()->id,
            'phone' => ['required'],
        ]);

        $user = Auth::user();
        $user->f_name=$request->f_name;
        $user->l_name=$request->l_name;
        if($request->email){
            $user->email=$request->email;
        }
        $user->phone=$request->phone;
        if ($request->hasFile("image")) {

            $file = $request->file("image");
            $mime = File::mimeType($file);
            $mimearr = explode('/', $mime);

            $img_path = base_path() . '/uploads/users/source/';
            $img_path200 = base_path() . '/uploads/users/resize200/';
            $img_path800 = base_path() . '/uploads/users/resize800/';

            if ($user->image != null) {
                unlink(sprintf($img_path . '%s', $user->image));
                unlink(sprintf($img_path200 . '%s', $user->image));
                unlink(sprintf($img_path800 . '%s', $user->image));
            }
            // $destinationPath = base_path() . '/uploads/'; // upload path
            $extension = $mimearr[1]; // getting file extension
            $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            $path = base_path('uploads/users/source/' . $fileName);
            $resize200 = base_path('uploads/users/resize200/' . $fileName);
            $resize800 = base_path('uploads/users/resize800/' . $fileName);
            //  $file->move($destinationPath, $fileName);

            Image::make($file->getRealPath())->save($path);

            $arrayimage = list($width, $height) = getimagesize($file->getRealPath());
            $widthreal = $arrayimage['0'];
            $heightreal = $arrayimage['1'];

            $width200 = ($widthreal / $heightreal) * 200;
            $height200 = $width200 / ($widthreal / $heightreal);

            $img200 = Image::canvas($width200, $height200);
            $image200 = Image::make($file->getRealPath())->resize($width200, $height200, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            $img200->insert($image200, 'center');
            $img200->save($resize200);

            $width800 = ($widthreal / $heightreal) * 800;
            $height800 = $width800 / ($widthreal / $heightreal);

            $img800 = Image::canvas($width800, $height800);
            $image800 = Image::make($file->getRealPath())->resize($width800, $height800, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            $img800->insert($image800, 'center');
            $img800->save($resize800);

            $user->image = $fileName;
        }
        $user->save();

        ////// change password////
        if($request->cur_password && $request->new_password && $request->conf_password){
            $request->validate([
                'cur_password' => ['required', new MatchOldPassword],
                'new_password' => ['required'],
                'conf_password' => ['same:new_password'],
            ]);

            $user->password = Hash::make($request->new_password);
            $user->save();

            ////// send email//////
    	    Mail::send('emails/passwordChanged', [], function($msg) use ($user) {
      			$msg->to($user ->email, 'Naguib Selim')->subject('Password Changed');
      			$msg->from(config('mail.from.address'),config('mail.from.name'));
    		});

            return redirect('user/account-settings')->with('success',trans('home.password changed successfully'));
        }

        ////// send email//////
	    // Mail::send('emails/userDateChanged', [], function($msg) use ($user) {
  		// 	$msg->to($user ->email, 'Naguib Selim')->subject('User Date Changed');
  		// 	$msg->from(config('mail.from.address'),config('mail.from.name'));
		// });

        return redirect('user/account-settings')->with('success',trans('home.account settings updated successfully'));
    }

    /////FUNCTION RETURN ORDERS VIEW///////////////
    public function orders(){
        $user = Auth::user();
        $orders=Order::where('user_id',$user->id)->orderBy('id','DESC')->get();
        $orderIds=Order::where('user_id',$user->id)->pluck('id')->toArray();
        $orderProduct=OrderProduct::whereIn('order_id',$orderIds)->pluck('product_id')->toArray();
        $checkRateRevivew=ProductReview::where('user_id',$user->id)->pluck('product_id')->toArray();
        return view('userBoard.orders',compact('user','orders','checkRateRevivew'));
    }

    public function trackOrder($id){
        $user= Auth::user();
        $order = Order::where('id',$id)->where('user_id',$user->id)->first();
        if($order){
            $orderStatus=OrderStatus::where('order_id',$order->id)->get();
            $status=OrderStatus::where('order_id',$order->id)->pluck('status')->toArray();
            $checkRateRevivew=ProductReview::where('user_id',$user->id)->pluck('product_id')->toArray();
            return view('userBoard.trackOrder',compact('orderStatus','status','user','order','checkRateRevivew'));
        }else{
            abort('404');
        }

    }

    ////// FUNCTION ADD TO CART//////////
    public function addToCart(){
        $attributeValuesIds=$_POST['attributeValuesIds'];
        $optionsIds=$_POST['optionsIds'];
        $productId=$_POST['productId'];
        $colorId=$_POST['colorId'];
        $quantity=$_POST['quantity'];


        if($attributeValuesIds == 0){
            $attributeValuesIds = [];
        }

        if($optionsIds == 0){
            $optionsIds = [];
        }

        $product=Product::find($productId);
        if($quantity <= $product->stock){
            $quantity=$quantity;
        }else{
            $quantity=$product->stock;
        }

        if(Auth::check()){
            /////// CHECK USER CART /////////////////
            $userCart=Cart::where('user_id',Auth::user()->id)->first();
            if(!$userCart){
                /////create user cart///
                $cart= new Cart();
                $cart->user_id=Auth::user()->id;
                $cart->save();
            }
            $cart = Cart::where('user_id',Auth::user()->id)->first();

            $cartProduct=CartProduct::where('product_id',$productId)->where('user_id',Auth::user()->id)->orderBy('id','desc')->first();
            if(!$cartProduct){
                //////ADD CART PRODUCT ////////
                $add= new CartProduct();
                $add->cart_id=$cart->id;
                $add->user_id =Auth::user()->id ;
                $add->product_id=$productId;
                $add->color_id=$colorId;
                if($product->discount()){
                    $add->price=$product->price - $product->discount();
                    $add->price_before_disc=$product->price;
                }else{
                    $add->price=$product->price;
                    $add->price_before_disc=$product->price;
                }
                if($quantity <= $product->stock){
                    $add->quantity=$quantity;
                }else{
                    $add->quantity=$product->stock;
                }
                $add->save();

                ///////ADD CART PRODUCT OPTIONS/////
                foreach($optionsIds as $optionId){
                    $option=ProductOption::find($optionId);
                    $cartProOption=new CartProductOption();
                    $cartProOption->cart_id=$cart->id;
                    $cartProOption->cart_product_id=$add->id;
                    $cartProOption->option_id=$optionId;
                    $cartProOption->price=$option->price;
                    $cartProOption->save();
                }

                //////ADD CART PRODUCT ATTRIBUTE VALUES////////
                foreach($attributeValuesIds as $attributeValueId){
                    $cartProAttrValue=new CartProductAttributeValue();
                    $cartProAttrValue->cart_id=$cart->id;
                    $cartProAttrValue->cart_product_id=$add->id;
                    $cartProAttrValue->attribute_value_id=$attributeValueId;
                    $cartProAttrValue->save();
                }

                $status='add';

                /////// update cart info////
                $cart->products_price+=$add->price * $quantity;
                $cart->total_price+=$add->price * $quantity;
                $cart->coupon_discount = NULL;
                $cart->coupon_id = NULL;
                $cart->save();

                $cartCount = CartProduct::where('cart_id',$cart->id)->count();
                $cartProduct = $add;
                return response()->json(['cartCount'=>$cartCount, 'product'=>$product,
                    'html' => view('website.partials.cartProduct', compact('cartProduct','cart'))->render(),
                ]);

            }else{

                $cartProductOptionsIds=CartProductOption::where('cart_id',$cart->id)->where('cart_product_id',$cartProduct->id)->pluck('option_id')->toArray();
                $cartProductAttributeValuesIds=CartProductAttributeValue::where('cart_id',$cart->id)->where('cart_product_id',$cartProduct->id)->pluck('attribute_value_id')->toArray();

                $checkOptions=[];
                $checkAttributeValues=[];
                $checkOptions= array_diff($cartProductOptionsIds,$optionsIds);
                $checkAttributeValues= array_diff($cartProductAttributeValuesIds,$attributeValuesIds);

                if(count($checkAttributeValues) == 0 && $cartProduct->color_id == $colorId){

                    if($cartProduct->quantity + $quantity <= $product->stock){
                        $diffQty = $quantity;

                        $cartProduct->quantity += $quantity;
                        $cartProduct->save();

                        /////// update cart info////
                        $cart->products_price+=$cartProduct->price * $diffQty;
                        $cart->total_price+=$cartProduct->price * $diffQty;
                        $cart->coupon_discount = NULL;
                        $cart->coupon_id = NULL;
                        $cart->save();

                    }else{
                        $cartProduct->quantity+=$product->stock;
                        $cartProduct->save();

                        /////// update cart info////
                        $cart->products_price+=$cartProduct->price * $quantity;
                        $cart->total_price+=$cartProduct->price * $quantity;
                        $cart->coupon_discount = NULL;
                        $cart->coupon_id = NULL;
                        $cart->save();
                    }

                    $status='add_again';

                    $cartCount = CartProduct::where('cart_id',$cart->id)->count();
                    $cartProduct = $cartProduct;
                    return response()->json(['cartCount'=>$cartCount,
                        'html' => view('website.partials.cartProduct', compact('cartProduct','cart'))->render(),
                    ]);

                }else{

                    if(count($checkOptions) == 0){

                        if($cartProduct->quantity + $quantity <= $product->stock){
                            $diffQty =  $quantity;

                            $cartProduct->quantity +=  $quantity;
                            $cartProduct->save();

                            /////// update cart info////
                            $cart->products_price+=$cartProduct->price * $diffQty;
                            $cart->total_price+=$cartProduct->price * $diffQty;
                            $cart->coupon_discount = NULL;
                            $cart->coupon_id = NULL;
                            $cart->save();

                        }else{
                            $cartProduct->quantity+=$product->stock;
                            $cartProduct->save();

                            /////// update cart info////
                            $cart->products_price+=$cartProduct->price * $quantity;
                            $cart->total_price+=$cartProduct->price * $quantity;
                            $cart->coupon_discount = NULL;
                            $cart->coupon_id = NULL;
                            $cart->save();
                        }

                        $status='add_again';

                        $cartCount = CartProduct::where('cart_id',$cart->id)->count();
                        $cartProduct = $cartProduct;
                        return response()->json(['cartCount'=>$cartCount,'product'=>$product,
                            'html' => view('website.partials.cartProduct', compact('cartProduct','cart'))->render(),
                        ]);
                    }

                    //////ADD CART PRODUCT ////////
                    $add= new CartProduct();
                    $add->cart_id=$cart->id;
                    $add->user_id =Auth::user()->id ;
                    $add->product_id=$productId;
                    $add->color_id=$colorId;
                    if($product->discount()){
                        $add->price=$product->price - $product->discount();
                        $add->price_before_disc=$product->price;
                    }else{
                        $add->price=$product->price;
                        $add->price_before_disc=$product->price;
                    }


                    if($quantity <= $product->stock){
                        $add->quantity=$quantity;
                    }else{
                        $add->quantity=$product->stock;
                    }

                    $add->save();

                    ///////ADD CART PRODUCT OPTIONS/////
                    foreach($optionsIds as $optionId){
                        $option=ProductOption::find($optionId);

                        $cartProOption=new CartProductOption();
                        $cartProOption->cart_id=$cart->id;
                        $cartProOption->cart_product_id=$add->id;
                        $cartProOption->option_id=$optionId;
                        $cartProOption->price=$option->price;
                        $cartProOption->save();
                    }

                    //////ADD CART PRODUCT ATTRIBUTE VALUES////////
                    foreach($attributeValuesIds as $attributeValueId){
                        $cartProAttrValue=new CartProductAttributeValue();
                        $cartProAttrValue->cart_id=$cart->id;
                        $cartProAttrValue->cart_product_id=$add->id;
                        $cartProAttrValue->attribute_value_id=$attributeValueId;
                        $cartProAttrValue->save();
                    }
                    $status='add';

                    //////// update cart info////
                    $cart->products_price+=$add->price * $quantity;
                    $cart->total_price+=$add->price * $quantity;
                    $cart->coupon_discount = NULL;
                    $cart->coupon_id = NULL;
                    $cart->save();

                    $cartCount = CartProduct::where('cart_id',$cart->id)->count();
                    $cartProduct = $add;
                    return response()->json(['cartCount'=>$cartCount, 'product'=>$product,
                        'html' => view('website.partials.cartProduct', compact('cartProduct','cart'))->render(),
                    ]);
                }
            }
        }else{
            if(!Session::has('session_id')){
                Session::put('session_id',mt_rand());
            }

            $guestCart=GuestCart::where('session_id',Session::get('session_id'))->first();
            if(!$guestCart){
                /////create user cart///
                $cart= new GuestCart();
                $cart->session_id= Session::get('session_id');
                $cart->save();
            }
            $cart = GuestCart::where('session_id',Session::get('session_id'))->first();

            $cartProduct=GuestCartProduct::where('product_id',$productId)->where('guest_cart_id',$cart->id)->orderBy('id','desc')->first();

            if(!$cartProduct){
                //////ADD CART PRODUCT ////////
                $add= new GuestCartProduct();
                $add->guest_cart_id=$cart->id;
                $add->session_id =Session::get('session_id') ;
                $add->product_id=$productId;
                $add->color_id=$colorId;
                if($product->discount()){
                    $add->price=$product->price - $product->discount();
                    $add->price_before_disc=$product->price;
                }else{
                    $add->price=$product->price;
                    $add->price_before_disc=$product->price;
                }

                if($quantity <= $product->stock){
                    $add->quantity=$quantity;
                }else{
                    $add->quantity=$product->stock;
                }
                $add->save();

                ///////ADD CART PRODUCT OPTIONS/////
                foreach($optionsIds as $optionId){
                    $option=GuestCartProductOption::find($optionId);

                    $cartProOption=new GuestCartProductOption();
                    $cartProOption->guest_cart_id=$cart->id;
                    $cartProOption->cart_product_id=$add->id;
                    $cartProOption->option_id=$optionId;
                    $cartProOption->price=$option->price;
                    $cartProOption->save();
                }

                //////ADD CART PRODUCT ATTRIBUTE VALUES////////
                foreach($attributeValuesIds as $attributeValueId){
                    $cartProAttrValue=new GuestCartProductAttribute();
                    $cartProAttrValue->guest_cart_id=$cart->id;
                    $cartProAttrValue->cart_product_id=$add->id;
                    $cartProAttrValue->attribute_value_id=$attributeValueId;
                    $cartProAttrValue->save();
                }

                $status='add';

                /////// update cart info////
                $cart->products_price+=$add->price * $quantity;
                $cart->total_price+=$add->price * $quantity;
                $cart->coupon_discount = NULL;
                $cart->coupon_id = NULL;
                $cart->save();

                $cartCount = GuestCartProduct::where('guest_cart_id',$cart->id)->count();
                $cartProduct = $add;
                return response()->json(['cartCount'=>$cartCount,'product'=>$product,
                    'html' => view('website.partials.cartProduct', compact('cartProduct','cart'))->render(),
                ]);

            }else{

                $cartProductOptionsIds=GuestCartProductOption::where('guest_cart_id',$cart->id)->where('guest_cart_product_id',$cartProduct->id)->pluck('option_id')->toArray();
                $cartProductAttributeValuesIds=GuestCartProductAttribute::where('guest_cart_id',$cart->id)->where('guest_cart_product_id',$cartProduct->id)->pluck('attribute_value_id')->toArray();

                $checkOptions=[];
                $checkAttributeValues=[];
                $checkOptions= array_diff($cartProductOptionsIds,$optionsIds);
                $checkAttributeValues= array_diff($cartProductAttributeValuesIds,$attributeValuesIds);

                if(count($checkAttributeValues) == 0 && $cartProduct->color_id == $colorId){

                    if($cartProduct->quantity + $quantity > 5){
                        $diffQty = 5 - $cartProduct->quantity;

                        $cartProduct->quantity = 5;
                        $cartProduct->save();

                        /////// update cart info////
                        $cart->products_price+=$cartProduct->price * $diffQty;
                        $cart->total_price+=$cartProduct->price * $diffQty;
                        $cart->coupon_discount = NULL;
                        $cart->coupon_id = NULL;
                        $cart->save();

                    }else{
                        $cartProduct->quantity+=$quantity;
                        $cartProduct->save();

                        /////// update cart info////
                        $cart->products_price+=$cartProduct->price * $quantity;
                        $cart->total_price+=$cartProduct->price * $quantity;
                        $cart->coupon_discount = NULL;
                        $cart->coupon_id = NULL;
                        $cart->save();
                    }

                    $status='add_again';

                    $cartCount = GuestCartProduct::where('guest_cart_id',$cart->id)->count();
                    $cartProduct = $cartProduct;
                    return response()->json(['cartCount'=>$cartCount,'product'=>$product,
                        'html' => view('website.partials.cartProduct', compact('cartProduct','cart'))->render(),
                    ]);

                }else{

                    if(count($checkOptions) == 0){

                        if($cartProduct->quantity + $quantity > 5){
                            $diffQty = 5 - $cartProduct->quantity;

                            $cartProduct->quantity = 5;
                            $cartProduct->save();

                            /////// update cart info////
                            $cart->products_price+=$cartProduct->price * $diffQty;
                            $cart->total_price+=$cartProduct->price * $diffQty;
                            $cart->coupon_discount = NULL;
                            $cart->coupon_id = NULL;
                            $cart->save();

                        }else{
                            $cartProduct->quantity+=$quantity;
                            $cartProduct->save();

                            /////// update cart info////
                            $cart->products_price+=$cartProduct->price * $quantity;
                            $cart->total_price+=$cartProduct->price * $quantity;
                            $cart->coupon_discount = NULL;
                            $cart->coupon_id = NULL;
                            $cart->save();
                        }

                        $status='add_again';

                        $cartCount = GuestCartProduct::where('guest_cart_id',$cart->id)->count();
                        $cartProduct = $cartProduct;
                        return response()->json(['cartCount'=>$cartCount,
                            'html' => view('website.partials.cartProduct', compact('cartProduct','cart'))->render(),
                        ]);
                    }

                    //////ADD CART PRODUCT ////////
                    $add= new GuestCartProduct();
                    $add->cart_id=$cart->id;
                    $add->session_id =Session::get('session_id') ;
                    $add->product_id=$productId;
                    $add->color_id=$colorId;
                    if($product->discount()){
                        $add->price=$product->price - $product->discount();
                        $add->price_before_disc=$product->price;
                    }else{
                        $add->price=$product->price;
                        $add->price_before_disc=$product->price;
                    }

                    $add->quantity=$quantity;
                    $add->save();

                    ///////ADD CART PRODUCT OPTIONS/////
                    foreach($optionsIds as $optionId){
                        $option=GuestCartProductOption::find($optionId);

                        $cartProOption=new GuestCartProductOption();
                        $cartProOption->guest_cart_id=$cart->id;
                        $cartProOption->cart_product_id=$add->id;
                        $cartProOption->option_id=$optionId;
                        $cartProOption->price=$option->price;
                        $cartProOption->save();
                    }

                    //////ADD CART PRODUCT ATTRIBUTE VALUES////////
                    foreach($attributeValuesIds as $attributeValueId){
                        $cartProAttrValue=new GuestCartProductAttribute();
                        $cartProAttrValue->guest_cart_id=$cart->id;
                        $cartProAttrValue->cart_product_id=$add->id;
                        $cartProAttrValue->attribute_value_id=$attributeValueId;
                        $cartProAttrValue->save();
                    }
                    $status='add';

                    //////// update cart info////
                    $cart->products_price+=$add->price * $quantity;
                    $cart->total_price+=$add->price * $quantity;
                    $cart->coupon_discount = NULL;
                    $cart->coupon_id = NULL;
                    $cart->save();

                    $cartCount = CartProduct::where('guest_cart_id',$cart->id)->count();
                    $cartProduct = $add;
                    return response()->json(['cartCount'=>$cartCount,'product'=>$product,
                        'html' => view('website.partials.cartProduct', compact('cartProduct','cart'))->render(),
                    ]);
                }
            }

        }
    }

    public function cardAddToCart(){
        $productId=$_POST['productId'];

        $product=Product::find($productId);
        $productAttributeIds= ProductAttribute::where('product_id',$productId)->distinct('attribute_id')->pluck('attribute_id')->toArray();
        $attributeValuesIds = [];
        $color = ProductColor::where('product_id',$productId)->first();
        if($color){
            $colorId = $color->id;
        }else{
            $colorId =1;
        }

        foreach($productAttributeIds as $productAttributeId){
            $valueId = AttributeValue::where('attribute_id',$productAttributeId)->first()->id;
            array_push($attributeValuesIds,$valueId);
        }

        if(Auth::check()){
            /////// CHECK USER CART /////////////////
            $userCart=Cart::where('user_id',Auth::user()->id)->first();
            if(!$userCart){
                /////create user cart///
                $cart= new Cart();
                $cart->user_id=Auth::user()->id;
                $cart->save();
            }
            $cart = Cart::where('user_id',Auth::user()->id)->first();

            $cartProduct=CartProduct::where('product_id',$productId)->where('user_id',Auth::user()->id)->orderBy('id','desc')->first();

            if(!$cartProduct){
                //////ADD CART PRODUCT ////////
                $add= new CartProduct();
                $add->cart_id=$cart->id;
                $add->user_id =Auth::user()->id ;
                $add->product_id=$productId;
                $add->color_id=$colorId;
                if($product->discount()){
                    $add->price=$product->price - $product->discount();
                    $add->price_before_disc=$product->price;
                }else{
                    $add->price=$product->price;
                    $add->price_before_disc=$product->price;
                }
                $add->quantity=1;
                $add->save();

                //////ADD CART PRODUCT ATTRIBUTE VALUES////////
                foreach($attributeValuesIds as $attributeValueId){
                    $cartProAttrValue=new CartProductAttributeValue();
                    $cartProAttrValue->cart_id=$cart->id;
                    $cartProAttrValue->cart_product_id=$add->id;
                    $cartProAttrValue->attribute_value_id=$attributeValueId;
                    $cartProAttrValue->save();
                }

                /////// update cart info////
                $cart->products_price+=$add->price;
                $cart->total_price+=$add->price;
                $cart->coupon_discount = NULL;
                $cart->coupon_id = NULL;
                $cart->save();

                $status='add';

                $cartCount = CartProduct::where('cart_id',$cart->id)->count();
                $cartProduct = $add;
                return response()->json(['cartCount'=>$cartCount,'product'=>$product,
                    'html' => view('website.partials.cartProduct', compact('cartProduct','cart'))->render(),
                ]);
            }else{
                if($cartProduct->quantity + 1 <= $product->stock){
                    $cartProduct->quantity+=1;
                    $cartProduct->save();

                    /////// update cart info////
                    $cart->products_price+=$cartProduct->price ;
                    $cart->total_price+=$cartProduct->price ;
                    $cart->coupon_discount = NULL;
                    $cart->coupon_id = NULL;
                    $cart->save();
                }

                $cartCount = CartProduct::where('cart_id',$cart->id)->count();
                $cartProduct = $cartProduct;
                return response()->json(['cartCount'=>$cartCount,'product'=>$product,
                    'html' => view('website.partials.cartProduct', compact('cartProduct','cart'))->render(),
                ]);
            }
        }else{

            if(!Session::has('session_id')){
                Session::put('session_id',mt_rand());
            }

            $guestCart=GuestCart::where('session_id',Session::get('session_id'))->first();
            if(!$guestCart){
                /////create user cart///
                $cart= new GuestCart();
                $cart->session_id= Session::get('session_id');
                $cart->save();
            }
            $cart = GuestCart::where('session_id',Session::get('session_id'))->first();

            $cartProduct=GuestCartProduct::where('product_id',$productId)->where('guest_cart_id',$cart->id)->orderBy('id','desc')->first();

            if(!$cartProduct){
                //////ADD CART PRODUCT ////////
                $add= new GuestCartProduct();
                $add->guest_cart_id=$cart->id;
                $add->session_id =Session::get('session_id') ;
                $add->product_id=$productId;
                $add->color_id=$colorId;
                if($product->discount()){
                    $add->price=$product->price - $product->discount();
                    $add->price_before_disc=$product->price;
                }else{
                    $add->price=$product->price;
                    $add->price_before_disc=$product->price;
                }

                $add->quantity=1;
                $add->save();

                //////ADD CART PRODUCT ATTRIBUTE VALUES////////
                foreach($attributeValuesIds as $attributeValueId){
                    $cartProAttrValue=new GuestCartProductAttribute();
                    $cartProAttrValue->guest_cart_id=$cart->id;
                    $cartProAttrValue->guest_cart_product_id=$add->id;
                    $cartProAttrValue->attribute_value_id=$attributeValueId;
                    $cartProAttrValue->save();
                }

                /////// update cart info////
                $cart->products_price+=$add->price;
                $cart->total_price+=$add->price;
                $cart->coupon_discount = NULL;
                $cart->coupon_id = NULL;
                $cart->save();


                $status='add';

                $cartCount = GuestCartProduct::where('guest_cart_id',$cart->id)->count();
                $cartProduct = $add;
                return response()->json(['cartCount'=>$cartCount,'product'=>$product,
                    'html' => view('website.partials.cartProduct', compact('cartProduct','cart'))->render(),
                ]);
            }else{
                if($cartProduct->quantity + 1 <= $product->stock){
                    $cartProduct->quantity+=1;
                    $cartProduct->save();

                    /////// update cart info////
                    $cart->products_price+=$cartProduct->price;
                    $cart->total_price+=$cartProduct->price;
                    $cart->coupon_discount = NULL;
                    $cart->coupon_id = NULL;
                    $cart->save();
                }

                $cartCount = GuestCartProduct::where('guest_cart_id',$cart->id)->count();
                $cartProduct = $cartProduct;
                return response()->json(['cartCount'=>$cartCount,'product'=>$product,
                    'html' => view('website.partials.cartProduct', compact('cartProduct','cart'))->render(),
                ]);
            }
        }
    }

    ////////////////////FUNCTION RETURNSHOPPING CART////////////////
    public function getShoppingCart(){
        if(Auth::check()){
            /////// CHECK USER CART /////////////////
            $user = Auth::user();
            $userCart=Cart::where('user_id',Auth::user()->id)->first();
            if(!$userCart){
                /////create user cart///
                $cart= new Cart();
                $cart->user_id=Auth::user()->id;
                $cart->save();
            }
            $cart = Cart::where('user_id',Auth::user()->id)->first();
            $cartProducts=CartProduct::where('cart_id',$cart->id)->get();

            if(count($cartProducts) == 0){

                return view('userBoard.emptyCart');
            }else{
                foreach($cartProducts as $cartProduct){
                    $product=Product::find($cartProduct->product_id);
                    $productDiscount=ProductDiscount::where('product_id',$cartProduct->product_id)->whereRaw('(now() between start_date and end_date)')->first();

                    /////// CHECK DISCOUNT IS AVAILABLE OR NOT////////
                    if(!$productDiscount){
                        $cartProduct->price=$product->price;
                        $cartProduct->price_before_disc=$product->price;
                        $cartProduct->save();
                    }
                    ///////CHECK PRODUCT STOCK AVAILABLE OR NOT////////
                    if($product->stock == 0){
                        $cartProduct->delete();
                    }

                    ///check stock for product changed or not//
                    if($cartProduct->quantity > $product->stock){
                        $cartProduct->quantity=$product->stock;
                        $cartProduct->save();
                    }
                }

                ///////// CHeck coupon expired or not //////////
                if($cart->coupon_id != NULL){
                    $coupon=Coupon::find($userCart->coupon_id);
                    if(date("Y-m-d") > $coupon->expire_date){
                        $cart->coupon_id=NULL;
                        $cart->coupon_discount=NULL;
                        $cart->save();
                    }
                }

                ////////// get Total price //////////
                $cartProductsPrice= CartProduct::where('cart_id',$cart->id)->sum(DB::raw('price * quantity'));
                $cartProductOptionsPrice = CartProductOption::where('cart_id',$cart->id)->sum('price');


                $productPrices=[];
                $cartProductOptionsPrice=[];

                $cartProds= CartProduct::where('cart_id',$cart->id)->select(DB::raw('price * quantity as price'),'id','quantity')->get();
                foreach($cartProds as $cartProduct){
                    $cartProductOptionsPrice= CartProductOption::where('cart_product_id',$cartProduct->id)->sum('price');
                    array_push($productPrices,$cartProduct->price + ($cartProductOptionsPrice * $cartProduct->quantity));
                }

                $productsPrice=array_sum($productPrices);
                $couponDiscount = $cart->coupon_discount;
                $totalPrice = $productsPrice - $couponDiscount;


                /////// upate cart details ////////
                $cart->products_price = $productsPrice;
                $cart->coupon_discount = $couponDiscount;
                $cart->total_price = $productsPrice - $couponDiscount;
                $cart->save();

                return view('userBoard.shoppingCart',compact('cartProducts','productsPrice','cart','totalPrice','couponDiscount','user'));
            }
        }else{

            if(!Session::has('session_id')){
                Session::put('session_id',mt_rand());
            }

            $guestCart=GuestCart::where('session_id',Session::get('session_id'))->first();
            if(!$guestCart){
                /////create user cart///
                $cart= new GuestCart();
                $cart->session_id= Session::get('session_id');
                $cart->save();
            }

            $cart = GuestCart::where('session_id',Session::get('session_id'))->first();
            $cartProducts=GuestCartProduct::where('guest_cart_id',$cart->id)->get();

            if(count($cartProducts) == 0){
                return view('userBoard.emptyCart');
            }else{
                foreach($cartProducts as $cartProduct){
                    $product=Product::find($cartProduct->product_id);
                    $productDiscount=ProductDiscount::where('product_id',$cartProduct->product_id)->whereRaw('(now() between start_date and end_date)')->first();

                    /////// CHECK DISCOUNT IS AVAILABLE OR NOT////////
                    if(!$productDiscount){
                        $cartProduct->price=$product->price;
                        $cartProduct->price_before_disc=$product->price;
                        $cartProduct->save();
                    }
                    ///////CHECK PRODUCT STOCK AVAILABLE OR NOT////////
                    if($product->stock == 0){
                        $cartProduct->delete();
                    }
                    ///check stock for product changed or not//
                    if($cartProduct->quantity > $product->stock){
                        $cartProduct->quantity=$product->stock;
                        $cartProduct->save();
                    }

                }

                ///////// CHeck coupon expired or not //////////
                if($cart->coupon_id != NULL){
                    $coupon=Coupon::find($userCart->coupon_id);
                    if(date("Y-m-d") > $coupon->expire_date){
                        $cart->coupon_id=NULL;
                        $cart->coupon_discount=NULL;
                        $cart->save();
                    }
                }

                ////////// get Total price //////////
                $cartProductsPrice= GuestCartProduct::where('guest_cart_id',$cart->id)->sum(DB::raw('price * quantity'));
                $cartProductOptionsPrice = GuestCartProductOption::where('guest_cart_id',$cart->id)->sum('price');
                $productPrices=[];
                $cartProductOptionsPrice=[];

                $cartProds= GuestCartProduct::where('guest_cart_id',$cart->id)->select(DB::raw('price * quantity as price'),'id','quantity')->get();
                foreach($cartProds as $cartProduct){
                    $cartProductOptionsPrice= GuestCartProductOption::where('guest_cart_product_id',$cartProduct->id)->sum('price');
                    array_push($productPrices,$cartProduct->price + ($cartProductOptionsPrice * $cartProduct->quantity));
                }
                $productsPrice=array_sum($productPrices);

                $couponDiscount = $cart->coupon_discount;
                $totalPrice = $productsPrice - $couponDiscount;

                /////// upate cart details ////////
                $cart->products_price = $productsPrice;
                $cart->coupon_discount = $couponDiscount;
                $cart->total_price = $productsPrice - $couponDiscount;
                $cart->save();

                return view('userBoard.shoppingCart',compact('cartProducts','productsPrice','cart','totalPrice','couponDiscount'));
            }

        }
    }

    /////////remove product from cart /////
    public function removeCartProduct(Request $request){
        if(Auth::check()){
            $cartProduct=CartProduct::find($request->CartProductId);

            //////// delete coupon discount if exist/////
            $cart=Cart::find($cartProduct->cart_id);
            $cart->coupon_id=NULL;
            $cart->coupon_discount=NULL;
            $cart->products_price -= $cartProduct->price * $cartProduct->quantity;
            $cart->total_price -= $cartProduct->price * $cartProduct->quantity;
            $cart->save();

            $cartProduct->delete();
            $cartProductOptions=CartProductOption::where('cart_id',$cartProduct->cart_id)->where('cart_product_id',$request->CartProductId)->delete();
            $cartProductOptions=CartProductAttributeValue::where('cart_id',$cartProduct->cart_id)->where('cart_product_id',$request->CartProductId)->delete();
        }else{
            $cartProduct=GuestCartProduct::find($request->CartProductId);

            //////// delete coupon discount if exist/////
            $cart=GuestCart::find($cartProduct->guest_cart_id);
            $cart->coupon_id=NULL;
            $cart->coupon_discount=NULL;
            $cart->products_price -= $cartProduct->price * $cartProduct->quantity;
            $cart->total_price -= $cartProduct->price * $cartProduct->quantity;
            $cart->save();

            $cartProduct->delete();
            $cartProductOptions=GuestCartProductOption::where('guest_cart_id',$cartProduct->guest_cart_id)->where('guest_cart_product_id',$request->CartProductId)->delete();
            $cartProductOptions=GuestCartProductAttribute::where('guest_cart_id',$cartProduct->guest_cart_id)->where('guest_cart_product_id',$request->CartProductId)->delete();

        }
        return  back()->with('success',trans('home.product_removed_from_cart'));
    }

    /////////////// function changeCartProductCount//////////////////////////
    public function changeCartProductQuantity(){

        $quantity=$_POST['quantity'];
        $cartProductId=$_POST['cartProductId'];
        $cartProduct=CartProduct::find($cartProductId);
        $product = Product::where('id',$cartProduct->product_id)->first();
        if($quantity <= $product->stock){
            $quantity=$quantity;
        }else{
            $quantity=$product->stock;
        }
        if(Auth::check()){
            $cartProduct=CartProduct::find($cartProductId);
            $cartProduct->quantity=$quantity;
            $cartProduct->save();
            $total_price = CartProduct::where('cart_id', $cartProduct->cart_id)
                            ->get()
                            ->map(function ($item) {
                                return $item->price * $item->quantity;
                            })
                            ->sum();


            /////// update cart info////
            $cart=Cart::find($cartProduct->cart_id);
            $cart->coupon_discount = NULL;
            $cart->coupon_id = NULL;
            $cart->products_price = $total_price;
            $cart->total_price = $total_price;
            $cart->save();
        }else{
            $cartProduct=GuestCartProduct::find($cartProductId);
            $cartProduct->quantity=$quantity;
            $cartProduct->save();
            $total_price = GuestCartProduct::where('cart_id', $cartProduct->cart_id)
                            ->get()
                            ->map(function ($item) {
                                return $item->price * $item->quantity;
                            })
                            ->sum();

            /////// update cart info////
            $cart=GuestCart::find($cartProduct->guest_cart_id);
            $cart->coupon_id=NULL;
            $cart->products_price = $total_price;
            $cart->total_price = $total_price;
            $cart->coupon_discount=NULL;
            $cart->save();
        }
    }

    /////////// FUNCTION RETURN checkOut VIEW /////
    public function oldcheckOut(){
        if(auth()->check()){
            return redirect('/');
        }
        $user = Auth::user();
        $cart = Cart::where('user_id',$user->id)->first();
        $cartProducts = CartProduct::where('cart_id',$cart->id)->get();
        $userAddresses = Address::where('user_id',$user->id)->get();
        if(count($cartProducts)>0){

            foreach($cartProducts as $cartProduct){
                ///////CHECK PRODUCT STOCK AVAILABLE OR NOT////////
                $product=Product::find($cartProduct->product_id);
                if($product->stock == 0){
                    $cartProduct->delete();
                }
                ///check stock for product changed or not//
                if($cartProduct->quantity > $product->stock){
                    $cartProduct->quantity=$product->stock;

                }
            }

            if(count($userAddresses) > 0){
                $primaryAddress=Address::where('is_primary',1)->where('user_id',$user->id)->first();
                if($primaryAddress->area_id==null || $primaryAddress->region_id==null){
                    session()->put('return-to-checkout','ok');
                    return redirect('user/shipping-addresses')->with('error','PLease select your region and area to your shiping address');
                }
                $area=Area::where('id',$primaryAddress->area_id)->first();
                $region=Region::where('id',$primaryAddress->region_id)->first();
                $paymentMethods=PaymentMethod::where('status',1)->get();
                $shippingMethods=ShippingMethod::where('status',1)->get();
                $cartproductShipping=DB::table('cart_products')
                                        ->leftJoin('products', 'products.id', '=', 'cart_products.product_id')
                                        ->select('products.shipping_fees')
                                        ->where('cart_products.user_id',Auth::user()->id)
                                        ->orderBy('products.shipping_fees','DESC')->first();

                if(!$cartproductShipping){
                    return redirect('shopping-cart');
                }

                $shippingFees=0;
                if($region->name_en=="Alexandria" || $region->name_en=="Cairo"){
                    $shippingFees=$cartproductShipping->shipping_fees;

                }else{
                    $shippingFees = $this->claculateShipping($region->name_en,$cart->total_price);
                }

                if($shippingMethods->first()->value_type == 'value'){
                    $shippingMethodFees = $shippingMethods->first()->value;
                }else{
                    $shippingMethodFees = ($shippingFees * $shippingMethods->first()->value )/100;
                }

                if($paymentMethods->first()->value_type == 'value'){
                    $paymentMethodFees = $paymentMethods->first()->value;
                }else{
                    $paymentMethodFees = ($cart->total_price * $paymentMethods->first()->value )/100;
                }

                return view('userBoard.checkOut',compact('primaryAddress','userAddresses','cart','cartProducts','paymentMethods','shippingMethods','shippingFees','paymentMethodFees','shippingMethodFees'));
            }else{
                session()->put('return-to-checkout','ok');
                return redirect('user/add/shipping-address');
            }
        }else{
            return redirect('/');
        }
    }

    public function checkOut(){
        if(!auth()->check()&&GuestCartProduct::where('session_id',Session::get('session_id') )->first()){
            return redirect('login');
        }elseif(!auth()->check()){
            return redirect('/');
        }
        $user = Auth::user();
        $cart = Cart::where('user_id',$user->id)->first();
        $cartProducts = CartProduct::where('user_id',$user->id)->get();
        $userAddresses = Address::where('user_id',$user->id)->get();
        if(count($cartProducts)>0){

            foreach($cartProducts as $cartProduct){
                ///////CHECK PRODUCT STOCK AVAILABLE OR NOT////////
                $product=Stock::find($cartProduct->group_id);
                if($product->stock == 0){
                    $cartProduct->delete();
                }
                ///check stock for product changed or not//
                if($cartProduct->quantity > $product->stock){
                    $cartProduct->quantity=$product->stock;

                }
            }

            if(count($userAddresses) > 0){
                $primaryAddress=Address::where('is_primary',1)->where('user_id',$user->id)->first();
                if($primaryAddress->area_id==null || $primaryAddress->region_id==null){
                    session()->put('return-to-checkout','ok');
                    return redirect('user/shipping-addresses')->with('error','PLease select your region and area to your shiping address');
                }
                $area=Area::where('id',$primaryAddress->area_id)->first();
                $region=Region::where('id',$primaryAddress->region_id)->first();
                $paymentMethods=PaymentMethod::where('status',1)->get();
                $shippingMethods=ShippingMethod::where('status',1)->get();
                $cartproductShipping=DB::table('cart_products')
                                        ->leftJoin('stock', 'stock.id', '=', 'cart_products.group_id')
                                        ->leftJoin('products', 'products.id', '=', 'stock.product_id')
                                        ->select('products.shipping_fees')
                                        ->where('cart_products.user_id',Auth::user()->id)
                                        ->orderBy('products.shipping_fees','DESC')->first();

                if(!$cartproductShipping){
                    return redirect('shopping-cart');
                }
                $shippingFees=0;
                if($region->name_en=="Alexandria" || $region->name_en=="Cairo"){
                    $shippingFees=$cartproductShipping->shipping_fees;

                }else{
                    $shippingFees = $this->claculateShipping($region->name_en,$cart->total_price);
                }

                if($shippingMethods->first()->value_type == 'value'){
                    $shippingMethodFees = $shippingMethods->first()->value;
                }else{
                    $shippingMethodFees = ($shippingFees * $shippingMethods->first()->value )/100;
                }

                if($paymentMethods->first()->value_type == 'value'){
                    $paymentMethodFees = $paymentMethods->first()->value;
                }else{
                    $paymentMethodFees = ($cartProducts->sum(function ($cartProduct) {  ;return $cartProduct->total_product ;})??0 * $paymentMethods->first()->value )/100;
                }

                return view('userBoard.checkOut',compact('primaryAddress','cart','userAddresses','cartProducts','paymentMethods','shippingMethods','shippingFees','paymentMethodFees','shippingMethodFees'));
            }else{
                session()->put('return-to-checkout','ok');
                return redirect('user/add/shipping-address');
            }
        }else{
            return redirect('/');
        }
    }

    
    //////// FUNCTION changeShippingMethod or paymentMethod////////
    public function changeMethod(){
        $paymentId=$_POST['paymentId'];
        $shippingId=$_POST['shippingId'];

        $setting = Setting::first();

        $user = auth()->user();
        $cart = Cart::where('user_id',$user->id)->first();
        $primaryAddress=Address::where('is_primary',1)->where('user_id',$user->id)->first();
        if($primaryAddress->area_id==null || $primaryAddress->region_id==null){
            session()->put('return-to-checkout','ok');
            return redirect('user/shipping-addresses')->with('error','PLease select your region and area to your shiping address');
        }
        $area=Area::where('id',$primaryAddress->area_id)->first();
        $region=Region::where('id',$primaryAddress->region_id)->first();
        $cart = Cart::where('user_id',$user->id)->first();
        $cartProducts = CartProduct::where('cart_id',$cart->id)->get();
        $paymentMethods=PaymentMethod::where('status',1)->get();
        $shippingMethods=ShippingMethod::where('status',1)->get();
        $cartproductShipping=DB::table('cart_products')
                                ->leftJoin('products', 'products.id', '=', 'cart_products.product_id')
                                ->select('products.shipping_fees')
                                ->where('cart_products.user_id',Auth::user()->id)
                                ->orderBy('products.shipping_fees','DESC')->first();
        $shippingFees=0;
        if($region->name_en=="Alexandria" || $region->name_en=="Cairo"){
            $shippingFees=$cartproductShipping->shipping_fees;

        }else{
            $shippingFees = $this->claculateShipping($region->name_en,$cart->total_price);
        }

        if(PaymentMethod::find($paymentId)->value_type == 'value'){
            $paymentMethodFees = PaymentMethod::find($paymentId)->value;
        }else{
            $paymentMethodFees = ($cart->total_price * PaymentMethod::find($paymentId)->value )/100;
        }

        if(ShippingMethod::find($shippingId)->value_type == 'value'){
            $shippingMethodFees = ShippingMethod::find($shippingId)->value;
        }else{
            $shippingMethodFees = ($cart->total_price * ShippingMethod::find($shippingId)->value )/100;
        }

        $totalPrice = $cart->products_price + $shippingFees + $shippingMethodFees + $paymentMethodFees + ($cart->products_price * $setting->tax ) /100- $cart->coupon_discount;
        $shippingTotal = $shippingFees + $shippingMethodFees;
        return response()->json(['paymentMethodFees'=>$paymentMethodFees,'shippingMethodFees'=>$shippingMethodFees,'totalPrice'=>$totalPrice,'shippingTotal'=>$shippingTotal]);
    }


    public function addProductReview(Request $request){
        $add=new ProductReview();
        $add->user_id=Auth::user()->id;
        $add->product_id=$request->product_id;
        $add->rate=$request->rate;
        $add->comment=$request->comment;
        $add->save();
        return back()->with('success',trans('home.rate and review added successfully'));
    }


    ////////////////////function return comapre Page view////////////////
    public function compareList(){
        $user=Auth::user();
        $comapreListProductsIds=ComapreList::where('user_id',$user->id)->pluck('product_id')->toArray();
        $comapreListProducts=Product::whereIn('id',$comapreListProductsIds)->get();
        if(count($comapreListProducts) > 0){
            return view('userBoard.comapreList',compact('user','comapreListProducts'));
        }else{
            return view('userBoard.emptyCompareList');
        }

    }

    //////////////// ajax function that add product to CompareList///////////
    public function addCompareList(){
        $productId=$_POST['productId'];

        $check=ComapreList::where('product_id',$productId)->where('user_id',Auth::user()->id)->first();
        if(! $check){
            $add= new ComapreList();
            $add->user_id =Auth::user()->id ;
            $add->product_id=$productId;
            $add->save();
            $status='add';
        }else{
            $check->delete();
            $status='delete';
        }
        return response()->json($status);
    }

    /////////////// function that remove CompareList////////////
    public function removeCompareList($id){
        $comapreList=ComapreList::where('user_id',Auth::user()->id)->where('product_id',$id)->delete();
        return back()->with('success',trans('home.product_removed_from_comapreList'));
    }

    public function cancelOrder(Request $request){
        $order = Order::find($request->orderId);
        $order->status = 'canceled';
        $order->save();
        $order_products = $order->products();
        foreach($order_products as $order_product){
            $product = Product::where('id',$order_product->product_id)->first();
            $product->increment('stock', $order_product->quantity);
            $product->save();
        }

        $orderStatus = new OrderStatus();
        $orderStatus ->order_id = $request->id;
        $orderStatus ->status = 'canceled';
        $orderStatus->save();
        return back()->with('success',trans('home.order canceled succesfully'));
    }


    ////// referesh user cart//////
    public function refreshCart(){
        if(Auth::check()){
            $cart = Cart::where('user_id',Auth::user()->id)->first();
            $cartCount = CartProduct::where('cart_id',$cart->id)->count();
            $cartProds= CartProduct::where('cart_id',$cart->id)->select(DB::raw('price as price'),'id','quantity','product_id')->get();

        }else{
            $cart = GuestCart::where('session_id',Session::get('session_id'))->first();
            $cartCount = GuestCartProduct::where('guest_cart_id',$cart->id)->count();
            $cartProds=GuestCartProduct::where('guest_cart_id',$cart->id)->select(DB::raw('price * quantity as price'),'id','quantity','product_id')->get();
        }

        return response()->json(['cartCount'=>$cartCount,
            'html' => view('website.partials.miniCart', compact('cartProds','cart'))->render(),
        ]);
    }

    /// refresh user wishlist ///////
    public function refreshWishlist(){
        if(Auth::check()){
            $wishCount =Wishlist::where('user_id',Auth::user()->id)->count();
        }else{
            $guestWishlist = Session::get('wishlist');
            $wishCount =count($guestWishlist);
        }
        return response()->json(['wishCount'=>$wishCount]);
    }

         /////////// FUNCTION RETURN Guest checkOut VIEW /////
      public function oldguest_checkOut(){
        if(Auth::check()){
            return redirect('/');
        }
        $cart = GuestCart::where('session_id',Session::get('session_id'))->first();
        if(!$cart){
             return redirect('/');
        }
        $cartProducts=GuestCartProduct::with('product','product.category')->where('guest_cart_id',$cart->id)->orderBy('id','desc')->get();
        if(count($cartProducts)==0){
            return redirect('/');
        }

        foreach($cartProducts as $cartProduct){
            ///////CHECK PRODUCT STOCK AVAILABLE OR NOT////////
            $product=Product::find($cartProduct->product_id);
            if($product->stock == 0){
                $cartProduct->delete();
            }
            ///check stock for product changed or not//
            if($cartProduct->quantity > $product->stock){
                $cartProduct->quantity=$product->stock;

            }
        }

        $shippingMethods=ShippingMethod::where('status',1)->get();

        $paymentMethods=PaymentMethod::where('status',1)->get();
        $cartproductShipping=DB::table('guest_cart_products')
                                ->leftJoin('products', 'products.id', '=', 'guest_cart_products.product_id')
                                ->select('products.shipping_fees')
                                ->where('guest_cart_products.session_id',Session::get('session_id'))
                                ->orderBy('products.shipping_fees','DESC')->first();
        $countries = Country::all();
        if($paymentMethods->first()->value_type == 'value'){
            $paymentMethodFees = $paymentMethods->first()->value;
        }else{
            $paymentMethodFees = ($cart->total_price * $paymentMethods->first()->value )/100;
        }
        $shippingFees = $cartproductShipping->shipping_fees;
        if(count($cartProducts)>0){
            return view('userBoard.guest_checkout',compact('shippingFees','cartProducts','cart','paymentMethodFees','shippingMethods','paymentMethods','countries'));
        }else{
            return redirect('/');
        }
    }

    public function guest_checkOut(){
        if(Auth::check()){
            return redirect('/');
        }
        // $cart = GuestCart::where('session_id',Session::get('session_id'))->first();
        // if(!$cart){
        //      return redirect('/');
        // }
        $cartProducts=GuestCartProduct::with('group')->where('session_id',Session::get('session_id'))->orderBy('id','desc')->get();
        if(count($cartProducts)==0){
            return redirect('/');
        }

        foreach($cartProducts as $cartProduct){
            ///////CHECK PRODUCT STOCK AVAILABLE OR NOT////////
            $product=$cartProduct->stock;
            if($product->stock == 0){
                $cartProduct->delete();
            }
            ///check stock for product changed or not//
            if($cartProduct->quantity > $product->stock){
                $cartProduct->quantity=$product->stock;
            }
        }

        $shippingMethods=ShippingMethod::where('status',1)->get();

        $paymentMethods=PaymentMethod::where('status',1)->get();
        $cartproductShipping=DB::table('guest_cart_products')
                                ->leftJoin('products', 'products.id', '=', 'guest_cart_products.product_id')
                                ->select('products.shipping_fees')
                                ->where('guest_cart_products.session_id',Session::get('session_id'))
                                ->orderBy('products.shipping_fees','DESC')->first();
        $countries = Country::all();
        if($paymentMethods->first()->value_type == 'value'){
            $paymentMethodFees = $paymentMethods->first()->value;
        }else{
            $paymentMethodFees = ($cart->total_price * $paymentMethods->first()->value )/100;
        }
        $shippingFees = $cartproductShipping->shipping_fees;
        if(count($cartProducts)>0){
            return view('userBoard.guest_checkout',compact('shippingFees','cartProducts','cart','paymentMethodFees','shippingMethods','paymentMethods','countries'));
        }else{
            return redirect('/');
        }
    }


   //////// FUNCTION Guest changeShippingMethod or paymentMethod////////
    public function guest_changeMethod(){
        $paymentId=$_POST['paymentId'];
        $shippingId=$_POST['shippingId'];
        $area_id=$_POST['area_id'];

        $setting = Setting::first();
        $cart = GuestCart::where('session_id',Session::get('session_id'))->first();
        $cartProducts=GuestCartProduct::where('guest_cart_id',$cart->id)->orderBy('id','desc')->get();
        $area = Area::find($area_id);
        $region = Region::find($area->region_id);

        $paymentMethods=PaymentMethod::where('status',1)->get();
        $shippingMethods=ShippingMethod::where('status',1)->get();
        $cartproductShipping=DB::table('guest_cart_products')
                                ->leftJoin('products', 'products.id', '=', 'guest_cart_products.product_id')
                                ->select('products.shipping_fees')
                                ->where('guest_cart_products.session_id',Session::get('session_id'))
                                ->orderBy('products.shipping_fees','DESC')->first();

        $shippingTotal=0;


        if($region->name_en=="Alexandria" || $region->name_en=="Cairo"){
            $shippingTotal=$cartproductShipping->shipping_fees;

        }else{
            $shippingTotal = $this->claculateShipping($region->name_en,$cart->total_price);
        }



        if(PaymentMethod::find($paymentId)->value_type == 'value'){
            $paymentMethodFees = PaymentMethod::find($paymentId)->value;
        }else{
            $paymentMethodFees = ($cart->total_price * PaymentMethod::find($paymentId)->value )/100;
        }

        if($setting->free_shipping_status==1 && $setting->free_shipping>0){
            if ($cart->total_price>=$setting->free_shipping){
                $shippingMethodFees=0;
            }
        }
        $totalPrice = $cart->products_price + $shippingTotal  + $paymentMethodFees + ($cart->products_price * $setting->tax ) /100- $cart->coupon_discount;
        return response()->json(['paymentMethodFees'=>$paymentMethodFees,'totalPrice'=>$totalPrice,'shippingTotal'=>$shippingTotal]);
    }


    public function claculateShipping($region,$total_price){

        $client = new Client();
        $apiKey = env('BOSTA_API_KEY');
        $response = $client->post('https://app.bosta.co/api/v2/users/login', [
        'headers' => [
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ],
        'json' => [
            "email"=> "drugstation7@gmail.com",
            "password"=> 'Zeyad.Taher123'
            ],
        ]);
        $token = json_decode($response->getBody(), true)['data']['token'];


        $client = new Client();
        $response = $client->get('https://app.bosta.co/api/v2/pricing/shipment/calculator', [
        'headers' => [
            'Authorization' => $token,
            'Content-Type' => 'application/json',
        ],
        'json' => [
            "cod"=>$total_price ,
            "dropOffCity"=> $region,
            "size"=> 'Light Bulky',
            "type"=> 'SEND',
            ],
        ]);
        $shippingFees = ceil(json_decode($response->getBody(), true)['data']['priceAfterVat']);
        return $shippingFees;
    }


}
