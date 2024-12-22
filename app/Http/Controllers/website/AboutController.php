<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\AboutStruc;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Traits\SeoTrait;

class AboutController extends Controller
{

    use SeoTrait;

    public function index()
    {
        $data['sliders'] = Slider::active()->get();
        $data['about_strucs'] = AboutStruc::active()->get();
        list($data['schema'], $data['metatags']) = $this->aboutUsPageSeo();
        return view('website.about-us.index',$data);
    }

}
