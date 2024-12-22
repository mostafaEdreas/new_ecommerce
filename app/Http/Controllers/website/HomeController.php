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
        $data['grouped_products'] = Product::active()->hasStock()->take(10)->filterProduct()->inRandomOrder()->get();
        $data['offers'] = Product::active()->hasStock()->take(10)->whereHas('discount')->filterProduct()->inRandomOrder()->get();
        $data['products'] = Product::active()->hasStock()->take(10)->filterProduct()->inRandomOrder()->get();
        $data['about_strucs'] = AboutStruc::active()->get();
        list($data['schema'], $data['metatags']) = $this->homePageSeo();
        return view('website.home.index',$data);
    }

}
