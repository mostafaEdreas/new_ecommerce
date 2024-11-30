<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\WishlistPaid;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Region;
use App\Models\Area;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\Wishlist;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use App\Models\ProductColor;
use App\Models\ProductReview;
use App\Models\ProductOption;

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
use Illuminate\Support\Facades\Hash;
use App\Models\ComapreList;
use App\Models\GuestCart;
use App\Models\GuestCartProduct;
use App\Models\GuestCartProductAttribute;
use App\Models\GuestCartProductOption;
use App\Helpers\Helper;
use App\Helpers\SaveImageTo3Path;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class OldUserBoardController extends Controller
{
    //////// FUNCTION RETURN VIEW OF ACCOUNT SETTINGS///
    // public function accountSettings()
    // {
    //     $user = User::with('orders')->find(auth()->user()->id);
    //     $countries = Country::all();
    //     $regions = Region::all();
    //     $areas = Area::all();
    //     $wisheProductIds = Wishlist::where('user_id', $user->id)->pluck('product_id')->toArray();
    //     $wishProducts = Product::whereIn('id', $wisheProductIds)->get();
    //     return view('userBoard.profile', compact('user', 'countries', 'wishProducts', 'regions', 'areas'));
    // }



    public function profile(){
        return view('userBoard.profile');
    }
    ////////////////////function return wishList view////////////////
    public function wishList()
    {
        // $user = auth()->user();
        // if (auth()->check()) {
        //     $wishlist = Wishlist::where('user_id', $user->id)->first();
        //     $wisheProductIds = Wishlist::where('user_id', $user->id)->pluck('product_id')->toArray();
        //     $wishProductIds_paid = WishlistPaid::where('user_id', $user->id)->where('done', 1)->pluck('product_id')->toArray();
        //     $wishProduct_paid_first = WishlistPaid::where('user_id', $user->id)->first();
        //     $wishProduct_paid = WishlistPaid::where('user_id', $user->id)->where('done', 1)->get();
        // } else {
        //     $wishProduct_paid_first = [0];
        //     $wisheProductIds = [];
        //     $wisheProductIds = Session::get('wishlist');
        //     $wishProductIds_paid = [0];
        //     $wishProduct_paid = [0];
        // }
        // if ($wisheProductIds) {
        //     $wishProducts = Product::whereIn('id', $wisheProductIds)->get();
        //     $wishProducts_paid = Product::whereIn('id', $wishProductIds_paid)->get();
        // } else {
        //     $wishProducts = [];
        // }
        $data['wishes'] = Wishlist::whereHas('group')->where('user_id',auth()->user()->id)->with('group')->get();
        return view('old-userBoard.wish_list', $data);
        // if (count($wishProducts) > 0) {
            // return view('userBoard.wish_list', compact('user', 'wishProducts', 'wishProduct_paid', 'wishProduct_paid_first', 'wishProducts_paid'));
        // } else {
        //     return view('userBoard.emptyWishlist');
        // }
    }

    //////////////// ajax function that add product to wishlist///////////
    public function addWishlist()
    {
        $productId = $_POST['productId'];

        $product = Product::where('id', $productId)->first();
        if (auth()->check()) {
            $wishCount_old = Wishlist::where('user_id', auth()->user()->id)->count();
            $check = Wishlist::where('product_id', $productId)->where('user_id', auth()->user()->id)->first();
            $check_exist_wishlist = WishlistPaid::where('user_id', auth()->user()->id)->where('done', 0)->first();
            if (!$check) {
                $add = new Wishlist();
                $add->user_id = auth()->user()->id;
                $add->product_id = $productId;
                $add->save();
            } else {
                $check->delete();
            }

            $wishListProducts_ids = Wishlist::where('user_id', auth()->user()->id)->pluck('product_id')->toArray();
            $wishCount = count($wishListProducts_ids);
            $wishProds = Product::whereIn('id', $wishListProducts_ids)->get();
            $message = ($wishCount_old < $wishCount) ? __('home.your_item_added_successfully') : __('home.product_removed_from_wishlist');
            return response()->json([
                'wishCount' => $wishCount,
                'html' => view('website.partials.sideWishlistProduct', compact('wishProds', 'wishCount'))->render(),
                'message' => $message,
                'product_image' => Helper::uploadedImagesPath('products', $product->firstImage()->image)

            ]);
        } else {
            if (!Session::has('wishlist')) {
                Session::put('wishlist', []);
            }
            $guestWishlist = Session::get('wishlist');
            $wishCount_old = count($guestWishlist);
            if (!in_array($productId, $guestWishlist)) {
                Session::push('wishlist', $productId);
                Session::save();
                $guestWishlist = Session::get('wishlist');
            } else {
                if (($key = array_search($productId, $guestWishlist)) !== false) {
                    unset($guestWishlist[$key]);
                    Session::put('wishlist', $guestWishlist);
                }
            }
            $wishCount = count($guestWishlist);
            $wishProds = Product::whereIn('id', $guestWishlist)->get();
            $message = ($wishCount_old < $wishCount) ? __('home.your_item_added_successfully') : __('home.product_removed_from_wishlist');
            return response()->json([
                'wishCount' => $wishCount,
                'html' => view('website.partials.sideWishlistProduct', compact('wishProds', 'wishCount'))->render(),
                'message' => $message,
                'product_image' => Helper::uploadedImagesPath('products', $product->firstImage()->image)
            ]);
        }
    }
    //////////////// find wishlist///////////
    public function findwishlist()
    {
        return view('userBoard.findWishlist');
    }
    ////////////// get products of gift wishlist///////////

    public function getGiftWishList(Request $request)
    {
        $products_ids = WishlistPaid::where('wishlist_shareCode', $request->wishlist_code)->where('done', 0)->pluck('product_id')->toArray();
        $products = Product::whereIn('id', $products_ids)->get();
        return view('userBoard.findWishlist', compact('products'));
    }
    /////////////// function that remove wishlist////////////
    public function removeWishlist($id)
    {
        if (auth()->check()) {
            $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('product_id', $id)->delete();
            WishlistPaid::where('user_id', auth()->user()->id)->where('product_id', $id)->where('done', 0)->delete();
        } else {

            //// remove wishlist from guest session//////
            $guestWishlist = Session::get('wishlist');
            if (($key = array_search($id, $guestWishlist)) !== false) {
                unset($guestWishlist[$key]);
                Session::put('wishlist', $guestWishlist);
            }
        }
        return back()->with('success', trans('home.product_removed_from_wishlist'));
    }

    ////////////////////function return shippingAddress view////////////////
    public function shippingAddresses()
    {
        $user = auth()->user();
        $addresses = Address::where('user_id', $user->id)->get();
        return view('userBoard.shipping_addresses', compact('user', 'addresses'));
    }

    ////////////////////function return add shipping Address view////////////////
    public function addShippingAddress()
    {
        $user = auth()->user();
        $countries = Country::where('status', 1)->get();

        session()->put('address', 'shipping_address');
        return view('userBoard.addAddress', compact('user', 'countries'));
    }


    public function storeAddress(Request $request)
    {

        $userAddresses = Address::where('user_id', auth()->user()->id)->get();
        if (count($userAddresses) > 0) {
            if ($request->is_primary == 1) {
                foreach ($userAddresses as $address) {
                    $address->is_primary = 0;
                    $address->save();
                }
            }
            $address = new Address();
            $address->user_id = auth()->user()->id;
            $address->country_id = $request->country_id;
            $address->region_id = $request->region_id;
            $address->area_id = $request->area_id;
            $address->is_primary = $request->is_primary;
            $address->phone1 = $request->phone1;
            $address->phone2 = $request->phone2;
            $address->address = $request->address;
            $address->lat = $request->latitude;
            $address->lng = $request->longtude;
            $address->land_mark = $request->land_mark;
            $address->save();
            return back()->with('success', trans('home.new address created successfully'));
        } else {
            $address = new Address();
            $address->user_id = auth()->user()->id;
            $address->country_id = $request->country_id;
            $address->region_id = $request->region_id;
            $address->area_id = $request->area_id;
            $address->is_primary = 1;
            $address->phone1 = $request->phone1;
            $address->phone2 = $request->phone2;
            $address->address = $request->address;
            $address->lat = $request->latitude;
            $address->lng = $request->longtude;
            $address->land_mark = $request->land_mark;
            $address->save();

            if (session()->has('return-to-checkout')) {
                session()->forget('return-to-checkout');
                return back()->with('success', trans('home.new address created successfully'));
            } else {
                return back()->with('success', trans('home.new address created successfully'));
            }
        }
    }

    ////////////////////function return edit shipping Address view////////////////
    public function editshippingAddress($id)
    {
        $user = auth()->user();
        $address = Address::where('id', $id)->where('user_id', $user->id)->first();
        if ($address) {
            $countries = Country::where('status', 1)->get();
            $regions = Region::where('country_id', $address->country_id)->where('status', 1)->get();
            $areas = Area::where('region_id', $address->region_id)->get();
            return view('userBoard.editAddress', compact('user', 'regions', 'areas', 'countries', 'address'));
        } else {
            abort('404');
        }
    }

    //////////////////////////////// edit user existing address//////////////////////////////////////////////////
    public function updateAddress($id, Request $request)
    {
        $userAddresses = Address::where('user_id', auth()->user()->id)->get();
        $address = Address::find($id);
        $address->country_id = $request->country_id;
        $address->region_id = $request->region_id;
        $address->area_id = $request->area_id;
        $address->phone1 = $request->phone1;
        $address->phone2 = $request->phone2;
        $address->address = $request->address;
        $address->lat = $request->latitude;
        $address->lng = $request->longtude;
        $address->land_mark = $request->landmark;
        if ($request->is_primary == 1) {
            foreach ($userAddresses as $user_address) {
                $user_address->is_primary = 0;
                $user_address->save();
            }
            $address->is_primary = $request->is_primary;
        } else {
            $address->is_primary = 0;
        }
        $address->save();
        return back()->with('success', trans('home.address updated successfully'));
    }

    ////////////////////////////// make user adress is aprimary address //////////////////////////////
    public function makeAddressPrimary(Request $request)
    {
        $id = $request->address_id;
        $userAddresses = Address::where('user_id', auth()->user()->id)->get();
        foreach ($userAddresses as $address) {
            $address->is_primary = 0;
            $address->save();
        }
        $address = Address::where('user_id', auth()->user()->id)->where('id', $id)->first();
        $address->is_primary = 1;
        $address->save();
        // return back()->with('success',trans('home.primary address changed successfully'));
    }

    ///////// delete user address ///////////////////////////////////////////////
    public function deleteAddress($id)
    {
        $address = Address::where('user_id', auth()->user()->id)->where('id', $id)->first();
        if ($address->is_primary == 1) {
            $primary_address_new =  Address::where('user_id', auth()->user()->id)->where('id', '!=', $id)->first();
            $primary_address_new->is_primary = 1;
            $primary_address_new->save();
        }
        $address->delete();
        return back()->with('success', trans('home.address deleted successfully'));
    }

    public function editAccount()
    {
        $user = auth()->user();
        return view('userBoard.editAccount', compact('user'));
    }

    public function updateAccountSetting(Request $request)
    {
        $user = User::find(auth()->user()->id);
        if ($request->invoice_address && $request->shipping_address) {
            $user->invoice_address = $request->invoice_address ? $request->invoice_address : $user->invoice_address;
            $user->shipping_address = $request->shipping_address ? $request->shipping_address : $user->shipping_address;
            return redirect()->back()->with('success', trans('home.account settings updated successfully'));
        }


        $user->f_name = $request->f_name ? $request->f_name : $user->f_name;
        $user->l_name = $request->l_name ? $request->l_name : $user->l_name;
        $user->phone = $request->phone ? $request->phone : $user->phone;
        if ($request->email) {
            $user->email = $request->email;
        }
        if ($request->hasFile("image")) {

            $saveImage = new SaveImageTo3Path(request()->file('image'),true);
            $fileName = $saveImage->saveImages('users');
            SaveImageTo3Path::deleteImage($user->image,'users');
            $user->image = $fileName;
        }
        $user->save();

        ////// change password////
        if ($request->cur_password && $request->new_password && $request->conf_password) {
            $request->validate([
                'cur_password' => ['required', new MatchOldPassword],
                'new_password' => ['required'],
                'conf_password' => ['same:new_password'],
            ]);

            $user->password = Hash::make($request->new_password);
            $user->save();

            ////// send email//////
            //    	    Mail::send('emails/passwordChanged', [], function($msg) use ($user) {
            //      			$msg->to($user ->email, 'Naguib Selim')->subject('Password Changed');
            //      			$msg->from(config('mail.from.address'),config('mail.from.name'));
            //    		});

            return redirect()->back()->with('success', trans('home.password changed successfully'));
        }

        ////// send email//////
        //	    Mail::send('emails/userDateChanged', [], function($msg) use ($user) {
        //  			$msg->to($user ->email, 'Naguib Selim')->subject('User Date Changed');
        //  			$msg->from(config('mail.from.address'),config('mail.from.name'));
        //		});

        return redirect()->back()->with('success', trans('home.account settings updated successfully'));
    }

    /////FUNCTION RETURN ORDERS VIEW///////////////
    public function orders()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->orderBy('id', 'DESC')->get();
        $orderIds = Order::where('user_id', $user->id)->pluck('id')->toArray();
        $orderProduct = OrderProduct::whereIn('order_id', $orderIds)->pluck('product_id')->toArray();
        $checkRateRevivew = ProductReview::where('user_id', $user->id)->pluck('product_id')->toArray();
        return view('userBoard.orders', compact('user', 'orders', 'checkRateRevivew'));
    }

    public function trackOrder($id)
    {
        $user = auth()->user();
        $order = Order::where('id', $id)->where('user_id', $user->id)->first();
        if ($order) {
            $orderStatus = OrderStatus::where('order_id', $order->id)->get();
            $status = OrderStatus::where('order_id', $order->id)->pluck('status')->toArray();
            $checkRateRevivew = ProductReview::where('user_id', $user->id)->pluck('product_id')->toArray();
            return view('userBoard.trackOrder', compact('orderStatus', 'status', 'user', 'order', 'checkRateRevivew'));
        } else {
            abort('404');
        }
    }
    public function orderTracking(Request $request)
    {
        $user = auth()->user();
        $track_code = str_replace("#", "", $request->tracking_code);
        $tracking_order = Order::where('user_id', $user->id)->where('tracking_code', $track_code)->first();
        if ($tracking_order) {
            return back()->with('tracking_order', $tracking_order);
        } else {
            return back()->with('error', __('home.order_tracking_error'));
        }
    }

    ////// FUNCTION ADD TO CART//////////
    public function addToCart()
    {
        $attributeValuesIds = $_POST['attributeValuesIds'];
        $optionsIds = $_POST['optionsIds'];
        $productId = $_POST['productId'];
        $colorId = $_POST['colorId'];
        $quantity = $_POST['quantity'];

        if ($attributeValuesIds == 0) {
            $attributeValuesIds = [];
        }

        if ($optionsIds == 0) {
            $optionsIds = [];
        }

        $product = Product::find($productId);

        if (auth()->check()) {
            /////// CHECK USER CART /////////////////
            $userCart = Cart::where('user_id', auth()->user()->id)->first();
            if (!$userCart) {
                /////create user cart///
                $cart = new Cart();
                $cart->user_id = auth()->user()->id;
                $cart->save();
            }
            $cart = Cart::where('user_id', auth()->user()->id)->first();

            $cartProduct = CartProduct::where('product_id', $productId)->where('user_id', auth()->user()->id)->orderBy('id', 'desc')->first();
            if (!$cartProduct) {
                //////ADD CART PRODUCT ////////
                $add = new CartProduct();
                $add->cart_id = $cart->id;
                $add->user_id = auth()->user()->id;
                $add->product_id = $productId;
                $add->color_id = $colorId;
                if ($product->discount()) {
                    $add->price = $product->price - $product->discount();
                    $add->price_before_disc = $product->price;
                } else {
                    $add->price = $product->price;
                    $add->price_before_disc = $product->price;
                }

                $add->quantity = $quantity;
                $add->save();

                ///////ADD CART PRODUCT OPTIONS/////
                foreach ($optionsIds as $optionId) {
                    $option = ProductOption::find($optionId);

                    $cartProOption = new CartProductOption();
                    $cartProOption->cart_id = $cart->id;
                    $cartProOption->cart_product_id = $add->id;
                    $cartProOption->option_id = $optionId;
                    $cartProOption->price = $option->price;
                    $cartProOption->save();
                }

                //////ADD CART PRODUCT ATTRIBUTE VALUES////////
                foreach ($attributeValuesIds as $attributeValueId) {
                    $cartProAttrValue = new CartProductAttributeValue();
                    $cartProAttrValue->cart_id = $cart->id;
                    $cartProAttrValue->cart_product_id = $add->id;
                    $cartProAttrValue->attribute_value_id = $attributeValueId;
                    $cartProAttrValue->save();
                }

                $status = 'add';

                /////// update cart info////
                $cart->products_price += $add->price * $quantity;
                $cart->total_price += $add->price * $quantity;
                $cart->coupon_discount = NULL;
                $cart->coupon_id = NULL;
                $cart->save();

                $cartCount = CartProduct::where('cart_id', $cart->id)->count();
                $cartProduct = $add;
                return response()->json([
                    'cartCount' => $cartCount,
                    'html' => view('website.partials.cartProduct', compact('cartProduct', 'cart'))->render(),
                ]);
            } else {

                $cartProductOptionsIds = CartProductOption::where('cart_id', $cart->id)->where('cart_product_id', $cartProduct->id)->pluck('option_id')->toArray();
                $cartProductAttributeValuesIds = CartProductAttributeValue::where('cart_id', $cart->id)->where('cart_product_id', $cartProduct->id)->pluck('attribute_value_id')->toArray();

                $checkOptions = [];
                $checkAttributeValues = [];
                $checkOptions = array_diff($cartProductOptionsIds, $optionsIds);
                $checkAttributeValues = array_diff($cartProductAttributeValuesIds, $attributeValuesIds);

                if (count($checkAttributeValues) == 0 && $cartProduct->color_id == $colorId) {

                    if ($cartProduct->quantity + $quantity > 5) {
                        $diffQty = 5 - $cartProduct->quantity;

                        $cartProduct->quantity = 5;
                        $cartProduct->save();

                        /////// update cart info////
                        $cart->products_price += $cartProduct->price * $diffQty;
                        $cart->total_price += $cartProduct->price * $diffQty;
                        $cart->coupon_discount = NULL;
                        $cart->coupon_id = NULL;
                        $cart->save();
                    } else {
                        $cartProduct->quantity += $quantity;
                        $cartProduct->save();

                        /////// update cart info////
                        $cart->products_price += $cartProduct->price * $quantity;
                        $cart->total_price += $cartProduct->price * $quantity;
                        $cart->coupon_discount = NULL;
                        $cart->coupon_id = NULL;
                        $cart->save();
                    }

                    $status = 'add_again';

                    $cartCount = CartProduct::where('cart_id', $cart->id)->count();
                    $cartProduct = $cartProduct;
                    return response()->json([
                        'cartCount' => $cartCount,
                        'html' => view('website.partials.cartProduct', compact('cartProduct', 'cart'))->render(),
                    ]);
                } else {

                    if (count($checkOptions) == 0) {

                        if ($cartProduct->quantity + $quantity > 5) {
                            $diffQty = 5 - $cartProduct->quantity;

                            $cartProduct->quantity = 5;
                            $cartProduct->save();

                            /////// update cart info////
                            $cart->products_price += $cartProduct->price * $diffQty;
                            $cart->total_price += $cartProduct->price * $diffQty;
                            $cart->coupon_discount = NULL;
                            $cart->coupon_id = NULL;
                            $cart->save();
                        } else {
                            $cartProduct->quantity += $quantity;
                            $cartProduct->save();

                            /////// update cart info////
                            $cart->products_price += $cartProduct->price * $quantity;
                            $cart->total_price += $cartProduct->price * $quantity;
                            $cart->coupon_discount = NULL;
                            $cart->coupon_id = NULL;
                            $cart->save();
                        }

                        $status = 'add_again';

                        $cartCount = CartProduct::where('cart_id', $cart->id)->count();
                        $cartProduct = $cartProduct;
                        return response()->json([
                            'cartCount' => $cartCount,
                            'html' => view('website.partials.cartProduct', compact('cartProduct', 'cart'))->render(),
                        ]);
                    }

                    //////ADD CART PRODUCT ////////
                    $add = new CartProduct();
                    $add->cart_id = $cart->id;
                    $add->user_id = auth()->user()->id;
                    $add->product_id = $productId;
                    $add->color_id = $colorId;
                    if ($product->discount()) {
                        $add->price = $product->price - $product->discount();
                        $add->price_before_disc = $product->price;
                    } else {
                        $add->price = $product->price;
                        $add->price_before_disc = $product->price;
                    }

                    $add->quantity = $quantity;
                    $add->save();

                    ///////ADD CART PRODUCT OPTIONS/////
                    foreach ($optionsIds as $optionId) {
                        $option = ProductOption::find($optionId);

                        $cartProOption = new CartProductOption();
                        $cartProOption->cart_id = $cart->id;
                        $cartProOption->cart_product_id = $add->id;
                        $cartProOption->option_id = $optionId;
                        $cartProOption->price = $option->price;
                        $cartProOption->save();
                    }

                    //////ADD CART PRODUCT ATTRIBUTE VALUES////////
                    foreach ($attributeValuesIds as $attributeValueId) {
                        $cartProAttrValue = new CartProductAttributeValue();
                        $cartProAttrValue->cart_id = $cart->id;
                        $cartProAttrValue->cart_product_id = $add->id;
                        $cartProAttrValue->attribute_value_id = $attributeValueId;
                        $cartProAttrValue->save();
                    }
                    $status = 'add';

                    //////// update cart info////
                    $cart->products_price += $add->price * $quantity;
                    $cart->total_price += $add->price * $quantity;
                    $cart->coupon_discount = NULL;
                    $cart->coupon_id = NULL;
                    $cart->save();

                    $cartCount = CartProduct::where('cart_id', $cart->id)->count();
                    $cartProduct = $add;
                    return response()->json([
                        'cartCount' => $cartCount,
                        'html' => view('website.partials.cartProduct', compact('cartProduct', 'cart'))->render(),
                    ]);
                }
            }
        } else {
            if (!Session::has('session_id')) {
                Session::put('session_id', mt_rand());
            }

            $guestCart = GuestCart::where('session_id', Session::get('session_id'))->first();
            if (!$guestCart) {
                /////create user cart///
                $cart = new GuestCart();
                $cart->session_id = Session::get('session_id');
                $cart->save();
            }
            $cart = GuestCart::where('session_id', Session::get('session_id'))->first();

            $cartProduct = GuestCartProduct::where('product_id', $productId)->where('guest_cart_id', $cart->id)->orderBy('id', 'desc')->first();

            if (!$cartProduct) {
                //////ADD CART PRODUCT ////////
                $add = new GuestCartProduct();
                $add->guest_cart_id = $cart->id;
                $add->session_id = Session::get('session_id');
                $add->product_id = $productId;
                $add->color_id = $colorId;
                if ($product->discount()) {
                    $add->price = $product->price - $product->discount();
                    $add->price_before_disc = $product->price;
                } else {
                    $add->price = $product->price;
                    $add->price_before_disc = $product->price;
                }

                $add->quantity = $quantity;
                $add->save();

                ///////ADD CART PRODUCT OPTIONS/////
                foreach ($optionsIds as $optionId) {
                    $option = GuestCartProductOption::find($optionId);

                    $cartProOption = new GuestCartProductOption();
                    $cartProOption->guest_cart_id = $cart->id;
                    $cartProOption->cart_product_id = $add->id;
                    $cartProOption->option_id = $optionId;
                    $cartProOption->price = $option->price;
                    $cartProOption->save();
                }

                //////ADD CART PRODUCT ATTRIBUTE VALUES////////
                foreach ($attributeValuesIds as $attributeValueId) {
                    $cartProAttrValue = new GuestCartProductAttribute();
                    $cartProAttrValue->guest_cart_id = $cart->id;
                    $cartProAttrValue->cart_product_id = $add->product_id;
                    $cartProAttrValue->attribute_value_id = $attributeValueId;
                    $cartProAttrValue->save();
                }

                $status = 'add';

                /////// update cart info////
                $cart->products_price += $add->price * $quantity;
                $cart->total_price += $add->price * $quantity;
                $cart->coupon_discount = NULL;
                $cart->coupon_id = NULL;
                $cart->save();

                $cartCount = GuestCartProduct::where('guest_cart_id', $cart->id)->count();
                $cartProduct = $add;
                return response()->json([
                    'cartCount' => $cartCount,
                    'html' => view('website.partials.cartProduct', compact('cartProduct', 'cart'))->render(),
                ]);
            } else {

                $cartProductOptionsIds = GuestCartProductOption::where('guest_cart_id', $cart->id)->where('guest_cart_product_id', $cartProduct->id)->pluck('option_id')->toArray();
                $cartProductAttributeValuesIds = GuestCartProductAttribute::where('guest_cart_id', $cart->id)->where('guest_cart_product_id', $cartProduct->product_id)->pluck('attribute_value_id')->toArray();

                $checkOptions = [];
                $checkAttributeValues = [];
                $checkOptions = array_diff($cartProductOptionsIds, $optionsIds);
                $checkAttributeValues = array_diff($cartProductAttributeValuesIds, $attributeValuesIds);

                if (count($checkAttributeValues) == 0 && $cartProduct->color_id == $colorId) {

                    if ($cartProduct->quantity + $quantity > 5) {
                        $diffQty = 5 - $cartProduct->quantity;

                        $cartProduct->quantity = 5;
                        $cartProduct->save();

                        /////// update cart info////
                        $cart->products_price += $cartProduct->price * $diffQty;
                        $cart->total_price += $cartProduct->price * $diffQty;
                        $cart->coupon_discount = NULL;
                        $cart->coupon_id = NULL;
                        $cart->save();
                    } else {
                        $cartProduct->quantity += $quantity;
                        $cartProduct->save();

                        /////// update cart info////
                        $cart->products_price += $cartProduct->price * $quantity;
                        $cart->total_price += $cartProduct->price * $quantity;
                        $cart->coupon_discount = NULL;
                        $cart->coupon_id = NULL;
                        $cart->save();
                    }

                    $status = 'add_again';

                    $cartCount = GuestCartProduct::where('guest_cart_id', $cart->id)->count();
                    $cartProduct = $cartProduct;
                    return response()->json([
                        'cartCount' => $cartCount,
                        'html' => view('website.partials.cartProduct', compact('cartProduct', 'cart'))->render(),
                    ]);
                } else {

                    if (count($checkOptions) == 0) {

                        if ($cartProduct->quantity + $quantity > 5) {
                            $diffQty = 5 - $cartProduct->quantity;

                            $cartProduct->quantity = 5;
                            $cartProduct->save();

                            /////// update cart info////
                            $cart->products_price += $cartProduct->price * $diffQty;
                            $cart->total_price += $cartProduct->price * $diffQty;
                            $cart->coupon_discount = NULL;
                            $cart->coupon_id = NULL;
                            $cart->save();
                        } else {
                            $cartProduct->quantity += $quantity;
                            $cartProduct->save();

                            /////// update cart info////
                            $cart->products_price += $cartProduct->price * $quantity;
                            $cart->total_price += $cartProduct->price * $quantity;
                            $cart->coupon_discount = NULL;
                            $cart->coupon_id = NULL;
                            $cart->save();
                        }

                        $status = 'add_again';

                        $cartCount = GuestCartProduct::where('guest_cart_id', $cart->id)->count();
                        $cartProduct = $cartProduct;
                        return response()->json([
                            'cartCount' => $cartCount,
                            'html' => view('website.partials.cartProduct', compact('cartProduct', 'cart'))->render(),
                        ]);
                    }

                    //////ADD CART PRODUCT ////////
                    $add = new GuestCartProduct();
                    $add->cart_id = $cart->id;
                    $add->session_id = Session::get('session_id');
                    $add->product_id = $productId;
                    $add->color_id = $colorId;
                    if ($product->discount()) {
                        $add->price = $product->price - $product->discount();
                        $add->price_before_disc = $product->price;
                    } else {
                        $add->price = $product->price;
                        $add->price_before_disc = $product->price;
                    }

                    $add->quantity = $quantity;
                    $add->save();

                    ///////ADD CART PRODUCT OPTIONS/////
                    foreach ($optionsIds as $optionId) {
                        $option = GuestCartProductOption::find($optionId);

                        $cartProOption = new GuestCartProductOption();
                        $cartProOption->guest_cart_id = $cart->id;
                        $cartProOption->cart_product_id = $add->id;
                        $cartProOption->option_id = $optionId;
                        $cartProOption->price = $option->price;
                        $cartProOption->save();
                    }

                    //////ADD CART PRODUCT ATTRIBUTE VALUES////////
                    foreach ($attributeValuesIds as $attributeValueId) {
                        $cartProAttrValue = new GuestCartProductAttribute();
                        $cartProAttrValue->guest_cart_id = $cart->id;
                        $cartProAttrValue->cart_product_id = $add->product_id;
                        $cartProAttrValue->attribute_value_id = $attributeValueId;
                        $cartProAttrValue->save();
                    }
                    $status = 'add';

                    //////// update cart info////
                    $cart->products_price += $add->price * $quantity;
                    $cart->total_price += $add->price * $quantity;
                    $cart->coupon_discount = NULL;
                    $cart->coupon_id = NULL;
                    $cart->save();

                    $cartCount = CartProduct::where('guest_cart_id', $cart->id)->count();
                    $cartProduct = $add;
                    return response()->json([
                        'cartCount' => $cartCount,
                        'html' => view('website.partials.cartProduct', compact('cartProduct', 'cart'))->render(),
                    ]);
                }
            }
        }
    }
    public function showCart()
    {
        $productId = $_POST['productId'];
        $cartProduct = Product::find($productId);

        return response()->json([
            'html' => view('website.partials.cartProduct', compact('cartProduct'))->render(),
        ]);
    }
    public function cardAddToCart()
    {
        $productId = $_POST['productId'];
        $attribute_value_id = $_POST['attribute_value_id'];
        $product = Product::find($productId);

        if ($attribute_value_id == 0) {
            $attribute_value_id = $product->price_options[0]['attribute_value_id'];
            $product_price = $product->condition_discount_product_page($attribute_value_id);
        } else {
            $attribute_option = ProductOption::where('product_id', $productId)->where('attribute_value_id', $attribute_value_id)->first();
            if ($product->discount() > 0) {
                $product_price = $product->condition_discount_product_page($attribute_value_id);
            } else {
                $product_price = $product->condition_discount_product_page($attribute_value_id);
            }
        }

        $productAttributeIds = ProductAttribute::where('product_id', $productId)->distinct('attribute_id')->pluck('attribute_id')->toArray();
        $attributeValuesIds = [];
        $color = ProductColor::where('product_id', $productId)->first();
        if ($color) {
            $colorId = $color->id;
        } else {
            $colorId = 1;
        }

        foreach ($productAttributeIds as $productAttributeId) {
            $valueId = AttributeValue::where('attribute_id', $productAttributeId)->first()->id;
            array_push($attributeValuesIds, $valueId);
        }

        if (auth()->check()) {
            /////// CHECK USER CART /////////////////
            $userCart = Cart::where('user_id', auth()->user()->id)->first();
            if (!$userCart) {
                /////create user cart///
                $cart = new Cart();
                $cart->user_id = auth()->user()->id;
                $cart->save();
            }
            $cart = Cart::where('user_id', auth()->user()->id)->first();

            $cartProduct = CartProduct::where('product_id', $productId)->where('cart_id', $cart->id)->where('user_id', auth()->user()->id)->orderBy('id', 'desc')->first();

            if (!$cartProduct) {
                //////ADD CART PRODUCT ////////
                $add = new CartProduct();
                $add->cart_id = $cart->id;
                $add->user_id = auth()->user()->id;
                $add->product_id = $productId;
                $add->color_id = $colorId;
                if ($product->discount()) {
                    $add->price = $product_price;
                    $add->price_before_disc = $product->old_price_product_with_attribute($attribute_value_id);
                } else {
                    $add->price = $product_price;
                    $add->price_before_disc = $product->old_price_product_with_attribute($attribute_value_id);
                }

                $add->quantity = 1;
                $add->save();


                //////ADD CART PRODUCT ATTRIBUTE VALUES////////
                foreach ($attributeValuesIds as $attributeValueId) {

                    $cartProAttrValue = new CartProductAttributeValue();
                    $cartProAttrValue->cart_id = $cart->id;
                    $cartProAttrValue->cart_product_id = $add->product_id;
                    $cartProAttrValue->attribute_value_id = $attribute_value_id;
                    $cartProAttrValue->save();
                }

                /////// update cart info////
                $cart->products_price += $add->price * $add->quantity;
                $cart->total_price += $add->price * $add->quantity;
                $cart->coupon_discount = NULL;
                $cart->coupon_id = NULL;
                $cart->save();

                $status = 'add';

                $cartCount = CartProduct::where('cart_id', $cart->id)->count();
                $cartProduct = $add;
                $cartProds = CartProduct::with('product')->where('cart_id', $cart->id)->get();
                $totalPrice = $cart->total_price;
                return response()->json([
                    'html' => view('website.partials.sideCartProduct', compact('cartProds', 'cartCount', 'cart'))->render(),
                    'cartCount' => $cartCount,
                    'text' => __('home.your_item_added_successfully'),
                    'type' => 'Success',
                    'product_image' => Helper::uploadedImagesPath('products', $product->firstImage()->image),
                    'totalPrice' => $totalPrice
                ]);
            } else {
                if ($cartProduct->quantity + 1 <= 5) {
                    $cartProduct->quantity += 1;
                    $cartProduct->save();

                    /////// update cart info////
                    $cart->products_price += $cartProduct->price;
                    $cart->total_price += $cartProduct->price;
                    $cart->coupon_discount = NULL;
                    $cart->coupon_id = NULL;
                    $cart->save();
                }

                $cartCount = CartProduct::where('cart_id', $cart->id)->count();
                $cartProduct = $cartProduct;
                $cartProds = CartProduct::with('product')->where('cart_id', $cart->id)->get();
                $totalPrice = $cart->total_price;
                return response()->json([
                    'html' => view('website.partials.sideCartProduct', compact('cartProds', 'cartCount', 'cart'))->render(),
                    'cartCount' => $cartCount,
                    'text' => __('home.your_item_added_successfully'),
                    'type' => 'Success',
                    'product_image' => Helper::uploadedImagesPath('products', $product->firstImage()->image),
                    'totalPrice' => $totalPrice
                ]);
            }
        } else {

            if (!Session::has('session_id')) {
                Session::put('session_id', mt_rand());
            }

            $guestCart = GuestCart::where('session_id', Session::get('session_id'))->first();
            if (!$guestCart) {
                /////create user cart///
                $cart = new GuestCart();
                $cart->session_id = Session::get('session_id');
                $cart->save();
            }
            $cart = GuestCart::where('session_id', Session::get('session_id'))->first();

            $cartProduct = GuestCartProduct::where('product_id', $productId)->where('guest_cart_id', $cart->id)->orderBy('id', 'desc')->first();
            if (!$cartProduct) {
                //////ADD CART PRODUCT ////////
                $add = new GuestCartProduct();
                $add->guest_cart_id = $cart->id;
                $add->session_id = Session::get('session_id');
                $add->product_id = $productId;
                $add->color_id = $colorId;
                if ($product->discount()) {
                    $add->price = $product_price;
                    $add->price_before_disc = $product->old_price_product_with_attribute($attribute_value_id);
                } else {
                    $add->price = $product_price;
                    $add->price_before_disc = $product->old_price_product_with_attribute($attribute_value_id);
                }

                $add->quantity = 1;
                $add->save();

                //////ADD CART PRODUCT ATTRIBUTE VALUES////////
                foreach ($attributeValuesIds as $attributeValueId) {
                    $cartProAttrValue = new GuestCartProductAttribute();
                    $cartProAttrValue->guest_cart_id = $cart->id;
                    $cartProAttrValue->guest_cart_product_id = $add->product_id;
                    $cartProAttrValue->attribute_value_id = $attribute_value_id;
                    $cartProAttrValue->save();
                }

                /////// update cart info////
                $cart->products_price += $add->price;
                $cart->total_price += $add->price;
                $cart->coupon_discount = NULL;
                $cart->coupon_id = NULL;
                $cart->save();


                $status = 'add';

                $cartCount = GuestCartProduct::where('guest_cart_id', $cart->id)->count();
                $cartProduct = $add;
                $cartProds = GuestCartProduct::with('product')->where('guest_cart_id', $cart->id)->get();
                $totalPrice = $cart->total_price;
                return response()->json([
                    'html' => view('website.partials.sideCartProduct', compact('cartProds', 'cartCount', 'cart'))->render(),
                    'cartCount' => $cartCount,
                    'text' => __('home.your_item_added_successfully'),
                    'type' => 'Success',
                    'product_image' => Helper::uploadedImagesPath('products', $product->firstImage()->image),
                    'totalPrice' => $totalPrice
                ]);
            } else {
                if ($cartProduct->quantity + 1 <= 5) {
                    $cartProduct->quantity += 1;
                    $cartProduct->save();

                    /////// update cart info////
                    $cart->products_price += $cartProduct->price;
                    $cart->total_price += $cartProduct->price;
                    $cart->coupon_discount = NULL;
                    $cart->coupon_id = NULL;
                    $cart->save();
                }
                $cartCount = GuestCartProduct::where('guest_cart_id', $cart->id)->count();
                $cartProds = GuestCartProduct::with('product')->where('guest_cart_id', $cart->id)->get();

                $totalPrice = $cart->total_price;
                return response()->json([
                    'html' => view('website.partials.sideCartProduct', compact('cartProds', 'cartCount', 'cart'))->render(),
                    'cartCount' => $cartCount,
                    'text' => __('home.your_item_added_successfully'),
                    'type' => 'Success',
                    'product_image' => Helper::uploadedImagesPath('products', $product->firstImage()->image),
                    'totalPrice' => $totalPrice
                ]);
            }
        }
    }

    ////////////////////FUNCTION RETURNSHOPPING CART////////////////

    public function getShoppingCart()
    {
        $shippingMethods = ShippingMethod::where('status', 1)->get();
        $user = User::find(auth()->user()->id);
        $userCart = Cart::where('user_id', auth()->user()->id)->first();
        if (auth()->check()) {
            /////// CHECK USER CART /////////////////
            if (!$userCart) {
                /////create user cart///
                $cart = new Cart();
                $cart->user_id = auth()->user()->id;
                $cart->save();
            }
            $cart = Cart::where('user_id', auth()->user()->id)->first();
            $cartProducts = CartProduct::where('cart_id', $cart->id)->get();

            if (count($cartProducts) == 0) {
                return view('userBoard.emptyCart');
            } else {
                foreach ($cartProducts as $cartProduct) {
                    $product = Product::find($cartProduct->product_id);
                    if ($product->discount() > 0) {
                        $product_price = $product->condition_discount_product_page($cartProduct->productAttributeValues()->id);
                    } else {
                        $product_price = $product->condition_discount_product_page($cartProduct->productAttributeValues()->id);
                    }
                    $category_id = $product->category_id;
                    /////// CHECK DISCOUNT IS AVAILABLE OR NOT////////
                    if ($product->discount() > 0) {
                        $cartProduct->price = $product_price;
                        $cartProduct->price_before_disc = $product->old_price_product_with_attribute($cartProduct->productAttributeValues()->id);
                        $cartProduct->save();
                    }
                    ///////CHECK PRODUCT STOCK AVAILABLE OR NOT////////
                    if ($product->stock == 0) {
                        $cartProduct->delete();
                    }
                }
                ///////// CHeck coupon expired or not //////////
                if ($cart->coupon_id != NULL) {
                    $coupon = Coupon::find($userCart->coupon_id);
                    if (date("Y-m-d") > $coupon->expire_date) {
                        $cart->coupon_id = NULL;
                        $cart->coupon_discount = NULL;
                        $cart->save();
                    }
                }
                $primaryAddress = Address::where('is_primary', 1)->where('user_id', $user->id)->first();
                if (!$primaryAddress) {
                    return redirect('user/account-settings')->with(['error' => 'لم تقم بتسجيل عنوان بعد']);
                }
                $area = Area::where('id', $primaryAddress->area_id)->first();
                $region = Region::where('id', $primaryAddress->region_id)->first();
                $paymentMethods = PaymentMethod::where('status', 1)->get();
                $shippingMethods = ShippingMethod::where('status', 1)->get();
                $cartproductShipping = DB::table('cart_products')
                    ->leftJoin('products', 'products.id', '=', 'cart_products.product_id')
                    ->select('products.shipping_fees')
                    ->where('cart_products.user_id', auth()->user()->id)
                    ->orderBy('products.shipping_fees', 'DESC')->first();
                $shippingFees = 0;

                if ($cartproductShipping) {
                    if ($area->shipping_fees) {
                        $shippingFees = $cartproductShipping->shipping_fees * $area->shipping_fees * $region->shipping_fees;
                    } else {
                        $shippingFees = $cartproductShipping->shipping_fees * $region->shipping_fees;
                    }
                }
                ////////// get Total price //////////
                $cartProductsPrice = CartProduct::where('cart_id', $cart->id)->sum(DB::raw('price * quantity'));
                $cartProductOptionsPrice = CartProductOption::where('cart_id', $cart->id)->sum('price');


                $productPrices = [];
                $cartProductOptionsPrice = [];

                $cartProds = CartProduct::where('cart_id', $cart->id)->select(DB::raw('price * quantity as price'), 'id', 'quantity')->get();
                foreach ($cartProds as $cartProduct) {
                    $cartProductOptionsPrice = CartProductOption::where('cart_product_id', $cartProduct->product_id)->sum('price');
                    array_push($productPrices, $cartProduct->price + ($cartProductOptionsPrice * $cartProduct->quantity));
                }

                $productsPrice = array_sum($productPrices);
                $couponDiscount = $cart->coupon_discount;
                $totalPrice = $productsPrice - $couponDiscount;


                /////// upate cart details ////////
                $cart->products_price = $productsPrice;
                $cart->coupon_discount = $couponDiscount;
                $cart->total_price = $productsPrice - $couponDiscount;
                $cart->save();
                $relatedProducts = Product::where('stock', '>', 0)->where('status', 1)->where('category_id', $category_id)->orderBy('visits', 'desc')->get()->shuffle();

                return view('userBoard.shoppingCart', compact('cartProducts', 'shippingFees', 'productsPrice', 'cart', 'totalPrice', 'couponDiscount', 'user', 'shippingMethods', 'relatedProducts'));
            }
        } else {

            if (!Session::has('session_id')) {
                Session::put('session_id', mt_rand());
            }

            $guestCart = GuestCart::where('session_id', Session::get('session_id'))->first();
            if (!$guestCart) {
                /////create user cart///
                $cart = new GuestCart();
                $cart->session_id = Session::get('session_id');
                $cart->save();
            }

            $cart = GuestCart::where('session_id', Session::get('session_id'))->first();
            $cartProducts = GuestCartProduct::where('guest_cart_id', $cart->id)->get();

            if (count($cartProducts) == 0) {
                return view('userBoard.emptyCart');
            } else {
                foreach ($cartProducts as $cartProduct) {
                    $product = Product::find($cartProduct->product_id);
                    if ($product->discount() > 0) {
                        $product_price = $product->condition_discount_product_page($cartProduct->productAttributeValues()->id);
                    } else {
                        $product_price = $product->condition_discount_product_page($cartProduct->productAttributeValues()->id);
                    }
                    $productDiscount = ProductDiscount::where('product_id', $cartProduct->product_id)->whereRaw('(now() between start_date and end_date)')->first();
                    $category_id = $product->category_id;

                    /////// CHECK DISCOUNT IS AVAILABLE OR NOT////////
                    if (!$productDiscount) {
                        $cartProduct->price = $product_price;
                        $cartProduct->price_before_disc = $product->old_price_product_with_attribute($cartProduct->productAttributeValues()->id);
                        $cartProduct->save();
                    }
                    ///////CHECK PRODUCT STOCK AVAILABLE OR NOT////////
                    if ($product->stock == 0) {
                        $cartProduct->delete();
                    }
                }

                ///////// CHeck coupon expired or not //////////
                if ($cart->coupon_id != NULL) {
                    $coupon = Coupon::find($userCart->coupon_id);
                    if (date("Y-m-d") > $coupon->expire_date) {
                        $cart->coupon_id = NULL;
                        $cart->coupon_discount = NULL;
                        $cart->save();
                    }
                }

                ////////// get Total price //////////
                $cartProductsPrice = GuestCartProduct::where('guest_cart_id', $cart->id)->sum(DB::raw('price * quantity'));
                $cartProductOptionsPrice = GuestCartProductOption::where('guest_cart_id', $cart->id)->sum('price');
                $productPrices = [];
                $cartProductOptionsPrice = [];

                $cartProds = GuestCartProduct::where('guest_cart_id', $cart->id)->select(DB::raw('price * quantity as price'), 'id', 'quantity')->get();
                foreach ($cartProds as $cartProduct) {
                    $cartProductOptionsPrice = GuestCartProductOption::where('guest_cart_product_id', $cartProduct->product_id)->sum('price');
                    array_push($productPrices, $cartProduct->price + ($cartProductOptionsPrice * $cartProduct->quantity));
                }
                $productsPrice = array_sum($productPrices);

                $couponDiscount = $cart->coupon_discount;
                $totalPrice = $productsPrice - $couponDiscount;

                /////// upate cart details ////////
                $cart->products_price = $productsPrice;
                $cart->coupon_discount = $couponDiscount;
                $cart->total_price = $productsPrice - $couponDiscount;
                $cart->save();
                $relatedProducts = Product::where('stock', '>', 0)->where('status', 1)->where('category_id', $category_id)->orderBy('visits', 'desc')->get()->shuffle();
                return view('userBoard.shoppingCart', compact('cartProducts', 'productsPrice', 'cart', 'totalPrice', 'couponDiscount', 'shippingMethods', 'relatedProducts'));
            }
        }
    }

    /////////remove product from cart /////
    public function removeCartProduct(Request $request)
    {
        if (auth()->check()) {
            $cartProduct = CartProduct::find($request->CartProductId);

            //////// delete coupon discount if exist/////
            $cart = Cart::find($cartProduct->cart_id);
            $cart->coupon_id = NULL;
            $cart->coupon_discount = NULL;
            $cart->products_price -= $cartProduct->price * $cartProduct->quantity;
            $cart->total_price -= $cartProduct->price * $cartProduct->quantity;
            $cart->save();

            $cartProduct->delete();
            $cartProductOptions = CartProductOption::where('cart_id', $cartProduct->cart_id)->where('cart_product_id', $request->product_id)->delete();
            $cartProductOptions = CartProductAttributeValue::where('cart_id', $cartProduct->cart_id)->where('cart_product_id', $request->CartProductId)->delete();
        } else {
            $cartProduct = GuestCartProduct::find($request->CartProductId);

            //////// delete coupon discount if exist/////
            $cart = GuestCart::find($cartProduct->guest_cart_id);
            $cart->coupon_id = NULL;
            $cart->coupon_discount = NULL;
            $cart->products_price -= $cartProduct->price * $cartProduct->quantity;
            $cart->total_price -= $cartProduct->price * $cartProduct->quantity;
            $cart->save();

            $cartProduct->delete();
            $cartProductOptions = GuestCartProductOption::where('guest_cart_id', $cartProduct->guest_cart_id)->where('guest_cart_product_id', $request->CartProductId)->delete();
            $cartProductOptions = GuestCartProductAttribute::where('guest_cart_id', $cartProduct->guest_cart_id)->where('guest_cart_product_id', $request->CartProductId)->delete();
        }
        return  back()->with('success', trans('home.product_removed_from_cart'));
    }
    /////////remove product from cart /////
    public function removeCartAllProduct()
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->user()->id)->first();
            $cart->coupon_id = NULL;
            $cart->coupon_discount = NULL;
            $cart->products_price = 0;
            $cart->total_price = 0;
            $cart->save();

            $cartProduct = CartProduct::where('user_id', auth()->user()->id)->where('cart_id', $cart->id)->delete();

            //////// delete coupon discount if exist/////
            $cartProductOptions = CartProductOption::where('cart_id', $cart->id)->delete();
            $cartProductOptions = CartProductAttributeValue::where('cart_id', $cart->id)->delete();
        } else {
            $cart = GuestCart::where('session_id', Session::get('session_id'))->first();
            $cart->coupon_id = NULL;
            $cart->coupon_discount = NULL;
            $cart->products_price = 0;
            $cart->total_price = 0;
            $cart->save();
            $cartProduct = GuestCartProduct::where('guest_cart_id', $cart->id)->delete();

            //////// delete coupon discount if exist/////
            $cartProductOptions = GuestCartProductOption::where('guest_cart_id', $cart->id)->delete();
            $cartProductOptions = GuestCartProductAttribute::where('guest_cart_id', $cart->id)->delete();
        }
        return  back()->with('success', trans('home.product_removed_from_cart'));
    }

    /////////////// function changeCartProductCount//////////////////////////
    public function changeCartProductQuantity()
    {
        $cartProductId = $_POST['cart_id'];
        $sign = $_POST['sign'];
        $shippingMethods = ShippingMethod::where('status', 1)->get();
        $setting = Setting::first();

        if (auth()->check()) {
            $cartProduct = CartProduct::find($cartProductId);
            $cart = Cart::where('user_id', auth()->user()->id)->where('id', $cartProduct->cart_id)->first();
            $quantity = $cartProduct->quantity;
            $n_stock = $cartProduct->product->stockCount();
            if ($sign == 'plus') {
                if ($cartProduct->quantity + 1 <= $n_stock) {
                    $cartProduct->quantity = $quantity + 1;
                    $cartProduct->save();
                    $cart->products_price += $cartProduct->price;
                    $cart->total_price += $cartProduct->price;
                    $cart->save();
                }
            }
            if ($sign == 'minus') {
                if ($quantity > 1) {
                    $cartProduct->quantity = $quantity - 1;
                    $cartProduct->save();
                    $cart->products_price -= $cartProduct->price;
                    $cart->total_price -= $cartProduct->price;
                    $cart->save();
                }
            }
            /////// update cart info////
            $cart = Cart::find($cartProduct->cart_id);
            $cart->coupon_discount = NULL;
            $cart->coupon_id = NULL;
            $cart->save();
            $cart = Cart::find($cartProduct->cart_id);
            $product_all_price = $cartProduct->quantity * $cartProduct->price;
            $progress = 100 - (($setting->free_shipping - $cart->total_price) / $setting->free_shipping * 100);
            $all_total_price = $progress >= 100 ? $cart->total_price : $cart->total_price + $shippingMethods->first()->value;
            return response()->json(['total_price' => $cart->total_price, 'product_all_price' => $product_all_price, 'all_total_price' => $all_total_price]);
        } else {
            $cartProduct = GuestCartProduct::find($cartProductId);
            $quantity = $cartProduct->quantity;
            //            $cart=GuestCart::where('session_id',Session::get('session_id'))->where('id',$cartProduct->cart_id)->first();

            $cart = GuestCart::find($cartProduct->guest_cart_id);
            $n_stock = $cartProduct->product->stockCount();
            if ($sign == 'plus') {
                if ($cartProduct->quantity + 1 <= $n_stock) {
                    $cartProduct->quantity = $quantity + 1;
                    $cartProduct->save();
                    $cart->products_price += $cartProduct->price;
                    $cart->total_price += $cartProduct->price;
                    $cart->save();
                }
            }
            if ($sign == 'minus') {
                if ($quantity > 1) {
                    $cartProduct->quantity = $quantity - 1;
                    $cartProduct->save();
                    $cart->products_price -= $cartProduct->price;
                    $cart->total_price -= $cartProduct->price;
                    $cart->save();
                }
            }
            /////// update cart info////
            $cart = GuestCart::find($cartProduct->guest_cart_id);
            $cart->coupon_id = NULL;
            $cart->coupon_discount = NULL;
            $cart->save();
            $cart = GuestCart::find($cartProduct->guest_cart_id);
            $product_all_price = $cartProduct->quantity * $cartProduct->price;
            $progress = 100 - (($setting->free_shipping - $cart->total_price) / $setting->free_shipping * 100);
            $all_total_price = $progress >= 100 ? $cart->total_price : $cart->total_price + $shippingMethods->first()->value;
            return response()->json(['total_price' => $cart->total_price, 'product_all_price' => $product_all_price, 'all_total_price' => $all_total_price]);
        }
    }

    /////////// FUNCTION RETURN checkOut VIEW /////
    public function checkOut()
    {
        $user = auth()->user();
        $cart_products = $user->cartProducts ?? GuestCartProduct::where('session_id',session()->get('session_id'))->get();
        if (count($cart_products) > 0) {
            $data['cart_products'] = $cart_products ;
            $data['countries'] = Country::all();
            $data['payment_methods'] = PaymentMethod::where('status', 1)->get();
            $data['shipping_methods'] = ShippingMethod::where('status', 1)->get();
            return view('userBoard.checkOut',$data);
        } else {
            return redirect('/');
        }
    }

    function svaeOrder(){
        $user = auth()->user();
        if(!$user->f_name ||!$user->l_name ||!$user->email ||!$user->phone ||!$user->country_id ||!$user->region_id ||!$user->area_id ||!$user->shipping_address)
          return redirect()->back()->withErrors(__('home.Please enter all your information.'));
        if(is_string($this->checkCoupon())) return redirect()->back()->withError($this->checkCoupon());




    }

    private function checkCoupon(){
        $couponBuilder = Coupon::whereCode(request('code'));
        $coupon = $couponBuilder->isValid()->first() ;
        $product_carts = auth()->user()->cartProducts;
        $total = count($product_carts)? $product_carts->sum(function ($cartProduct) {return $cartProduct->total_product;}): 0 ;
        $new_price = (object)[];
        // if (!$coupon)return response()->json(['stutas'=> false,'message'=>__('home.Sorry Coupon Not Found')]);
        // if (!$couponBuilder->isValid())return response()->json(['stutas'=> false,'message'=>__('home.Sorry this is Expired Coupon')]);
        // if ($couponBuilder->couponUsed()->count() >= $coupon->max_used || $couponBuilder->isAuthUsed())return response()->json(['stutas'=> false,'message'=>__('home.This Coupon already in use')]);
        // if ($coupon->order_min_price > request('total_after_all_discount'))return response()->json(['stutas'=> false,'message'=>__('home.Sorry Coupon only valid for price above')]);
        if (!$coupon)return __('home.Sorry Coupon Not Found');
        if (!$couponBuilder->isValid())return __('home.Sorry this is Expired Coupon');
        if ($coupon->couponUsed()->count() >= $coupon->max_used || $coupon->isAuthUsed())return __('home.This Coupon already in use') ;
        if ($coupon->order_min_price >  $total )return __('home.Sorry Coupon only valid for price above');
        if ( $total <= 0 )return __('home.an error occurred');
        $new_price->total = $coupon->value_type == 'percentage' ?  $total - (( $total * $coupon->value) /100) :   $total - $coupon->value ;
        $new_price->value = $coupon->value_type == 'percentage' ? (( $total* $coupon->value) /100) :   $coupon->value ;
        $new_price->name  = $coupon->name ;
        $new_price->coupon_id  = $coupon->id ;
        // return response()->json(['stutas'=> false,'message'=>__('home.valid coupon'),'coupon'=>$new_price]);
        return $new_price ;
    }

    //////// FUNCTION changeShippingMethod or paymentMethod////////
    public function changeMethod()
    {
        $paymentId = $_POST['paymentId'];
        $shippingId = $_POST['shippingId'];

        $setting = Setting::first();

        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->first();
        $primaryAddress = Address::where('is_primary', 1)->where('user_id', $user->id)->first();
        $area = Area::where('id', $primaryAddress->area_id)->first();
        $region = Region::where('id', $primaryAddress->region_id)->first();
        $cart = Cart::where('user_id', $user->id)->first();
        $cartProducts = CartProduct::where('cart_id', $cart->id)->get();
        $paymentMethods = PaymentMethod::where('status', 1)->get();
        $shippingMethods = ShippingMethod::where('status', 1)->get();
        $cartproductShipping = DB::table('cart_products')
            ->leftJoin('products', 'products.id', '=', 'cart_products.product_id')
            ->select('products.shipping_fees')
            ->where('cart_products.user_id', auth()->user()->id)
            ->orderBy('products.shipping_fees', 'DESC')->first();
        $shippingFees = 0;
        if ($cartproductShipping) {
            if ($area->shipping_fees) {
                $shippingFees = $cartproductShipping->shipping_fees * $area->shipping_fees * $region->shipping_fees;
            } else {
                $shippingFees = $cartproductShipping->shipping_fees * $region->shipping_fees;
            }
        }

        if (PaymentMethod::find($paymentId)->value_type == 'value') {
            $paymentMethodFees = PaymentMethod::find($paymentId)->value;
        } else {
            $paymentMethodFees = ($cart->total_price * PaymentMethod::find($paymentId)->value) / 100;
        }

        if (ShippingMethod::find($shippingId)->value_type == 'value') {
            $shippingMethodFees = ShippingMethod::find($shippingId)->value;
        } else {
            $shippingMethodFees = ($cart->total_price * ShippingMethod::find($shippingId)->value) / 100;
        }
        if ($setting->free_shipping_status == 1 && $setting->free_shipping > 0) {
            if ($cart->total_price >= $setting->free_shipping) {
                $shippingMethodFees = 0;
            }
        }
        $totalPrice = $cart->products_price + $shippingFees + $shippingMethodFees + $paymentMethodFees + ($cart->products_price * $setting->tax) / 100 - $cart->coupon_discount;
        $shippingTotal = $shippingFees + $shippingMethodFees;
        return response()->json(['paymentMethodFees' => $paymentMethodFees, 'shippingMethodFees' => $shippingMethodFees, 'totalPrice' => $totalPrice, 'shippingTotal' => $shippingTotal]);
    }


    public function addProductReview(Request $request)
    {
        $rate = $request->rate;
        if($rate > 5){  $rate = 5; }
        elseif($rate < 1){  $rate = 1; }
        $add = new ProductReview();
        $add->user_id = auth()->user()->id;
        $add->product_id = $request->product_id;
        $add->rate = $rate;
        $add->comment = $request->comment;
        $add->save();
        if(request()->ajax()){
            return response()->json(['status'=>true,'message'=>trans('home.rate and review added successfully')]);
        }
        return back()->with('success', trans('home.rate and review added successfully'));
    }


    ////////////////////function return comapre Page view////////////////
    public function compareList()
    {
        $user = auth()->user();
        $comapreListProductsIds = ComapreList::where('user_id', $user->id)->pluck('product_id')->toArray();
        $comapreListProducts = Product::whereIn('id', $comapreListProductsIds)->get();
        if (count($comapreListProducts) > 0) {
            return view('userBoard.comapreList', compact('user', 'comapreListProducts'));
        } else {
            return view('userBoard.emptyCompareList');
        }
    }

    //////////////// ajax function that add product to CompareList///////////
    public function addCompareList()
    {
        $productId = $_POST['productId'];

        $check = ComapreList::where('product_id', $productId)->where('user_id', auth()->user()->id)->first();
        if (!$check) {
            $add = new ComapreList();
            $add->user_id = auth()->user()->id;
            $add->product_id = $productId;
            $add->save();
            $status = 'add';
        } else {
            $check->delete();
            $status = 'delete';
        }
        return response()->json($status);
    }

    /////////////// function that remove CompareList////////////
    public function removeCompareList($id)
    {
        $comapreList = ComapreList::where('user_id', auth()->user()->id)->where('product_id', $id)->delete();
        return back()->with('success', trans('home.product_removed_from_comapreList'));
    }

    public function cancelOrder(Request $request)
    {
        $order = Order::find($request->id);
        $order->status = 'canceled';
        $order->save();

        $orderStatus = new OrderStatus();
        $orderStatus->order_id = $request->id;
        $orderStatus->status = 'canceled';
        $orderStatus->save();
        return back()->with('success', trans('home.order canceled succesfully'));
    }

    ////// referesh user cart//////
    public function refreshCart()
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->user()->id)->first();
            $cartCount = CartProduct::where('cart_id', $cart->id)->count();
            $cartProds = CartProduct::where('cart_id', $cart->id)->select(DB::raw('price as price'), 'id', 'quantity', 'product_id')->get();
        } else {
            $cart = GuestCart::where('session_id', Session::get('session_id'))->first();
            $cartCount = GuestCartProduct::where('guest_cart_id', $cart->id)->count();
            $cartProds = GuestCartProduct::where('guest_cart_id', $cart->id)->select(DB::raw('price * quantity as price'), 'id', 'quantity', 'product_id')->get();
        }

        return response()->json([
            'cartCount' => $cartCount,
            // 'html' => view('website.partials.miniCart', compact('cartProds','cart'))->render(),
        ]);
    }

    /// refresh user wishlist ///////
    public function refreshWishlist()
    {
        if (auth()->check()) {
            $wishCount = Wishlist::where('user_id', auth()->user()->id)->count();
        } else {
            $guestWishlist = Session::get('wishlist');
            $wishCount = count($guestWishlist);
        }
        return response()->json(['wishCount' => $wishCount]);
    }

    public function editAddressShow(Request $request)
    {
        $id = $request->address_id;
        $address = Address::where('user_id', auth()->user()->id)->where('id', $id)->first();
        $countries = Country::where('status', 1)->get();
        return response()->json([
            'view' => view('website.partials.EditAddress', compact('address', 'countries'))->render(),
        ]);
    }
    public function get_option_price(Request $request)
    {
        $productDiscount = ProductDiscount::where('product_id', $request->product_id)->first();
        $old_price =  ProductOption::where('attribute_value_id', $request->value_id)->where('product_id', $request->product_id)->first()->price;
        if ($productDiscount && Carbon::now()->between(Carbon::parse($productDiscount->start_date), Carbon::parse($productDiscount->end_date))) {
            if ($productDiscount->value_type == 'value') {
                $discount = $old_price - $productDiscount->value;
            } else {
                $discount = $old_price - (($productDiscount->value * $old_price) / 100);
            }
        } else {
            $discount = $old_price;
        }
        return response()->json(['price' => $discount, 'old_price' => $old_price]);
    }
}
