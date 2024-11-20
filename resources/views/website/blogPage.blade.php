@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp

    @php echo $schema @endphp
@endsection
@section('content')
<div class="rts-navigation-area-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="navigator-breadcrumb-wrapper">
                    <a href="{{LaravelLocalization::localizeUrl('/') }}">@lang('home.home')</a>
                    <i class="fa-regular fa-chevron-right"></i>
                    <a  href="{{LaravelLocalization::localizeUrl('blogs') }}">@lang('home.blogs')</a>
                    <i class="fa-regular fa-chevron-right"></i>
                    <a class="current" href="javascript:void(0)">{{ $blog->{'title_'.$lang} }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-seperator">
    <div class="container">
        <hr class="section-seperator">
    </div>
</div>


<!-- blog sidebar area start -->
<div class="blog-sidebar-area rts-section-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 order-lg-1 order-md-2 order-sm-2 order-2">
                <div class="blog-details-area-1">
                    <div class="thumbnail">
                        <img src="{{Helper::uploadedImagesPath('blogitems',$blog->image)}}" alt="">
                    </div>
                    <div class="body-content-blog-details">
                        <div class="top-tag-time">
                            <div class="single">
                                <i class="fa-solid fa-clock"></i>
                                <span>{{ date_format($blog->updated_at,'d M; Y') }}</span>
                            </div>
                        </div>
                        <h1 class="title">{{$blog->{'title_'.$lang} }} </h1>
                        <p class="disc">
                            {!! $blog->{'text_'.$lang} !!}                        </p>





                        <div class="tag-social-share-wrapper-area-wrapper">
                            {{-- <div class="tags-area">
                                <span>الوسوم</span>
                                <button>عضوي</button>
                                <button>حلقات</button>
                                <button> تخييم</button>
                            </div> --}}
                            <div class="social-icons">
                                <span>@lang('home.social_media')</span>
                                <ul>
                                    @if ($setting->facebook)
                                    <li><a href="{{$setting->facebook}}"><i class="fa-brands fa-facebook-f"></i></a></li>
                                    @endif
                                    @if ($setting->twitter)
                                    <li><a href="{{$setting->twitter}}"><i class="fa-brands fa-fatwitter"></i></a></li>
                                    @endif
                                    @if ($setting->instagram)
                                    <li><a href="{{$setting->instagram}}"><i class="fa-brands fa-instagram"></i></a></li>
                                    @endif

                                </ul>
                            </div>
                        </div>
                        <!-- <div class="blog-details-author">
                            <div class="thumbnail">
                                <img src="assets/images/blog/01.png" alt="">
                            </div>
                            <div class="author-information">
                                <span>
                                    المؤلف
                                </span>
                                <h5 class="title">فينيللا والتون</h5>
                                <p>
                                    قم بتضمين بعض النصوص الافتراضية هنا لعرضها كجزء من التصميم النهائي. هذه النصوص ستساعد في تحسين مظهر المحتوى عند تقديمه للعميل.
                                </p>
                                <div class="social">
                                    <ul>
                                        <li><a href="#"><i class="fa-brands fa-dribbble"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="col-lg-4 pl--60 order-lg-2 order-md-1 order-sm-1 order-1 pl_md--10 pl_sm--10 rts-sticky-column-item">
                {{-- <div class="blog-sidebar-single-wized">
                    <form action="#">
                        <input type="text" placeholder="ابحث هنا" required>
                        <button><i class="fa-regular fa-magnifying-glass"></i></button>
                    </form>
                </div> --}}

                <div class="blog-sidebar-single-wized with-title">
                    <h4 class="title">@lang('home.categories')</h4>
                    <div class="category-main-wrapper">
                        <!-- single category area start -->
                        @foreach ($blogCategories as $blogCategory)
                        <div class="single-category-area">
                            <p> {{ $blogCategory->{'title_'.$lang} }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="blog-sidebar-single-wized with-title">
                    <h4 class="title">@lang('home.list of our latests blogs and news')</h4>
                    <div class="latest-post-small-area-wrapper">
                        <!-- single Latest news -->
                        @foreach ($blogs as $related_blog)
                        <div class="single-latest-post-area">
                            <a href="#" class="thumbnail">
                                <img src="{{Helper::uploadedImagesPath('blogitems',$related_blog->image)}}" alt="thumbnail">
                            </a>
                            <div class="inner-content-area">
                                <div class="icon-top-area">
                                    <i class="fa-light fa-clock"></i>
                                    <span>{{ date_format($blog->updated_at,'d M; Y') }}</span>
                                </div>
                                <a href="#">
                                    <h5 class="title-sm-blog">
                                        {{$related_blog->{'title_'.$lang} }}
                                    </h5>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                {{-- <div class="blog-sidebar-single-wized with-title">
                    <h4 class="title">الوسوم</h4>
                    <div class="tags-area-blog-short-main">
                        <!-- single -->
                        <button class="single-category">شامبو</button>
                        <!-- single end -->
                        <!-- single -->
                        <button class="single-category">زبدة</button>
                        <!-- single end -->
                        <!-- single -->
                        <button class="single-category">عيد ميلاد</button>
                        <!-- single end -->
                        <!-- single -->
                        <button class="single-category">هدايا</button>
                        <!-- single end -->
                        <!-- single -->
                        <button class="single-category">عناية الوجه</button>
                        <!-- single end -->
                        <!-- single -->
                        <button class="single-category">أخضر</button>
                        <!-- single end -->
                        <!-- single -->
                        <button class="single-category">لوشن</button>
                        <!-- single end -->
                        <!-- single -->
                        <button class="single-category">مقشر</button>
                        <!-- single end -->
                    </div>
                </div> --}}
            </div>

        </div>
    </div>
</div>

@endsection

