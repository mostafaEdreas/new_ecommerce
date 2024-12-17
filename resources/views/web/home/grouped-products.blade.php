<section class="content-inner overlay-white-middle">
    <div class="container">
        <div class="left-content text-center pb-3">
            <h2 class="title">@lang('home.hot_offers')</h2>
        </div>
        <div class="row">
            @foreach ($grouped_products as $index => $group)
                <div class="col-md-3 wow fadeInUp pb-3" data-wow-delay="0.{{ $index ? $index + 1 :  $index + 2}}s">
                    <div class="category-product left">
                        <a href="shop-sidebar.html">								
                            <img src="{{$group->main_image_source}}" alt="">
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>