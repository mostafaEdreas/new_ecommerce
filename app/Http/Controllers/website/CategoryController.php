<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\AboutStruc;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Traits\SeoTrait;

class CategoryController extends Controller
{

    use SeoTrait;

    public function index($category_link)
    {
        $data['color'] = Attribute::active()->where('name_ar' ,'اللون' )->where('name_en' ,'color' )->first();
        $data['categories'] = Category::active()->get();
        $data['products'] = Product::active()->whereHas('category',function($q) use($category_link){
            $q->where('link_ar',$category_link)
            ->orWhere('link_en' ,$category_link);
        })->hasStock()->filterProduct()->paginate(2)->appends(request()->query());;
        list($data['schema'], $data['metatags']) = $this->productSPageSeo();

        return view('website.products.index',$data);
    }

}
