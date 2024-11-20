<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\CartProductAttributeValue;
use App\Models\GuestCart;
use App\Models\GuestCartProduct;
use App\Models\GuestCartProductAttribute;
use App\Models\IntroSlider;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Region;
use App\Models\Area;
use App\Models\HomeSlider;
use App\Models\Category;
use App\Models\Product;
use App\Models\Compatible;
use App\Models\OrderProduct;
use App\Models\HomeImage;
use App\Models\Vendor;
use App\Models\MenuItem;
use App\Models\Brand;
use App\Models\CategoryAttribute;
use App\Models\Attribute;
use App\Models\Wishlist;
use App\Models\Team;

use App\Models\CartProduct;
use Auth;
use App\Models\Stock;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\ProductOption;
use App\Models\ProductPrice;
use App\Models\ProductDiscount;
use App\Models\OfferSlider;
use App\Models\Service;
use App\Models\Color;
use App\Models\Page;
use App\Models\AboutStruc;
use App\Models\About;
use App\Models\ContactUs;
use App\Models\Setting;

use Illuminate\Support\Facades\Session;
use Mail;
use App\Models\BlogCategory;
use App\Models\BlogItem;
use \Crypt;
use App\Models\GalleryVideo;
use App\Models\Winner;
use App\Models\Branche;
use App\Models\Faq;
use App\Traits\SeoTrait;
use App\Models\InstallmentPartner;
use App\Models\Report;
use App\Models\Testimonial;
use App\Traits\WebsiteTrait;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder ;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class WebsiteController extends Controller
{
    use SeoTrait,WebsiteTrait;


    public function checkUrl($slug)
    {
        $checkMenu = MenuItem::where('type', $slug)->first();
        $checkBlog = BlogItem::where('link_en', $slug)->orwhere('link_ar', $slug)->first();
        if ($checkMenu) {
            return $this->menus($checkMenu->type);
        }

        if ($checkBlog) {
            return $this->getBlogPage($slug);
        }
    }

    ///////// function retun dynamic menu//////////
    public function menus($menu)
    {
        $menu = MenuItem::where('type', $menu)->first();

        $lang = LaravelLocalization::getCurrentLocale();
        if(!$menu){
            abort('404');
        }
        elseif ($menu->type == 'home') {
            return $this->home();
        } elseif ($menu->type == 'about-us') {
            return $this->aboutUs();
        } elseif ($menu->type == 'contact-us') {
            return $this->contactUs();
        } elseif ($menu->type == 'deals') {
            return $this->deals(request());
        } elseif ($menu->type == 'featured') {
            return $this->featuredProducts(request());
        } elseif ($menu->type == 'blogs') {
            return redirect('blogs');
        } elseif ($menu->type == 'branches') {
            return $this->getBrnaches();
        } elseif ($menu->type == 'galleryVideos') {
            return $this->getGalleryVideos();
        } elseif ($menu->type == 'galleryImages') {

            return $this->getGalleryImages();
        } elseif ($menu->type == 'inspection-request') {
            return $this->getInspectionRequest();
        }
    }

    ////////////// function returnindex page///////////
    public function home()
    {

        $lang = LaravelLocalization::getCurrentLocale();
        $data['home_categories'] = Category::where('status',1)->take(20)->get();
        $data['first_category'] = [] ;
        $data['second_category'] = [];
        $data['theerd_category'] = [];
        // if(count( $data['home_categories']) > 0){
        //     $data['first_category'] = Stock::whereIn('product_id',$data['home_categories'][0]->products->pluck('id'))->take(6)->get();
        // }
        // if(count( $data['home_categories']) > 1){
        //     $data['second_category'] = Stock::whereIn('product_id',$data['home_categories'][1]->products->pluck('id'))->take(6)->get();
        // }
        // if(count( $data['home_categories']) > 2){
        //     $data['theerd_category'] = Stock::whereIn('product_id',$data['home_categories'][2]->products->pluck('id'))->take(6)->get();
        // }
        if(count( $data['home_categories']) > 0){
            $data['first_category'] = Product::where('category_id',$data['home_categories'][0]->id)->whereHas('groups',function($q){
                $q->whereNotNull('price')->where('price','>',0)
                ->whereJsonLength('product_attribute_id', '>', 0)
                ->whereNotNull('product_attribute_id') ;
            })->take(6)->get();
        }
        if(count( $data['home_categories']) > 1){
            $data['second_category'] = Product::where('category_id',$data['home_categories'][1]->id)->whereHas('groups',function($q){
                $q->whereNotNull('price')->where('price','>',0)
                ->whereJsonLength('product_attribute_id', '>', 0)
                ->whereNotNull('product_attribute_id') ;           })->take(6)->get();
        }
        if(count( $data['home_categories']) > 2){
            $data['theerd_category'] = Product::where('category_id',$data['home_categories'][2]->id)->whereHas('groups',function($q){
                $q->whereNotNull('price')->where('price','>',0)
                ->whereJsonLength('product_attribute_id', '>', 0)
                ->whereNotNull('product_attribute_id') ;           })->take(6)->get();
        }

        $data['home_sliders'] = HomeSlider::where('status', 1)->where('lang', $lang)->orderBy('order', 'ASC')->get();
        $discount_ids= ProductDiscount::latest()->pluck('id')->toArray();
        // $data['new_discount'] = Stock::whereHas('product',function($product_query)use($discount_ids){
        //     $product_query->whereHas('discount',function($discount_query)use($discount_ids){
        //         $discount_query->whereIn('id',$discount_ids);
        //     });
        // })->take(3)->groupBy('product_id')->inRandomOrder()->get();

        $data['new_discount'] = Product::whereHas('discount',function($discount_query)use($discount_ids){
                $discount_query->whereIn('id',$discount_ids);
        })->whereHas('groups',function($q){
            $q->whereNotNull('price')->where('price','>',0)
            ->whereJsonLength('product_attribute_id', '>', 0)
            ->whereNotNull('product_attribute_id') ;
        })->take(3)->inRandomOrder()->get();
        $data['blogs'] = BlogItem::whereStatus(1)->take(4)->get();
        // $product_ids = Product::whereStatus(1)->latest()->pluck('id')->toArray();
        $data['new_products'] = Product::whereStatus(1)->whereHas('groups',function($q){
            $q->whereNotNull('price')->where('price','>',0)
            ->whereJsonLength('product_attribute_id', '>', 0)
            ->whereNotNull('product_attribute_id') ;
               })->latest()->get();

        // $data['new_products']= Stock::whereHas('product',function($prudct_query)use($product_ids){
        //     $prudct_query->whereIn('id',$product_ids);
        // })->groupBy('product_id')->take(20)->inRandomOrder()->get();


        ////// seo script//////
        list($data['schema'], $data['metatags']) = $this->homePageSeo();

        return view('website.home',$data);
    }

    ////////////FUNCTION RETURN VIEW ABOUT US//////
    public function aboutUs()
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $data['about'] = About::first();
        $data['aboutStrucs'] = AboutStruc::where('lang', $lang)->where('status', 1)->get();
        $data['teams'] = Team::where('status',1)->whereLang($lang)->get();
        $data['testimonials'] = Testimonial::where('status',1)->whereLang($lang)->get();
        $data['counters'] = Report::where('status',1)->get();


        ////// seo script//////
        list($data['schema'], $data['metatags']) = $this->aboutUsPageSeo();
        return view('website.about-us', $data);
    }

    ////////////FUNCTION RETURN VIEW CONTACT US//////
    public function contactUs()
    {
        $lang = LaravelLocalization::getCurrentLocale();
        ////// seo script//////
        list($schema, $metatags) = $this->contactUsPageSeo();
        return view('website.contact-us', compact('lang', 'schema', 'metatags'));
    }

    ////////////// function saveContact//////////
    public function saveContactUs(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150',
            //   'email'=>'required|email',
            //   'message'=>'required',
            'phone' => 'required|regex:/(01)[0-9]{9}/',
        ]);

        $contact = new ContactUs();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->message = $request->message;
        $contact->save();

        $data = array('contact' => $contact);
        $setting = Setting::first();
//        Mail::send('emails/contact_email', $data, function ($msg) use ($setting) {
//            $msg->to($setting->contact_email, 'Naguib Selim')->subject('Contact Us');
//            $msg->from(config('mail.from.address'), config('mail.from.name'));
//        });

        return back()->with(['contact_message' => trans('home.Thank you for contacting us. A customer service officer will contact you soon')]);

    }

    /////////// FUNCTION RETURN VIEW OF best seller////////
    public function getBestSeller(Request $request)
    {
        $lang = LaravelLocalization::getCurrentLocale();
        ////// seo script//////
        list($schema, $metatags) = $this->productsPageSeo();
        $bestSellerProductIds = OrderProduct::select(DB::raw('count(*) as Count, id,product_id'))->groupBy('product_id')->orderBy('Count', 'desc')->take(20)->pluck('product_id')->toArray();
        $MainProducts = Product::whereIn('id', $bestSellerProductIds)->where('status', 1)->get()->shuffle();
        list($schema, $metatags) = $this->productsPageSeo();
        if (count($MainProducts)>0){
            $products = Product::whereIn('id', $bestSellerProductIds)->where('status', 1)->get()->shuffle();

            $MainCategories = Category::where('status', 1)->where('home', 1)->where('parent_id', 0)->get();
            $max = $MainProducts->max('price');
            $min = $MainProducts->min('price');

            ////// seo script//////
            if (count($request->all()) > 0 && $request->from && $request->to) {
                $checkedValuesIds = $request->valueId;
                $checkedBrandIds = $request->brand_id;
                $checkedCategoryIds = $request->category_id;
                $from = $request->from;
                $to = $request->to;

                if ($checkedValuesIds == 0) {
                    $checkedValuesIds = [];
                }

                if ($checkedBrandIds == 0) {
                    $checkedBrandIds = [];
                }

                if ($checkedCategoryIds == 0) {
                    $checkedCategoryIds = [];
                }

                $MainProducts = $MainProducts->whereBetween('price', [intval($from), intval($to)]);

                if ($checkedBrandIds) {
                    $brands = Brand::whereIn('id', $checkedBrandIds)->get();
                    foreach ($brands as $brand) {
                        if ($lang == 'en') {
                            array_push($filters, $brand->name_en);
                        } else {
                            array_push($filters, $brand->name_ar);
                        }
                    }
                    $MainProducts = $MainProducts->whereIn('brand_id', $checkedBrandIds);
                }

                if ($checkedCategoryIds) {
                    $cartegories = Category::whereIn('id', $checkedCategoryIds)->get();
                    foreach ($cartegories as $cartegory) {
                        if (session()->get('lang') == 'en') {
                            array_push($filters, $cartegory->name_en);
                        } else {
                            array_push($filters, $cartegory->name_ar);
                        }

                    }
                    $MainProducts = $MainProducts->whereIn('category_id', $checkedCategoryIds);
                }

                if ((count(array_filter($checkedValuesIds)) > 0)) {

                    $attrValues = AttributeValue::whereIn('id', $checkedValuesIds)->get();
                    foreach ($attrValues as $attrValue) {
                        if ($lang == 'en') {
                            array_push($filters, $attrValue->value_en);
                        } else {
                            array_push($filters, $attrValue->value_ar);
                        }
                    }

                    $attValueIds = [];

                    foreach ($checkedValuesIds as $key => $val) {
                        $attValueIds[$val][] = $val;
                    }

                    $productIds = [];
                    foreach ($attValueIds as $key => $attValueId) {
                        array_push($productIds, ProductAttribute::whereIn('attribute_value_id', $attValueId)->pluck('product_id')->toArray());
                    }

                    $newArrayy = call_user_func_array('array_merge', $productIds);
                    if (count($attValueIds) > 1) {
                        $countsArray = array_count_values($newArrayy);
                        $finalArray = array_keys($countsArray, count($attValueIds));
                        $finalArray = array_map('strval', $finalArray);
                        $MainProducts = $MainProducts->whereIN('id', $finalArray);

                    } else {
                        $MainProducts = $MainProducts->whereIN('id', $newArrayy);
                    }
                }

                $prodIds = [];
                foreach ($MainProducts as $prodd) {
                    array_push($prodIds, $prodd->id);
                }

                if ($request->sort_by) {
                    if ($request->sort_by == 'latest') {
                        $MainProducts = $MainProducts = $MainProducts->sortByDesc('id');
                    } elseif ($request->sort_by == 'price-low') {
                        $MainProducts = $MainProducts->sortBy('price');
                    } elseif ($request->sort_by == 'price-high') {
                        $MainProducts = $MainProducts->sortByDesc('price');
                    }
                }
                $MainProducts = (new Collection($MainProducts))->paginate(10);
                return view('website.best_products', compact('lang', 'MainCategories', 'MainProducts', 'schema', 'metatags',
                    'checkedValuesIds', 'checkedCategoryIds', 'checkedBrandIds', 'checkedCategoryIds', 'max', 'min'));
            }
            else
            {
                $MainProducts = Product::whereIn('id', $bestSellerProductIds)->where('status', 1)->paginate(10);
                return view('website.best_products', compact('lang', 'MainCategories', 'MainProducts', 'schema', 'metatags', 'max', 'min'));
            }
        }else{
            return view('website.emptyCategory', compact( 'schema', 'metatags'));
        }



    }

    /////////// FUNCTION RETURN VIEW OF DAILY DEALS////////
    public function deals(Request $request)
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $productIds = DB::table('product_discounts')->whereRaw('(now() between start_date and end_date)')->pluck('product_id')->toArray();
        $productIds = Product::whereIn('id', $productIds)->where('status', 1)->pluck('id')->toArray();

        $ProductBrandIds = Product::whereIn('id', $productIds)->where('status', 1)->where('status', 1)->pluck('brand_id')->toArray();
        $brands = Brand::whereIn('id', $ProductBrandIds)->where('status', 1)->get();
        $brandIds = Brand::whereIn('id', $ProductBrandIds)->where('status', 1)->pluck('id')->toArray();

        $productCategoryIds = Product::whereIn('id', $productIds)->pluck('category_id')->toArray();
        $categoriesIds = Category::WhereIn('id', $productCategoryIds)->where('status', 1)->pluck('id')->toArray();
        $categories = Category::WhereIn('id', $productCategoryIds)->where('status', 1)->get();

        $categoryAttributeIds = CategoryAttribute::whereIn('category_id', $categoriesIds)->pluck('attribute_id')->toArray();
        $attributes = Attribute::whereIn('id', $categoryAttributeIds)->where('status', 1)->get();

        $products = Product::whereIn('id', $productIds)->where('status', 1)->paginate(21);

        $checkedCategoryIds = [];


        $checkedValuesIds = [];
        $checkedBrandIds = [];
        $from = $products->min('price');
        $to = $products->max('price');

        $wishlistedProdutIds = [];
        $cartProductIds = [];
        if (Auth::check()) {
            $wishlistIds = Wishlist::where('user_id', Auth::user()->id)->pluck('product_id')->toArray();
            $cartProductIds = CartProduct::where('user_id', Auth::user()->id)->pluck('product_id')->toArray();
        }

        $filters = [];

        //// seo script////////
        list($schema, $metatags) = $this->dealsPageSeo();

        if (count($products) > 0) {
            if (count($request->all()) > 0 && $request->from && $request->to) {
                $checkedCategoryIds = $request->category_id;
                $checkedBrandIds = $request->brand_id;
                $from = $request->from;
                $to = $request->to;

                if ($checkedCategoryIds == 0) {
                    $checkedCategoryIds = [];
                }
                if ($checkedBrandIds == 0) {
                    $checkedBrandIds = [];
                }

                $products = Product::where('status', 1)->whereBetween('price', [intval($from) - 1, intval($to) + 1])->get();

                if ($checkedCategoryIds) {
                    $cartegories = Category::whereIn('id', $checkedCategoryIds)->get();
                    foreach ($cartegories as $cartegory) {
                        if (session()->get('lang') == 'en') {
                            array_push($filters, $cartegory->name_en);
                        } else {
                            array_push($filters, $cartegory->name_ar);
                        }

                    }

                    $products = $products->whereIn('category_id', $checkedCategoryIds);
                }

                if ($checkedBrandIds) {
                    $brandss = Brand::whereIn('id', $checkedBrandIds)->get();
                    foreach ($brandss as $brand) {
                        if ($lang == 'en') {
                            array_push($filters, $brand->name_en);
                        } else {
                            array_push($filters, $brand->name_ar);
                        }
                    }
                    $products = $products->whereIn('brand_id', $checkedBrandIds);
                }

                if ((count(array_filter($checkedValuesIds)) > 0)) {

                    $attrValues = AttributeValue::whereIn('id', $checkedValuesIds)->get();
                    foreach ($attrValues as $attrValue) {
                        if ($lang == 'en') {
                            array_push($filters, $attrValue->value_en);
                        } else {
                            array_push($filters, $attrValue->value_ar);
                        }
                    }

                    $attValueIds = [];

                    foreach ($checkedValuesIds as $key => $val) {
                        $attValueIds[$val][] = $val;
                    }

                    $productIds = [];
                    foreach ($attValueIds as $key => $attValueId) {
                        array_push($productIds, ProductAttribute::whereIn('attribute_value_id', $attValueId)->pluck('product_id')->toArray());
                    }

                    $newArrayy = call_user_func_array('array_merge', $productIds);
                    if (count($attValueIds) > 1) {
                        $countsArray = array_count_values($newArrayy);
                        $finalArray = array_keys($countsArray, count($attValueIds));
                        $finalArray = array_map('strval', $finalArray);
                        $products = $products->whereIN('id', $finalArray);

                    } else {
                        $products = $products->whereIN('id', $newArrayy);
                    }
                }

                if ($request->sort_by) {
                    if ($request->sort_by == 'latest') {
                        $products = $products->sortByDesc('id');
                    } elseif ($request->sort_by == 'price-low') {
                        $products = $products->sortBy('price');
                    } elseif ($request->sort_by == 'price-high') {
                        $products = $products->sortByDesc('price');
                    }
                }

                $prodIds = [];
                foreach ($products as $prodd) {
                    array_push($prodIds, $prodd->id);
                }

                $products = (new Collection($products))->paginate(21);

                return view('website.hotDeals-products', compact('lang', 'products', 'wishlistedProdutIds', 'cartProductIds', 'checkedValuesIds', 'schema', 'metatags',
                    'checkedCategoryIds', 'checkedBrandIds', 'from', 'to', 'filters', 'brands', 'categories', 'attributes'));
            } else {
                return view('website.hotDeals-products', compact('lang', 'products', 'wishlistedProdutIds', 'cartProductIds', 'checkedValuesIds', 'schema', 'metatags',
                    'checkedCategoryIds', 'checkedBrandIds', 'from', 'to', 'brands', 'categories', 'filters', 'attributes'));
            }
        } else {
            return view('website.emptyDeals', compact('schema', 'metatags'));
        }
    }

    /////////////FUNCTION RETURN FEATURED PRODUCTS/////////
    public function featuredProducts(Request $request)
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $productIds = Product::where('featurd', 1)->where('status', 1)->pluck('id')->toArray();

        $ProductBrandIds = Product::whereIn('id', $productIds)->where('status', 1)->where('status', 1)->pluck('brand_id')->toArray();
        $brands = Brand::whereIn('id', $ProductBrandIds)->where('status', 1)->get();
        $all_brands = Brand::where('status', 1)->get();
        $brandIds = Brand::whereIn('id', $ProductBrandIds)->where('status', 1)->pluck('id')->toArray();

        $productCategoryIds = Product::whereIn('id', $productIds)->where('status', 1)->pluck('category_id')->toArray();
        $categoriesIds = Category::WhereIn('id', $productCategoryIds)->where('status', 1)->pluck('id')->toArray();
        $categories = Category::WhereIn('id', $productCategoryIds)->where('status', 1)->get();

        $categoryAttributeIds = CategoryAttribute::whereIn('category_id', $categoriesIds)->pluck('attribute_id')->toArray();
        $attributes = Attribute::whereIn('id', $categoryAttributeIds)->where('status', 1)->get();

        $products = Product::whereIn('id', $productIds)->whereIn('category_id', $categoriesIds)->whereIn('brand_id', $brandIds)->where('featurd', 1)->paginate(21);

        $checkedCategoryIds = [];
        $checkedValuesIds = [];
        $checkedBrandIds = [];
        $from = $products->min('price');
        $to = $products->max('price');
        $attribute_value = $request->attribute_value;

        $wishlistedProdutIds = [];
        $cartProductIds = [];
        if (Auth::check()) {
            $wishlistIds = Wishlist::where('user_id', Auth::user()->id)->pluck('product_id')->toArray();
            $cartProductIds = CartProduct::where('user_id', Auth::user()->id)->pluck('product_id')->toArray();
        }
        $attribute = Attribute::with('value_relation')->first();

        $filters = [];
        //// seo script////////
        list($schema, $metatags) = $this->featuredPageSeo();

        if (count($products) > 0) {
            if (count($request->all()) > 0 && $request->from && $request->to) {
                $checkedCategoryIds = $request->category_id;
                $checkedBrandIds = $request->brand_id;
                $from = $request->from;
                $to = $request->to;

                if ($checkedCategoryIds == 0) {
                    $checkedCategoryIds = [];
                }
                if ($checkedBrandIds == 0) {
                    $checkedBrandIds = [];
                }
                if ($attribute_value == 0) {
                    $attribute_value = '';
                }

                $products = Product::where('featurd', 1)->where('status', 1)->whereBetween('price', [intval($from) - 1, intval($to) + 1])->get();

                if ($checkedCategoryIds) {
                    $cartegories = Category::whereIn('id', $checkedCategoryIds)->get();
                    foreach ($cartegories as $cartegory) {
                        if (session()->get('lang') == 'en') {
                            array_push($filters, $cartegory->name_en);
                        } else {
                            array_push($filters, $cartegory->name_ar);
                        }

                    }

                    $products = $products->whereIn('category_id', $checkedCategoryIds);
                }

                if ($checkedBrandIds) {
                    $brandss = Brand::whereIn('id', $checkedBrandIds)->get();
                    foreach ($brandss as $brand) {
                        if ($lang == 'en') {
                            array_push($filters, $brand->name_en);
                        } else {
                            array_push($filters, $brand->name_ar);
                        }
                    }
                    $products = $products->whereIn('brand_id', $checkedBrandIds);
                }

                if ((count(array_filter($checkedValuesIds)) > 0)) {

                    $attrValues = AttributeValue::whereIn('id', $checkedValuesIds)->get();
                    foreach ($attrValues as $attrValue) {
                        if ($lang == 'en') {
                            array_push($filters, $attrValue->value_en);
                        } else {
                            array_push($filters, $attrValue->value_ar);
                        }
                    }

                    $attValueIds = [];

                    foreach ($checkedValuesIds as $key => $val) {
                        $attValueIds[$val][] = $val;
                    }


                    $productIds = [];
                    foreach ($attValueIds as $key => $attValueId) {
                        array_push($productIds, ProductAttribute::whereIn('attribute_value_id', $attValueId)->pluck('product_id')->toArray());
                    }


                    $newArrayy = call_user_func_array('array_merge', $productIds);
                    if (count($attValueIds) > 1) {
                        $countsArray = array_count_values($newArrayy);
                        $finalArray = array_keys($countsArray, count($attValueIds));
                        $finalArray = array_map('strval', $finalArray);
                        $products = $products->whereIN('id', $finalArray);

                    } else {
                        $products = $products->whereIN('id', $newArrayy);
                    }
                }
                if($attribute_value){
                    $products_ids = ProductAttribute::where('attribute_value_id',$request->attribute_value)->pluck('product_id')->toArray();
                    $products = $products->whereIn('id', $products_ids);
                }

                if ($request->sort_by) {
                    if ($request->sort_by == 'latest') {
                        $products = $products->sortByDesc('id');
                    } elseif ($request->sort_by == 'price-low') {
                        $products = $products->sortBy('price');
                    } elseif ($request->sort_by == 'price-high') {
                        $products = $products->sortByDesc('price');
                    }
                }

                $prodIds = [];
                foreach ($products as $prodd) {
                    array_push($prodIds, $prodd->id);
                }
                $products = (new Collection($products))->paginate(21);

                return view('website.featured-products', compact('attribute','all_brands', 'lang', 'products', 'wishlistedProdutIds', 'cartProductIds', 'checkedValuesIds', 'schema', 'metatags',
                    'checkedCategoryIds', 'checkedBrandIds', 'from', 'to', 'filters', 'brands', 'categories', 'attributes'));
            } else {
                return view('website.featured-products', compact('attribute','all_brands', 'lang', 'products', 'wishlistedProdutIds', 'cartProductIds', 'checkedValuesIds', 'schema', 'metatags',
                    'checkedCategoryIds', 'checkedBrandIds', 'from', 'to', 'brands', 'categories', 'filters', 'attributes'));
            }
        } else {
            return view('website.emptyFeatured', compact('schema', 'metatags'));
        }
    }

    ////////// FUNCTION RETURN PAGE INFORMATION /////////
    public function getPage($link)
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $page = Page::where('link_en', $link)->orwhere('link_ar', $link)->first();

        ////// seo script//////
        list($schema, $metatags) = $this->pageSeo($link);
        return view('website.page', compact('lang', 'page', 'schema', 'metatags'));
    }



    ////////////// function return all all categories///////////
    public function getCategory($link)
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $category = Category::where('link_en',$link)->orWhere('link_ar',$link)->first();
        $MainProducts = Product::whereHas('groups',function($q){
            $q->whereNotNull('price')->where('price','>',0)
            ->whereJsonLength('product_attribute_id', '>', 0)
            ->whereNotNull('product_attribute_id') ;
        });
        if(count(value: $category->subCategories)){
            $categories_ids = $category->subCategories->pluck('id')->toArray();
            $MainProducts = $MainProducts->WhereIn('category_id',$categories_ids)->where('category_id',$category->id);
        }else{
            $MainProducts = $MainProducts->Where('category_id',$category->id);
        }

        $main_products = $this->fliterProductsBuilder($MainProducts)->whereStatus(1)->with('groups')->paginate(10);
        $data['MainProducts'] = $main_products ;
        // dd($data['MainProducts']);
        $data['MainCategories'] = Category::where(  'status', 1)->where('parent_id', operator:  $category->id)->get();
        $size_attribute=  attribute::where('name_en','size')->first();
        $size_attribute_id= $size_attribute?->id ;
        $data['sizes'] = attributeValue::where('attribute_id',$size_attribute_id)->get();
        list($data['schema'], $data['metatags']) = $this->categoryPageSeo($link);

        if(request()->ajax()){
            $product_html = view('website.appendes.products.add_product_cart',$data)->render();
            return response()->json(['status'=>true,'product_html'=>$product_html]);
        }
        return view('website.products',$data);
    }

    /////////// function return category subcategories///////
    public function getSubCategories($name, $id)
    {
        $mainCategory = category::where('id', $id)->where('name_en', $name)->first();
        if ($mainCategory) {

            if ($mainCategory->has_sub == 1) {
                $lang = LaravelLocalization::getCurrentLocale();
                $subCategories = Category::where('status', 1)->where('parent_id', $id)->get();
                return view('website.sub-categories', compact('lang', 'subCategories', 'mainCategory'));
            } else {
                return redirect('category/' . $mainCategory->name_en . '/' . $mainCategory->id . '/products');
            }

        } else {
            abort('404');
        }

    }

    /////////////////////FUNCTION RETURN VIEW BLOGS ///////////
    public function getProducts(Request $request)
    {
        try {

            $lang = LaravelLocalization::getCurrentLocale();
            $main_products= Product::query()->whereHas('groups',function($q){
                $q->whereNotNull('price')->where('price','>',0)
                ->whereJsonLength('product_attribute_id', '>', 0)
                ->whereNotNull('product_attribute_id') ;
                       })->where('status', 1);
            $main_products = $this->fliterProductsBuilder($main_products);
            $main_products = $main_products->paginate(10);
            // $data['MainProducts'] = $this->filterproductsCollection( $main_products );
            // $groups = Stock::whereHas('product',function($q){$q->where('status',1);});
            // $groups = $this->filterStockBuilder($groups);
            // $data['groups'] = $this->filterproductsCollection( $groups );
            $data['MainProducts'] = $main_products ;
            $data['Product'] = $main_products ;
            // $data['groups'] = $groups->orderBy('price')->inRandomOrder()->paginate(10) ;

            $data['MainCategories'] = Category::where('status', 1)->where('parent_id', 0)->get();
            $size_attribute=  attribute::where('name_en','size')->first();
            $size_attribute_id= $size_attribute?->id ;
            $data['sizes'] = attributeValue::where('attribute_id',$size_attribute_id)->get();
            list($data['schema'], $data['metatags']) = $this->productsPageSeo();
            if(request()->ajax()){
                $product_html = view('website.appendes.products.add_product_cart',$data)->render();
                return response()->json(['status'=>true,'product_html'=>$product_html]);
            }
            return view('website.products',$data);
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




    /////////////////////FUNCTION RETURN VIEW BLOGS ///////////
    public function getBlogs()
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $blogCategories = BlogCategory::where('status', 1)->get();
        $blogCategoriesIds = BlogCategory::where('status', 1)->pluck('id')->toArray();
        $blogs = BlogItem::whereIn('blogcategory_id', $blogCategoriesIds)->where('status', 1)->paginate(9);

        ////// seo script//////
        list($schema, $metatags) = $this->blogsPageSeo();
        return view('website.blogs', compact('lang', 'blogCategories', 'blogs', 'schema', 'metatags'));
    }


    /////////////////////FUNCTION RETURN VIEW BLOG ///////////
    public function getBlogPage($link)
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $blog = BlogItem::where('link_en', $link)->orwhere('link_ar', $link)->first();
        $blog->increment('seen');
        $blog->update();
        $blogs = BlogItem::where('status', 1)->where('id', '!=', $blog->id)->where('blogcategory_id', $blog->blogcategory_id)->get();
        $blogCategories = BlogCategory::with('blogs')->where('status', 1)->get();
        ////// seo script//////
        list($schema, $metatags) = $this->blogPageSeo($link);
        return view('website.blogPage', compact('lang','blogCategories', 'blog', 'blogs', 'schema', 'metatags'));
    }
    /////////////////////FUNCTION RETURN VIEW CATEGORY BLOGs ///////////
    public function getCategoryBlogs($link)
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $blogCategory = BlogCategory::where('link_en', $link)->orwhere('link_ar', $link)->first();
        list($schema, $metatags) = $this->blogsPageSeo();
        if($blogCategory){
            $blogCategories = BlogCategory::where('status', 1)->get();
            $blogs = BlogItem::where('blogcategory_id', $blogCategory->id)->where('status', 1)->paginate(9);
            return view('website.blogs', compact('lang','schema', 'metatags', 'blogCategories', 'blogs', 'blogCategory'));
        }else{
            return abort(404);

        }

    }

    ////////////// function return catrgory products///////////
    public function getCategoryProducts(Request $request, $link)
    {
        $lang = LaravelLocalization::getCurrentLocale();

        $category = Category::where('link_en', $link)->orwhere('link_ar', $link)->first();
        $id = $category->id;
        $category->seen = $category->seen + 1;
        $category->save();

        $Categories = Category::Where('parent_id', 0)->where('status', 1)->get();
        $CategoriesIds = Category::Where('parent_id', $id)->where('status', 1)->pluck('id')->toArray();
        array_push($CategoriesIds, intval($id));

        $products = Product::whereIn('category_id', $CategoriesIds)->where('status', 1)->get();
        $all_products = Product::whereIn('category_id', $CategoriesIds)->where('status', 1)->get();
        $productIds = Product::whereIn('category_id', $CategoriesIds)->where('status', 1)->pluck('id')->toArray();

        $ProductBrandIds = Product::whereIn('id', $productIds)->where('status', 1)->where('status', 1)->pluck('brand_id')->toArray();
        $brands = Brand::whereIn('id', $ProductBrandIds)->where('status', 1)->get();
        $brandIds = Brand::whereIn('id', $ProductBrandIds)->where('status', 1)->pluck('id')->toArray();

        $categoryAttributeIds = CategoryAttribute::where('category_id', $id)->pluck('attribute_id')->toArray();
        $attributes = Attribute::whereIn('id', $categoryAttributeIds)->where('status', 1)->get();

        $products = Product::whereIn('category_id', $CategoriesIds)->where('status', 1)->paginate(21);

        $checkedValuesIds = [];
        $checkedCategoryIds = [];
        $checkedBrandIds = [];
        $from = $products->min('price');
        $to = $products->max('price');
        $max = $all_products->max('price');
        $min = $all_products->min('price');

        $wishlistedProdutIds = [];
        $cartProductIds = [];
        if (Auth::check()) {
            $wishlistIds = Wishlist::where('user_id', Auth::user()->id)->pluck('product_id')->toArray();
            $cartProductIds = CartProduct::where('user_id', Auth::user()->id)->pluck('product_id')->toArray();
        }

        ////// seo script//////
        list($schema, $metatags) = $this->categoryPageSeo($link);

        $filters = [];
        if (count($products) > 0) {
            if (count($request->all()) > 0 && $request->from && $request->to) {
                $checkedValuesIds = $request->valueId;
                $checkedBrandIds = $request->brand_id;
                $checkedCategoryIds = $request->category_id;
                $from = $request->from;
                $to = $request->to;

                if ($checkedValuesIds == 0) {
                    $checkedValuesIds = [];
                }


                if ($checkedBrandIds == 0) {
                    $checkedBrandIds = [];
                }

                if ($checkedCategoryIds == 0) {
                    $checkedCategoryIds = [];
                }

                $products = $products->whereBetween('price', [intval($from) - 1, intval($to) + 1]);

                if ($checkedBrandIds) {
                    $brands = Brand::whereIn('id', $checkedBrandIds)->get();
                    foreach ($brands as $brand) {
                        if ($lang == 'en') {
                            array_push($filters, $brand->name_en);
                        } else {
                            array_push($filters, $brand->name_ar);
                        }
                    }
                    $products = $products->whereIn('brand_id', $checkedBrandIds);
                }

                if ($checkedCategoryIds) {
                    $cartegories = Category::whereIn('id', $checkedCategoryIds)->get();
                    foreach ($cartegories as $cartegory) {
                        if (session()->get('lang') == 'en') {
                            array_push($filters, $cartegory->name_en);
                        } else {
                            array_push($filters, $cartegory->name_ar);
                        }

                    }
                    $products = $products->whereIn('category_id', $checkedCategoryIds);
                }

                if ((count(array_filter($checkedValuesIds)) > 0)) {

                    $attrValues = AttributeValue::whereIn('id', $checkedValuesIds)->get();
                    foreach ($attrValues as $attrValue) {
                        if ($lang == 'en') {
                            array_push($filters, $attrValue->value_en);
                        } else {
                            array_push($filters, $attrValue->value_ar);
                        }
                    }

                    $attValueIds = [];

                    foreach ($checkedValuesIds as $key => $val) {
                        $attValueIds[$val][] = $val;
                    }

                    $productIds = [];
                    foreach ($attValueIds as $key => $attValueId) {
                        array_push($productIds, ProductAttribute::whereIn('attribute_value_id', $attValueId)->pluck('product_id')->toArray());
                    }

                    $newArrayy = call_user_func_array('array_merge', $productIds);
                    if (count($attValueIds) > 1) {
                        $countsArray = array_count_values($newArrayy);
                        $finalArray = array_keys($countsArray, count($attValueIds));
                        $finalArray = array_map('strval', $finalArray);
                        $products = $products->whereIN('id', $finalArray);

                    } else {
                        $products = $products->whereIN('id', $newArrayy);
                    }
                }

                $prodIds = [];
                foreach ($products as $prodd) {
                    array_push($prodIds, $prodd->id);
                }
                if ($request->sort_by) {
                    if ($request->sort_by == 'latest') {
                        $products = $products->sortByDesc('id');
                    } elseif ($request->sort_by == 'price-low') {
                        $products = $products->sortBy('price');
                    } elseif ($request->sort_by == 'price-high') {
                        $products = $products->sortByDesc('price');
                    }
                }

                $products = (new Collection($products))->paginate(21);

                return view('website.category-products', compact('lang', 'category', 'products', 'wishlistedProdutIds', 'cartProductIds', 'schema', 'metatags',
                    'checkedValuesIds', 'checkedCategoryIds', 'checkedBrandIds', 'checkedCategoryIds', 'from', 'to', 'filters', 'attributes', 'brands', 'Categories', 'max', 'min'));
            } else {
                return view('website.category-products', compact('lang', 'category', 'products', 'wishlistedProdutIds', 'cartProductIds', 'schema', 'metatags',
                    'checkedValuesIds', 'checkedCategoryIds', 'checkedBrandIds', 'checkedCategoryIds', 'from', 'to', 'attributes', 'brands', 'filters', 'Categories', 'max', 'min'));
            }
        } else {
            return view('website.emptyCategory', compact('category', 'schema', 'metatags'));
        }
    }

    //////// FUNCTION RETURN PRODUCT DETAILS///////////////
    public function getProductDetails($link)
    {
        try{
            $product = Product::where(function($query) use ($link) {
                $query->where('link_en', $link)
                      ->orWhere('link_ar', $link);
            })
            ->whereHas('groups', function($q) {
                $q->whereNotNull('price')->where('price','>',0)
                ->whereJsonLength('product_attribute_id', '>', 0)
                ->whereNotNull('product_attribute_id') ;
               })
            ->with('groups')
            ->first();
            $data['product'] =$product;
            // $data['group'] = Stock::with('product')->find(request('group'));
            // $data['size_groups_Product'] = Stock::where('product_id', $product->id)->whereNot('price',$data['group']->price)->get();
            // $data['related_groups'] = Stock::whereHas('product',function($Product_query)use($product){
            //     $Product_query->whereNot('id',$product->id)->where('category_id',$product->category_id);
            // })->take(50)->get();
            $data['related_groups'] = Product::where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->whereHas('groups', function($q) {
                $q->whereNotNull('price')->where('price','>',0)
                ->whereJsonLength('product_attribute_id', '>', 0)
                ->whereNotNull('product_attribute_id') ;
            })
            ->take(50)
            ->get();

            $lang = LaravelLocalization::getCurrentLocale();
            $id = $product->id;
            if ($product) {

                // $product->visits = $product->visits + 1;
                // $product->save();

                // $productColorIds = ProductColor::where('product_id', $id)->pluck('color_id')->toArray();
                // $colors = Color::whereIN('id', $productColorIds)->get();

                // $productImages = ProductImage::where('product_id', $id)->get();
                // //$productColorImage=ProductImage::where('product_id',$id)->groupBy('image_color_id')->orderBy('id','ASC')->pluck('img','image_color_id')->toArray();
                // $relatedProducts = Product::where('id', '!=', $id)->where('status', 1)->where('category_id', $product->category->id)->get();
                // //dd($relatedProducts);
                // $productOptions = ProductOption::where('product_id', $id)->get();

                // $productPrices = ProductPrice::where('product_id', $id)->get();
                // $product_discount = ProductDiscount::where('product_id', $id)->first();

                // $productAttributeIds = ProductAttribute::pluck('attribute_id')->toArray();
                // $attributes = Attribute::whereIn('id', $productAttributeIds)->get();

                // $reviews = ProductReview::where('product_id', $id)->get();
                // $productRate = ProductReview::where('product_id', $id)->avg('rate');
                // $rateCount = ProductReview::where('product_id', $id)->count();

                // $rateCount_1 = ProductReview::where('product_id', $id)->where('rate', 1)->count();
                // $rateCount_2 = ProductReview::where('product_id', $id)->where('rate', 2)->count();
                // $rateCount_3 = ProductReview::where('product_id', $id)->where('rate', 3)->count();
                // $rateCount_4 = ProductReview::where('product_id', $id)->where('rate', 4)->count();
                // $rateCount_5 = ProductReview::where('product_id', $id)->where('rate', 5)->count();
                // ////// seo script//////
                list($data['schema'], $data['metatags']) = $this->productPageSeo($id);


                return view('website.product',$data );
                // compact('lang', 'product', 'colors', 'productImages', 'productPrices', 'reviews', 'relatedProducts', 'schema', 'metatags',
                //     'product_discount', 'productOptions', 'attributes', 'productRate', 'rateCount', 'rateCount_1', 'rateCount_2', 'rateCount_3', 'rateCount_4', 'rateCount_5')
            } else {
                abort('404');
            }
        }catch(\Exception $ex){
            if(request()->ajax()){
                return response()->json(['status'=>false,'message'=>$ex->getMessage()]);
            }
            if(env('APP_DEBUG')){
                dd($ex->getMessage().' in: '.$ex->getFile() .' At line: ' .$ex->getLine() );
            }

            return abort(500,__('home.an error occurred please connect with developer to solve it'));
        }

    }

    ////////// function return country regions/////
    public function getRegions()
    {
        $id = $_POST['id'];
        $regions = Region::where('Country_id', $id)->where('status', 1)->select('name_en', 'id', 'name_ar')->get();
        return response()->json($regions);
    }

    ////////// function return region areas/////
    public function getAreas()
    {
        $id = $_POST['id'];
        $areas = Area::where('region_id', $id)->where('status', 1)->select('name_en', 'id', 'name_ar')->get();
        return response()->json($areas);
    }

    //////////////////// search auto complete function ///////////////////
    public function autoCompletesearch()
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $text = $_GET['phrase'];
        $products = Product::where('name_en', 'like', '%' . $text . '%')->orwhere('name_ar', 'like', '%' . $text . '%')->where('status', 1)->get();
        $brands = Brand::where('name_en', 'like', '%' . $text . '%')->orwhere('name_ar', 'like', '%' . $text . '%')->where('status', 1)->get();
        $results = [];
        foreach ($products as $query) {
            if ($lang == 'en') {
                $results[] = ['name' => $query->name_en];
            } else {
                $results[] = ['name' => $query->name_ar];
            }
        }
        foreach ($brands as $query) {
            if ($lang == 'en') {
                $results[] = ['name' => $query->name_en];
            } else {
                $results[] = ['name' => $query->name_ar];
            }
        }
        return response()->json($results);
    }

    /////////////////// searchResult function //////////////
    public function searchResult(Request $request)
    {
        $search_input = $request->input('search_input') ? $request->input('search_input') : '';
        $MainCategories = Category::where('status', 1)->where('home', 1)->where('parent_id', 0)->get();
        $MainProducts = Product::where('status', 1)->get();
        $max = $MainProducts->max('price');
        $min = $MainProducts->min('price');
        $from = $request->from;
        $to = $request->to;
        $all_brands = Brand::where('status', 1)->get();
        $attribute = Attribute::with('value_relation')->first();
        $all_products = Product::where('status', 1)->get();
         $attribute_value = $request->attribute_value;

        if ($search_input == '') {
            $products = Product::where('status', 1)->get();
        }
        else
        {
            if ($search_input) {
                $products_en = Product::where('name_en', 'LIKE', '%' . $search_input . '%')->where('status', 1)->get();
            }
            if ($search_input) {
                $products_ar = Product::where('name_ar', 'LIKE', '%' . $search_input . '%')->where('status', 1)->get();
            }
            if ($search_input) {
                $brand_en = Brand::where('name_en', 'LIKE', '%' . $search_input . '%')->orwhere('name_ar', 'LIKE', '%' . $search_input . '%')->where('status', 1)->first();
                $prodBrand_en = collect();
                if ($brand_en) {
                    $prodBrand_en = Product::where('brand_id', $brand_en->id)->where('status', 1)->get();
                }
            }
            if ($search_input) {
                $brand_ar = Brand::where('name_ar', 'LIKE', '%' . $search_input . '%')->where('status', 1)->first();
                $prodBrand_ar = collect();
                if ($brand_ar) {
                    $prodBrand_ar = Product::where('brand_id', $brand_ar->id)->where('status', 1)->get();
                }
            }
            if ($search_input) {
                $attributes_ids = AttributeValue::where('value_en', 'LIKE', '%' . $search_input . '%')->orwhere('value_ar', 'LIKE', '%' . $search_input . '%')->pluck('id')->toArray();
                $products_ids_from_attributes = ProductAttribute::whereIn('attribute_value_id',$attributes_ids)->pluck('product_id')->toArray();
            }
            if ($search_input) {
                $categories_ids = Category::where('name_en', 'LIKE', '%' . $search_input . '%')->orwhere('name_ar', 'LIKE', '%' . $search_input . '%')->pluck('id')->toArray();
                $category_product_ids = Product::whereIn('category_id',$categories_ids)->pluck('id')->toArray();
            }

            $products_names = $products_en->merge($products_ar);
            $products_brandNames = $prodBrand_en->merge($prodBrand_ar);
            $products = $products_names->merge($products_brandNames);
            $products_ids_from_attributes = $products_ids_from_attributes;
        }
        if ($attribute_value == 0) {
            $attribute_value = '';
        }
        if($attribute_value){
            $products_ids = ProductAttribute::where('attribute_value_id',$request->attribute_value)->pluck('product_id')->toArray();
            $products =  $products->whereIn('id', $products_ids);
        }





        if ($request->categoryId) {
            $products = $products->where('category_id', $request->categoryId);
        }
        if($request->from &&$request->to){
            $products = $products->whereBetween('price', [intval($from), intval($to)]);
        }


        $wishlistedProdutIds = [];
        $cartProductIds = [];
        $checkedValuesIds = [];
        if (Auth::check()) {
            $wishlistedProdutIds = Wishlist::where('user_id', Auth::user()->id)->pluck('product_id')->toArray();
            $cartProductIds = CartProduct::where('user_id', Auth::user()->id)->pluck('product_id')->toArray();
        }

        $lang = LaravelLocalization::getCurrentLocale();
        $productIds = $products->pluck('id')->toArray();

        $productIds = Product::whereIn('id', $productIds)->where('status', 1)->pluck('id')->toArray();



        $ProductBrandIds = Product::whereIn('id', $productIds)->where('status', 1)->where('status', 1)->pluck('brand_id')->toArray();
        $brands = Brand::whereIn('id', $ProductBrandIds)->where('status', 1)->get();
        $brandIds = Brand::whereIn('id', $ProductBrandIds)->where('status', 1)->pluck('id')->toArray();

        $productCategoryIds = Product::whereIn('id', $productIds)->pluck('category_id')->toArray();
        $categoriesIds = Category::WhereIn('id', $productCategoryIds)->where('status', 1)->pluck('id')->toArray();
        $categories = Category::WhereIn('id', $productCategoryIds)->where('status', 1)->get();

        $categoryAttributeIds = CategoryAttribute::whereIn('category_id', $categoriesIds)->pluck('attribute_id')->toArray();
        $attributes = Attribute::whereIn('id', $categoryAttributeIds)->where('status', 1)->get();

        $checkedCategoryIds = $request->category_id ? $request->category_id : [];
        $checkedBrandIds = $request->brand_id ? $request->brand_id : [];
        $checkedValuesIds = $request->valueId ? $request->valueId : [];
        $filters = [];
//        $from = $products->min('price');
//        $to = $products->max('price');




        if ($checkedBrandIds) {
            $brands = Brand::whereIn('id', $checkedBrandIds)->get();
            foreach ($brands as $brand) {
                if ($lang == 'en') {
                    array_push($filters, $brand->name_en);
                } else {
                    array_push($filters, $brand->name_ar);
                }
            }
            $products = $products->whereIn('brand_id', $checkedBrandIds);
        }

        if ($checkedCategoryIds) {
            $cartegories = Category::whereIn('id', $checkedCategoryIds)->get();
            return $cartegories;
            foreach ($cartegories as $cartegory) {
                if (session()->get('lang') == 'en') {
                    array_push($filters, $cartegory->name_en);
                } else {
                    array_push($filters, $cartegory->name_ar);
                }

            }
            $products = $products->whereIn('category_id', $checkedCategoryIds);
        }

        if ((count(array_filter($checkedValuesIds)) > 0)) {

            $attrValues = AttributeValue::whereIn('id', $checkedValuesIds)->get();
            foreach ($attrValues as $attrValue) {
                if ($lang == 'en') {
                    array_push($filters, $attrValue->value_en);
                } else {
                    array_push($filters, $attrValue->value_ar);
                }
            }

            $attValueIds = [];

            foreach ($checkedValuesIds as $key => $val) {
                $attValueIds[$val][] = $val;
            }

            $productIds = [];
            foreach ($attValueIds as $key => $attValueId) {
                array_push($productIds, ProductAttribute::whereIn('attribute_value_id', $attValueId)->pluck('product_id')->toArray());
            }

            $newArrayy = call_user_func_array('array_merge', $productIds);
            if (count($attValueIds) > 1) {
                $countsArray = array_count_values($newArrayy);
                $finalArray = array_keys($countsArray, count($attValueIds));
                $finalArray = array_map('strval', $finalArray);
                $products = $products->whereIN('id', $finalArray);

            } else {
                $products = $products->whereIN('id', $newArrayy);
            }

        }

        if ($request->sort_by) {
            if ($request->sort_by == 'latest') {
                $products = $products->sortByDesc('id');
            } elseif ($request->sort_by == 'price-low') {
                $products = $products->sortBy('price');
            } elseif ($request->sort_by == 'price-high') {
                $products = $products->sortByDesc('price');
            }
        }
        $old_products = $products->pluck('id')->toArray();
        if($search_input == ''){
              $search_products = $all_products->filter(function ($product) use ($old_products) {
                return in_array($product->id, $old_products);
            });
        }else{
            $search_products = $all_products->filter(function ($product) use ($products_ids_from_attributes, $old_products, $category_product_ids) {
                return in_array($product->id, $products_ids_from_attributes) || in_array($product->id, $old_products)|| in_array($product->id, $category_product_ids);
            });
        }


        $products = $search_products->where('stock', '>', 0);

        $products = (new Collection($products))->paginate(21);
        if (count($products) > 0) {
            $products_ids = $products->pluck('id');
            $table_ids = DB::table('frequently_search')->pluck('product_id')->toArray();
//            DB::table('frequently_search')->insert([]);
            foreach ($products_ids as $product_id) {
                if (in_array($product_id, $table_ids)) {
                    $search_record = DB::table('frequently_search')->where('product_id', $product_id)->first();
                    DB::table('frequently_search')->where('product_id', $product_id)->update(['count_search' => $search_record->count_search + 1]);
                } else {
                    DB::table('frequently_search')->insert([
                        'product_id' => $product_id,
                        'count_search' => 1]);
                }
            }

            return view('website.search-products', compact('all_brands','attribute','lang', 'products','MainProducts','min' ,'max','wishlistedProdutIds',
                'MainCategories' ,'cartProductIds', 'checkedValuesIds',
                'checkedCategoryIds', 'checkedBrandIds', 'from', 'to', 'brands', 'categories', 'filters', 'attributes'));
        }
        else {
            return view('website.emptySearch');
        }
    }


    ////// FUNCTION RETURN BRAND PRODUCTS////////
    public function getBrandproducts(Request $request, $link)
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $brand = Brand::where('link_en', $link)->orwhere('link_ar', $link)->first();
        $id = $brand->id;

        $products = Product::where('brand_id', $id)->where('status', 1)->paginate(21);
        $productCategoryIds = Product::where('brand_id', $id)->where('status', 1)->distinct('category_id')->pluck('category_id')->toArray();
        $categories = Category::whereIn('id', $productCategoryIds)->get();
        $categoryAttributeIds = CategoryAttribute::whereIn('category_id', $productCategoryIds)->pluck('attribute_id')->toArray();
        $attributes = Attribute::whereIn('id', $categoryAttributeIds)->where('status', 1)->get();
        $wishlistedProdutIds = [];
        $cartProductIds = [];
        $checkedValuesIds = [];
        $checkedCategoryIds = [];
        $filters = [];
        $max = $products->max('price');
        $min = $products->min('price');
        $from = $products->min('price');
        $to = $products->max('price');

        if (Auth::check()) {
            $wishlistIds = Wishlist::where('user_id', Auth::user()->id)->pluck('product_id')->toArray();
            $cartProductIds = CartProduct::where('user_id', Auth::user()->id)->pluck('product_id')->toArray();
        }

        ////// seo script//////
        list($schema, $metatags) = $this->brandPageSeo($link);
        if(count($products)){
            if (count($request->all()) > 0 && $request->from && $request->to) {
                $checkedValuesIds = $request->valueId;
                $checkedCategoryIds = $request->category_id;
                $from = $request->from;
                $to = $request->to;

                if ($checkedValuesIds == 0) {
                    $checkedValuesIds = [];
                }

                if ($checkedCategoryIds == 0) {
                    $checkedCategoryIds = [];
                }

                $products = Product::where('status', 1)->where('brand_id', $brand->id)->whereBetween('price', [intval($from) - 1, intval($to) + 1])->get();

                if ($checkedCategoryIds) {
                    $cartegories = Category::whereIn('id', $checkedCategoryIds)->get();
                    foreach ($cartegories as $cartegory) {
                        if (session()->get('lang') == 'en') {
                            array_push($filters, $cartegory->name_en);
                        } else {
                            array_push($filters, $cartegory->name_ar);
                        }

                    }
                    $products = $products->whereIn('category_id', $checkedCategoryIds);
                }

                if ((count(array_filter($checkedValuesIds)) > 0)) {
                    $attrValues = AttributeValue::whereIn('id', $checkedValuesIds)->get();
                    foreach ($attrValues as $attrValue) {
                        if ($lang == 'en') {
                            array_push($filters, $attrValue->value_en);
                        } else {
                            array_push($filters, $attrValue->value_ar);
                        }
                    }

                    $attValueIds = [];
                    foreach ($checkedValuesIds as $key => $val) {
                        $attValueIds[$val][] = $val;
                    }

                    $productIds = [];
                    foreach ($attValueIds as $key => $attValueId) {
                        array_push($productIds, ProductAttribute::whereIn('attribute_value_id', $attValueId)->pluck('product_id')->toArray());
                    }
                    $newArrayy = call_user_func_array('array_merge', $productIds);
                    if (count($attValueIds) > 1) {
                        $countsArray = array_count_values($newArrayy);
                        $finalArray = array_keys($countsArray, count($attValueIds));
                        $finalArray = array_map('strval', $finalArray);
                        $products = $products->whereIN('id', $finalArray);

                    } else {
                        $products = $products->whereIN('id', $newArrayy);
                    }
                }

                if ($request->sort_by) {
                    if ($request->sort_by == 'latest') {
                        $products = $products->sortByDesc('id');
                    } elseif ($request->sort_by == 'price-low') {
                        $products = $products->sortBy('price');
                    } elseif ($request->sort_by == 'price-high') {
                        $products = $products->sortByDesc('price');
                    }
                }

                $prodIds = [];
                foreach ($products as $prodd) {
                    array_push($prodIds, $prodd->id);
                }

                $products = (new Collection($products))->paginate(21);

                return view('website.brand-products', compact('brand', 'products', 'categories', 'attributes', 'wishlistedProdutIds', 'schema', 'metatags',
                    'cartProductIds', 'checkedCategoryIds', 'checkedValuesIds', 'max', 'min', 'filters'));

            } else {
                return view('website.brand-products', compact('brand', 'products', 'categories', 'attributes', 'wishlistedProdutIds', 'cartProductIds', 'checkedCategoryIds', 'checkedValuesIds', 'max', 'min', 'schema', 'metatags'));
            }
        }else{
                return view('website.emptyBrand', compact('schema', 'metatags'));
        }


    }

    public function getGalleryVideos()
    {
        $galleryVideos = GalleryVideo::get();
        return view('website.galleryVideos', compact('galleryVideos'));
    }

    public function getInspectionRequest()
    {
        $categories = Category::where('status', 1)->get();
        ////// seo script//////
        list($schema, $metatags) = $this->inspectionRequestPageSeo();
        return view('website.inspectionRequest', compact('categories', 'schema', 'metatags'));
    }


    public function getBrnaches()
    {
        $branches = Branche::where('status', 1)->get();
        $regions = Region::where('available_beranches', 1)->where('status', 1)->select('name_en', 'id', 'name_ar')->get();
        ////// seo script//////
        list($schema, $metatags) = $this->branchesPageSeo();
        return view('website.branches', compact('branches', 'regions', 'schema', 'metatags'));
    }

    public function getRegionsBranches()
    {
        $id = $_POST['id'];
        $areas = Area::where('region_id', $id)->where('available_beranche', 1)->where('status', 1)->select('name_en', 'id', 'name_ar')->get();
        return response()->json($areas);
    }

    public function branchesFilter()
    {
        $region_id = $_POST['region_id'];
        $area_id = $_POST['area_id'];
        $branches = Branche::where('status', 1)->get();


        if ($region_id) {
            $branches = $branches->where('region_id', $region_id);
        }

        if ($area_id) {
            $branches = $branches->where('area_id', $area_id);
        }

        return response()->json([
            'html' => view('website.partials.branches', compact('branches'))->render(),
        ]);
    }


    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $check = Newsletter::getMember($request->email);
        if ($check['status'] != 'subscribed') {
            Newsletter::subscribe($request->email);
            return back()->with(['success' => trans('home.Thank you for subscribing.latest informations,events,sales and Offers will be sent soon')]);
        }
        return back()->with(['success' => trans('home.Thank you, subscribied before')]);
    }


    public function addAndChoppiongCart(Request $request)
    {

        $productId = $request->product_id;

        $product = Product::find($productId);
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

        if (Auth::check()) {
            /////// CHECK USER CART /////////////////
            $userCart = Cart::where('user_id', Auth::user()->id)->first();
            if (!$userCart) {
                /////create user cart///
                $cart = new Cart();
                $cart->user_id = Auth::user()->id;
                $cart->save();
            }
            $cart = Cart::where('user_id', Auth::user()->id)->first();

            $cartProduct = CartProduct::where('product_id', $productId)->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();

            if (!$cartProduct) {
                //////ADD CART PRODUCT ////////
                $add = new CartProduct();
                $add->cart_id = $cart->id;
                $add->user_id = Auth::user()->id;
                $add->product_id = $productId;
                $add->color_id = $colorId;
                if ($product->discount()) {
                    $add->price = $product->price - $product->discount();
                    $add->price_before_disc = $product->price;
                } else {
                    $add->price = $product->price;
                    $add->price_before_disc = $product->price;
                }

                $add->quantity = $request->quantity;
                $add->save();

                //////ADD CART PRODUCT ATTRIBUTE VALUES////////
                foreach ($attributeValuesIds as $attributeValueId) {
                    $cartProAttrValue = new CartProductAttributeValue();
                    $cartProAttrValue->cart_id = $cart->id;
                    $cartProAttrValue->cart_product_id = $add->id;
                    $cartProAttrValue->attribute_value_id = $attributeValueId;
                    $cartProAttrValue->save();
                }

                /////// update cart info////
//                $cart->products_price+=$add->price;
                $cart->products_price += $add->price * $add->quantity;
                $cart->total_price += $add->price * $add->quantity;
                $cart->coupon_discount = NULL;
                $cart->coupon_id = NULL;
                $cart->save();

                $status = 'add';

                $cartCount = CartProduct::where('cart_id', $cart->id)->count();
                $cartProduct = $add;
                return redirect()->route('shopping-cart');
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
                return redirect()->route('shopping-cart');
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

                $add->quantity = $request->quantity;;
                $add->save();

                //////ADD CART PRODUCT ATTRIBUTE VALUES////////
                foreach ($attributeValuesIds as $attributeValueId) {
                    $cartProAttrValue = new GuestCartProductAttribute();
                    $cartProAttrValue->guest_cart_id = $cart->id;
                    $cartProAttrValue->guest_cart_product_id = $add->id;
                    $cartProAttrValue->attribute_value_id = $attributeValueId;
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
                return redirect()->route('shopping-cart');

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
                return redirect()->route('shopping-cart');

            }
        }
    }

    public function getBrands(){
        $lang = LaravelLocalization::getCurrentLocale();
        $brands =  Brand::where('status',1)->get();
        list($schema, $metatags) = $this->brandsPageSeo();
        return view('website.brands',compact('brands','lang','schema','metatags'));
    }

}
