<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\AboutStruc;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Traits\SeoTrait;

class ProductController extends Controller
{

    use SeoTrait;

    public function index()
    {

        $data['color'] = Attribute::active()->where('name_ar' ,'اللون' )->where('name_en' ,'color' )->first();
        $data['categories'] = Category::active()->get();
        $data['products'] = Product::active()->hasStock()->filterProduct()->paginate(50)->appends(request()->query());;
        list($data['schema'], $data['metatags']) = $this->productSPageSeo();
        return view('website.products.index',$data);
    }

    public function show($link)
    {   
        $lang = app()->getLocale() ;

        $product = Product::where('link_'.$lang , $link)->first();
        if(!$product){
           return redirect()->back()->withErrors(__('home.not_found'));
        }
        $color =  $product->attributes->whereIn('value' ,['اللون' , 'color'] );
        $size =  $product->attributes->whereIn('value' ,['المقاس' , 'size'] );
        $data['color'] = $color->isEmpty() ? null : $color->first();
        $data['size'] = $size->isEmpty() ? null : $size->first();
        $data['related_products'] = Product::active()->byCategory($product->category_id)->hasStock()->take(10)->get() ;
        $data['related_products'] = $data['related_products']->isEmpty() ? Product::active()->hasStock()->take(10)->get() :  $data['related_products'];
        list($data['schema'], $data['metatags']) = $this->productPageSeo($product->id);
        $data['product'] = $product ;
        return view('website.product.index',$data);
    }

}
