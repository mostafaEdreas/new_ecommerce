<section class="content-inner-1">
    <div class="container">
        <div class="section-head style-2 wow fadeInUp" data-wow-delay="0.1s">
            <div class="left-content">
                <h2 class="title">@lang('home.offers')</h2>
            </div>
            <a href="shop-sidebar.html" class="text-secondary font-14 d-flex align-items-center gap-1">
                @lang('home.all offers')
                <i class="icon feather icon-chevron-right font-18"></i>
            </a>
        </div>
        <div class="swiper-btn-center-lr">
            <div class="swiper swiper-twelve">
                <div class="swiper-wrapper">
                   @include('website.home.partials.product-cart', ['array' => $offers])
                </div>
            </div>
            <div class="pagination-align">
                <div class="twelve-button-prev btn-prev">
                    <i class="flaticon flaticon-left-chevron"></i>
                </div>
                <div class="twelve-button-next btn-next">
                    <i class="flaticon flaticon-chevron"></i>
                </div>
            </div>
        </div>
    </div>
</section>