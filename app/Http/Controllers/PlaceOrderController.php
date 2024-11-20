<?php

namespace App\Http\Controllers;

use App\Models\WishlistPaid;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Region;
use App\Models\Area;
use App\Models\Category;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\Vendor;
use App\Models\Brand;
use App\Models\CategoryAttribute;
use App\Models\Attribute;
use App\Models\Wishlist;
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
use App\Models\CouponProduct;
use App\Models\CouponCategory;
use App\Models\CouponBrand;
use App\Models\CouponUser;
use App\Models\CouponRegion;
use App\Models\CouponShipping;
use Carbon\Carbon;
use App\Models\ShippingMethod;
use App\Models\PaymentMethod;
use App\Models\OrderProductAttributeValue;
use App\Models\OrderProductOption;
use App\Models\OrderStatus;
use App\Models\Setting;
use App\Models\Configration;
use App\Models\Stock;
use App\Traits\SMSTrait;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PlaceOrderController extends Controller
{
    use SMSTrait;
    /////////// FUNCTION Place Order ///////////////
    public function oldplaceOrder(Request $request){

        session(['form_data' => $request->all()]);

        $setting = Setting::first();
        $lang = \LaravelLocalization::getCurrentLocale();
        $configration = Configration::where('lang',$lang)->first();

        $user = Auth::user();
        $address=Address::where('user_id',$user->id)->where('is_primary',1)->first();
        $region=Region::where('id',$address->region_id)->first();
        $area=Area::where('id',$address->area_id)->first();
        $cart = Cart::where('user_id',$user->id)->first();
        $cartProducts = CartProduct::where('cart_id',$cart->id)->get();
        $cartproducts_wishlistProducts=[];
        $exist_flag=0;


        $cartproductShipping=DB::table('cart_products')
                    ->leftJoin('products', 'products.id', '=', 'cart_products.product_id')
                    ->select('products.shipping_fees')
                    ->where('cart_products.user_id',Auth::user()->id)
                    ->orderBy('products.shipping_fees','DESC')->first();
        $shippingFees=0;

        if($cartproductShipping){
            if($area->shipping_fees){
                $shippingFees=$cartproductShipping->shipping_fees * $area->shipping_fees * $region->shipping_fees;
            }else{
                $shippingFees=$cartproductShipping->shipping_fees * $region->shipping_fees;
            }
        }


        if(ShippingMethod::find($request->shipping_id)->value_type == 'value'){
            $shippingMethodFees = ShippingMethod::find($request->shipping_id)->value;
        }else{
            $shippingMethodFees = ($shippingFees * ShippingMethod::find($request->shipping_id)->value )/100;
        }

        if(PaymentMethod::find($request->payment_id)->value_type == 'value'){
            $paymentMethodFees = PaymentMethod::find($request->payment_id)->value;
        }else{
            $paymentMethodFees = ($cart->total_price * PaymentMethod::find($request->payment_id)->value )/100;
        }
        if($setting->free_shipping_status==1 && $setting->free_shipping>0){
            if ($cart->total_price>=$setting->free_shipping){
                $shippingMethodFees=0;
            }
        }
	    $total_price=($cart->products_price + $paymentMethodFees + $shippingFees + $shippingMethodFees + ($cart->products_price * $setting->tax)/100 ) - $cart->coupon_discount;

	    //////////////// add order data to session//////////////////
	    session()->put('form_data.address_id',$address->id);
        session()->put('form_data.products_price',$cart->products_price);
        session()->put('form_data.payment_method_fees',$paymentMethodFees);
        session()->put('form_data.shipping_method_fees',$shippingMethodFees);
        session()->put('form_data.total_shipping',$shippingFees + $shippingMethodFees);
        session()->put('form_data.coupon_id',$cart->coupon_id);
        session()->put('form_data.coupon_discount',$cart->coupon_discount);
        session()->put('form_data.total_price',$total_price);

        if($request->payment_id == 1){
            ////////save order data/////////
            $order = new Order();
            $order->user_id=$user->id;
            $order->status='pending';
            $order->address_id=$address->id;
            $order->payment_id=$request->payment_id;
            $order->shipping_id=$request->shipping_id;
            $order->products_price=$cart->products_price;
            $order->payment_method_fees=$paymentMethodFees;
            $order->shipping_method_fees=$shippingMethodFees;
            $order->total_shipping=$shippingFees + $shippingMethodFees;
            $order->coupoun_discount=$cart->coupon_discount;
            $order->tax_fees = ($cart->products_price * $setting->tax)/100;
            $order->total_price= ($cart->products_price + $paymentMethodFees + $shippingFees + $shippingMethodFees + $order->tax_fees) - $cart->coupon_discount;
            $order->coupon_id=$cart->coupon_id;
            $order->tracking_code=mt_rand();
            $order->payment_status = 'unpaid';
            $order->order_note = $request->note;
            $order->save();

            ////////save order products with attributes and options///////////////////////
            foreach($cartProducts as $cartProduct){
                if($cartProduct->product->discount()>0){
                    $product_price = $cartProduct->product->condition_discount_product_page($cartProduct->productAttributeValues()->id);
                }else{
                    $product_price = $cartProduct->product->condition_discount_product_page($cartProduct->productAttributeValues()->id);
                }
                $orderProduct=new OrderProduct();
                $orderProduct->order_id=$order->id;
                $orderProduct->product_id=$cartProduct->product_id;
                $orderProduct->color_id=$cartProduct->color_id;

                $orderProduct->price_before_disc=$cartProduct->product->old_price_product_with_attribute($cartProduct->productAttributeValues()->id);
                $orderProduct->price=$product_price;
                $orderProduct->quantity=$cartProduct->quantity;
                $orderProduct->save();

                $CartProductAttributeValues = CartProductAttributeValue::where('cart_product_id',$cartProduct->product_id)->get();
                if(count($CartProductAttributeValues)>0){
                    foreach($CartProductAttributeValues as $CartProductAttributeValue){
                        $orderProdAtt=new OrderProductAttributeValue();
                        $orderProdAtt->order_id=$order->id;
                        $orderProdAtt->order_product_id=$orderProduct->id;
                        $orderProdAtt->attribute_value_id=$CartProductAttributeValue->attribute_value_id;
                        $orderProdAtt->save();
                    }
                }

                // $cartProductOptions=CartProductOption::where('cart_product_id',$cartProduct->id)->get();
                // if(count($cartProductOptions)>0){
                //     foreach($cartProductOptions as $cartProdOption){
                //         $orderProdOpt=new OrderProductOption();
                //         $orderProdAtt->order_id=$order->id;
                //         $orderProdAtt->order_product_id=$orderProduct->id;
                //         $orderProdOpt->option_id=$cartProdOption->option_id;
                //         $orderProdOpt->price=$cartProdOption->price;
                //         $orderProdOpt->save();
                //     }
                // }
            }

            ////// save order staus///////
            $orderStatus=new OrderStatus();
            $orderStatus->order_id=$order->id;
            $orderStatus->status='pending';
            $orderStatus->save();

            ////////////delete cart and other related product/////////
            $cart->delete();

            /////send sms after creating order////
//            $this->SendMessage($address->phone1,$setting->place_order_msg);

            /////////// send email to user order and admin///////

            $add = array('order' =>$order, 'configration'=>$configration,'setting'=>$setting);

//            Mail::send('emails/orderInfo', $add, function($msg) use ($setting) {
//              	$msg->to([$setting -> contact_email,'nada.hassan@nstextile-eg.com'], 'Naguib Selim Order')->subject('Naguib Selim Order');
//              	$msg->from(config('mail.from.address'),config('mail.from.name'));
//            });
//
//            Mail::send('emails/orderInfo', $add, function($msg) use ($order) {
//              	$msg->to($order->user->email, 'Naguib Selim Order')->subject('Naguib Selim Order');
//              	$msg->from(config('mail.from.address'),config('mail.from.name'));
//            });

            return redirect('order/'.$order->id.'/completed');

        }elseif($request->payment_id == 2){
            $this->weAcceptCardPayment($total_price);
        }elseif($request->payment_id == 3){
            $this->weAcceptPayment2($total_price);
        }elseif($request->payment_id == 4){
            $this->weAcceptPayment3($total_price);
            return redirect('/user/orders')->with(['order_not_paid' =>trans('home.To pay, go to the nearest Aman or Masary outlet, ask for Madfouaat Accept and provide your reference number')]);
        }
    }

    public function placeOrder(Request $request){
        try {
            DB::beginTransaction();
            session(['form_data' => $request->all()]);

        $setting = Setting::first();
        $lang = LaravelLocalization::getCurrentLocale();
        $configration = Configration::where('lang',$lang)->first();

        $user = Auth::user();
        $address=Address::where('user_id',$user->id)->where('is_primary',1)->first();
        $region=Region::where('id',$address->region_id)->first();
        $area=Area::where('id',$address->area_id)->first();
        $cart = Cart::where('user_id',$user->id)->first();
        $cartProducts = CartProduct::where('cart_id',$cart->id)->get();
        $cartproducts_wishlistProducts=[];
        $exist_flag=0;


        $cartproductShipping=DB::table('cart_products')
                    ->leftJoin('stock', 'stock.id', '=', 'cart_products.group_id')
                    ->leftJoin('products', 'products.id', '=', 'stock.product_id')
                    ->select('products.shipping_fees')
                    ->where('cart_products.user_id',Auth::user()->id)
                    ->orderBy('products.shipping_fees','DESC')->first();
        // $shippingFees=0;

        if($region->name_en=="Alexandria" || $region->name_en=="Cairo"){
            $shippingFees=$cartproductShipping->shipping_fees;

        }else{
            $shippingFees = $this->claculateShipping($region->name_en,$cart->total_price);
        }


        // if(ShippingMethod::find($request->shipping_id)->value_type == 'value'){
        //     $shippingMethodFees = ShippingMethod::find($request->shipping_id)->value;
        // }else{
        //     $shippingMethodFees = ($shippingFees * ShippingMethod::find($request->shipping_id)->value )/100;
        // }

        if(PaymentMethod::find($request->payment_id)->value_type == 'value'){
            $paymentMethodFees = PaymentMethod::find($request->payment_id)->value;
        }else{
            $paymentMethodFees = ($cart->total_price * PaymentMethod::find($request->payment_id)->value )/100;
        }


        // if($setting->free_shipping_status==1 && $setting->free_shipping>0){
        //     if ($cart->total_price>=$setting->free_shipping){
        //         $shippingMethodFees=0;
        //     }
        // }

        // $shippingMethodFees +
	    $total_price=($cart->products_price + $paymentMethodFees + $shippingFees +  ($cart->products_price * $setting->tax)/100 ) - $cart->coupon_discount;

	    //////////////// add order data to session//////////////////
	    session()->put('form_data.address_id',$address->id);
        session()->put('form_data.products_price',$cart->products_price);
        session()->put('form_data.payment_method_fees',$paymentMethodFees);
        session()->put('form_data.shipping_method_fees',$shippingFees);
        session()->put('form_data.total_shipping',$shippingFees );
        session()->put('form_data.coupon_id',$cart->coupon_id);
        session()->put('form_data.coupon_discount',$cart->coupon_discount);
        session()->put('form_data.total_price',$total_price);

        if($request->payment_id == 1){
            ////////save order data/////////
            $order = new Order();
            $order->user_id=$user->id;
            $order->status='pending';
            $order->address_id=$address->id;
            $order->payment_id=$request->payment_id;
            $order->shipping_id=$request->shipping_id;
            $order->products_price=$cart->products_price;
            $order->payment_method_fees=$paymentMethodFees;
            $order->shipping_method_fees=$shippingFees;
            $order->total_shipping=$shippingFees ;
            $order->coupoun_discount=$cart->coupon_discount;
            $order->tax_fees = ($cart->products_price * $setting->tax)/100;
            $order->total_price= ($cart->products_price + $paymentMethodFees + $shippingFees  + $order->tax_fees) - $cart->coupon_discount;
            $order->coupon_id=$cart->coupon_id;
            $order->tracking_code=mt_rand();
            $order->payment_status = 'unpaid';
            $order->order_note = $request->note;
            $order->save();


            // ////////save order products with attributes and options///////////////////////
            // foreach($cartProducts as $cartProduct){
            //     if($cartProduct->product->discount()>0){
            //         $product_price = $cartProduct->group->product->condition_discount_product_page($cartProduct->productAttributeValues()->id);
            //     }else{
            //         $product_price = $cartProduct->group->product->condition_discount_product_page($cartProduct->productAttributeValues()->id);
            //     }
            //     $orderProduct=new OrderProduct();
            //     $orderProduct->order_id=$order->id;
            //     $orderProduct->product_id=$cartProduct->group->product_id;
            //     $orderProduct->color_id=$cartProduct->color_id;
            //     $orderProduct->group_id=$cartProduct->group_id;

            //     $orderProduct->price_before_disc=$cartProduct->group_id->product->old_price_product_with_attribute($cartProduct->productAttributeValues()->id);
            //     $orderProduct->price=$product_price;
            //     $orderProduct->quantity=$cartProduct->quantity;
            //     $orderProduct->save();



            //     $CartProductAttributeValues = CartProductAttributeValue::where('cart_product_id',$cartProduct->product_id)->get();
            //     if(count($CartProductAttributeValues)>0){
            //         foreach($CartProductAttributeValues as $CartProductAttributeValue){
            //             $orderProdAtt=new OrderProductAttributeValue();
            //             $orderProdAtt->order_id=$order->id;
            //             $orderProdAtt->order_product_id=$orderProduct->id;
            //             $orderProdAtt->attribute_value_id=$CartProductAttributeValue->attribute_value_id;
            //             $orderProdAtt->save();
            //         }
            //     }

            //     // $cartProductOptions=CartProductOption::where('cart_product_id',$cartProduct->id)->get();
            //     // if(count($cartProductOptions)>0){
            //     //     foreach($cartProductOptions as $cartProdOption){
            //     //         $orderProdOpt=new OrderProductOption();
            //     //         $orderProdAtt->order_id=$order->id;
            //     //         $orderProdAtt->order_product_id=$orderProduct->id;
            //     //         $orderProdOpt->option_id=$cartProdOption->option_id;
            //     //         $orderProdOpt->price=$cartProdOption->price;
            //     //         $orderProdOpt->save();
            //     //     }
            //     // }
            // }


            foreach($cartProducts as $cartProduct){
                $orderProduct=new OrderProduct();
                $orderProduct->order_id=$order->id;
                $orderProduct->product_id=$cartProduct->group->product_id;
                $orderProduct->group_id=$cartProduct->group_id;
                $orderProduct->color_id=$cartProduct->color_id;
                $orderProduct->price_before_disc=$cartProduct->group->price_details->old_price;
                $orderProduct->price=$cartProduct->group->price_details->new_price;
                $orderProduct->quantity=$cartProduct->quantity;
                $product = Stock::where('id',$cartProduct->group_id)->first();
                $product->decrement('stock', $cartProduct->quantity);
                $orderProduct->save();

                // $CartProductAttributeValues = CartProductAttributeValue::where('cart_product_id',$cartProduct->id)->get();
                // if(count($CartProductAttributeValues)>0){
                //     foreach($CartProductAttributeValues as $CartProductAttributeValue){
                //         $orderProdAtt=new OrderProductAttributeValue();
                //         $orderProdAtt->order_id=$order->id;
                //         $orderProdAtt->order_product_id=$orderProduct->id;
                //         $orderProdAtt->attribute_value_id=$CartProductAttributeValue->attribute_value_id;
                //         $orderProdAtt->save();
                //     }
                // }
                // $cartProductOptions=CartProductOption::where('cart_product_id',$cartProduct->id)->get();
                // if(count($cartProductOptions)>0){
                //     foreach($cartProductOptions as $cartProdOption){
                //         $orderProdOpt=new OrderProductOption();
                //         $orderProdAtt->order_id=$order->id;
                //         $orderProdAtt->order_product_id=$orderProduct->id;
                //         $orderProdOpt->option_id=$cartProdOption->option_id;
                //         $orderProdOpt->price=$cartProdOption->price;
                //         $orderProdOpt->save();
                //     }
                // }
            }

            ////// save order staus///////
            $orderStatus=new OrderStatus();
            $orderStatus->order_id=$order->id;
            $orderStatus->status='pending';
            $orderStatus->save();

            ////////////delete cart and other related product/////////
             CartProduct::where('cart_id',$cart->id)->delete();
            $cart->delete();

             /////send sms after creating order////
            //$this->SendMessage($address->phone1,$setting->place_order_msg);

            /////////// send email to user order and admin///////
            $add = array('order' =>$order,'setting'=>$setting);

           try {
                // Mail::send('emails/orderInfo', $add, function($msg) use ($order) {
                //     $msg->to($order->user->email, 'Drug Station Order')->subject('Order Thanks');
                //     $msg->from(config('mail.from.address'), config('mail.from.name'));
                // });
            } catch (\Exception $e) {
                // Log the exception or handle the error
                \Log::error('Mail send failed: ' . $e->getMessage());
            }

           ////// notify admin with new order created /////
            // Mail::send('emails/notifyAdminWithNewOrder', $add, function($msg) use ($setting) {
            //   	$msg->to($setting -> contact_email, 'Drug Station Order')->subject('New Order Submitted');
            //   	$msg->from(config('mail.from.address'),config('mail.from.name'));
            // });

            $items=[];
            $orderProducts=OrderProduct::where('order_id',$order->id)->get();

            foreach($orderProducts as $orderProduct){
                $item=[
                    'item_id'=>$orderProduct->product_id,
                    'item_name'=> (app()->getLocale() == 'en')?$orderProduct->group->product->link_en:$orderProduct->product->link_ar,
                    'item_category'=> (app()->getLocale() == 'en')?$orderProduct->group->product->category->link_en:$orderProduct->product->category->link_ar,
                    'item_brand'=> (app()->getLocale() == 'en')?$orderProduct->group->product->brand?->link_en:$orderProduct->product->brand?->link_ar,
                    'price'=> $orderProduct->price,
                    'discount'=> $orderProduct->price_before_disc - $orderProduct->price,
                    'quantity'=> $orderProduct->quantity,
                ];
                array_push($items,$item);

            }
            header('Content-type:application/json;charset=utf-8');
            $items =  json_encode($items,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            DB::commit();
            return view('userBoard.orderThank',compact('order','items','user'))->with('success',trans('home.thank you your order placed successfully'));
            // return redirect('/user/orders');

        }elseif($request->payment_id == 2){
            $this->payMobPayment($total_price);
        }
        } catch (\Throwable $ex) {
           DB::rollBack();
           dd($ex->getMessage(),$ex->getFile(),$ex->getLine());
           return redirect()->back();
        }

    }

    public function payMobPayment($total_price){

        $payMobOnlineCardIntegrationId = env('payMobOnlineCardIntegrationId');
        $payMobValueIntegrationId = env('payMobValueIntegrationId');
        $payMobsecretKey = env('payMobsecretKey');
        $payMobPublicKey= env('payMobPublicKey');

        $merchant_order_id = rand(11111111,99999999);

        $address = Address::where('user_id',Auth::user()->id)->where('is_primary',1)->first();
        $data = [
            'amount' => $total_price * 100, // Amount in cents
            'currency' => 'EGP',
            'payment_methods' => [intval($payMobOnlineCardIntegrationId),intval($payMobValueIntegrationId)],
            'special_reference'=>$merchant_order_id,
            'billing_data' => [
                'apartment' => 'NA',
                'email' => Auth::user()->email ? Auth::user()->email : 'email not found!',
                'floor' => 'NA',
                'first_name' => Auth::user()->f_name,
                'street' => 'NA',
                'building' => 'NA',
                'phone_number' => $address->phone1,
                'postal_code' => 'NA',
                'city' => ($address->region)?$address->region->name_en:'NA',
                'country' => ($address->country)?$address->country->name_en:'NA',
                'last_name' => Auth::user()->l_name,
                'state' => 'NA'
            ],
            'customer' => [
                'first_name' => Auth::user()->f_name,
                'last_name' => Auth::user()->l_name,
                'email' => Auth::user()->email ? Auth::user()->email : 'email not found!',
            ],
        ];

        $client = new Client();
        $headers = [
            'Authorization' => 'Token '.$payMobsecretKey,
            'Content-Type' => 'application/json'
        ];

        try {
            $response = $client->post('https://accept.paymob.com/v1/intention/', [
                'headers' => $headers,
                'json' => $data // Convert array to JSON
            ]);

            $body = $response->getBody();

            $jsonResponse = json_decode($body, true);

            $clientSecret = $jsonResponse['client_secret'];

            //////// insert oredr to temp orders/////
            DB::table('temp_orders')->insert([
                "merchant_order_id" =>$merchant_order_id,
                "payment_id" => session('form_data')['payment_id'],
                "shipping_id" => session('form_data')['shipping_id'],
                "products_price" => session('form_data')['products_price'],
                "shipping_fees" => session('form_data')['shipping_method_fees'],
                "total_shipping" => session('form_data')['total_shipping'],
                "address_id" => session('form_data')['address_id'],
                "payment_fees" => session('form_data')['payment_method_fees'],
                "coupon_id" => session('form_data')['coupon_id'] ?? null,
                "coupon_discount" => session('form_data')['coupon_discount'] ?? null,
                "user_id" => session('form_data')['user_id'] ?? null,
            ]);

            header('location: https://accept.paymob.com/unifiedcheckout/?publicKey='.$payMobPublicKey.'&clientSecret='.$clientSecret);
            die();

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->getResponse()->getBody(true);

            echo "ClientException: " . $responseBody;
        } catch (\Exception $e) {
            echo "Exception: " . $e->getMessage();
        }

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
    public function weAcceptCardPayment($total_price){
        $setting = Setting::first();
        $curl = curl_init();
    	$data = [];
        $data['api_key'] = "ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TVRRd056TTVMQ0p1WVcxbElqb2lhVzVwZEdsaGJDSjkuN056bkFSRlFSdmpvQzh0NmlQcTRRbjM4d3F2cTd3ZHJ3ODI3dURLUUMzdS1jYXBtdldub2VDa0V5UVh6RHhybk1CeVRISjZWUGNnWVR5SUdUUHpuX1E=";
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://accept.paymobsolutions.com/api/auth/tokens",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json"
            ),
        ));

    	$response = curl_exec($curl);
    	$err = curl_error($curl);

    	curl_close($curl);

        if ($err) {
    	   dd("cURL Error #:" . $err);
    	}else{
    	    $res = json_decode($response);

            $address = Address::where('user_id',Auth::user()->id)->where('is_primary',1)->first();
    	    $token = $res->token;
    	    $merchant_order_id = rand(11111111,99999999);
    	    $data = [];
    	    $data['auth_token'] = $token;
    	    $data['delivery_needed'] = 'false';
    	    $data['merchant_id'] = $res->profile->id;
    	    $data['amount_cents'] = $total_price * 100;
    	    $data['currency'] = 'EGP';
    	    $data['merchant_order_id'] = $merchant_order_id;
    	    $data['items'] = [];
    	    $data['shipping_data'] = ['apartment' => 'NA',
                	   			     'email' => Auth::user()->email?Auth::user()->email:'email not found !',
                	   			     'floor' => 'NA',
                	   			     'first_name' => Auth::user()->f_name,
                	   			     'street' => 'NA',
                	   			     'building' => 'NA',
                	   			     'phone_number' => $address -> phone1,
                	   			     'postal_code' => 'NA',
                	   			     'city' => $address -> region -> name_en,
                	   			     'country' => $address -> country -> name_en,
                	   			     'last_name' => Auth::user()->l_name,
                	   			     'state' => 'NA'];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://accept.paymobsolutions.com/api/ecommerce/orders",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/json"
                ),
            ));

    	    $response = curl_exec($curl);
    	    $err = curl_error($curl);

    	    curl_close($curl);

    	    if($err) {
    	        dd("cURL Error #:" . $err);
    	    }else {
    	        $res = json_decode($response);

    	        $order_id = $res->id;

    	        session(['weaccept_order_id' => $order_id]);;
	            $data = [];
	   	        $data['auth_token'] = $token;
	   	        $data['amount_cents'] = $total_price * 100;
        	   	$data['expiration'] = '36000';
        	   	$data['order_id'] = $order_id;
        	   	$data['currency'] = 'EGP';
        	    $data['integration_id'] = '3739142';

        	   	//// test /////
        	   // $data['integration_id'] = '3720106';
        	   	$data['lock_order_when_paid'] = 'false';
        	   	$data['billing_data'] = ['apartment' => 'NA',
                		   			     'email' =>Auth::user()->email?Auth::user()->email:'email not found !',
                		   			     'floor' => 'NA',
                		   			     'first_name' => Auth::user()->f_name,
                		   			     'street' => 'NA',
                		   			     'building' => 'NA',
                		   			     'phone_number' => $address -> phone1,
                		   			     'shipping_method' =>'PKG',
                		   			     'postal_code' => 'NA',
                		   			     'city' => $address -> region -> name_en,
                		   			     'country' => $address -> country -> name_en,
                		   			     'last_name' => Auth::user()->l_name,
                		   			     'state' => 'NA'];

	            $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://accept.paymobsolutions.com/api/acceptance/payment_keys",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/json"
                    ),
                ));

		        $response = curl_exec($curl);
		        $err = curl_error($curl);

	            curl_close($curl);

        	    if ($err) {
        		    dd("cURL Error #:" . $err);
        	    } else {
        		        $res = json_decode($response);

        		        //////// insert oredr to temp orders/////
        		        DB::table('temp_orders')->insert([
        		          "weaccept_order" =>$order_id,
        		          "payment_id" => session('form_data')['payment_id'],
                          "shipping_id" => session('form_data')['shipping_id'],
                          "products_price" => session('form_data')['products_price'],
                          "shipping_fees" => session('form_data')['shipping_method_fees'],
                          "total_shipping" => session('form_data')['total_shipping'],
                          "address_id" => session('form_data')['address_id'],
                          "payment_fees" => session('form_data')['payment_method_fees'],
                          "coupon_id" => session('form_data')['coupon_id'] ?? null,
                          "coupon_discount" => session('form_data')['coupon_discount'] ?? null,
        		        ]);

        		        $payment_token = $res->token;
        		        header('location: https://accept.paymob.com/api/acceptance/iframes/315418?payment_token='.$payment_token);
        		        die();
        		}
    	    }
    	}
    }

    public function weAcceptCardPaymentCallback(Request $request){
        $setting = Setting::first();
        $user = Auth::user();
        $form_data=DB::table('temp_orders')->where('weaccept_order',$request->order)->first();

        if($request->success == "true" && $request->pending == "false"){
            $address=Address::where('id',$form_data->address_id)->first();
            $region=Region::where('id',$address->region_id)->first();
            $area=Area::where('id',$address->area_id)->first();
            $cart = Cart::where('user_id',$user->id)->first();
            $cartProducts = CartProduct::where('cart_id',$cart->id)->get();

            /////// save order data//////
            $order = new Order();
            $order->user_id=$user->id;
            $order->status='pending';
            $order->address_id=$address->id;
            $order->payment_id=$form_data->payment_id;
            $order->shipping_id=$form_data->shipping_id;
            $order->products_price=$form_data->products_price;
            $order->payment_method_fees=$form_data->payment_fees;
            $order->shipping_method_fees=$form_data->shipping_fees;
            $order->total_shipping=$form_data->total_shipping;
            $order->coupoun_discount=$form_data->coupon_discount ?? null;
            $order->tax_fees = ($cart->products_price * $setting->tax)/100;
            $order->total_price= $form_data->products_price + $form_data->payment_fees + $form_data->total_shipping + $order->tax_fees - $form_data->coupon_discount;
            $order->coupon_id=$form_data->coupon_id ?? null;
            $order->tracking_code=mt_rand();
            $order->payment_status = 'paid';
            $order->save();

            ////////save order products with attributes and options///////////////////////
            foreach($cartProducts as $cartProduct){
                $orderProduct=new OrderProduct();
                $orderProduct->order_id=$order->id;
                $orderProduct->product_id=$cartProduct->product_id;
                $orderProduct->color_id=$cartProduct->color_id;
                $orderProduct->price_before_disc=$cartProduct->price_before_disc;
                $orderProduct->price=$cartProduct->price;
                $orderProduct->quantity=$cartProduct->quantity;
                $orderProduct->save();

                $CartProductAttributeValues = CartProductAttributeValue::where('cart_product_id',$cartProduct->id)->get();
                if(count($CartProductAttributeValues)>0){
                    foreach($CartProductAttributeValues as $CartProductAttributeValue){
                        $orderProdAtt=new OrderProductAttributeValue();
                        $orderProdAtt->order_id=$order->id;
                        $orderProdAtt->order_product_id=$orderProduct->id;
                        $orderProdAtt->attribute_value_id=$CartProductAttributeValue->attribute_value_id;
                        $orderProdAtt->save();
                    }
                }

                $cartProductOptions=CartProductOption::where('cart_product_id',$cartProduct->id)->get();
                if(count($cartProductOptions)>0){
                    foreach($cartProductOptions as $cartProdOption){
                        $orderProdOpt=new OrderProductOption();
                        $orderProdAtt->order_id=$order->id;
                        $orderProdAtt->order_product_id=$orderProduct->id;
                        $orderProdOpt->option_id=$cartProdOption->option_id;
                        $orderProdOpt->price=$cartProdOption->price;
                        $orderProdOpt->save();
                    }
                }
            }

            ////// save order staus///////
            $orderStatus=new OrderStatus();
            $orderStatus->order_id=$order->id;
            $orderStatus->status='pending';
            $orderStatus->save();

            ////////////delete cart and other related product/////////
            $cart->delete();

            /////send sms after creating order////
            $this->SendMessage($address->phone1,$setting->place_order_msg);

            /////////// send email to user order and admin///////
            // $add = array('order' =>$order, 'orderProducts'=>$orderProducts,'setting'=>$setting);

            // Mail::send('emails/orderInfo', $add, function($msg) use ($setting) {
            //   	$msg->to($setting -> contact_email, 'Naguib Selim Order')->subject('Naguib Selim Order');
            //   	$msg->from(config('mail.from.address'),config('mail.from.name'));
            // });

            // Mail::send('emails/orderInfo', $add, function($msg) use ($order) {
            //   	$msg->to($order->user->email, 'Naguib Selim Order')->subject('Naguib Selim Order');
            //   	$msg->from(config('mail.from.address'),config('mail.from.name'));
            // });


    	    ///// delete order date from temp orders///
    	    DB::table('temp_orders')->where('weaccept_order',$request->order)->delete();
            return redirect('/user/orders')->with('success',trans('home.thank you your order placed successfully'));
        }else{

            return redirect('order-checkOut')->with(['order_not_completed' =>trans('home.payment_faild')]);
        }

    }

    public function weAcceptAmanAndMasary($total_price){
        $curl = curl_init();
    	$data = [];
        $data['api_key'] = "ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SndjbTltYVd4bFgzQnJJam94TXpNNU5UY3NJbTVoYldVaU9pSnBibWwwYVdGc0lpd2lZMnhoYzNNaU9pSk5aWEpqYUdGdWRDSjkuemdVY29ydVhNblZyMXJVOElwMlE0cEZIUTBVVnVvVDUxRmJPUjluZ2ZPSDdlcS1yalNJYjdMaFd4cTc4LXBlOHRDZ2VCU1pLMXUyRndzRTZRRzlud2c=";
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://accept.paymobsolutions.com/api/auth/tokens",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json"
            ),
        ));

    	$response = curl_exec($curl);
    	$err = curl_error($curl);

    	curl_close($curl);

        if ($err) {
    	   dd("cURL Error #:" . $err);
    	}else{
    	    $res = json_decode($response);

            $address = Address::where('user_id',Auth::user()->id)->where('is_primary',1)->first();
    	    $token = $res->token;
    	    $merchant_order_id = rand(11111111,99999999);
    	    $data = [];
    	    $data['auth_token'] = $token;
    	    $data['delivery_needed'] = 'false';
    	    $data['merchant_id'] = $res->profile->id;
    	    $data['amount_cents'] = $total_price * 100;
    	    $data['currency'] = 'EGP';
    	    $data['merchant_order_id'] = $merchant_order_id;
    	    $data['items'] = [];
    	    $data['shipping_data'] = ['apartment' => 'NA',
                	   			     'email' => Auth::user()->email?Auth::user()->email:'email not found !',
                	   			     'floor' => 'NA',
                	   			     'first_name' => Auth::user()->f_name,
                	   			     'street' => 'NA',
                	   			     'building' => 'NA',
                	   			     'phone_number' => $address -> phone1,
                	   			     'postal_code' => 'NA',
                	   			     'city' => $address -> region -> name_en,
                	   			     'country' => $address -> country -> name_en,
                	   			     'last_name' => Auth::user()->l_name,
                	   			     'state' => 'NA'];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://accept.paymobsolutions.com/api/ecommerce/orders",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/json"
                ),
            ));

    	    $response = curl_exec($curl);
    	    $err = curl_error($curl);

    	    curl_close($curl);

    	    if($err) {
    	        dd("cURL Error #:" . $err);
    	    }else {
    	        $res = json_decode($response);
    	        $order_id = $res->id;

    	        session(['weaccept_order_id' => $order_id]);;
	            $data = [];
	   	        $data['auth_token'] = $token;
	   	        $data['amount_cents'] = $total_price * 100;
        	   	$data['expiration'] = '36000';
        	   	$data['order_id'] = $order_id;
        	   	$data['currency'] = 'EGP';
        	   	$data['integration_id'] = '607235';
        	   	$data['lock_order_when_paid'] = 'false';
           	   	$data['billing_data'] = ['apartment' => 'NA',
		   			     'email' => Auth::user()->email?Auth::user()->email:'email not found !',
		   			     'floor' => 'NA',
		   			     'first_name' => Auth::user()->f_name,
		   			     'street' => 'NA',
		   			     'building' => 'NA',
		   			     'phone_number' => $address -> phone1,
		   			     'shipping_method' =>'PKG',
		   			     'postal_code' => 'NA',
		   			     'city' => $address -> region -> name_en,
		   			     'country' => $address -> country -> name_en,
		   			     'last_name' => Auth::user()->l_name,
		   			     'state' => 'NA'];

	            $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://accept.paymobsolutions.com/api/acceptance/payment_keys",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/json"
                    ),
                ));

		        $response = curl_exec($curl);
		        $err = curl_error($curl);
	            curl_close($curl);

        	    if ($err) {
        		    dd("cURL Error #:" . $err);

        	    } else {
        	         $res = json_decode($response);
        		     //dd($res);
            		 $payment_token = $res->token;

    	             $data = [];
            	   	 $data['source'] = ['identifier' => $address -> phone1,
                    		   		   'subtype'=> "WALLET"
                    		   		  ];
                    $data['payment_token'] = $payment_token;

    	            $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://accept.paymobsolutions.com/api/acceptance/payments/pay",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => json_encode($data),
                        CURLOPT_HTTPHEADER => array(
                            "content-type: application/json"
                        ),
                    ));

		            $response = curl_exec($curl);
		            $err = curl_error($curl);

	                curl_close($curl);

        		    if ($err) {
        		        dd("cURL Error #:" . $err);
            	    } else {
            		      $res = json_decode($response);
            		      //dd($res);
            		      $iframe_redirection_url = $res->iframe_redirection_url;
            		      header("location: $iframe_redirection_url");
            		}


        		}
    	    }
    	}
    }

    public function weAcceptKioskCallback($bill_reference){

        $setting = Setting::first();
        $form_data = session('form_data');
        $weaccept_order_id = session('weaccept_order_id');

        $address=Address::where('id',$form_data['address_id'])->first();
        $region=Region::where('id',$address->region_id)->first();
        $area=Area::where('id',$address->area_id)->first();
        $chars = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $serial = '';
        $max = count($chars)-1;
        for($i=0;$i<8;$i++){
            $serial .= (!($i % 4) && $i ? '-' : '').$chars[rand(0, $max)];
        }

        ////////save order data/////////
        $order = new Order();
        $order->user_id=Auth::user()->id;
        $order->status='Placed';
        $order->address_id=$form_data['address_id'];
        $order->area_id=$address->area_id;
        $order->region_id=$address->region_id;
        $order->country_id=$address->country_id;
        $order->payment_id=$form_data['payment_id'];
        $order->shipping_id=$form_data['shipping_id'];
        $order->products_price=$form_data['products_price'];
        $order->payment_fees=$form_data['payment_fees'];
        $order->shipping_fees=$form_data['shipping_fees'];
        $order->free_shipping=$form_data['free_shipping'];
        $order->coupoun_discount=$form_data['discount'];
        if(isset($form_data['user_balance']) && $form_data['user_balance'] != null && $form_data['user_balance'] != '' && $form_data['user_balance'] > 0){
            $order->user_balance = $form_data['user_balance'];
            $order->total_price=($form_data['payment_fees'] + $form_data['shipping_fees'] + $form_data['products_price']) - $form_data['discount'] - $form_data['user_balance'];
        }else{
            $order->total_price=($form_data['payment_fees'] + $form_data['shipping_fees'] + $form_data['products_price']) - $form_data['discount'];
        }


        $order->coupon_id=$form_data['coupon_id'];
        //$order->tracking_code=$serial;
        $order->weaccept_order_id=$weaccept_order_id;
        $order->weaccept_bill_reference=$bill_reference;
        $order->payment_status='unpaid';

        $order->save();

        if($form_data['shipping_id'] == 1){
            $orderDate=date_format($order->created_at,"m/d/Y");
            if($region->delivery && !$area->delivery){
                $order->delivery_date= date('m/d/Y', strtotime($orderDate. "+ ". $region->delivery ." days"));

                $deliveryday = DateTime::createFromFormat('m/d/Y',  $order->delivery_date);
                $order->delivery_day=$deliveryday->format('D');
            }
            if($region->delivery && $area->delivery){
                $order->delivery_date= date('m/d/Y', strtotime($orderDate. "+ ". $area->delivery ." days"));

                $deliveryday = DateTime::createFromFormat('m/d/Y',  $order->delivery_date);
                $order->delivery_day=$deliveryday->format('D');
            }
            $order->save();
        }
        ////////save order products and order product options///////////////////////
        $userCart=Cart::where('user_id',Auth::user()->id)->first();
        $cartProducts=CartProduct::where('user_id',Auth::user()->id)->where('cart_id',$userCart->id)->select('id','product_id','count','color_id')->get();

          foreach($cartProducts as $cartProd){
            $optionPrice=CartProductOption::where('cart_id',$userCart->id)->where('product_id',$cartProd->id)->where('type','addition')->sum('price');
            $cartProductDiscount=CartCouponProduct::where('coupon_value_id',$cartProd->product->id)->where('cart_id',$userCart->id)->first();

            $orderProduct=new OrderProduct();
            $orderProduct->order_id=$order->id;
            $orderProduct->product_id=$cartProd->product->id;
            $orderProduct->color_id=$cartProd->color_id;
            $orderProduct->product_name=$cartProd->product->name_en;

            if($cartProd->product->discount()){
                $orderProduct->before_disc=$cartProd->product->price + $optionPrice;
                $orderProduct->price=$cartProd->product->discount() + $optionPrice;
            }else{
                $orderProduct->price=$cartProd->product->price + $optionPrice;
                $orderProduct->before_disc=0;
            }

            $orderProduct->product_name=$cartProd->product->name_en;
            $orderProduct->quantity=$cartProd->count;
            if($cartProductDiscount){
                $orderProduct->discount=$cartProductDiscount->discount;
            }else{
                $orderProduct->discount=0;
            }
            $orderProduct->total_price=$orderProduct->price - $orderProduct->discount;

            ///////////decreas stock of table product//////////////
                $prod=Product::find($cartProd->product->id);
                $prod->stock=$prod->stock - $cartProd->count;
                $prod->ordered=$prod->ordered + $cartProd->count;
                $prod->save();

                $productStocks = productStock::where('product_id',$cartProd->product->id)->where('quantity','>',0)->get();
                $productStock = $productStocks[0];
                for($i = 1 ;$i < count($productStocks);$i++){
                    if($productStocks[$i]->price_ber_piece < $productStock->price_ber_piece){
                        $productStock = $productStocks[$i];
                    }

                    if($productStocks[$i]->price_ber_piece == $productStock->price_ber_piece &&  $productStocks[$i]->expire_date <= $productStock->expire_date){
                        $productStock = $productStocks[$i];
                    }
                }

                $productStock->available=$productStock->available - $cartProd->count;
                $productStock->ordered=$productStock->ordered + $cartProd->count;
                $productStock->save();

                // $orderProduct->product_stock=implode(",",$usedStock);
                $orderProduct->vendor_price = $productStock->price_ber_piece;
                $orderProduct->product_stock  =$productStock->id;
                $orderProduct->save();

                ////////////// increase points and user balance//////
                $user = Auth::user();
                $user->balance +=$cartProd->product->points * $setting->point_price;
        	    $user->save;

            $cartProductOptions=CartProductOption::where('cart_id',$userCart->id)->where('product_id',$cartProd->id)->get();
            if(count($cartProductOptions)>0){
                foreach($cartProductOptions as $cartProdOption){
                    $orderProdOpt=new OrderProductOption();
                    $orderProdOpt->order_id=$order->id;
                    $orderProdOpt->product_id=$cartProd->product->id;
                    $orderProdOpt->product_name=$cartProd->product->name_en;
                    $orderProdOpt->option_id=$cartProdOption->option_id;
                    $orderProdOpt->price=$cartProdOption->price;
                    $orderProdOpt->type=$cartProdOption->type;
                    $orderProdOpt->save();
                }
            }

            ////////////// vendor operations//////////////////////////////////////////////////////
            $productCategory = Category::find($cartProd->product->category_id);
            $vendorOperation=new VendorOperation();
            $vendorOperation->order_id=$order->id;
            $vendorOperation->vendor_id=$cartProd->product->vendor_id;
            $vendorOperation->product_id=$cartProd->product->id;
            // if($cartProd->product->discount()){
            //     $vendorOperation->price=$cartProd->product->discount() + $optionPrice;
            //     $vendorOperation->commission=($cartProd->product->discount() + $optionPrice  * $productCategory->vendor_commission)/100;
            //     $vendorOperation->your_price= $cartProd->product->discount() + $optionPrice - (($cartProd->product->discount() + $optionPrice  * $productCategory->vendor_commission)/100);
            // }else{

            //     $vendorOperation->price=$cartProd->product->price + $optionPrice;
            //     $vendorOperation->commission=($cartProd->product->price + $optionPrice  * $productCategory->vendor_commission)/100;
            //     $vendorOperation->your_price=$cartProd->product->price + $optionPrice - (($cartProd->product->price + $optionPrice  * $productCategory->vendor_commission)/100);
            // }

            $vendorOperation->price =$orderProduct->price;
            $vendorOperation->your_price =$productStock->price_ber_piece;
            $vendorOperation->quantity=$cartProd->count;
            $vendorOperation->status='pending';
            $vendorOperation->save();

            /////////// vendor operations status//////////////
            $vendorOperationStatus=new VendorOperationStatus();
            $vendorOperationStatus->vendor_operation_id=$vendorOperation->id;
            $vendorOperationStatus->vendor_id=$cartProd->product->vendor_id;
            $vendorOperationStatus->status='pending';
            $vendorOperationStatus->save();

        }
        ////// save order staus///////
        $orderStaus=new OrderStatus();
        $orderStaus->order_id=$order->id;
        $orderStaus->user_id=Auth::user()->id;
        $orderStaus->change='Placed';
        $orderStaus->save();

        //////// increment used of coupon and add coupon use to table coupon_use//////////
        if($order->coupon_id){
            $couponProCount=OrderProduct::where('order_id',$order->id)->where('discount','!=',0)->count();
            $coupon=Coupon::where('id',$order->coupon_id)->first();
            $coupon->used_count=$coupon->used_count + $couponProCount;
            $coupon->save();

            $couponUse=new CouponUse();
            $couponUse->coupon_id=$order->coupon_id;
            $couponUse->user_id=Auth::user()->id;
            $couponUse->save();
        }
        ////////////delete cart and other related product/////////
        $userCart->delete();
        //session()->remove('form_data');
        //session()->remove('weaccept_order_id');
        /////////// send email to user order and admin///////
        $orderProducts=OrderProduct::where('order_id',$order->id)->get();
        $setting = Setting::first();
        $add = array('order' =>$order, 'orderProducts'=>$orderProducts,'setting'=>$setting);
        try{
            Mail::send('emails/orderInfo', $add, function($msg) use ($setting) {
              	$msg->to($setting -> contact_email, 'Naguib Selim Order')->subject('Naguib Selim Order');
              	$msg->from(config('mail.from.address'),config('mail.from.name'));
           });

            Mail::send('emails/orderInfo', $add, function($msg) use ($order) {
              	$msg->to($order->user->email, 'Naguib Selim Order')->subject('Naguib Selim Order');
              	$msg->from(config('mail.from.address'),config('mail.from.name'));
           });
           session(['order' => trans('home.Your Order placed Successfully')]);
        }
        catch(Exception $e){
        	dd($e);
	        session(['order' => 'Invalid Email Address']);

	    }

	    //////////// decrease user balance//////////
	    if(isset($form_data['user_balance']) && $form_data['user_balance'] != null && $form_data['user_balance'] != '' && $form_data['user_balance'] > 0){
    	    $user = Auth::user();
    	    $user->balance = $user->balance - $order->user_balance;
    	    $user->save();
	    }

    }


    public function orderComplete($id){
        $order = Order::find($id);

        $items=[];
        $orderProducts=OrderProduct::where('order_id',$id)->get();

        foreach($orderProducts as $orderProduct){
            $item=[
                'item_id'=>$orderProduct->product_id,
                'item_name'=> (app()->getLocale() == 'en')?$orderProduct->product->link_en:$orderProduct->product->link_ar,
                'item_category'=> (app()->getLocale() == 'en')?$orderProduct->product->category->link_en:$orderProduct->product->category->link_ar,
                'item_brand'=> (app()->getLocale() == 'en')?$orderProduct->product->brand->link_en:$orderProduct->product->brand->link_ar,
                'quantity'=> $orderProduct->quantity,
                'price'=> $orderProduct->price,
                'discount'=> $orderProduct->price_before_disc - $orderProduct->price,
                'quantity'=> $orderProduct->quantity,
            ];
            array_push($items,$item);

        }
        header('Content-type:application/json;charset=utf-8');
        $items =  json_encode($items,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

        return view('userBoard.orderThank',compact('order','items'));
    }

}
