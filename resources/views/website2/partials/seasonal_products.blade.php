@if (count($new_products))
    <!-- rts grocery feature area start -->
    <div class="rts-grocery-feature-area rts-section-gapBottom mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area-between">
                        <h2 class="title-left">
                            @lang('home.seasonal products')
                        </h2>
                        <div class="next-prev-swiper-wrapper">
                            <div class="swiper-button-prev"><i class="fa-regular fa-chevron-left"></i></div>
                            <div class="swiper-button-next"><i class="fa-regular fa-chevron-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="category-area-main-wrapper-one">
                        <div class="swiper mySwiper-category-1 swiper-data" data-swiper='{
                            "spaceBetween":16,
                            "slidesPerView":6,
                            "loop": true,
                            "speed": 700,
                            "navigation":{
                                "nextEl":".swiper-button-next",
                                "prevEl":".swiper-button-prev"
                              },
                            "breakpoints":{
                            "0":{
                                "slidesPerView":1,
                                "spaceBetween": 12},
                            "320":{
                                "slidesPerView":1,
                                "spaceBetween":12},
                            "480":{
                                "slidesPerView":2,
                                "spaceBetween":12},
                            "640":{
                                "slidesPerView":2,
                                "spaceBetween":16},
                            "840":{
                                "slidesPerView":3,
                                "spaceBetween":16},
                            "1140":{
                                "slidesPerView":5,
                                "spaceBetween":16},
                            "1540":{
                                "slidesPerView":5,
                                "spaceBetween":16},
                            "1840":{
                                "slidesPerView":6,
                                "spaceBetween":16}
                            }
                        }'>
                            <div class="swiper-wrapper">
                                <!-- single swiper start -->
                                @foreach ($new_products as $product_main )
                                    <!-- single swiper start -->
                                    <div class="swiper-slide">
                                            @include('website.appendes.products.add_product_cart',['product_main'=>$product_main,'doesnt_use_forloop'=>true])
                                    </div>
                                    <!-- single swiper start -->
                                @endforeach
                                <!-- single swiper start -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts grocery feature area end -->
@endif
