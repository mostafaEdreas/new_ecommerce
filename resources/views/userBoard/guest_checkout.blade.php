@extends('layouts.app')
@section('meta')
    <title>{{$configration->app_name}}|{{trans('home.checkout')}}</title>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection
@section('content')
<!------------------------------------------------------- START CHECKOUT -------------------------------------------------------------------------->

<!-- Page Title -->
<div class="page section-header text-center mb-0">
    <div class="page-title">
        <div class="wrapper"><h1 class="page-width">{{trans('home.checkout')}}</h1></div>
    </div>
</div>
<!-- End Page Title -->

<!-- Breadcrumbs -->
<div class="bredcrumbWrap bredcrumbWrapPage bredcrumb-style2 text-center mb-0">
    <div class="container breadcrumbs">
        <a href="{{url('/')}}" title="Back to home page">{{trans('home.home')}}</a><span aria-hidden="true">|</span><span class="title-bold">{{trans('home.checkout')}}</span>
    </div>
</div>
<!-- End Breadcrumbs -->
<div class="container">
	<!--Main Content-->
		<form class="bs-example" action="{{url('guest-placeOrder')}}" method="post" id="orderForm">
            @csrf
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="card card--grey">
                        <div class="card-body">
                            <div class="block-content">
                                            <h3 class="title mb-3">{{__('home.INFORMATIONS')}}</h3>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="form-group col-6">
                                                        <input required name="f_name" value="{{old('f_name')}}" placeholder="{{__('home.f_name')}}"  type="text"/>
                                                        @error('f_name')
                                                        <div class="alert alert-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <input required name="l_name" value="{{old('l_name')}}" placeholder="{{__('home.l_name')}}"  type="text"/>
                                                        @error('l_name')
                                                        <div class="alert alert-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <input required name="email" value="{{old('email')}}" placeholder="{{__('home.email')}}"  type="email"/>
                                                        @error('email')
                                                        <div class="alert alert-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <input required name="phone1" value="{{old('phone1')}}" placeholder="{{__('home.phone')}}"  type="tel" pattern="^01[0-2]\d{1,8}$"/>
                                                        @error('phone1')
                                                        <div class="alert alert-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <input required name="address" value="{{old('address')}}" placeholder="{{__('home.address').' '.__('home.prefered in arabic')}}"  type="text"/>
                                                        @error('address')
                                                        <div class="alert alert-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-4 col-sm-12">
                                                        <label for="country_id">{{__('home.country')}}</label>
                                                        <select class="form-control country select2" name="country_id" required>
                                                            @foreach($countries as $country)
                                                                <option  selected disabled>{{__('home.country')}}</option>
                                                                <option  value="{{$country->id}}">{{(app()->getLocale() == 'en')?$country->name_en:$country->name_ar}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group col-md-4 col-sm-12">
                                                        <label for="region_id">{{__('home.region')}}</label>
                                                        <select class="form-control region select2" name="region_id" required>
                                                        </select>
                                                        <span id="select_country" class="text-danger">{{__('home.select country first')}}</span>
                                                    </div>
                                                    <div class="form-group col-md-4 col-sm-12">
                                                            <label for="area_id">{{__('home.area')}}</label>
                                                        <select class="form-control area select2" id="area_id" name="area_id" required>
                                                        </select>
                                                        <span id="select_region" class="text-danger">{{__('home.select region first')}}</span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>   
                        </div>
                    </div>
                    
                    <div class="card card--grey">
                        <div class="card-body">
                            <h2>{{trans('home.SelectYourShippingMethod')}}</h2>
                            @foreach($shippingMethods as $key=>$shippingMethod)
                                <div class="customRadio clearfix">
                                    <input id="shipping-method-{{$key}}" name='shipping_id' value='{{$shippingMethod->id}}' type="radio" class="method shipping_method radio" @if($key == 0) checked @endif required>
                                    <label for="shipping-method-{{$key}}">{{(app()->getLocale() == 'en')?$shippingMethod->name_en:$shippingMethod->name_ar}}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-6 mt-2 mt-md-0">
                
                    <h2 class="title">{{trans('home.order_summary')}}</h2>
                    <div class="table-responsive-sm order-table"> 
                        <table class="bg-white table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                	<th class="text-left">{{trans('home.image')}}</th>
                                    <th class="text-left">{{trans('home.name')}}</th>
                                    <th>{{trans('home.price')}}</th>
                                    <th>{{trans('home.quantity')}}</th>
                                    <th>{{trans('home.subtotal')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartProducts as $product)
                                    <tr>
                                    	<td>
                                    	    <a href="{{($lang == 'en')?url('product/'.$product->product->link_en):url('product/'.$product->product->link_ar)}}" class="thumb">
                                    	        @if($product->product->firstImage())
                                                    <img width="100px" class="checkout-image" src="{{url('uploads/products/resize200/'.$product->product->firstImage()->image)}}">
                                                @else
                                                    <img width="100px" class="checkout-image" src="{{url('resources/assets/front/images/noimage.png')}}">
                                                @endif
                                    	    </a>
                                    	</td>
                                        <td class="text-left">
                                            <a href="{{($lang == 'en')?url('product/'.$product->product->link_en):url('product/'.$product->product->link_ar)}}" class="thumb">
                                                {{($lang == 'en')?$product->product->name_en : $product->product->name_ar}}
                                            </a>    
                                        </td>
                                        <td>
                                            @if($product->price_before_disc != $product->price)
                                                <span>{{$product->price}} {{trans('home.SAR')}}</span><
                                                <del class="product-old-price">{{$product->price_before_disc}} {{trans('home.SAR')}}</del>
                                            @else
                                                <span>{{$product->price}} {{trans('home.SAR')}}</span>
                                            @endif
                                        </td>
                                        <td>{{$product->quantity}}</td>
                                        <td>{{$product->price * $product->quantity}} {{trans('home.SAR')}}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot class="font-weight-600">
                                <tr>
                                    <td colspan="4" class="text-right"> + {{trans('home.products_price')}} </td>
                                    <td>{{$cart->products_price}} {{trans('home.SAR')}}</td>
                                </tr>
                                
                                @if($paymentMethodFees)
                                    <tr>
                                        <td colspan="4" class="text-right"> + {{trans('home.paymentMethodFees')}}</td>
                                        <td class="payment_value">{{$paymentMethodFees}} {{trans('home.SAR')}}</td>
                                    </tr>
                                @endif
                                <input type="hidden" id="shipping_value" 
                                                                value="{{$shippingFees}}">
                                <tr>
                                    <td colspan="4" class="text-right"> + {{trans('home.shipping')}}</td>
                                    <td class="payment_value shipping_total"> {{$shippingFees.' '.trans('home.EGP')}}</td>
                                </tr>
                                
                                
                                @if($cart->coupon_discount)
                                    <tr>
                                        <td colspan="4" class="text-right"> - {{trans('home.discount')}}</td>
                                        <td>{{$cart->coupon_discount}} {{trans('home.SAR')}}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="4" class="text-right">{{trans('home.total')}}</td>
                                    <td class="total_price" >{{$cart->products_price + $paymentMethodFees - $cart->coupon_discount+$shippingFees}} {{trans('home.SAR')}}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="mt-2"></div>
                    <div class="card card--grey">
                        <div class="card-body">
                            <h2>{{trans('home.SelectYourPaymentMethod')}}</h2>
                            @foreach($paymentMethods as $key=>$paymentMethod)
                                <div class="customRadio clearfix">
                                    <input  id='payment_method_{{$paymentMethod->id}}' name='payment_id' value='{{$paymentMethod->id}}' type="radio" class="radio method payment_method" @if($key == 0) checked @endif required>
                                    <label for="payment_method_{{$paymentMethod->id}}">{{(app()->getLocale() == 'en')?$paymentMethod->name_en:$paymentMethod->name_ar}}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="clearfix"><button type="submit" class="btn btn-large btn--lg w-100" id="makeOrder">{{trans('home.place_order')}}</button></div>
                    <div class="mt-2"></div>
                </div>
            </div>
        </form>
    <!--End Main Content-->        
</div>
<!--End Body Container-->

@endsection
@section('script')

    {{--quantity--}}
    <script>
        function changeAddQuantity() {
            $('.plus-button').click(function () {
                var total_price = document.getElementById('sideCart_totalPrice').value;
                var cart_id = $(this).data('cart_id');
                var product_price = $(this).data('product_price');
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
                        $('#sub_totalPrice').html(parseInt(total_price) + parseInt(product_price));
                    },
                });
            });
        }

        changeAddQuantity();

        function changeMinusQuantity() {
            $('.minus-button').click(function () {
                var total_price = document.getElementById('sideCart_totalPrice').value;
                var cart_id = $(this).data('cart_id');
                var product_price = $(this).data('product_price');

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
                        if (parseInt(total_price) - parseInt(product_price) > 0) {
                            $('#sub_totalPrice').html(parseInt(total_price) - parseInt(product_price));
                        }
                    },
                });
            });
        }

        changeMinusQuantity()
    </script>
    {{--copune--}}
    <script>
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
    </script>

    @if(Session::has('check_coupon'))
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
    @endphp
    {{--countries--}}
    <script>

        $('.country').change(function () {
            var id = $(this).val();
            var region = $('.region');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{url('getRegions')  }}',
                data: {id: id},
                success: function (data) {
                    var html = '';
                    html += '<option></option>'
                    for (var i = 0; i < data.length; i++) {
                        html += '<option  value="' + data[i].id + '">@if(\App::getLocale() == 'en')' + data[i].name_en + ' @else ' + data[i].name_ar + ' @endif</option>';
                    }
                    region.html(html);
                    $('#select_country').html('');
                }
            });
        });

        $('.region').change(function () {
            var id = $(this).val();
            var area = $('.area');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{url('getAreas')  }}',
                data: {id: id},
                success: function (data) {
                    var html = '';
                    html += '<option></option>'
                    for (var i = 0; i < data.length; i++) {
                        html += '<option  value="' + data[i].id + '">@if(\App::getLocale() == 'en')' + data[i].name_en + ' @else ' + data[i].name_ar + ' @endif</option>';
                    }
                    area.html(html);
                    $('#select_region').html('');
                    
                }
            });
        });
        $('#area_id').change(function () {
            var area_id = $(this).val();
            var shippingId = $('.shipping_method:checked').val();
            var paymentId = $('.payment_method:checked').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{url('guest_changeMethod')  }}',
                data: {area_id: area_id,shippingId:shippingId,paymentId:paymentId},
                success: function (data) {
                    $('.shipping_total').html(data.shippingTotal + " {{trans('home.EGP')}}");
                    $('.total_price').html(data.totalPrice + " {{trans('home.EGP')}}");
                }
            });
            
        });
        
        $('.select2').select2({placeholder: 'Choose One'});

    </script>
    <script>
        $('.method').on('change', function () {
            var shippingId = $('.shipping_method:checked').val();
            var paymentId = $('.payment_method:checked').val();
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{url('guest_changeMethod')}}",
                method: 'POST',
                data: {shippingId: shippingId, paymentId: paymentId},
                success: function (data) {
                    $('.payment_value').html(data.paymentMethodFees + " {{trans('home.EGP')}}");
                    $('.shipping_value').html(data.shippingMethodFees + " {{trans('home.EGP')}}");
                    $('#shipping_value').val(data.shippingTotal );
                    $('.shipping_total').html(data.shippingTotal + " {{trans('home.EGP')}}");
                    $('.total_price').html(data.totalPrice + " {{trans('home.EGP')}}");
                }
            });
        });
    </script>
    <?php 
        $layer_data = $cartProducts->map(function ($item) {
                        return [
                            'item_id' => $item['product_id'],
                            'item_name' => $item->product->name_en,
                            'item_category' => $item->product->category->link_en ,
                            'item_brand' => $item->product->brand->name_en,
                            'price' => $item->product->price,
                            'quantity' => $item['quantity']
                        ];
                    });

    ?>


    <script>
        $(document).ready(function(){
            function fireGoogleCheckout(){
                gtag("event", "checkout_button", {
                    user_id: "Visitor",
                    email : "Visitor",
                    first_name : "Visitor",
                    last_name : "Visitor",
                    cart_id: "Visitor",
                    items:{!! $layer_data;!!}
                });
            }
            fireGoogleCheckout();
        });
    </script>
@endsection
