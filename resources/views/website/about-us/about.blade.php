@if($about)
    <section class="content-inner overlay-white-dark overflow-hidden"
        style="background-image: url('{{Helper::frontFilesPath('images/background/bg1.jpg')}}'); background-repeat: no-repeat; background-size: cover;">
        <div class="container">
            <div class="row about-style1 align-items-center">
                <div class="col-lg-6 m-b30">
                    <div class="position-relative">
                        <div class="about-thumb wow fadeInUp" data-wow-delay="0.1s">
                            <img src="{{$about->image_source}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 m-b30 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="px-lg-4">
                        <div class="section-head">
                            <h2 class="title"> {{$about->title}}</h2>
                        </div>
                        <div class="swiper swiper-five">

                            <div class="about-content">
                                <p class="para-text">
                                   {!! $about->text !!}
                                </p>
                            </div>
                            <a class="btn btn-secondary  me-xl-3 me-2 btnhover20" href="{{LaravelLocalization::localizeUrl('about-us')}}">@lang('home.read_more')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About End -->
@endif