<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}">

    <head>
        @include('web.head')
    </head>

    <body>
        <div class="page-wraper" id="scroll-container">

            @include('web.loader')
            @include('web.headers.index')
            
           @yield('content')


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
                                        <a href="index.html"><img src="images/logo.png" alt=""></a>
                                    </div>

                                </div>
                            </div>

                            <div class=" col-md-3 col-sm-4 col-6 wow fadeInUp" data-wow-delay="0.4s">
                                <div class="widget widget_services">
                                    <h5 class="footer-title">Useful Links</h5>
                                    <ul>
                                        <li><a href="index.html">Home</a></li>
                                        <li><a href="about-us.html">About us</a></li>
                                        <li><a href="shop-sidebar.html">All Products</a></li>
                                        <li><a href="contact.html">Contact Us</a></li>
                                        <li><a href="shop-cart.html">Shopping Cart</a></li>

                                    </ul>
                                </div>
                            </div>
                            <div class=" col-md-3 col-sm-4 wow fadeInUp" data-wow-delay="0.5s">
                                <div class="widget widget_services">
                                    <h5 class="footer-title">Our Categories</h5>
                                    <ul>
                                        <li><a href="shop-sidebar.html">Fans</a></li>
                                        <li><a href="shop-sidebar.html">Oven and Grill</a></li>
                                        <li><a href="shop-sidebar.html">Heaters</a></li>
                                        <li><a href="shop-sidebar.html">Vacuum Cleaner</a></li>
                                        <li><a href="shop-sidebar.html">Water Appliances</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class=" col-md-3 col-sm-4 wow fadeInUp" data-wow-delay="0.5s">
                                <div class="widget widget_services">
                                    <h5 class="footer-title">Contact With us</h5>
                                    <ul class="widget-address">
                                        <li>
                                            <p><span>Address</span> :25 Asmaa Fahmy - Ard ELgolf - Cairo  </p>
                                        </li>
                                        <li>
                                            <p><span>E-mail</span> : info@i-home.com</p>
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
                <div class="footer-bottom">
                    <div class="container">
                        <div class="row fb-inner wow fadeInUp" data-wow-delay="0.1s">
                            <div class=" col-md-12 text-center">
                                <p class="copyright-text">All Rights Reserved I Home, Developed and Designed by
                                    <a href="https://begroup.com/">BeGroup</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer Bottom End -->

            </footer>
            <!-- Footer End -->
            <ul id=" " class="social-sec " style="transform: translate(15%, 100%); ">
                <li class="Icon call ">
                    <a href="{{config('')}}" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-secondary-fast">
                        <i class="fa fa-phone"></i>
                    </a>
                </li>
                <li class="Icon whatsapp ">
                    <a href="https://wa.me/+201017152542" target="_blank ">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </li>
            
            </ul>
            <button class="scroltop" type="button"><i class="fas fa-arrow-up"></i></button>
            <!-- Designed by Mohamed Seif -->
            <!-- SearchBar -->
            <div class="dz-search-area dz-offcanvas offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    &times;
                </button>
                <div class="container">
                    <form class="header-item-search">
                        <div class="input-group search-input">
                            
                            <input type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Search Product">
                            <button class="btn" type="button">
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="10.0535" cy="10.5399" r="7.49047" stroke="#0D775E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15.2632 16.1387L18.1999 19.0677" stroke="#0D775E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    
                    
                    </form>
                    
                </div>
            </div>
            <!-- SearchBar -->
            <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Contact</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="list-unstyled footer-widget__contact phone">
                                    <li>
                                        <i class="agrikon-icon-telephone"></i>
                                        <a href="tel:+201001503703"><span>Customer Service :</span>01001503703</a>
                                    </li>
                                    <li>
                                        <i class="agrikon-icon-telephone"></i>
                                        <a href="tel:+201001503703"><span>Maintenance Service :</span>2 25285832</a>
                                    </li>
                                    <li>
                                        <i class="agrikon-icon-telephone"></i>
                                        <a href="tel:+225285832"><span>Office Services :</span> 225285832</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="{{ Helper::frontFilesPath('js/jquery.min.js') }}"></script><!-- JQUERY MIN JS -->
            <script src="{{ Helper::frontFilesPath('vendor/wow/wow.min.js') }}"></script><!-- WOW JS -->
            <script src="{{ Helper::frontFilesPath('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script><!-- BOOTSTRAP MIN JS -->
            <script src="{{ Helper::frontFilesPath('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script><!-- BOOTSTRAP SELECT MIN JS -->
            <script src="{{ Helper::frontFilesPath('vendor/bootstrap-touchspin/bootstrap-touchspin.js') }}"></script><!-- BOOTSTRAP TOUCHSPIN JS -->
            <script src="{{ Helper::frontFilesPath('vendor/counter/waypoints-min.js') }}"></script><!-- WAYPOINTS JS -->
            <script src="{{ Helper::frontFilesPath('vendor/counter/counterup.min.js') }}"></script><!-- COUNTERUP JS -->
            <script src="{{ Helper::frontFilesPath('vendor/swiper/swiper-bundle.min.js') }}"></script><!-- SWIPER JS -->
            <script src="{{ Helper::frontFilesPath('vendor/imagesloaded/imagesloaded.js') }}"></script><!-- IMAGESLOADED-->
            <script src="{{ Helper::frontFilesPath('vendor/imagesloaded/imagesloaded.js') }}"></script><!-- IMAGESLOADED-->
            <script src="{{ Helper::frontFilesPath('vendor/masonry/masonry-4.2.2.js') }}"></script><!-- MASONRY -->
            <script src="{{ Helper::frontFilesPath('vendor/masonry/isotope.pkgd.min.js') }}"></script><!-- ISOTOPE -->
            <script src="{{ Helper::frontFilesPath('vendor/countdown/jquery.countdown.js') }}"></script><!-- COUNTDOWN FUCTIONS  -->
            <script src="{{ Helper::frontFilesPath('vendor/wnumb/wNumb.js') }}"></script><!-- WNUMB -->
            <script src="{{ Helper::frontFilesPath('vendor/nouislider/nouislider.min.js') }}"></script><!-- NOUSLIDER MIN JS-->
            <script src="{{ Helper::frontFilesPath('js/dz.carousel.js') }}"></script><!-- DZ CAROUSEL JS -->
            <script src="{{ Helper::frontFilesPath('vendor/lightgallery/dist/lightgallery.min.js') }}"></script>
            <script src="{{ Helper::frontFilesPath('vendor/lightgallery/dist/plugins/thumbnail/lg-thumbnail.min.js') }}"></script>
            <script src="{{ Helper::frontFilesPath('vendor/lightgallery/dist/plugins/zoom/lg-zoom.min.js') }}"></script>
            <script src="{{ Helper::frontFilesPath('js/dz.ajax.js') }}"></script><!-- AJAX -->
            <script src="{{ Helper::frontFilesPath('js/custom.js') }}"></script><!-- CUSTOM JS -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

            <script>
                $(document).ready(function() {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            'lang': @json($lang)
                        }
                    });
                   
                });
            </script>

            @yield('script')
           
            <script>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        toastr.error('{{ $error }}');
                    @endforeach
                @endif

                @if (session()->has('success'))
                
                        toastr.success('{{ session('success') }}');
                
                @endif
            </script>
        </body>

</html>
