@if($home_sliders)
    <div class="background-light-gray-color">
        <!-- rts banner area start -->
        <div class="rts-banner-area-one">

            <div class="category-area-main-wrapper-one">
                <div class="swiper mySwiper-category-1 swiper-data" data-swiper='{
                    "spaceBetween":1,
                    "slidesPerView":1,
                    "loop": true,
                    "speed": 2000,
                    "autoplay":{
                        "delay":"4000"
                    },
                    "navigation":{
                        "nextEl":".swiper-button-next",
                        "prevEl":".swiper-button-prev"
                    },
                    "breakpoints":{
                    "0":{
                        "slidesPerView":1,
                        "spaceBetween": 0},
                    "320":{
                        "slidesPerView":1,
                        "spaceBetween":0},
                    "480":{
                        "slidesPerView":1,
                        "spaceBetween":0},
                    "640":{
                        "slidesPerView":1,
                        "spaceBetween":0},
                    "840":{
                        "slidesPerView":1,
                        "spaceBetween":0},
                    "1140":{
                        "slidesPerView":1,
                        "spaceBetween":0}
                    }
                }'>
                    <div class="swiper-wrapper">
                        <!-- single swiper start -->
                        @foreach ($home_sliders as $slider )
                        <div class="swiper-slide">
                            <div class="banner-bg-image bg_image bg_one-banner  ptb--120 ptb_md--80 ptb_sm--60" style="background-image: url('{{ $slider->image?Helper::uploadedImagesPath("sliders/home-sliders",$slider->image):url("resources/assets/back/img/noimage.png")}}')" >
                                <div class="banner-one-inner-content">
                                    <span class="pre"> {{$slider->title}} </span>
                                    <h1 class="title">
                                        {!! $slider->text !!}
                                    </h1>
                                    <a href="{{LaravelLocalization::localizeUrl('products')}}" class="rts-btn btn-primary radious-sm with-icon">
                                        <div class="btn-text">
                                            @lang('home.products')
                                        </div>
                                        <div class="arrow-icon">
                                            <i class="fa-light fa-arrow-right"></i>
                                        </div>
                                        <div class="arrow-icon">
                                            <i class="fa-light fa-arrow-right"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- single swiper start -->
                        <!-- single swiper start -->

                        <!-- single swiper start -->

                    </div>

                    <button class="swiper-button-next"><i class="fa-regular fa-arrow-right"></i></button>
                    <button class="swiper-button-prev"><i class="fa-regular fa-arrow-left"></i></button>
                </div>
            </div>

        </div>
        <!-- rts banner area end -->

    </div>
    <!-- Home Section End -->
@endif
@if(count($home_categories))
        <!-- rts category area satart -->
        <div class="rts-caregory-area-one bg_light-1 py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="category-area-main-wrapper-one">
                            <div class="swiper mySwiper-category-1 swiper-data" data-swiper='{
                                "spaceBetween":12,
                                "slidesPerView":10,
                                "loop": true,
                                "speed": 1000,
                                "breakpoints":{
                                "0":{
                                    "slidesPerView":2,
                                    "spaceBetween": 12},
                                "320":{
                                    "slidesPerView":2,
                                    "spaceBetween":12},
                                "480":{
                                    "slidesPerView":3,
                                    "spaceBetween":12},
                                "640":{
                                    "slidesPerView":4,
                                    "spaceBetween":12},
                                "840":{
                                    "slidesPerView":4,
                                    "spaceBetween":12},
                                "1140":{
                                    "slidesPerView":10,
                                    "spaceBetween":12}
                                }
                            }'>
                                <div class="swiper-wrapper">
                                    @foreach ($home_categories as $category_home )
                                    <div class="swiper-slide">
                                        <a href="{{ LaravelLocalization::localizeUrl('category/' . $category_home->{'link_' . $lang}) }}" class="single-category-one">
                                            @if ($category_home->image)
                                                <img src="{{Helper::uploadedImagesPath('categories',$category_home->image)}}" alt="category">
                                            @else
                                                <img src="{{url('resources/assets/back/img/noimage.png')}}" alt="category">
                                            @endif
                                            <p> {{$category_home->{'name_'.$lang} }} </p>
                                        </a>
                                    </div>
                                    @endforeach
                                    <!-- single swiper start -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- rts category area end -->
@endif
