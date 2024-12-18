<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\AboutStruc;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Traits\SeoTrait;

class HomeController extends Controller
{

    use SeoTrait;

    public function index()
    {
        $data['sliders'] = Slider::active()->get();
        $data['categories'] = Category::active()->get();
        $data['grouped_products'] = Product::active()->take(10)->inRandomOrder()->get();
        $data['offers'] = Product::active()->take(10)->whereHas('discount')->inRandomOrder()->get();
        $data['products'] =Product::active()->take(10)->inRandomOrder()->get();
        $data['about_sraucs'] = AboutStruc::active()->get();
        list($data['schema'], $data['metatags']) = $this->homePageSeo();
        return view('website.home.index',$data);
    }

}
