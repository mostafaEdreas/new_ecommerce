<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Country;
use App\Region;
use App\Area;
use App\Address;
use App\Category;
use App\ContactUs;
use App\HomeSlider;
use JWTAuth;
use File;
use Image;
use App\Product;
use App\Order;
use App\OrderProduct;
use App\OrderStatus;
use App\Page;
use App\Setting;
use App\OrderProductAttributeValue;
use App\IntroSlider;
use Mail;
use App\OfferSlider;
use App\PaymentMethod;
use App\ShippingMethod;
use App\Notification;
use App\ProductAttribute;

use App\Http\Resources\CountryResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\AreaResource;
use App\Http\Resources\AddressResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\PageResource;
use App\Http\Resources\SettingResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\IntroSliderResource;
use App\Http\Resources\HomeSliderResource;
use App\Http\Resources\OfferSliderResource;
use App\Http\Resources\HomeCategoryResource;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Resources\ShippingMethodResource;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    //////// function get all countries////////////
    public function getCountries(){
        try{
            $countries =CountryResource::collection(Country::where('status',1)->get());
            return response()->json(['countries'=>$countries,'message'=>trans('messages.list of all available countries'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    //////// function get all country region////////////
    public function getCountryRegions(Request $request){
        try{
            $regions =RegionResource::collection(Region::where('country_id',$request->country_id)->where('status',1)->get());
            return response()->json(['regions'=>$regions,'message'=>trans('messages.list of all available regions'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    //////// function get all region areas////////////
    public function getRegionAreas(Request $request){
        try{
            $areas =AreaResource::collection(Area::where('region_id',$request->region_id)->where('status',1)->get());
            return response()->json(['areas'=>$areas,'message'=>trans('messages.list of all available areas'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    /////////// function add Country ///////////////
    public function addCountry(Request $request)
    {
        try{
            $country = new Country();
            $country->name_en = $request->name_en;
            $country->name_ar = $request->name_ar;
            $country->status = $request->status;
            $country->save();
            $country = new CountryResource($country);
            return response()->json(['countryData'=>$country,'message'=>'country added successfully','statusCode'=>201]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }


    /////////// function add Region ///////////////
    public function addRegion(Request $request)
    {
        try{
            $region = new Region();
            $region->name_en = $request->name_en;
            $region->name_ar = $request->name_ar;
            $region->country_id = $request->country_id;
            $region->status = $request->status;
            $region->save();
            $region = new RegionResource($region);
            return response()->json(['regionData'=>$region,'message'=>'region added successfully','statusCode'=>201]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }
    /////////// function add Area ///////////////
    public function addArea(Request $request)
    {
        try{
            $area = new Area();
            $area->name_en = $request->name_en;
            $area->name_ar = $request->name_ar;
            $area->region_id = $request->region_id;
            $area->status = $request->status;
            $area->save();
            $area = new AreaResource($area);
            return response()->json(['areaData'=>$area,'message'=>'area added successfully','statusCode'=>201]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }


    //////// function return  user addresses/////////
    public function getAddresses(Request $request){
        try{
            $token = $request->bearerToken();
            if($token){
                $user = JWTAuth::toUser($token);
            }
            $addresses = AddressResource::collection(Address::where('user_id',$user->id)->get());
            return response()->json(['addresses'=>$addresses,'message'=>trans('messages.list of all available addresses'),'statusCode'=>404]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }
    /////////// function add user address////////////
    public function createAddress(Request $request){
        try{
            $token = $request->bearerToken();
            if($token){
                $user = JWTAuth::toUser($token);
            }

            /////////// check primary adress /////////////
            $checkPrimaryAddress = Address::where('user_id',$user->id)->where('is_primary',1)->first();
            if($checkPrimaryAddress){
                $checkPrimaryAddress->is_primary = 0;
                $checkPrimaryAddress->save();
            }

            ///////////// add new address//////////////////
            $address = new Address();
            $address->user_id = $user->id;
            $address->address_title = $request->address_title;
            $address->address = $request->address;
            $address->land_mark = $request->land_mark;
            $address->lat = $request->lat;
            $address->lng = $request->lng;
            $address->phone1 = $request->phone1;
            $address->phone2 = $request->phone2;
            $address->country_id = $request->country_id;
            $address->region_id = $request->region_id;
            $address->area_id = $request->area_id;
            $address->is_primary = $request->is_primary;
            $address->save();
            $address = new AddressResource($address);
            return response()->json(['addressData'=>$address,'message'=>trans('messages.address added successfully'),'statusCode'=>201]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    /////////// function  update user address////////////
    public function updateAddress(Request $request){
        try{
            $token = $request->bearerToken();
            if($token){
                $user = JWTAuth::toUser($token);
            }

            /////////// check primary adress /////////////
            $checkPrimaryAddress = Address::where('user_id',$user->id)->where('is_primary',1)->first();
            if($checkPrimaryAddress && $request->is_primary == 1){
                $checkPrimaryAddress->is_primary = 0;
                $checkPrimaryAddress->save();
            }

            ///////////// add new address//////////////////
            $address =Address::find($request->address_id);
            $address->user_id = $user->id;
            $address->address_title = $request->address_title;
            $address->address = $request->address;
            $address->land_mark = $request->land_mark;
            $address->lat = $request->lat;
            $address->lng = $request->lng;
            $address->phone1 = $request->phone1;
            $address->phone2 = $request->phone2;
            $address->country_id = $request->country_id;
            $address->region_id = $request->region_id;
            $address->area_id = $request->area_id;
            $address->is_primary = $request->is_primary;
            $address->save();
            $address = new AddressResource($address);
            return response()->json(['addressData'=>$address,'message'=>trans('messages.address updated successfully'),'statusCode'=>201]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    //////// function delete user address/////////
    public function deleteAddress(Request $request){
        try{
            $address = Address::find($request->address_id);
            if($address){
                $address->delete();
                return response()->json(['message'=>trans('messages.address deleted successfully'),'statusCode'=>200]);
            }else{
                return response()->json(['message'=>trans('messages.address id not found'),'statusCode'=>404]);
            }
            
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    //////// function make user primary address/////////
    public function makePrimaryAddress(Request $request){
        try{

            $token = $request->bearerToken();
            if($token){
                $user = JWTAuth::toUser($token);
            }
            $checkPrimaryAddress=Address::where('user_id',$user->id)->where('is_primary',1)->first();
            if($checkPrimaryAddress){
                $checkPrimaryAddress->is_primary = 0;
                $checkPrimaryAddress->save();
            }

            $address = Address::find($request->address_id);
            $address->is_primary = 1;
            $address->save();

            $address = new AddressResource($address);
            return response()->json(['address'=>$address,'message'=>trans('messages.address is now primary'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    ////////// function get all categories/////////////
    public function getCategories(){
        try{
            $categories =CategoryResource::collection(Category::where('parent_id',0)->where('status',1)->get());
            return response()->json(['categories'=>$categories,'message'=>trans('messages.list of all available categories'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    
    }

    ////////// function get all categories/////////////
    public function getSubCategories(Request $request,$id){
        try{
            $categories = Category::where('parent_id',$id)->where('status',1)->get();
            
            if(!$categories){
                return response()->json(['message'=>trans('messages.no sub categories available !!'),'statusCode'=>204]);
            }
            $categories=CategoryResource::collection($categories);
            return response()->json(['categories'=>$categories,'message'=>trans('messages.list of all available sub categories'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    
    }


    ////////// function return category Products////////
    public function getCategoryProducts(Request $request){
        try{
            $products = ProductResource::collection(Product::where('category_id',$request->category_id)->paginate(10));
            return response()->json(['products'=>$products,'message'=>trans('messages.list of all availbale category Products'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }


    ////////// function return category Products////////
    public function getProduct(Request $request){
        try{
            $product = new ProductResource(Product::find($request->product_id));
            return response()->json(['product'=>$product,'message'=>trans('messages.product data'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    //////////////// function place order///////////////
    public function placeOrder(Request $request){

        try{
            $token = $request->bearerToken();
            if($token){
                $user = JWTAuth::toUser($token);
            }

            $orderDetails = $request->all();

            $setting =Setting::first();
            
            $address = Address::where('user_id',$user->id)->where('user_id',$user->id)->first();
            $order = new Order();
            $order->address_id = $address->id;
            $order->user_id = $user->id;
            $order->payment_id = $request->payment_id;
            $order->shipping_id = $request->shipping_id;
            $order->products_price = $orderDetails['products_price'];
            $order->payment_fees =  0.00;
            $order->shipping_fees = 0.00;
            $order->tax_fees =  ( $orderDetails['products_price'] * $setting->tax ) / 100;
            $order->total_price = $order->products_price + $order->payment_fees + $order->shipping_fees + $order->tax_fees ;
            $order->status = 'pending';
            $order->save();

            /////////////////// save order products ///////////////////////
            foreach($orderDetails['orderProducts'] as $key=> $orderProduct){

                $orderProd = new OrderProduct();
                $orderProd->order_id = $order->id;
                $orderProd->product_id = $orderProduct['product_id'];
                $orderProd->quantity = $orderProduct['quantity'];
                $orderProd->price = $orderProduct['price'];
                $orderProd->note = $orderProduct['note'];
                $orderProd->save();
                
                //////// save order product attribute values//////
                if($orderProduct['attributeValues']){
                    foreach($orderProduct['attributeValues'] as $productAttValue){
                        $prodAttrValue = new OrderProductAttributeValue();
                        $prodAttrValue->order_product_id = $orderProd->id;
                        $prodAttrValue->value_id =  $productAttValue['value_id'];
                        $prodAttrValue->save();
                    }
                }
            }

            /////// save order status/////
            $orderStatus = new OrderStatus();
            $orderStatus->order_id = $order->id;
            $orderStatus->status = 'pending';
            $orderStatus->save();

            $orderDetails = new OrderResource($order);

            return response()->json(['orderDetails'=>$orderDetails,'message'=>trans('messages.order created successfully'),'statusCode'=>200]);
        }catch(\Exception $e){
            dd($e);
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    /////////// function return user orders/////
    public function orders(Request $request){
        try{

            $token = $request->bearerToken();
            if($token){
                $user = JWTAuth::toUser($token);
            }

            $orders = OrderResource::collection(Order::where('user_id',$user->id)->where('status',$request->order_status)->get());
            return response()->json(['orders'=>$orders,'message'=>trans('messages.list of all orders'),'statusCode'=>200]);
        }
        catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    ////////// function return order details/////////
    public function getOrderDeatils(Request $request){
        try{

            $token = $request->bearerToken();
            if($token){
                $user = JWTAuth::toUser($token);
            }

            $orderDetails = new OrderResource(Order::find($request->order_id));
            return response()->json(['orderDetails'=>$orderDetails,'message'=>trans('messages.order details'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    /////////// function return about application//////
    public function aboutApp(){
        try{
            $settings = new SettingResource(Setting::first());
            return response()->json(['settings'=>$settings,'message'=>trans('messages.application settings'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    /////////// function return pages//////
    public function pages(){
        try{
            $pages = PageResource::collection(Page::where('status',1)->get());
            return response()->json(['pages'=>$pages,'message'=>trans('messages.list of all available pages'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    /////////// function return page//////
    public function getPage(Request $request){
        try{
            $pageData = new PageResource (Page::find($request->page_id));
            return response()->json(['pageData'=>$pageData,'message'=>trans('messages.page data'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    /////// function return intro sliders/////////
    public function getIntrSliders(Request $request){
        try{
            $lang = $request->header('lang');
            $sliders = IntroSliderResource::collection(IntroSlider::where('lang',$lang)->where('status',1)->get());
            return response()->json(['sliders'=>$sliders,'message'=>trans('messages.list of all sliders'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }


    /////// function return home sliders/////////
    public function getHomeSliders(Request $request){
        try{
            $lang = $request->header('lang');
            $sliders = HomeSliderResource::collection(HomeSlider::where('lang',$lang)->where('status',1)->get());
            return response()->json(['sliders'=>$sliders,'message'=>trans('messages.list of all sliders'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    /////// function return offers sliders/////////
    public function getOfferSliders(Request $request){
        try{
            $lang = $request->header('lang');
            $sliders = OfferSliderResource::collection(OfferSlider::where('lang',$lang)->where('status',1)->get());
            return response()->json(['sliders'=>$sliders,'message'=>trans('messages.list of all sliders'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }


    //////// function return home categry Products///
    public function getHomeCategoriesProducts(){
        try{
            $homeCategories= HomeCategoryResource::collection(Category::where('home',1)->where('status',1)->get());
            return response()->json(['homeCategories'=>$homeCategories,'message'=>trans('messages.list of home categories and thier products'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }
    


    //////// function create contact us ////////
    public function contactUs(Request $request){
        try{
            $add = new ContactUs();
            $add->name= $request->name;
            $add->email= $request->email;
            $add->phone= $request->phone;
            $add->message= $request->message;
            $add->admin_seen= 0 ;
            $add->save();

            /////////// send email to admin///////
            // $data = ['contact'=>$add];
            // Mail::send('emails/contact-us', $data, function($msg) use ($add) {
            //     $msg->to($add->email, 'App Name')->subject('Contact Us');
            //     $msg->from(config('mail.from.address'),config('mail.from.name'));
            // });
            return response()->json(['message'=>trans('messages.your message sent'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    ////////////// function return product offers////////
    public function getProductOffers(){
        try{
            $productOffers= ProductResource::collection(Product::where('offer_price','!=',NULL)->where('status',1)->paginate(10));
            return response()->json(['productOffers'=>$productOffers,'message'=>trans('messages.product offers'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    //////////// function ceck cart products////////
    public function checkCartProducts(Request $request){
        try{
            $orderProductIds = $request->orderProducts;

            $notAvailableProductIds = [];

            foreach($orderProductIds as $id){
                if(! Product::where('id',$id)->where('status',1)->exists()){
                    array_push($notAvailableProductIds,$id);
                }
            }

            if($notAvailableProductIds){
                

                foreach($notAvailableProductIds as $id) {
                    $productIds[] = array(
                        'id' => $id,
                    );
                }
                
                $productIds =  json_encode(array('productIds' => $productIds));

                return response()->json(['notAvailableProductIds'=>$productIds,'message'=>trans('messages.some products not available now !'),'statusCode'=>404]);
            }else{
                return response()->json(['message'=>trans('messages.now you can complete your order'),'statusCode'=>200]);
            }
            
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    ////////// function return paymentmethods//////
    public function getPaymentMethods(Request $request){
        try{
            $paymentMethods = PaymentMethodResource::collection(PaymentMethod::where('status',1)->get());
            return response()->json(['paymentMethods'=>$paymentMethods,'message'=>trans('messages.list of all available payment methods'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    ////////// function return shippingmethods//////
    public function getShippingMethods(Request $request){
        try{
            $shippingMethods = ShippingMethodResource::collection(ShippingMethod::where('status',1)->get());
            return response()->json(['shippingMethods'=>$shippingMethods,'message'=>trans('messages.list of all available shipping methods'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    public function getNotifications(Request $request){

        try{
            $token = $request->bearerToken();
            if($token){
                $user = JWTAuth::toUser($token);
            }

            $notifications=NotificationResource::collection(Notification::where('user_id',$user->id)->orderBy('id','DESC')->get());
            return response()->json(['notifications'=>$notifications,'message'=>trans('messages.list of all available notifications'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    public function notificationSeen(Request $request){
    
        try{
            $notification= Notification::find($request->notification_id);
            $notification->seen=1;
            $notification->save();

            return response()->json(['message'=>trans('messages.notification seen'),'statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }

    }

    /////////////// function filter products with name or product attribute values//////
    public function FilterCategoryProducts(Request $request){
        try{    
            $products=Product::where('category_id',$request->category_id)->where('status',1)->get();

            if($request->name){
                $products = Product::where('name_en', 'like', '%' . $request->name . '%')->orwhere('name_ar', 'like', '%' . $request->name . '%')->where('status',1)->get();
            }
            
            if($request->valueIds){
                $productIds = ProductAttribute::whereIn('attribute_value_id',$request->valueIds)->pluck('product_id')->toArray();
                $products = $products->whereIn('id',$productIds);
            }
            
            $filterdProducts = ProductResource::collection($products);

            return response()->json(['filterdProducts'=>$filterdProducts,'message'=>trans('messages.filtered products'),'statusCode'=>200]);
        }catch(\Exception $e){
            dd($e);
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    





































































    /////////// function create Category////////////
    public function createCategory(Request $request){
        try{
            $category = new Category();
            $category->name_en = $request->name_en;
            $category->name_ar = $request->name_ar;
            $category->desc_en = $request->desc_en;
            $category->desc_ar = $request->desc_ar;
            
            if($request->parent_id !=0){
                $category->parent_id = $request->parent_id;
                $category=Category::find($request->parent_id);
                $category->has_sub =1;
                $category->save();
            }else{
                $category->parent_id = 0;
                $category->has_sub =0;
            }

            if ($request->hasFile("image")) {

                $file = $request->file("image");
                $mime = File::mimeType($file);
                $mimearr = explode('/', $mime);
    
                // $destinationPath = base_path() . '/uploads/'; // upload path
                $extension = $mimearr[1]; // getting file extension
                $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                $path = base_path('uploads/categories/source/' . $fileName);
                $resize200 = base_path('uploads/categories/resize200/' . $fileName);
                $resize800 = base_path('uploads/categories/resize800/' . $fileName);
                //  $file->move($destinationPath, $fileName);
    
                Image::make($file->getRealPath())->save($path);
    
                $arrayimage = list($width, $height) = getimagesize($file->getRealPath());
                $widthreal = $arrayimage['0'];
                $heightreal = $arrayimage['1'];
    
                $width200 = ($widthreal / $heightreal) * 150;
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
    
                $category->image = $fileName;
            }

            $category->home = $request->home;
            $category->menu = $request->menu;
            $category->status = $request->status;
            $category->save();

            $category = new CategoryResource($category);
            return response()->json(['category'=>$category,'message'=>'category created successfully','statusCode'=>201]);
        }catch(\Exception $e){
            dd($e);
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    ////////// function create Category////////////
    public function updateCategory(Request $request){
        try{
            $category = Category::find($request->category_id);
            $category->name_en = $request->name_en;
            $category->name_ar = $request->name_ar;
            $category->desc_en = $request->desc_en;
            $category->desc_ar = $request->desc_ar;

            $category->parent_id = $request->parent_id;
            if($request->parent_id !=0){
                $cat=Category::find($request->parent_id);
                $cat->has_sub =1;
                $cat->save();
            }

            if ($request->hasFile("image")) {

                $file = $request->file("image");
                $mime = File::mimeType($file);
                $mimearr = explode('/', $mime);
    
                $img_path = base_path() . '/uploads/categories/source/';
                $img_path200 = base_path() . '/uploads/categories/resize200/';
                $img_path800 = base_path() . '/uploads/categories/resize800/';
    
                if ($category->image != null) {
                    unlink(sprintf($img_path . '%s', $category->image));
                    unlink(sprintf($img_path200 . '%s', $category->image));
                    unlink(sprintf($img_path800 . '%s', $category->image));
                }
    
                // $destinationPath = base_path() . '/uploads/'; // upload path
                $extension = $mimearr[1]; // getting file extension
                $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                $path = base_path('uploads/categories/source/' . $fileName);
                $resize200 = base_path('uploads/categories/resize200/' . $fileName);
                $resize800 = base_path('uploads/categories/resize800/' . $fileName);
                //  $file->move($destinationPath, $fileName);
    
                $img =Image::make($file->getRealPath());
                $img->save($path);
    
                $arrayimage = list($width, $height) = getimagesize($file->getRealPath());
                $widthreal = $arrayimage['0'];
                $heightreal = $arrayimage['1'];
    
                $width200 = ($widthreal / $heightreal) * 150;
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
    
                $category->image = $fileName;
            }
    
            $category->home = $request->home;
            $category->menu = $request->menu;
            $category->status = $request->status;
            $category->save();

            $category = new CategoryResource($category);
            return response()->json(['category'=>$category,'message'=>'category updated successfully','statusCode'=>202]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    /////////// function delte Category and thier subs if found////////////
    public function deleteCategory(Request $request){
        try{
            $category = Category::find($request->category_id);
            if($category){
                $category->delete();
                $subCategories = Category::where('parent_id',$request->category_id)->delete();
                return response()->json(['message'=>'category and and thier subCategories deleted successfully','statusCode'=>200]);
            }            
            return response()->json(['message'=>'category id not found !!','statusCode'=>200]);
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }



    public function createProduct(Request $request){
        try{

            $product = new Product();
            $product->category_id = $request->category_id;
            $product->name_en = $request->name_en;
            $product->name_ar = $request->name_ar;
            $product->desc_en = $request->desc_en;
            $product->desc_ar = $request->desc_ar;
            $product->code = mt_rand(100000,999999);
            $product->price = $request->price;
            if($request->offer_price){
                $product->offer_price = $request->offer_price;
            }

            if ($request->hasFile("image")) {

                $file = $request->file("image");
                $mime = File::mimeType($file);
                $mimearr = explode('/', $mime);
    
                // $destinationPath = base_path() . '/uploads/'; // upload path
                $extension = $mimearr[1]; // getting file extension
                $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                $path = base_path('uploads/products/source/' . $fileName);
                $resize200 = base_path('uploads/products/resize200/' . $fileName);
                $resize800 = base_path('uploads/products/resize800/' . $fileName);
                //  $file->move($destinationPath, $fileName);
    
                Image::make($file->getRealPath())->save($path);
    
                $arrayimage = list($width, $height) = getimagesize($file->getRealPath());
                $widthreal = $arrayimage['0'];
                $heightreal = $arrayimage['1'];
    
                $width200 = ($widthreal / $heightreal) * 150;
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
    
                $category->image = $fileName;
            }

            $product->status = $request->status;
            $product->save();

            $product = new ProductResource($product);
            return response()->json(['product'=>$product,'message'=>'product created successfully','statusCode'=>201]);
        
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }
    
    
    public function allOrders(Request $request){
        try{
            $orders = OrderResource::collection(Order::get());
            return response()->json(['ordersData'=>$orders,'message'=>trans('messages.list of all orders'),'statusCode'=>200]);
        }
        catch(\Exception $e){
            dd($e);
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }












}