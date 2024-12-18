    <!--Featured Section Start-->
    <section class="content-inner overlay-white-middle">
        <div class="container">
            <div class="section-head style-2 wow fadeInUp" data-wow-delay="0.1s">
                <div class="left-content">
                    <h2 class="title">@lang('home.categories')</h2>
                    <p>@lang('home.discover your interests')</p>
                </div>
                <a href="{{LaravelLocalization::localizeUrl('products')}}" class="text-secondary font-14 d-flex align-items-center gap-1">
                    @lang('home.all_products') 
                    <i class="icon feather icon-chevron-right font-18"></i>
                </a>			
            </div>
            <div class="swiper swiper-eleven">
                <div class="swiper-wrapper">
                    @forelse ($categories as $index => $category )
                        <div class="swiper-slide wow fadeInUp" data-wow-delay="0.{{ $index ? $index + 1 :  $index + 2}}s">
                            <div class="category-product left">
                                <a href="{{LaravelLocalization::localizeUrl('category/'.$category->link)}}">								
                                    <img src="{{$category->image_source}}" alt="">
                                    <div class="category-badge">{{$category->name}}</div>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center" >
                            @lang('home.there are no categories')
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="pagination-align">
                <div class="eleven-button-prev btn-prev">
                    <i class="flaticon flaticon-left-chevron"></i>
                </div>
                <div class="eleven-button-next btn-next">
                    <i class="flaticon flaticon-chevron"></i>
                </div>
            </div>
        </div>
    </section>	
    <!--Featured Section End-->