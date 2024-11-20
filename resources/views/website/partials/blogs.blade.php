@if (count($blogs))
        <!-- rts top tranding product area -->
        <div class="blog-area-start rts-section-gapBottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="title-area-between">
                            <h2 class="title-left mb--0">
                                @lang('home.blog')
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cover-card-main-over">
                            <div class="row g-4">
                                @foreach ($blogs as $blog )
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <!-- single blog area start -->
                                    <div class="single-blog-area-start">
                                        <a href="{{LaravelLocalization::localizeUrl('blog/'.$blog->{'link_'.$lang})}}" class="thumbnail">
                                            @if ($blog->image)
                                                <img src="{{ Helper::uploadedImagesPath('blogItems', $blog->image) }}"  alt="grocery">
                                            @else
                                                <img src="{{url('resources/assets/back/img/noimage.png')}}"  alt="grocery">
                                            @endif
                                        </a>
                                        <div class="blog-body">
                                            <div class="top-area">
                                                <div class="single-meta">
                                                    <i class="fa-light fa-clock"></i>
                                                    <span>{{ date_format($blog->updated_at,'d M; Y') }}</span>
                                                </div>

                                            </div>
                                            <a href="{{LaravelLocalization::localizeUrl('blog/'.$blog->{'link_'.$lang})}}">
                                                <h4 class="title">
                                                   {{$blog->{'title_'.$lang} }}
                                                </h4>
                                            </a>
                                            <a href="{{LaravelLocalization::localizeUrl('blog/'.$blog->{'link_'.$lang})}}" class="shop-now-goshop-btn">
                                                <span class="text">@lang('home.read_more')</span>
                                                <div class="plus-icon">
                                                    <i class="fa-sharp fa-regular fa-plus"></i>
                                                </div>
                                                <div class="plus-icon">
                                                    <i class="fa-sharp fa-regular fa-plus"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- single blog area end -->
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @if (Request::segment(2)!='blogs')
                <div class="text-center mt-5">
                    <a href="{{LaravelLocalization::localizeUrl('blogs')}}" class="rts-btn btn-primary radious-sm with-icon">
                        <div class="btn-text">
                            @lang('home.See More')
                        </div>
                        <div class="arrow-icon">
                            <i class="fa-regular fa-cart-shopping"></i>
                        </div>
                        <div class="arrow-icon">
                            <i class="fa-regular fa-cart-shopping"></i>
                        </div>
                    </a>
                </div>
                @endif

            </div>
        </div>
        <!-- rts top tranding product area end -->
@endif
