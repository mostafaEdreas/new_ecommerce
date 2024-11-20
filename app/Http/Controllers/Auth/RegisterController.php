<?php

namespace App\Http\Controllers\Auth;

use App\Models\Country;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\GuestCart;
use App\Models\GuestCartProduct;
use App\Models\GuestCartProductAttribute;
use App\Models\GuestCartProductOption;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\CartProductAttributeValue;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = '/order-checkOut';
    protected $redirectTo = RouteServiceProvider::HOME;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
//      $this->middleware('guest:vendor');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'f_name' => ['required', 'string', 'max:150'],
            'l_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string','email:rfc,dns', 'max:150', 'unique:users'],
            'password' =>request('checkout')?'nullable': ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    protected function  generateStrongPassword($length = 12) {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialCharacters = '!@#$%^&*()-_=+[]{}|;:,.<>?';

        $allCharacters = $uppercase . $lowercase . $numbers . $specialCharacters;
        $password = '';
        // Ensure at least one character from each set is included
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $specialCharacters[random_int(0, strlen($specialCharacters) - 1)];
        // Fill the rest of the password length with random characters from all sets
        for ($i = 4; $i < $length; $i++) {
            $password .= $allCharacters[random_int(0, strlen($allCharacters) - 1)];
        }
        // Shuffle the characters to ensure randomness
        return str_shuffle($password);
    }
    protected function create(array $data)
    {
        return User::create([
            'f_name' => $data['f_name'],
            'l_name' => $data['l_name'],
            'email' => $data['email'],
            'password' => request('checkout')?  Hash::make($this-> generateStrongPassword()): Hash::make($data['password']),
        ]);
    }

    ///// override register method/////
    public function register(Request $request){
        $this->validator($request->all())->validate();

        $user = new User();
        $user->f_name = $request->f_name;
        $user->l_name = $request->l_name;
        $user->email = $request->email;
        $user->password = request('checkout')?  Hash::make($this-> generateStrongPassword()): Hash::make($request->password);
        $user->remember_token = Str::random(80);
        $user->country_id = $request->country_id;
        $user->region_id = $request->region_id;
        $user->area_id = $request->area_id;
        $user->phone = $request->phone;
        $user->note = $request->note;
        $user->shipping_address = $request->shipping_address;


        $user->save();

        $this->guard()->login($user);

        $this->guestOperations();
        if(request('checkout') && auth()->check()){
            return redirect()->back()->withInput();
        }
        ////// send email//////
//        if($user->email){
//    	    Mail::send('emails/welcomeEmail', [], function($msg) use ($user) {
//      			$msg->to($user ->email, 'Kiddix')->subject('Welcome To Kiddix');
//      			$msg->from(config('mail.from.address'),config('mail.from.name'));
//    		});
//        }
        return $this->registered($request, $user)?: redirect($this->redirectPath());

    }

    public function guestOperations(){
        //// add guest wishlist///////
        // if(Session::has('wishlist')){
        //     $productIds = Session::get('wishlist');
        //     foreach($productIds as $productId){
        //         $check=Wishlist::where('product_id',$productId)->where('user_id',auth()->user()->id)->first();
        //         $check_exist_wishlist = WishlistPaid::where('user_id',Auth::user()->id)->where('done',0)->first();

        //         if(! $check){
        //             $add= new Wishlist();
        //             $add->user_id =Auth::user()->id ;
        //             $add->product_id=$productId;
        //             $add->save();
        //             $wishlist_paid_add= new WishlistPaid();
        //             $wishlist_paid_add->user_id =Auth::user()->id ;
        //             $wishlist_paid_add->product_id=$productId;
        //             if(!$check_exist_wishlist){

        //                 $wishlist_paid_add->wishlist_shareCode = time() . bin2hex(random_bytes(8));
        //                 $wishlist_paid_add->save();
        //             }else{
        //                 $wishlist_paid_add->wishlist_shareCode = $check_exist_wishlist->wishlist_shareCode;
        //                 $wishlist_paid_add->save();
        //             }
        //         }
        //     }
        // }

        //////// add guest cart ///////
        if(Session::has('session_id')){
            $session_id = Session ::get('session_id');
            $guestCart = GuestCart::where('session_id',$session_id)->first();
            if(!$guestCart){
                Session::forget('session_id');
                return ;
            }
            $cartProducts=GuestCartProduct::where('session_id',$session_id)->where('guest_cart_id',$guestCart->id);
            if(!$cartProducts){
                $guestCart->delete();
                return ;
            }
            ///////delete user cart if exist///
            $cart=Cart::where('user_id',Auth::user()->id)->first();

            if(!$cart){
                $cart= new Cart();
            }
            /////create user cart///
            $cart= new Cart();
            $cart->user_id=Auth::user()->id;
            $cart->coupon_id = $guestCart->coupon_id;
            $cart->coupon_discount = $guestCart->coupon_discount;
            $cart->products_price = $guestCart->products_price;
            $cart->total_price = $guestCart->total_price;
            $cart->save();

            foreach($cartProducts as $cartPro){
                $cartProduct=CartProduct::where('group_id',$cartPro->group_id)->where('user_id',Auth::user()->id)->orderBy('id','desc')->first();
                if(!$cartProduct){
                    //////ADD CART PRODUCT ////////
                    $add= new CartProduct();
                    $add->cart_id=$cart->id;
                    $add->user_id =Auth::user()->id ;
                    $add->product_id=$cartPro->product_id;
                    $add->color_id=$cartPro->color_id;
                    $add->price=$cartPro->price;
                    $add->price_before_disc=$cartPro->price_before_disc;
                    $add->quantity=$cartPro->quantity;
                    $add->save();

                    //////ADD CART PRODUCT ATTRIBUTE VALUES////////
                    // $productAttributeValues = GuestCartProductAttribute::where('guest_cart_id',$guestCart->id)->where('guest_cart_product_id',$cartPro->product_id)->get();
                    // foreach($productAttributeValues as $productAttributeValue){
                    //     $cartProAttrValue=new CartProductAttributeValue();
                    //     $cartProAttrValue->cart_id=$cart->id;
                    //     $cartProAttrValue->cart_product_id=$productAttributeValue->guest_cart_product_id;
                    //     $cartProAttrValue->attribute_value_id=$productAttributeValue->attribute_value_id;
                    //     $cartProAttrValue->save();
                    // }

                    $status='add';
                }else{
                    $cartProduct->quantity=$cartPro->quantity;
                    $cartProduct->save();
                }
            }

            ////// delete guest cart////
            $guestCart->delete();
        }
    }
}
