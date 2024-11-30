<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Lang;
use App\Models\Region;
use App\Models\Page;
use App\Models\Attribute;
use App\Models\Color;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\OrderProduct;
use App\Models\User;
use Auth;
use App\Models\Winner;
use App\Models\Area;
use App\Models\GalleryImage;
use App\Models\GalleryVideo;
use App\Models\AboutStruc;
use App\Models\BlogCategory;
use App\Models\BlogItem;
use App\Models\HomeSlider;
use App\Models\IntroSlider;
use App\Models\OfferSlider;
use App\Models\ShippingMethod;
use App\Models\PaymentMethod;
use App\Models\Coupon;
use App\Models\Branche;
use App\Models\Service;
use App\Models\InstallmentPartner;
use App\Models\Stock;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    ///// function return admin index view///////
   public function admin(){
        $totalOrders = Order::count();
        $currentMonthOrders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
        $pendingOrders = Order::where('status','pending')->count();
        $pendingOrdersCost = Order::where('status','pending')->sum('total_price');


        $products = Product::all();
        $productsPrice =[];
        foreach($products as $product){
            if($product->offer_price !='' && $product->offer_price != NULL){
                array_push($productsPrice,$product->offer_price);
            }else{
                array_push($productsPrice,$product->price);
            }
        }
        $productsPrice = Stock::whereHas('product')->sum('price')??array_sum($productsPrice);
        $orderedProductsCost = OrderProduct::sum('price');

        $productsCount=Product::count();
        $orderdProductCount = OrderProduct::sum('quantity');
        $orders = Order::orderBy('id','DESC')->take(10)->get();

        $totalUsers = User::count();
        $currentMonthUsers = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $totalOrdersCost = Order::sum('total_price');
        $currentMonthOrdersCost = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->sum('total_price');
        $lastMonthOrdersCost = Order::whereYear('created_at', Carbon::now()->year)->where('created_at', '>=', Carbon::now()->subMonth()->month)->sum('total_price');

        return view('admin.index',compact('totalOrders','currentMonthOrders','pendingOrders',
        'pendingOrdersCost','productsPrice','orderedProductsCost','productsCount','orderdProductCount',
        'orders','totalUsers','currentMonthUsers','currentMonthOrdersCost','lastMonthOrdersCost','totalOrdersCost'));
    }

    ///// function set session lang of the app////
    public function setlang($lang){
        $langs = ['en', 'ar'];
        if (in_array($lang, $langs)) {
            session(['lang' => $lang]);
            return redirect()->back();
        }
    }


    ///// function publish and unpublish status////
    public function updatestatus($name,$ids)
    {
        $ids = explode(',', $ids);
        foreach ($ids as $x) {

            if($name == 'categories'){
                $update = Category::findOrFail($x);
            }

            if($name == 'countries'){
                $update = Country::findOrFail($x);
            }

            if($name == 'regions'){
                $update = Region::findOrFail($x);
            }

            if($name == 'areas'){
                $update = Area::findOrFail($x);
            }

            if($name == 'attributes'){
                $update = Attribute::findOrFail($x);
            }

            if($name == 'colors'){
                $update = Color::findOrFail($x);
            }

            if($name == 'brands'){
                $update = Brand::findOrFail($x);
            }

            if($name == 'pages'){
                $update = Page::findOrFail($x);
            }

            if($name == 'products'){
                $update = Product::findOrFail($x);
            }

            if($name == 'menus'){
                $update = Menu::findOrFail($x);
            }

            if($name == 'gallery-images'){
                $update = GalleryImage::findOrFail($x);
            }

            if($name == 'gallery-videos'){
                $update = GalleryVideo::findOrFail($x);
            }

             if($name == 'menu-items'){
                $update = MenuItem::findOrFail($x);
            }

            if($name == 'winners'){
                $update = Winner::findOrFail($x);
            }

            if($name == 'aboutStrucs'){
                $update = Menu::findOrFail($x);
            }

            if($name == 'blog-categories'){
                $update = BlogCategory::findOrFail($x);
            }

            if($name == 'blog-items'){
                $update = BlogItem::findOrFail($x);
            }

            if($name == 'home-sliders'){
                $update = HomeSlider::findOrFail($x);
            }

            if($name == 'intro-sliders'){
                $update = IntroSlider::findOrFail($x);
            }

            if($name == 'offers-sliders'){
                $update = OfferSlider::findOrFail($x);
            }

            if($name == 'shipping-methods'){
                $update = ShippingMethod::findOrFail($x);
            }

            if($name == 'payment-methods'){
                $update = PaymentMethod::findOrFail($x);
            }

            if($name == 'coupons'){
                $update = Coupon::findOrFail($x);
            }

            if($name == 'branches'){
                $update = Branche::findOrFail($x);
            }

            if($name == 'services'){
                $update = Branche::findOrFail($x);
            }


            if($name == 'installmentPartners'){
                $update = InstallmentPartner::findOrFail($x);
            }




            if ($update->status == 0) {
                $update->status = 1;
                $update->save();
            }
            else {
                $update->status = 0;
                $update->save();
            }
        }
    }

    public function switchTheme(){

        $user =Auth::user();
        if ($user ->theme == 'default') {
            $user ->theme = 'dark';
            $user ->save();
        }else {
            $user->theme = 'default';
            $user->save();
        }

        return back();
    }
}
