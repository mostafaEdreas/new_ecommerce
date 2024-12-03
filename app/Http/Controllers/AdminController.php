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
use App\Models\ProductStock;
use App\Models\Slider;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /////////// function return admin index view //////////

      
   public function admin(){
        //------------------------------
        /////     Orders Report     /////

        $data['reports']['totalOrders'] = Order::count();
        $data['reports']['currentMonthOrders'] = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
        $data['reports']['pendingOrders'] = Order::whereHas('status',function($q){
            $q->whereStatus('pending');
        })->count();
        $data['reports']['pendingOrdersCost'] = Order::whereHas('status',function($q){
            $q->whereStatus('pending');
        })->sum('total_price');
        $data['reports']['totalOrdersCost'] = Order::sum('total_price');
        $data['reports']['ordersQuantity'] = OrderProduct::sum('quantity');
        $data['reports']['currentMonthOrdersCost'] = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->sum('total_price');
        $data['reports']['lastMonthOrdersCost'] = Order::whereYear('created_at', Carbon::now()->year)->where('created_at', '>=', Carbon::now()->subMonth()->month)->sum('total_price');
        $data['orders'] = Order::orderBy('id','DESC')->take(10)->get();


        //--------------------------------//
        /////     Products Report     /////
       
        $products = Product::query();
        $data['reports']['productCount'] = $products->count() ;
        $data['reports']['availableProductNumber'] = $products->active()->count();
        $data['reports']['productHasStock'] = $products->hasStock()->count();
        $data['reports']['productsPrice'] = ProductStock::sum('price');

        //--------------------------------//
        /////     uesrs Report     /////
      
        $data['reports']['usersCount'] = User::count();
        // $currentMonthUsers = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        //--------------------------------//
        /////     categories Report     /////

        $data['reports']['categoriesNumber'] = Category::count();

        /////     brands Report     /////
        
        $data['reports']['brandsNumber'] = Brand::count();

        return view('admin.index',$data);
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
                $update = AboutStruc::findOrFail($x);
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

            if($name == 'sliders'){
                $update = Slider::findOrFail($x);
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

        $user =User::find(Auth::user()->id);
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
