@extends('layouts.app')
@section('meta')
    <title>{{ trans('home.checkout') }}</title>
@endsection

@section('content')
    <!------------------------------------------------------- START CHECKOUT -------------------------------------------------------------------------->
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
    <div class="rts-navigation-area-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="navigator-breadcrumb-wrapper">
                        <a href="{{ LaravelLocalization::localizeUrl('/') }}">{{ __('home.home') }}</a>
                        <i class="fa-regular fa-chevron-right"></i>
                        <a class="#" href="{{ LaravelLocalization::localizeUrl('products') }}">@lang('home.Continue Shopping')</a>
                        <i class="fa-regular fa-chevron-right"></i>
                        <a class="current" href="javascript:void(0)">@lang('home.checkout')</a>
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

    <div class="checkout-area rts-section-gap">
        <div class="container">
            <div class="row">
                <div
                    class="col-lg-8 pr--40 pr_md--5 pr_sm--5 order-2 order-xl-1 order-lg-2 order-md-2 order-sm-2 mt_md--30 mt_sm--30">
                    <div class="rts-billing-details-area">
                        <h3 class="title">@lang('home.order_details')</h3>
                        @if (auth()->check())
                        <form action="{{ LaravelLocalization::localizeUrl('users/'.auth()->user()->id) }}" method="POST">
                        @method('PATCH')
                        @else
                        <form action="{{ route('register') }}" method="POST">
                        @endif
                            @csrf
                            <div class="half-input-wrapper">
                                <div class="single-input">
                                    <label for="f-name">@lang('home.f_name')*</label>
                                    <input id="f-name" name="f_name" type="text" value="{{ old('f_name')?? auth()->user()?->f_name }}"
                                        required>
                                </div>
                                <div class="single-input">
                                    <label for="l-name">@lang('home.l_name')*</label>
                                    <input id="l-name" name="l_name" type="text"
                                        value="{{ old('l_name')??auth()->user()?->l_name }}">
                                </div>
                            </div>
                            <div class="single-input">
                                <label for="phone"> @lang('home.phone') *</label>
                                <input id="phone" name="phone" value="{{ old('phone')??auth()->user()?->phone }}" type="text">
                            </div>
                            <div class="single-input">
                                <label for="email"> @lang('home.email')*</label>
                                <input id="email" name="email" type="text" value="{{ old('email')??auth()->user()?->email }}"
                                    required>
                            </div>
                            <div class="single-input">
                                <label for="country">@lang('home.country')*</label>
                                {{-- <input id="country" name="country" value="{{auth()->user()->country}}" type="text"> --}}
                                <select name="country_id" id="country" class="country form-control">
                                    <option value="">@lang('home.countries')</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" @selected($country->id == (old('country_id')??auth()->user()?->country->id))>
                                            {{ $country->{'name_' . $lang} }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="half-input-wrapper">
                                <div class="single-input">
                                    <label for="region">@lang('home.regions')*</label>
                                    {{-- <input id="city" name="city" type="text"> --}}
                                    <select name="region_id" id="region" class="region form-control">
                                        <option value="">@lang('home.regions')</option>
                                        @foreach (auth()->user()?->userRegions()??[] as $region)
                                            <option value="{{ $region->id }}" @selected($region->id == (old('region_id')??auth()->user()?->region->id))>
                                                {{ $region->{'name_' . $lang} }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="single-input">
                                    <label for="area">@lang('home.area')*</label>
                                    {{-- <input id="state" type="text"> --}}
                                    <select name="area_id" id="area" class="area form-control">
                                        <option value="">@lang('home.areas')</option>
                                        @foreach (auth()->user()?->userAreas()??[] as $area)
                                            <option value="{{ $area->id }}" @selected($area->id ==(old('area_id')?? auth()->user()?->area->id))>
                                                {{ $area->{'name_' . $lang} }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="single-input">
                                <label for="zip">@lang('zip Code')*</label>
                                <input id="zip" type="text" required>
                            </div> --}}
                           @isset($coupon)
                           <input type="hidden" name="code" value="{{request('code')}}">
                           @endisset
                           <input type="hidden" name="checkout" value="true">
                            <div class="single-input">
                                <label for="address">@lang('home.address')*</label>
                                <textarea id="address" name="shipping_address" required>{{old('shipping_address')??auth()->user()?->shipping_address}}</textarea>
                            </div>
                            <div class="single-input">
                                <label for="ordernotes">@lang('home.note')*</label>
                                <textarea id="ordernotes" name="note">{{old('note')??auth()->user()?->note}}</textarea>
                            </div>
                            <button type="submit" class="rts-btn btn-primary">@lang('home.Save Changes')</button>
                        </form>
                        @auth
                        <div class="coupon-input-area-1">
                            <div class="coupon-area">
                                <div class="coupon-ask  cupon-wrapper-1">
                                    <button class="coupon-click">@lang('home.Add Coupon')</button>
                                </div>
                                <div class="coupon-input-area cupon1">
                                    <div class="inner">
                                        <p class="mt--0 mb--20">@lang('home.Enter Coupon Code')</p>
                                        <form action="{{ LaravelLocalization::localizeUrl('carts/coupon') }}" method="post" >

                                            <div class="form-area">
                                                @csrf
                                                <input type="text" name="code" placeholder="@lang('home.Enter Coupon Code')">
                                                <button type="submit" class="btn-primary rts-btn">
                                                    @lang('home.apply coupon')
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endauth

                    </div>

                </div>
                <form action=""></form>
                <div class="col-lg-4 order-1 order-xl-2 order-lg-1 order-md-1 order-sm-1">
                    <h3 class="title-checkout">@lang('home.order_details')</h3>
                    <div class="right-card-sidebar-checkout">
                        <div class="top-wrapper">
                            <div class="product">
                                @lang('home.products')
                            </div>
                            <div class="price">
                                @lang('home.price')
                            </div>
                        </div>
                        @forelse ($cart_products as $index => $cartProduct)
                            <div class="single-shop-list">
                                <div class="left-area">
                                    <a href="{{ LaravelLocalization::localizeUrl('product/' . $cartProduct->group->product->{'link_' . $lang}) }}"
                                        class="thumbnail">
                                        <img src="{{ Helper::uploadedImagesPath('products', $cartProduct->group->image->image) }}"
                                            alt="">
                                    </a>
                                    <a href="{{ LaravelLocalization::localizeUrl('product/' . $cartProduct->group->product->{'link_' . $lang}) }}"
                                        class="title">
                                        {{ $cartProduct->group->product->{'name_' . $lang} }}
                                    </a>
                                </div>
                                <span class="price sub-totat-product">{{ $cartProduct->group->price_details->new_price }}
                                    @lang('EGP') * {{ $cartProduct->quantity }} </span>
                            </div>
                        @endforeach
                        @isset($coupon)
                            <div class="single-shop-list">
                                <div class="left-area">
                                    <span style="font-weight: 600; color: #1b2519;">@lang('home.coupon')</span>
                                </div>
                                <span class="price" style="color: #302114;">{{ $coupon->name }}:
                                    {{ $coupon->value }}@lang('EGP')</span>
                            </div>
                        @endisset
                        <div class="single-shop-list">
                            <div class="left-area">
                                <span style="font-weight: 600; color: #2C3C28;">@lang('home.total')</span>
                            </div>
                            <span id="total-with-shipping-costs" class="price" style="color: #81552f;">
                                @if (isset($coupon))
                                    {{ $coupon->total }}
                                @else
                                    {{ count($cartsPub)? $cartsPub->sum(function ($cartProduct) {return $cartProduct->total_product;}): 0 }}
                                @endif
                                @lang('EGP')
                            </span>
                        </div>
                        <div class="cottom-cart-right-area" id="coupon-container">
                            {{-- <span>@lang('home.shipping')</span> --}}
                            <ul>
                                @foreach ($shipping_methods as $shipping)
                                    <li>
                                        <input type="radio" name="shipping_method" class="shipping-method" id="{{ $shipping->{'name_' . $lang} }}" value="{{ $shipping->value }}" >
                                        <input type="hidden" name="shipping_id" value="{{ $shipping->id }}" >
                                        <label
                                            for="{{ $shipping->{'name_' . $lang} }}">{{ $shipping->{'name_' . $lang} }}</label>
                                        <div class="check"></div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="cottom-cart-right-area">
                            <ul>
                                @foreach ($payment_methods as $payment)
                                    <li>
                                        <input type="radio" class="payment-method" id="f-options{{ $payment->id }}" value="{{ $payment->value }}"  name="payment_method">
                                        <input type="radio" id="f-options{{ $payment->id }}" value="{{ $payment->id }}"  name="payment_id">
                                        <label for="f-options{{ $payment->id }}">{{ $payment->{'name_' . $lang} }}</label>
                                        <div class="check"></div>
                                    </li>
                                @endforeach
                            </ul>
                            {{-- <ul>
                                <li>
                                  <input type="radio" id="s-option" name="selector">
                                  <label for="s-option">Cash On Delivery</label>

                                  <div class="check"><div class="inside"></div></div>
                                </li>

                                <li>
                                  <input type="radio" id="t-option" name="selector">
                                  <label for="t-option">Paypal</label>

                                  <div class="check"><div class="inside"></div></div>
                                </li>
                            </ul> --}}
                            <p class="mb--20">@lang('home.Your personal data will be used to process, and to personalize your experience through this website, but for other purposes described in our privacy policy.')
                            </p>
                            <div class="single-category mb--30">
                                <input id="cat14" type="checkbox">
                                <label for="cat14"> @lang('home.I have read and agree to') <a
                                        href="{{ LaravelLocalization::localizeUrl('terms&condation') }}">@lang('terms & condation')</a>
                                    *
                                </label>
                            </div>
                            <a href="#" class="rts-btn btn-primary">شراء</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {{-- make primary address --}}
    <script>
        $(document).ready(function() {
            $('.radio-input').on('change', function() {
                var isChecked = $(this).prop('checked');
                if (isChecked) {
                    var address_id = $(this).attr('data-address-id');
                    var url = "{{ url('make/userAddress/primary') }}";

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ route('makeAddressPrimary') }}',
                        method: 'POST',
                        data: {
                            address_id: address_id,
                        },
                        success: function(response) {
                            location.reload();
                        }

                    });
                }
            });
        });
    </script>

    {{-- delete address --}}
    <script>
        $(document).ready(function() {
            $('.delete_address').on('click', function() {
                btn = $(this);
                $('#conformation').modal('show');
            });

            $('.confirm-delete').on('click', function() {
                btn.closest("form").submit();
                $('#conformation').modal('hide');
            });
        });
    </script>
    {{-- countries --}}
    <script>
        $(function() {
            $(document).on('change', '.country', function() {
                var id = $(this).val();
                var region = $('#region');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ url('getRegions') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        console.log(data, region);
                        var html = '';
                        html += '<option></option>'
                        for (var i = 0; i < data.length; i++) {
                            html += '<option  value="' + data[i].id +
                                '"> @if (\App::getLocale() == 'en')' + data[i].name_en +
                                ' @else ' +
                                data[i].name_ar +
                                ' @endif</option>';
                        }
                        console.log(data, region, html);
                        region.html(html);
                        // region.niceSelect('update');
                    }
                });
            });

            $(document).on('change', '.region', function() {
                var id = $(this).val();
                var area = $('#area');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '{{ url('getAreas') }}',
                    data: {
                        id: id
                    },
                    success: function(data) {

                        var html = '';
                        html += '<option></option>'
                        for (var i = 0; i < data.length; i++) {
                            html += '<option  value="' + data[i].id +
                                '">@if (\App::getLocale() == 'en')' + data[i].name_en +
                                ' @else ' +
                                data[i].name_ar +
                                ' @endif</option>';
                        }
                        area.html(html);
                    }
                });
            });
        })
    </script>
    @include('userBoard.partials.set-total')

    {{-- edit address --}}
    <script>
        $('.editAddress').click(function() {
            var address_id = $(this).data('address_id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('editAddress.show') }}',
                method: 'POST',
                data: {
                    address_id: address_id,
                },
                success: function(response) {
                    $('#addEditModal ').empty();
                    $('.index-demo1 ').append(response.view);
                    $('#addEditModal_' + address_id).modal('show');
                }
            });
        });
    </script>




    @if (auth()->user() && auth()->user()->email == '')
        <script>
            $.alert({
                title: "{{ trans('home.account_settings') }}",
                content: "{{ trans('home.first. update your account information before submitting your order') }} <a href='{{ url('user/account-settings') }}' style='color:red'>{{ trans('home.account_settings') }}</a>",

                buttons: {
                    GO: function() {
                        text: "{{ trans('home.Go') }}";
                        btnClass: "btn main-btn";
                        location.href = "{{ url('user/account-settings') }}";
                    },
                },

                columnClass: 'col-md-6'
            });
        </script>
    @endif

    {{-- copune --}}
    <script>
        $('.getCode').click(function() {
            var couponCode = $('#coupon_code').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ LaravelLocalization::localizeUrl('check/coupon') }}",
                method: 'POST',
                data: {
                    couponCode: couponCode
                },
                success: function(data) {
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.status == 401) {
                        window.location.href = "{{ LaravelLocalization::localizeUrl('login') }}";
                    }
                }
            });
        });
    </script>

    @if (Session::has('check_coupon'))
        <script>
            $.alert({
                title: "{{ trans('home.apply coupon') }}",
                content: "{{ Session::get('check_coupon') }}",
                buttons: {
                    ok: {
                        text: "{{ trans('home.OK') }}",
                        btnClass: 'btn main-btn',
                    },
                },
                columnClass: 'col-md-6'
            });
        </script>
    @endif
    @php
        Session::forget('check_coupon');
    @endphp

    {{-- <script>
        $('.method').on('change', function(){
            var shippingId=$('.shipping_method:checked').val();
            var paymentId=$('.payment_method:checked').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{url('changeMethod')}}",
                method:'POST',
                data: {shippingId:shippingId,paymentId:paymentId},
                success:function(data) {
                    console.log($('.shipping_value'));
                    $('.payment_value').html(data.paymentMethodFees + " {{trans('home.EGP')}}");
                    $('.shipping_value').html(data.shippingMethodFees + " {{trans('home.EGP')}}");
                    $('.shipping_total').html(data.shippingTotal + " {{trans('home.EGP')}}");
                    $('.total_price').html(data.totalPrice + " {{trans('home.EGP')}}");
                }
            });
        });
    </script> --}}
@endsection
