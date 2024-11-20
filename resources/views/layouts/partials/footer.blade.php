
     <!-- rts footer one area start -->
      <div id='footer-size' class="rts-footer-area pt--60 bg_light-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-main-content-wrapper pb--70">
                        <!-- single footer area wrapper -->
                        <div class="single-footer-wized">
                            <h3 class="footer-title">@lang('home.about_app')</h3>
                            <div class="call-area">
                                <div class="icon">
                                    <i class="fa-solid fa-phone-rotary"></i>
                                </div>
                                <div class="info">
                                    <span>@lang('home.call_us')</span>
                                    <a href="#" class="number" tel='+2{{$setting->mobile}}'>{{$setting->mobile}}</a>
                                </div>
                                <p>
                                  {!! $configration->about_app !!}
                                </p>
                            </div>
                            {{-- <div class="opening-hour">
                                <div class="single">
                                    <p>Monday - Friday: <span>8:00am - 6:00pm</span></p>
                                </div>
                                <div class="single">
                                    <p>Saturday: <span>8:00am - 6:00pm</span></p>
                                </div>
                                <div class="single">
                                    <p>Sunday: <span>Service Close</span></p>
                                </div>
                            </div> --}}
                        </div>
                        <!-- single footer area wrapper -->
                        <!-- single footer area wrapper -->
                        {{-- <div class="single-footer-wized">
                            <h3 class="footer-title">Our Stores</h3>
                            <div class="footer-nav">
                                <ul>
                                    <li><a href="#">Delivery Information</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Terms & Conditions</a></li>
                                    <li><a href="#">Support Center</a></li>
                                    <li><a href="#">Careers</a></li>
                                </ul>
                            </div>
                        </div> --}}
                        <!-- single footer area wrapper -->
                        <!-- single footer area wrapper -->
                        <div class="single-footer-wized">
                            <h3 class="footer-title">@lang('home.categories')</h3>
                            <div class="footer-nav">
                                <ul>
                                  @foreach ($mainCategories as $categoryMenu)
                                    @if (!count($categoryMenu->subCategories))
                                      <li><a href="{{ LaravelLocalization::localizeUrl('products?') . 'category_id=' . $categoryMenu->id}}">{{ $categoryMenu->{'name_' . $lang} }}</a></li>

                                    @endif
                                  @endforeach
                                    
                                </ul>
                            </div>
                        </div>
                        <!-- single footer area wrapper -->
                        <!-- single footer area wrapper -->
                        <div class="single-footer-wized">
                            <h3 class="footer-title">@lang('home.quick_links')</h3>
                            <div class="footer-nav">
                                <ul>
                                  @foreach ($menus as $menu)
                                    <li><a href="{{ LaravelLocalization::localizeUrl($menu->type) }}"> {{ $menu->{'name_' . $lang} }}</a></li>
                                  @endforeach
                                  
                                </ul>
                            </div>
                        </div>
                        <!-- single footer area wrapper -->
                        <!-- single footer area wrapper -->
                        {{-- <div class="single-footer-wized">
                            <h3 class="footer-title">Our Newsletter</h3>
                            <p class="disc-news-letter">
                                Subscribe to the mailing list to receive updates one <br> the new arrivals and other discounts
                            </p>
                            <form class="footersubscribe-form" action="#">
                                <input type="email" placeholder="Your email address" required>
                                <button class="rts-btn btn-primary">Subscribe</button>
                            </form>

                            <p class="dsic">
                                I would like to receive news and special offer
                            </p>
                        </div> --}}
                        <!-- single footer area wrapper -->
                    </div>
                    <div class="social-and-payment-area-wrapper">
                        <div class="social-one-wrapper">
                            <span>Follow Us:</span>
                            <ul>
                              @if ($setting->facebook)
                              <li><a href="{{$setting->facebook}}"><i class="fa-brands fa-facebook-f"></i></a></li>

                              @endif
                              @if ($setting->twitter)
                              <li><a href="{{$setting->twitter}}"><i class="fa-brands fa-twitter"></i></a></li>
                              @endif
                              @if ($setting->youtube)
                              <li><a href="{{$setting->youtube}}"><i class="fa-brands fa-youtube"></i></a></li>
                              @endif
                              @if ($setting->whatsapp)
                              <li><a href="{{$setting->whatsapp}}"><i class="fa-brands fa-whatsapp"></i></a></li>

                              @endif
                              @if ($setting->instagram)
                              <li><a href="{{$setting->instagram}}"><i class="fa-brands fa-instagram"></i></a></li>
                              @endif
                              
                               
                            </ul>
                        </div>
                        <div class="payment-access">
                            <span>@lang('home.payment_method')</span>
                            <img src="{{url('resources/assets/front/images/payment/01.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts footer one area end -->