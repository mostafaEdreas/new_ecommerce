<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\WishlistPaid;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Redirect;
use Mail;
use Illuminate\Support\Str;

use App\Models\GuestCart;
use App\Models\GuestCartProduct;
use App\Models\GuestCartProductAttribute;
use App\Models\GuestCartProductOption;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\CartProductAttributeValue;
use App\Models\GalleryImage;
use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/order-checkOut';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // session(['url.intended' => url()->previous()]);
        // $this->redirectTo = session()->get('url.intended');

        $this->middleware('guest')->except('logout');
        // $this->middleware('guest:vendor')->except('logout');
    }

    use AuthenticatesUsers {
        logout as performLogout;
    }

    public function logout(Request $request){
        $this->performLogout($request);
        return redirect('/');
    }

    public function redirectToFacebookProvider(){
        return Socialite::driver('facebook ')->redirect();
    }

    public function handleFacebookProviderCallback(Request $request){
        try {
            $user = Socialite::driver('facebook')->user();

            $saveUser = User::updateOrCreate([
                'facebook_id' => $user->getId(),
            ],[
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => Hash::make($user->getName().'@'.$user->getId())
                 ]);

            Auth::loginUsingId($saveUser->id);

            return redirect()->route('home');
            } catch (\Throwable $th) {
               throw $th;
            }
    }

    public function redirectToGoogleProvider(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleProviderCallback(){
        try{
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleUser->email)->first();
        if(!$user)
        {
            $user = User::create(['name' => $googleUser->name, 'email' => $googleUser->email, 'password' => Hash::make(rand(100000,999999))]);
        }

        Auth::login($user);
        $this->guestOperations();
        return redirect(RouteServiceProvider::HOME);

        } catch (Exception $e) {
            return redirect ('/');
        }
    }

    public function showLoginForm(){
        if(!session()->has('url.intended')){
            session(['url.intended' => url()->previous()]);
        }
        // $gallery_image = GalleryImage::first();
        return view('auth.login');
    }

    public function login(Request $request){
        $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            //// add guest cart and wishlist///
            // $this->guestOperations();
            $user = Auth::user();
            $this->guestOperations();
            if ($user->roles->isEmpty()) {
                return redirect('/');  // If user has no roles assigned, => 'users'

            }else{
                return redirect('/admin'); // If user has roles assigned, => 'admin or anything else'
            }

            // return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
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
                return ;
            }
            $cartProducts=GuestCartProduct::where('session_id',$session_id)->where('guest_cart_id',$guestCart->id);
            if(!(count($cartProducts->get()) > 0)){
                $guestCart->delete();
                return ;
            }
            ///////delete user cart if exist///
            $cart=Cart::where('user_id',Auth::user()->id)->first();

            if(!$cart){
                $cart= new Cart();
            }
            /////create user cart///
            $cart->user_id=Auth::user()->id;
            $cart->coupon_id = $guestCart->coupon_id;
            $cart->coupon_discount = $guestCart->coupon_discount;
            $cart->products_price = $guestCart->products_price;
            $cart->group_id = $guestCart->group_id;
            $cart->total_price = $guestCart->total_price;
            $cart->save();
            foreach($cartProducts->get() as $cartPro){
                $cartProduct=CartProduct::where('group_id',$cartPro->group_id)->where('user_id',Auth::user()->id)->orderBy('id','desc')->first();
                if(!$cartProduct){
                    //////ADD CART PRODUCT ////////
                    $add= new CartProduct();
                    $add->cart_id=$cart->id;
                    $add->user_id =Auth::user()->id ;
                    $add->product_id=$cartPro->product_id;
                    $add->group_id=$cartPro->group_id;
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
            $cartProducts->delete();
        }
    }
}
