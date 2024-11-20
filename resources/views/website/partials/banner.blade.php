@if(count($homesliders)>0)
   <!-- Offer Banner section Start -->
   <section class="offer-banner">
      <div class="container-lg">
        <div class="row g-3 g-xl-4">

          <div class="col-md-6 ratio_asos">

            <div class="row g-3 g-xl-4">
            @if(count($homesliders)>0)
              <div class="col-6 wow fadeInUp" data-wow-delay="0.4s">
                <div class="offer-box">
                  <img class="bg-img" src="{{Helper::uploadedImagesPath('sliders/home-sliders',$homesliders[0]->image)}}" alt="banner" />
                  <div class="content-box right-align">
                    <h4>{{ $homesliders[0]->title }}</h4>
                    @if ($homesliders[0]->link)
                    <div class="btn-style4">
                      <a href="{{ url($homesliders[0]->link) }}" class="btn btn-outline btn-sm">
                        <span class="corner-wrap left-top">
                          <span class="corner"></span>
                        </span>
                        <span class="corner-wrap right-bottom">
                          <span class="corner"></span>
                        </span>
                        {{__('home.shop_now')}}
                      </a>
                    </div>

                    @endif

                  </div>
                </div>
              </div>
            @endif
            @if(count($homesliders)>1)
              <div class="col-6 wow fadeInUp" data-wow-delay="0.6s">
                <div class="offer-box secound">
                  <img class="bg-img" src="{{Helper::uploadedImagesPath('sliders/home-sliders',$homesliders[1]->image)}}" alt="banner" />
                  <div class="dark-bodered-box">
                    <div class="bordered-wrap">
                      <div class="bordered-content">
                        <span class="corner-wrap left-top">
                          <span class="corner"></span>
                        </span>
                        <span class="corner-wrap right-top">
                          <span class="corner"></span>
                        </span>
                        <span class="corner-wrap right-bottom">
                          <span class="corner"></span>
                        </span>
                        <span class="corner-wrap left-bottom">
                          <span class="corner"></span>
                        </span>

                        <div>
                          <h4 class="offer" style="color: aliceblue;"> {{$homesliders[1]->title}}</h4>
                          <h6>{{$homesliders[1]->text}}</h6>
                          @if ($homesliders[1]->link)
                            <a class="link-explore" href="{{ url($homesliders[1]->link) }}">{{__('home.featuredProducts')}} </a>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endif
            </div>
          </div>
        @if(count($homesliders)>2)
          <div class="col-md-6 ratio2_3 wow fadeInUp" data-wow-delay="0.8s">
            <div class="offer-box landscape">
              <img class="bg-img" src="{{Helper::uploadedImagesPath('sliders/home-sliders',$homesliders[2]->image)}}" alt="banner" />
              <div class="content-box left-align">
                <h4>{{$homesliders[2]->title}}</h4>
                <h5>{{$homesliders[2]->text}}</h5>
            @if ($homesliders[2]->link)
                <div class="btn-style4">
                  <a href="{{ url($homesliders[2]->link) }}" class="btn btn-outline btn-sm">
                    <span class="corner-wrap left-top">
                      <span class="corner"></span>
                    </span>
                    <span class="corner-wrap right-bottom">
                      <span class="corner"></span>
                    </span>
                    {{__('home.shop_now')}}
                  </a>
                </div>
            @endif
              </div>
            </div>
          </div>
        @endif
        
        
        </div>
      </div>
    </section>
    <!-- Offer Banner section End -->
    <!--Parallax Banner-->
    <!-- <div class="section parallax-banner-style1 py-0">
        <div class="">
            <div class="hero hero-large hero-overlay bg-size">
                <img class="bg-img" src="{{Helper::uploadedImagesPath('sliders/intro-sliders',$introSlider->image)}}" alt="{{$introSlider->title}}" width="1920" height="645" />
                <div class="hero-inner d-flex-justify-center">
                    <div class="container">
                        <div class="wrap-text center text-white">
                            <h1 class="hero-title text-white">{{$introSlider->title}}</h1>
                            <p class="hero-details">{{$introSlider->text}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!--End Parallax Banner-->

@endif
