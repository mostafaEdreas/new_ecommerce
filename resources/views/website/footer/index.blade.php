            <!-- Footer -->
            <footer class="site-footer style-1">
                <div class="dz-bnr-inr style-1" style="background-image:url(images/background/bg-shape.jpg);"></div>
                <!-- Footer Top -->
                <div class="footer-top">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="widget widget_about me-2">
                                    <div class="footer-logo logo-white">
                                        <a href="{{LaravelLocalization::localizeUrl('/')}}"><img src="{{config('site_logo')}}" alt="image"></a>
                                    </div>

                                </div>
                            </div>

                            <div class=" col-md-3 col-sm-4 col-6 wow fadeInUp" data-wow-delay="0.4s">
                                <div class="widget widget_services">
                                    <h5 class="footer-title">@lang('home.quick_links')</h5>
                                    <ul>
                                        @foreach ($menus as $menu)
                                            @if ($menu->segment === 'home')
                                                <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{$menu->name}}</a></li>
                                            @else
                                                <li><a href="{{LaravelLocalization::localizeUrl($menu->segment)}}">{{$menu->name}}</a></li>
                                            @endif

                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class=" col-md-3 col-sm-4 wow fadeInUp" data-wow-delay="0.5s">
                                <div class="widget widget_services">
                                    <h5 class="footer-title">@lang('home.Our Categories')</h5>
                                    <ul>
                                        @foreach($public_categories as $category)
                                            <li><a href="{{LaravelLocalization::localizeUrl('category/' .$category->link)}}">{{$category->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class=" col-md-3 col-sm-4 wow fadeInUp" data-wow-delay="0.5s">
                                <div class="widget widget_services">
                                    <h5 class="footer-title">@lang('home.Contact details')</h5>
                                    <ul class="widget-address">
                                        <li>
                                            <p><span>@lang('home.address')</span>: {{ config('site_address1') }}  </p>
                                        </li>
                                        <li>
                                            <p><span>@lang('home.email')</span>: {{ config('site_email') }}</p>
                                        </li>
                                        <li>
                                            <p><a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-secondary-fast">Call us </a></p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer Top End -->

                <!-- Footer Bottom -->
                @include('website.footer.copy-right')
                <!-- Footer Bottom End -->

            </footer>
            <!-- Footer End -->
            @include('website.footer.call-modal')
            <ul id=" " class="social-sec " style="transform: translate(15%, 100%); ">
                <li class="Icon call ">
                    <a href="tel:+2{{config('site_mobile')}}" target="_blank ">
                        <i class="fa fa-phone"></i>
                    </a>
                </li>
                <li class="Icon whatsapp ">
                    <a href="https://wa.me/+2{{config('site_whatsapp')}}" target="_blank ">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </li>
              
            </ul>
            <button class="scroltop" type="button"><i class="fas fa-arrow-up"></i></button>
