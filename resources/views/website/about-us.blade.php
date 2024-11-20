@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp
    @php echo $schema @endphp
@endsection

@section('content')
    <div class="about-banner-area-bg rts-section-gap bg_iamge">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content-about-area">
                        <h1 class="title">@lang('home.about-us')</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts banner area about end -->
    <!-- rts counter area start -->
    <div class="rts-counter-area">
        <div class="container-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="counter-area-main-wrapper">
                        @foreach ($counters as $counter)
                            <div class="single-counter-area">
                                <h2 class="title"><span class="counter">{{ $counter->number }}</span>M+</h2>
                                <p>
                                    {{ $counter->{'name_' . $lang} }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts counter area end -->
    <!-- about area start -->
    <div class="rts-about-area rts-section-gap2">
        <div class="container-3">
            <div class="row">
                <div class="col-lg-5">
                    <div class="thumbnail-left">
                        <img src="{{ Helper::uploadedImagesPath('aboutStrucs', $about->image) }}" alt="">
                    </div>
                </div>
                <div class="col-lg-7 pl--60 pl_md--10 pt_md--30 pl_sm--10 pt_sm--30">
                    <div class="about-content-area-1">
                        <h2 class="title">
                            {{ $about->{'title_' . $lang} }}
                        </h2>
                        <p class="disc">
                            {!! $about->{'text_' . $lang} !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about area end -->
    <!-- section-seperator start -->
    <div class="section-seperator">
        <div class="container-3">
            <hr class="section-seperator">
        </div>
    </div>
    <!-- section-seperator start -->
    <!-- meet our expart team -->
    <div class="meet-our-expart-team rts-section-gap2">
        <div class="container-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-center-area-main">
                        <h2 class="title">
                            @lang('home.our teams')
                        </h2>
                        <p class="disc">
                            @lang('home.Our dedicated team consists of experts in multiple fields to ensure that we provide the best products and services to our customers. We are committed to providing the highest levels of quality and innovation in all aspects of our work')
                        </p>
                    </div>
                </div>
            </div>
            <div class="row g-5 mt--40">
                @foreach ($teams as $team)
                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                        <!-- single team area start -->
                        <div class="single-team-style-one">
                            <a href="#" class="thumbnail">
                                <img src="{{ Helper::uploadedImagesPath('teams', $team->img) }}" alt="team_single">
                            </a>
                            <div class="bottom-content-area">
                                <div class="top">
                                    <h3 class="title">
                                        {{ $team->name }}
                                    </h3>
                                    <span class="designation"> {{ $team->position }}</span>
                                </div>

                            </div>
                        </div>
                        <!-- single team area end -->
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- choosing reason service area start -->
    <div class="rts-service-area rts-section-gap2 bg_light-1">
        <div class="container-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-center-area-main">
                        <h2 class="title">
                            @lang('home.why choose us')
                        </h2>
                        <p class="disc">
                            @lang('home.We are committed to providing the best camping equipment and services to ensure an unforgettable outdoor experience. Discover why we are the perfect choice for camping enthusiasts.')
                        </p>
                    </div>
                </div>
            </div>
            <div class="row mt--30 g-5">
                @foreach ($aboutStrucs as $index => $aboutStruc)
                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="single-service-area-style-one">
                            <div class="icon-area">
                                <span class="bg-text">{{ $index + 1 }}</span>
                                    @if ($aboutStruc->image)
                                        <img src="{{Helper::uploadedImagesPath('aboutStrucs', $aboutStruc->image) }}"  alt="grocery">
                                    @else
                                        <img src="{{url('resources/assets/back/img/noimage.png')}}"  alt="grocery">
                                    @endif
                            </div>
                            <div class="bottom-content">
                                <h3 class="title">
                                    {{ $aboutStruc->title }}
                                </h3>
                                <p class="disc">
                                    {{ $aboutStruc->text }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- rts customers feedbacka area start -->
    <div class="rts-cuystomers-feedback-area rts-section-gap2">
        <div class="container-3">
            <div class="row">
                <div class="col-lgl-12">
                    <div class="title-area-left pl--0">
                        <h2 class="title-left mb--0">
                            @lang('home.testimonials')
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row mt--50">
                <div class="col-lg-12">
                    <div class="customers-feedback-area-main-wrapper">
                        <!-- rts category area satart -->
                        <div class="rts-caregory-area-one ">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="category-area-main-wrapper-one">
                                        <div class="swiper mySwiper-category-1 swiper-data"
                                            data-swiper='{
                                            "spaceBetween":24,
                                            "slidesPerView":2,
                                            "loop": true,
                                            "speed": 1000,
                                            "navigation":{
                                                "nextEl":".swiper-button-nexts",
                                                "prevEl":".swiper-button-prevs"
                                                },
                                            "breakpoints":{
                                            "0":{
                                                "slidesPerView":1,
                                                "spaceBetween": 24},
                                            "320":{
                                                "slidesPerView":1,
                                                "spaceBetween":24},
                                            "480":{
                                                "slidesPerView":1,
                                                "spaceBetween":24},
                                            "640":{
                                                "slidesPerView":1,
                                                "spaceBetween":24},
                                            "840":{
                                                "slidesPerView":1,
                                                "spaceBetween":24},
                                            "1140":{
                                                "slidesPerView":2,
                                                "spaceBetween":24}
                                            }
                                        }'>
                                            <div class="swiper-wrapper">
                                                @foreach ($testimonials as $testimonial)
                                                <!-- single swiper start -->
                                                <div class="swiper-slide">

                                                        <!-- single customers feedback area start -->
                                                        <div class="single-customers-feedback-area">
                                                            <div class="top-thumbnail-area">
                                                                <div class="left">
                                                                    @if ($testimonial->img)
                                                                        <img src="{{  Helper::uploadedImagesPath('testimonials', $testimonial->img) }}"  alt="grocery">

                                                                    @else
                                                                        <img src="{{url('resources/assets/back/img/noimage.png')}}"  alt="grocery">

                                                                    @endif
                                                                    <div class="information">
                                                                        <h4 class="title">
                                                                            {{ $testimonial->name }}
                                                                        </h4>
                                                                        <span>
                                                                            {{ $testimonial->position }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="right">
                                                                    <img src="{{ url('uploads/settings/source/' . $configration->app_logo) }}"
                                                                        alt="logo">
                                                                </div>
                                                            </div>
                                                            <div class="body-content">
                                                                <p class="disc">
                                                                    {{ $testimonial->text }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <!-- single customers feedback area end -->

                                                </div>
                                                @endforeach
                                                <!-- single swiper start -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- rts category area end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts customers feedbacka area end -->
    <!-- choosing reason service area end -->
    <!-- meet our expart end -->
@endsection
