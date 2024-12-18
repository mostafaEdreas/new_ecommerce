@if(count($offerSliders)>1)
 <!-- Sub Banner Section Start -->
 <section class="sub-banner-5 pt-0">
      <div class="container-lg">
        <div class="sub-banner">
          <img class="bg-img" src="{{Helper::uploadedImagesPath('sliders/offers-sliders',$offerSliders[1]->image)}}" alt="sub-banner" />

          <div class="content-box">

            <h5 class="title-banner">
              <span class="after">{{__('home.deal')}}</span> {{$offerSliders[1]->title}}
              <span class="offer">{!! $offerSliders[1]->text !!}<span> <span class="span-1">%</span><span class="span-2">{{__('home.discount')}}</span></span>
            </span>
              </span>
            </h5>
            <h6 class="collection-title"><span class="line"></span>{{$offerSliders[1]->text_2}}  </h6>
            <div class="btn-box">
              @if($offerSliders[1]->link)
                <div class="btn-style4">
                  <a href="{{LaravelLocalization::localizeUrl('product/'.$offerSliders[1]->{'link_'.$lang})}}" class="btn">
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

              <div class="contact-info">
                <a class="phone-link" href="tel:{{$setting->mobile}}" dir="ltr">
                  <img src="{{Helper::imageFilesPath('icons/svg/phone-book.svg')}}" alt="phone-book" />
                  {{__('home.contact_us')}} 
                </a>

                <ul class="social-list">
                  @if ($setting->facebook)
                      <li>
                        <a href="{{ $setting->facebook }}" target="_blank"> <i  data-feather="facebook"></i></a>
                      </li>
                  @endif
                  @if ($setting->instgram)
                      <li>
                        <a href="{{ $setting->instgram }}" target="_blank"> <i  data-feather="instagram"></i></a>
                      </li>
                  @endif
                  @if ($setting->twitter)
                      <li>
                        <a href="{{ $setting->twitter }}" target="_blank"> <i  data-feather="twitter"></i></a>
                      </li>
                  @endif
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Sub Banner Section End -->
<!--End Service Section-->
@endif
