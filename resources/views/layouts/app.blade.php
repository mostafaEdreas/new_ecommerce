<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon"
        href="{{ url('uploads/settings/source/' . $configration->about_image) }}">
    <!-- plugins css -->


    @yield('meta')

    @include('layouts.partials.hreflang')
    <link rel="stylesheet preload" href="{{ Helper::cssFilesPath('plugins.css') }}" as="style">

    <link rel="stylesheet preload" href="{{ Helper::cssFilesPath('style.css') }}" as="style">
    <link rel="stylesheet preload" href="{{ Helper::cssFilesPath('Youseff.css') }}" as="style">
    <link rel="stylesheet preload" href="{{ Helper::cssFilesPath('styleRtl.css') }}" as="style">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @if($lang == 'en' )
        <link rel="stylesheet preload" href="{{ Helper::cssFilesPath('style_en.css') }}" as="style">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @yield('style')

    <!-- Google Tag Manager -->
    {!! $setting->GTM_script ? html_entity_decode($setting->GTM_script) : '' !!}
    <!-- End Google Tag Manager -->

    @if ($setting->GTM_id)
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', "{{ $setting->GTM_id }}");
        </script>
    @endif
</head>

<body class="shop-main-h">
    <!-- Loader Start -->
<!--================= Preloader Section Start Here =================-->
<div id="weiboo-load">
    <div class="preloader-new">
        <svg class="cart_preloader" role="img" aria-label="Shopping cart_preloader line animation"
            viewBox="0 0 128 128" width="128px" height="128px" xmlns="http://www.w3.org/2000/svg">
            <g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="8">
                <g class="cart__track" stroke="hsla(0,10%,10%,0.1)">
                    <polyline points="4,4 21,4 26,22 124,22 112,64 35,64 39,80 106,80" />
                    <circle cx="43" cy="111" r="13" />
                    <circle cx="102" cy="111" r="13" />
                </g>
                <g class="cart__lines" stroke="currentColor">
                    <polyline class="cart__top" points="4,4 21,4 26,22 124,22 112,64 35,64 39,80 106,80"
                        stroke-dasharray="338 338" stroke-dashoffset="-338" />
                    <g class="cart__wheel1" transform="rotate(-90,43,111)">
                        <circle class="cart__wheel-stroke" cx="43" cy="111" r="13" stroke-dasharray="81.68 81.68"
                            stroke-dashoffset="81.68" />
                    </g>
                    <g class="cart__wheel2" transform="rotate(90,102,111)">
                        <circle class="cart__wheel-stroke" cx="102" cy="111" r="13" stroke-dasharray="81.68 81.68"
                            stroke-dashoffset="81.68" />
                    </g>
                </g>
            </g>
        </svg>
    </div>
</div>
<!--================= Preloader End Here =================-->
    <!-- Overlay -->
    <a href="javascript:void(0)" class="overlay-general overlay-common"></a>
    @if (Request::segment(2) != 'register' && Request::segment(2) != 'login')
        @include('layouts.partials.header')
    @endif

    <!-- Content Main Start  -->
    <main>
        @yield('content')
    </main>
    @if (Request::segment(2) != 'register' && Request::segment(2) != 'login')
        @include('layouts.partials.footer')
    @endif

    <div class="search-input-area">
        <div class="container">
            <div class="search-input-inner">
                <div class="input-div">
                    <input id="searchInput1" class="search-input" type="text" placeholder="Search by keyword or #">
                    <button><i class="far fa-search"></i></button>
                </div>
            </div>
        </div>
        <div id="close" class="search-close-icon"><i class="far fa-times"></i></div>
    </div>

    <div id="anywhere-home" class="anywere"></div>

    <!-- Floating Bottons End  -->

    <!-- Tap To Top Button Start -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
            </path>
        </svg>
    </div>
    <!-- Tap To Top Button End -->
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"

        integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script> --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            toastr.options = {
                "closeButton": true,  // Show close button
                "progressBar": true,  // Show progress bar
                "positionClass": "toast-top-right",  // Position of the toastr message
                "showDuration": "300",  // Duration for which the toastr is displayed without user interaction
                "hideDuration": "1000",  // Duration for which the toastr is hidden after user interaction
                "timeOut": "5000",  // Duration before the toastr automatically closes
                "extendedTimeOut": "1000",  // Extra duration if the user hovers over the toastr
                "showEasing": "swing",  // Easing animation for showing the toastr
                "hideEasing": "linear",  // Easing animation for hiding the toastr
                "showMethod": "fadeIn",  // Method for showing the toastr
                "hideMethod": "fadeOut",  // Method for hiding the toastr
                "textColor": "#ffffff",  // Text color for error messages
                "iconClass": "toast-error-icon",  // Icon class for error messages (can be customized with CSS)
                "icon": "error" ,// Icon for error messages (can be "success", "info", "warning", "error")
                "toastClass": "errBackground" // Set your custom class here
            };
            toastr.options = {
                    "closeButton": true,  // Show close button
                    "progressBar": true,  // Show progress bar
                    "positionClass": "toast-top-right",  // Position of the toastr message
                    "showDuration": "300",  // Duration for which the toastr is displayed without user interaction
                    "hideDuration": "1000",  // Duration for which the toastr is hidden after user interaction
                    "timeOut": "5000",  // Duration before the toastr automatically closes
                    "extendedTimeOut": "1000",  // Extra duration if the user hovers over the toastr
                    "showEasing": "swing",  // Easing animation for showing the toastr
                    "hideEasing": "linear",  // Easing animation for hiding the toastr
                    "showMethod": "fadeIn",  // Method for showing the toastr
                    "hideMethod": "fadeOut",  // Method for hiding the toastr
                    "textColor": "#ffffff",  // Text color for success messages
                    "iconClass": "toast-success-icon",  // Icon class for success messages (can be customized with CSS)
                    "icon": "success",  // Icon for success messages (can be "success", "info", "warning", "error")
                    "toastClass": "succBackground" // Set your custom class here
                };
        </script>

    <!-- plugins js -->
    <script defer src="{{ Helper::jsFilesPath('plugins.js') }}"></script>

    <!-- custom js -->
    <script defer src="{{ Helper::jsFilesPath('main.js') }}"></script>

    <!-- header style two End -->

    <script>
        function search() {
            let searchQuery = $('#Qsearch').val();
            if (searchQuery) {
                let url = '{{ LaravelLocalization::localizeUrl("products?search=") }}' + searchQuery;
                window.location.href = url;
            }
        }

        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#Qsearch').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    search()
                }
            });
            $('#btn-Qsearch').on('click',function (e) {
                e.preventDefault();
                search()
            })

        });
    </script>

    <script>
        /////// MAPS with lat and long//////
        var lat = $('#latitude').val();
        var long = $('#longitude').val();
        if (lat != '') {
            function initMap2() {
                var uluru = {
                    lat: Number(lat),
                    lng: Number(long)
                };
                var myOptions = {
                        zoom: 10,
                        center: new google.maps.LatLng(lat, long)
                    },
                    map = new google.maps.Map(document.getElementById('map-canvas'), myOptions),
                    marker = new google.maps.Marker({
                        position: uluru,
                        map: map,
                    }),
                    infowindow = new google.maps.InfoWindow;
                map.addListener('click', function(e) {
                    map.setCenter(e.latLng);
                    marker.setPosition(e.latLng);
                    infowindow.setContent("Latitude: " + e.latLng.lat() +
                        "<br>" + "Longitude: " + e.latLng.lng());
                    infowindow.open(map, marker);
                    var s = $('#latitude').val(e.latLng.lat());
                    var ss = $('#longitude').val(e.latLng.lng());
                });
            }
        } else {
            function initMap1() {
                var uluru = {
                    lat: 30.0561,
                    lng: 31.2394
                };
                var myOptions = {
                        zoom: 10,
                        center: new google.maps.LatLng(30.0561, 31.2394)
                    },
                    map = new google.maps.Map(document.getElementById('map-canvas'), myOptions),
                    marker = new google.maps.Marker({
                        position: uluru,
                        map: map,
                    }),
                    infowindow = new google.maps.InfoWindow;
                map.addListener('click', function(e) {
                    map.setCenter(e.latLng);
                    marker.setPosition(e.latLng);
                    infowindow.setContent("Latitude: " + e.latLng.lat() +
                        "<br>" + "Longitude: " + e.latLng.lng());
                    infowindow.open(map, marker);
                    var s = $('#latitude').val(e.latLng.lat());
                    var ss = $('#longitude').val(e.latLng.lng());
                });
            }
        }
    </script>
    <script>
        // delete cart product//////////
        function delete_product() {
            $('.delete_product').on('click', function() {
                btn = $(this);
                $.confirm({
                    title: '{{ trans("home.delete product") }}',
                    content: '{{ trans("home.Are you sure you want to delete that product ?") }}',
                    rtl: true,

                    buttons: {
                        confirm: function() {
                            text: "{{ trans('home.OK') }}";
                            btnClass: "btn main-btn";
                            btn.closest("form").submit();
                        },
                        cancel: function() {
                            text: "{{ trans('home.cancel') }}";
                        }
                    },
                });
            });
        }

        delete_product();
        ///////// function to show card details/////
        function showAddCart() {
        $('.btn-showCart').click(function() {
            var productId = $(this).data('product_id');
            var modalId = '#addtocart_modal_' + productId;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ LaravelLocalization::localizeUrl('showAddCart') }}",
                method: 'POST',
                data: {
                    productId: productId
                },
                success: function(data) {
                    $('body').append(data.html);
                    $(modalId).modal('show');

                    // Initialize Swiper sliders after modal content is appended
                    var thumbnailSlider = new Swiper(modalId + " .thumbnailSlider", {
                        direction: "vertical",
                        watchSlidesProgress: true,
                        spaceBetween: 8,
                        slidesPerView: 4,
                    });

                    var mainSlider = new Swiper(modalId + " .mainslider", {
                        spaceBetween: 2,
                        thumbs: {
                            swiper: thumbnailSlider,
                        },
                    });
                    const sizeList = document.querySelectorAll(".size-list");
                    toggleClassF(sizeList);
                },
            });
        });

        }
        showAddCart();
        //to close modal/////
        function closeModal(modalId) {
            $(modalId).modal('hide');
        }

        /////// function card add to cart/////
        function cardAddToCart() {
            $('.btn-cart').click(function() {
                var productId = $(this).data('product_id');
                var attribute_value_id = $('#data-attribute_value_' + productId).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ LaravelLocalization::localizeUrl('cardAddToCart') }}",
                    method: 'POST',
                    data: {
                        productId: productId,
                        attribute_value_id: attribute_value_id
                    },
                    success: function(data) {
                        $('.shopingbag-cart').html(data.html);
                        $('.cart-count').html(data.cartCount);
                        $('.side-cart-count').html(data.cartCount);
                        $('.notification-wrap.addToCart img').attr('src', data.product_image);
                        $('#sideCart_totalPrice').html(data.totalPrice);

                        delete_product();


                    },
                });
            });
        }

        cardAddToCart();

        //////function add to wishlist///////
        function addToWishlist() {
            $('.btn-wishlist').click(function() {
                var productId = $(this).data('product_id');
                var button = $(this);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ LaravelLocalization::localizeUrl('addWishlist') }}",
                    method: 'POST',
                    data: {
                        productId: productId
                    },
                    success: function(data) {
                        $('.wish-count').html(data.wishCount);
                        $('.notification-wrap.addToWishlist img').attr('src', data.product_image);
                        $('.notification-wrap.addToWishlist h5').html(data.message);
                        console.log(data.html);
                        $('.dropdown.whislist-dropdown .onhover-show-div .card-wrap.custom-scroll')
                            .html(data.html);

                    }
                });
            });
        }

        addToWishlist();

        //////function add to comparelist///////
        function addToComparelist() {
            $('.btn-quickview').click(function() {
                var productId = $(this).data('product_id');
                var button = $(this);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ LaravelLocalization::localizeUrl('addCompareList') }}",
                    method: 'POST',
                    data: {
                        productId: productId
                    },
                    success: function(data) {
                        location.href = "{{ url('user/compareList') }}";
                    },
                    error: function(xhr) {
                        if (xhr.status == 401) {
                            window.location.href = "{{ url('login') }}";
                        }
                    }
                });
            });
        }

        addToComparelist();
    </script>
    <script>
        function changeAddQuantity() {
            $('.plus-button').click(function() {
                var cart_id = $(this).data('cart_id');
                var n_stock = $(this).data('n_stock');
                var product_id = $(this).data('product_id');
                var quantity = $('#quantity_' + product_id).val();
                if (quantity >= n_stock) {
                    $(this).addClass('disabled');
                }
                let updateDone = false;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ LaravelLocalization::localizeUrl('changeCartProductQuantity') }}",
                    method: 'POST',
                    data: {
                        cart_id: cart_id,
                        sign: 'plus'
                    },
                    success: function(data) {
                        $('#sideCart_totalPrice').html(data.total_price +
                        '{{ ' ' . __('home.EGP') }}');
                        $('#sub_totalPrice').html(data.total_price);
                    },

                });
            });
        }
        changeAddQuantity();

        function changeMinusQuantity() {
            $('.minus-button').click(function() {
                var cart_id = $(this).data('cart_id');
                var product_id = $(this).data('product_id');
                console.log(product_id);
                $('.product_' + product_id + ' a').removeClass('disabled');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ LaravelLocalization::localizeUrl('changeCartProductQuantity') }}",
                    method: 'POST',
                    data: {
                        cart_id: cart_id,
                        sign: 'minus'
                    },
                    success: function(data) {
                        $('#sideCart_totalPrice').html(data.total_price +
                        '{{ ' ' . __('home.EGP') }}');
                        $('#sub_totalPrice').html(data.total_price);

                    },
                });
            });
        }
        changeMinusQuantity()
    </script>
    <!--refresh cart and wish list partials-->
    <script>
        function refreshCart() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ LaravelLocalization::localizeUrl('refreshCart') }}",
                method: 'POST',
                success: function(data) {
                    $('#miniCart').html(data.html);
                    $('.cart-count').html(data.cartCount);
                    delete_product();
                },
            });
        }

        function refreshWishlist() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ LaravelLocalization::localizeUrl('refreshWishlist') }}",
                method: 'POST',
                success: function(data) {
                    $('.wish-count').html(data.wishCount);
                },
            });
        }

        window.addEventListener("pageshow", function(event) {
            var historyTraversal = event.persisted || (typeof window.performance != "undefined" && window
                .performance.navigation.type === 2);
            if (historyTraversal) {
                // Handle page restore.
                refreshCart();
                refreshWishlist();
            }
        });
    </script>

    <!-- Google Tag Manager (noscript) -->
    {!! $setting->GTM_noscript ? html_entity_decode($setting->GTM_noscript) : '' !!}

    <!-- End Google Tag Manager (noscript) -->
    @yield('script')
    <script>
    function replaceUrlWithoutReload(newUrl) {
        window.history.replaceState(null, '', newUrl);
    }
        function addToCart (ele){
            let group_id = ele.getAttribute('group_id');
            let quantity_input = ele.getAttribute('quan-input');
            let in_cart = ele.getAttribute('in-cart');
            let quantity = document.getElementById(quantity_input).value;
            // let header_cart = document.getElementsByClassName('header-cart');
            let data ={'group_id':group_id,'quantity':quantity,'in_cart':in_cart}
            if(group_id){
                $.ajax({
                    url: '{{LaravelLocalization::localizeUrl("carts")}}',
                    method: 'post',
                    data:data,
                    success: function(response) {
                        if (response.status) {
                            $('.header-cart').html(response.html_cart);
                            toastr.success(response.message);
                        } else {

                            toastr.warning(response.message);
                        }

                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                        console.log('Error:', error);
                    }
                });
            }
        }
    </script>
    <script>
        function addToWish (ele){
            let group_id = ele.getAttribute('group_id');
            let data ={'group_id':group_id}
            // let counterElement = document.getElementById('wish-counter-id');
            let counterElementC = $('.wish-counter-id');
            let counterElementCF = $('.wish-counter-id').first();

            // let currentCount = parseInt(counterElement.text(), 10);
            if(group_id){
                $.ajax({
                    url: '{{LaravelLocalization::localizeUrl("wishes")}}',
                    method: 'post',
                    data:data,
                    success: function(response) {
                        if (response.status) {
                            if (counterElementC.length) {
                                let currentCount = Number(counterElementCF.text().trim()) || 0;
                                // Increment by 1
                                counterElementC.text(currentCount +1);
                            } else {
                                $('.wishlist').append(`<span class="abs-number wish-counter-id" id="wish-counter-id">1</span>`);
                                counterElementCf = $('.wish-counter-id').first();

                            }



                            // $(header_cart).text(response.count);
                            toastr.success(response.message);
                        } else {
                            toastr.warning(response.message);
                        }

                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                        console.log('Error:', error);
                    }
                });
            }
        }
    </script>
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
