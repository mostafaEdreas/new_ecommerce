@extends('layouts.app')
@section('meta')
    <title>{{ trans('home.shopping_cart') }}</title>
@endsection
@section('content')
    @if (session()->has('data'))
        @php
            if (array_key_exists('coupon', session()->get('data'))) {
            $coupon = session()->get('data')['coupon'];
            }
            if (array_key_exists('shipping_methods', session()->get('data'))) {
                // dd(session()->get('data'));
                $shipping_methods = session()->get('data')['shipping_methods'];
            }
        @endphp
    @endif
    <div class="rts-navigation-area-breadcrumb bg_light-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="navigator-breadcrumb-wrapper">
                        <a href="{{ LaravelLocalization::localizeUrl('/') }}">@lang('home.home')</a>
                        <i class="fa-regular fa-chevron-right"></i>
                        <a class="current" href="index.html">
                            @lang('home.shopping_cart')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-seperator bg_light-1">
        <div class="container">
            <hr class="section-seperator">
        </div>
    </div>
    @if (count($cartsPub))
    <div class="rts-cart-area rts-section-gap bg_light-1">
        <div class="container">
            <div class="row g-5">
                <div class="col-xl-9 col-lg-12 col-md-12 col-12 order-2 order-xl-1 order-lg-2 order-md-2 order-sm-2">

                    <div class="rts-cart-list-area">
                        <div class="single-cart-area-list head">
                            <div class="product-main">
                                <P>@lang('home.products')</P>
                            </div>
                            <div class="price">
                                <p>@lang('home.price')</p>
                            </div>
                            <div class="quantity">
                                <p>@lang('home.quantity')</p>
                            </div>
                            <div class="subtotal">
                                <p>@lang('home.sub_total_price')</p>
                            </div>
                        </div>
                        @forelse ($cartsPub as $index => $cartProduct)
                            <div class="single-cart-area-list main  item-parent">
                                <div class="product-main-cart">
                                    <div class="close section-activation" in-cart="true"
                                        url="{{ LaravelLocalization::localizeUrl('carts') }}/{{ $cartProduct->id }}"
                                        id="del-cart-{{ $cartProduct->group->product->id }}">
                                        <i class="fa-regular fa-x"></i>
                                    </div>
                                    <div class="thumbnail">
                                        @if ($cartProduct->group->image->image)
                                        <img src="{{ Helper::uploadedImagesPath('products', $cartProduct->group->image->image) }}"
                                        alt="shop">
                                        @else
                                        <img src="{{url('resources/assets/back/img/noimage.png')}}"
                                        alt="shop">
                                        @endif

                                    </div>
                                    <div class="information">
                                        <h6 class="title"> {{ $cartProduct->group->product->{'name_' . $lang} }}</h6>
                                        {{-- <span>@lang('home.barcode'): {{ $cartProduct->group->product->{'barcode'} }}</span> --}}
                                    </div>
                                </div>
                                <div class="price">
                                    <p>{{ $cartProduct->group->price_details->new_price }} @lang('home.EGP')</p>
                                </div>
                                <div class="quantity">
                                    <div class="quantity-edit">
                                        <input type="text" stock="{{ $cartProduct->group->stock }}"
                                            sub-total-id="subtotal{{ $cartProduct->id }}"
                                            price="{{ $cartProduct->group->price_details->new_price }}" class="input"
                                            value="{{ $cartProduct->quantity }}"
                                            id="quan-inp-{{ $cartProduct->group->id }}">
                                        <div class="button-wrapper-action">
                                            <button class="button" in-cart="true"
                                                quan-input="quan-inp-{{ $cartProduct->group->id }}"
                                                group_id="{{ $cartProduct->group->id }}"><i
                                                    class="fa-regular fa-chevron-down"></i></button>
                                            <button class="button plus" in-cart="true"
                                                quan-input="quan-inp-{{ $cartProduct->group->id }}"
                                                group_id="{{ $cartProduct->group->id }}">+<i
                                                    class="fa-regular fa-chevron-up"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="subtotal">
                                    <p> <span class="sub-totat-product"
                                            id="subtotal{{ $cartProduct->id }}">{{ $cartProduct->total_product }}</span>
                                        @lang('home.EGP')</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center p-5">
                                @lang('home.doesn\'t have paroducts')
                            </div>
                        @endforelse
                        @auth
                        <div class="bottom-cupon-code-cart-area">
                            <form action="{{ LaravelLocalization::localizeUrl('carts/coupon') }}" method="post" onsubmit="document.getElementById('total-input').value = document.getElementById('total-with-shipping-costs').innerText ">
                                @csrf
                                <input type="hidden" id="total-input" name="total_after_all_discount"  >
                                <input type="text"  name="code" id="cobone-code" placeholder="@lang('home.Enter Coupon Code')">
                                <button class="rts-btn btn-primary">@lang('home.apply coupon')</button>
                            </form>
                            <button onclick="deletAllWish()" class="rts-btn btn-primary mr--50">@lang('home.delete')
                                @lang('home.all')</button>
                        </div>
                        @endauth
                    </div>
                </div>
                <div class="col-xl-3 col-lg-12 col-md-12 col-12 order-1 order-xl-2 order-lg-1 order-md-1 order-sm-1">
                    <div class="cart-total-area-start-right">
                        <h5 class="title">@lang('home.cart_total')</h5>
                        <div class="subtotal">
                            <span>@lang('home.total') </span>
                            <h6 class="price"><span
                                    id="total-without-shipping-costs">{{ count($cartsPub)? $cartsPub->sum(function ($cartProduct) {return $cartProduct->total_product;}): 0 }}</span>
                                @lang('home.EGP')</h6>
                        </div>
                        <div class="shipping">
                            <span>@lang('home.shipping')</span>
                            <ul>
                                @foreach ($shipping_methods as $index => $shipping)
                                    <li>
                                        <input type="radio" name="shipping_method" class="shipping-method" id="{{ $shipping->{'name_' . $lang} }}" value="{{ $shipping->value }}" 
                                        {{ $loop->first ? 'checked' : '' }}>
                                        <input type="hidden" name="shipping_id" value="{{ $shipping->id }}">
                                        <label for="{{ $shipping->{'name_' . $lang} }}">{{ $shipping->{'name_' . $lang} }}</label>
                                        <div class="check"></div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        @isset($coupon)
                            <div class="shipping"  id="coupon-container">
                                <span>@lang('home.coupon')</span>
                                <ul>
                                    <li>
                                        <label>@lang('home.name'): </label>
                                        <span>{{ $coupon->name }}</span>
                                        <div class="check"></div>
                                    </li>
                                    <li>
                                        <label>@lang('home.value'): </label>
                                        <span id="coupon-value">{{ $coupon->value }}</span>
                                        <div class="check"></div>
                                    </li>
                                </ul>
                            </div>
                        @endisset
                        <div class="bottom">
                            <div class="wrapper">
                                <span>@lang('home.total_price')</span>
                                <h6 class="price">
                                    <span id="total-with-shipping-costs">
                                        @if (isset($coupon))
                                            {{ $coupon->total }}
                                        @else
                                            {{ count($cartsPub)? $cartsPub->sum(function ($cartProduct) {return $cartProduct->total_product;}): 0 }}
                                        @endif
                                    </span>
                                    @lang('home.EGP')
                                </h6>
                            </div>
                            <div class="button-area">
                                <a href="{{LaravelLocalization::LocalizeUrl('order-checkOut')}}" class="rts-btn btn-primary">@lang('home.checkout')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center p-5">
        @lang('home.doesn\'t have paroducts')
    </div>
    @endif
    <!-- rts cart area start -->

    <!-- rts cart area end -->
@endsection
@section('script')
    <script>
        function deleteCart(ele) {
            let url = ele.getAttribute('url');
            let header_cart = document.getElementById('header-cart');
            if (url) {
                let itemParent = $(ele).parents('.item-parent'); // Store reference to the parent item
                $.ajax({
                    url: url,
                    method: 'DELETE',
                    // data: data, // Uncomment if you need to send data
                    success: function(response) {
                        if (response.status) {
                            // Update the cart HTML
                          return  location.reload();
                            $(header_cart).html(response.html_cart);
                            console.log(header_cart);
                            // Remove the parent item
                            itemParent.remove();
                            setTotal()
                            // Show success notification
                            toastr.success(response.message);
                        } else {
                            toastr.warning(response.message);
                        }
                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            }
        }
        /// this function for wish list and shopping cart
        function deletAllWish() {
            let elements = document.getElementsByClassName('section-activation');
            for (let i = 0; i < elements.length; i++) {
                elements[i].click();
            }

        }

    </script>
    @include('userBoard.partials.set-total')

    <script></script>
    {{-- <script>

    function changeAddQuantityCart() {
        $('.plus-button-cart').click(function () {
            var cart_id = $(this).data('cart_id');
            var product_price = $(this).data('product_price');
            var product_id = $(this).data('product_id');
            var n_stock = $(this).data('n_stock');
            var quantity = $('#quantity_cart_'+product_id).val();
            if(quantity>=n_stock){
                   $(this).addClass('disabled');
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{LaravelLocalization::localizeUrl('changeCartProductQuantity')}}",
                method: 'POST',
                data: {
                    cart_id: cart_id,
                    sign: 'plus'
                },
               success: function (data) {
                    $('#sideCart_totalPrice').html(data.total_price+'{{ ' '.__('home.EGP')}}');
                    $('#sub_totalPrice').html(data.total_price);
                    $('#product_all_price_'+product_id).html(data.product_all_price);
                    $('#all_total_price').html(data.all_total_price);
                },

            });
        });
    }
    changeAddQuantityCart();
    function changeMinusQuantityCart() {
        $('.minus-button-cart').click(function () {
            var cart_id = $(this).data('cart_id');
            var product_price = $(this).data('product_price');
            var product_id = $(this).data('product_id');
            $('tr.product_' + product_id + ' a').removeClass('disabled');


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{LaravelLocalization::localizeUrl('changeCartProductQuantity')}}",
                method: 'POST',
                data: {
                    cart_id: cart_id,
                    sign: 'minus'
                },
                success: function (data) {
                    $('#sideCart_totalPrice').html(data.total_price+'{{' '. __('home.EGP')}}');
                    $('#sub_totalPrice').html(data.total_price);
                    $('#product_all_price_'+product_id).html(data.product_all_price);
                    $('#all_total_price').html(data.all_total_price);
                },
            });
        });
    }
    changeMinusQuantityCart()

    function changeAddQuantityCartMob() {
        $('.plus-button-cart-Mob').click(function () {
            var cart_id = $(this).data('cart_id');
            var product_price = $(this).data('product_price');
            var product_id = $(this).data('product_id');
            var n_stock = $(this).data('n_stock');
            var quantity = $('#quantity_cart_mob_'+product_id).val();

            if(quantity>=n_stock){
                   $(this).addClass('disabled');
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{LaravelLocalization::localizeUrl('changeCartProductQuantity')}}",
                method: 'POST',
                data: {
                    cart_id: cart_id,
                    sign: 'plus'
                },
               success: function (data) {
                    $('#sideCart_totalPrice').html(data.total_price+'{{ ' '.__('home.EGP')}}');
                    $('#sub_totalPrice').html(data.total_price);
                    $('#product_all_price_'+product_id).html(data.product_all_price);
                    $('#all_total_price').html(data.all_total_price);
                },

            });
        });
    }
    changeAddQuantityCartMob();
    function changeMinusQuantityCartMob() {
        $('.minus-button-cart-Mob').click(function () {
            var cart_id = $(this).data('cart_id');
            var product_price = $(this).data('product_price');
            var product_id = $(this).data('product_id');
            $('tr.product_' + product_id + ' a').removeClass('disabled');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{LaravelLocalization::localizeUrl('changeCartProductQuantity')}}",
                method: 'POST',
                data: {
                    cart_id: cart_id,
                    sign: 'minus'
                },
                success: function (data) {
                    $('#sideCart_totalPrice').html(data.total_price+'{{' '. __('home.EGP')}}');
                    $('#sub_totalPrice').html(data.total_price);
                    $('#product_all_price_'+product_id).html(data.product_all_price);
                    $('#all_total_price').html(data.all_total_price);
                },
            });
        });
    }
    changeMinusQuantityCartMob()

    copune
    $('.getCode').click(function () {
        var couponCode = $('#coupon_code').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{LaravelLocalization::localizeUrl('check/coupon')}}",
            method: 'POST',
            data: {couponCode: couponCode},
            success: function (data) {
                location.reload();
            },
            error: function (xhr) {
                if (xhr.status == 401) {
                    window.location.href = "{{LaravelLocalization::localizeUrl('login')}}";
                }
            }
        });
    });
</script> --}}

    {{-- @if (Session::has('check_coupon'))
        <script>
            $.alert({
                title: "{{trans('home.apply coupon')}}",
                content: "{{Session::get('check_coupon')}}",
                buttons: {
                    ok: {
                        text: "{{trans('home.OK')}}",
                        btnClass: 'btn main-btn',
                    },
                },
                columnClass: 'col-md-6'
            });
        </script>
    @endif
    @php
        Session::forget('check_coupon')
    @endphp --}}
@endsection
