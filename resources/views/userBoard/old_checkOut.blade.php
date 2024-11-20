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
		<form class="bs-example" action="{{url('placeOrder')}}" method="post" id="orderForm">
            @csrf
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="card card--grey">
                        <div class="card-body">
                            <h2>{{trans('home.shippingAddress')}}</h2>
                            <ul style="list-style:none;">
                                <li><strong>{{trans('home.landmark')}} : </strong>{{$primaryAddress->land_mark}}</li>
                                <li><strong>{{trans('home.address')}} : </strong>{{$primaryAddress->address}}</li>
                                <li><strong>{{trans('home.region')}} : </strong>@if($primaryAddress->region) {{(app()->getLocale() == 'en')?$primaryAddress->region->name_en:$primaryAddress->region->name_ar}} @endif</li>
                                <li><strong>{{trans('home.area')}} : </strong>@if($primaryAddress->area) {{(app()->getLocale() == 'en')?$primaryAddress->area->name_en:$primaryAddress->area->name_ar}} @endif</li>
                                <li><strong>{{trans('home.country')}} : </strong> @if($primaryAddress->country) {{(app()->getLocale() == 'en')?$primaryAddress->country->name_en:$primaryAddress->country->name_ar}} @endif</li>
                                <li><strong>{{trans('home.phone1')}} : </strong>{{$primaryAddress->phone1}}</li>
                                @if($primaryAddress->phone2)
                                    <li><strong>{{trans('home.phone2')}} : </strong>{{$primaryAddress->phone2}}</li>
                                @endif
                            </ul>
                            <p>
                                <a class="btn" href="{{url('user/add/shipping-address')}}">{{trans('home.CreateNewAddress')}} </a>
                                @if(count($userAddresses) > 1)
                                    <a class="btn" href="#" data-bs-toggle="modal" data-bs-target="#addressModal">{{trans('home.SelectAnotherAddress')}}</a>
                                 @endif
                            </p>     
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
                                
                                @if($shippingMethodFees)
                                    <tr>
                                        <td colspan="4" class="text-right"> + {{trans('home.shippingMethodFees')}}</td>
                                        <td class="shipping_value">{{$shippingMethodFees}} {{trans('home.SAR')}}</td>
                                    </tr>
                                @endif
                                
                                <tr>
                                    <td colspan="4" class="text-right"> + {{trans('home.totalShipping')}}</td>
                                    <td class="shipping_total">{{$shippingFees + $shippingMethodFees}} {{trans('home.SAR')}}</td>
                                </tr>
                                
                                @if($cart->coupon_discount)
                                    <tr>
                                        <td colspan="4" class="text-right"> - {{trans('home.discount')}}</td>
                                        <td>{{$cart->coupon_discount}} {{trans('home.SAR')}}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="4" class="text-right">{{trans('home.total')}}</td>
                                    <td class="total_price">{{$cart->products_price + $shippingFees + $shippingMethodFees + $paymentMethodFees - $cart->coupon_discount}} {{trans('home.SAR')}}</td>
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

<!-------- modal --------------->
<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-bs-labelledby="exampleModalLabel" aria-bs-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('home.SelectAnotherAddress')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach($userAddresses as $key=>$addres)
                    <ul style="list-style:none;">
                        <li><strong>{{trans('home.landmark')}} : </strong>{{$addres->land_mark}}</li>
                        <li><strong>{{trans('home.address')}} : </strong>{{$addres->address}}</li>
                        <li><strong>{{trans('home.region')}} : </strong>@if($addres->region) {{($lang == 'en')?$addres->region->name_en:$addres->region->name_ar}} @endif</li>
                        <li><strong>{{trans('home.area')}} : </strong>@if($addres->area) {{($lang == 'en')?$addres->area->name_en:$addres->area->name_ar}} @endif</li>
                        <li><strong>{{trans('home.country')}} : </strong>@if($addres->country) {{($lang == 'en')?$addres->country->name_en:$addres->country->name_ar}} @endif</li>
                        <li><strong>{{trans('home.phone1')}} : </strong>{{$addres->phone1}}</li>
                        @if($addres->phone2)
                            <li><strong>{{trans('home.phone2')}} : </strong>{{$addres->phone2}}</li>
                        @endif
                        <li class="line">
                            <form id="select-addesss-{{$key}}" action="{{url('make/userAddress/primary')}}/{{$addres->id}}}}" method="post">
                                 @csrf
                                <a class="btn" href="javascript:{}" onclick="document.getElementById('select-addesss-{{$key}}').submit();">{{trans('home.select')}}</a>
                            </form>
                        </li>
                    </ul>
                    @if(!$loop->last)
                        <hr>
                    @endif
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-ds-dismiss="modal">{{trans('home.close')}}</button>
            </div>
        </div>
    </div>
</div>
<!----------- modal------------->


@endsection
@section('script')

    <script>
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
        'event': 'checkout',
        'ecommerce': {
            'checkout': {
                'actionField': {'step': 1}, // Step 1: Entering the checkout process
                'items': [
                    @foreach($cartProducts as $cartProduct)
                    {
                        'id': '{{ $cartProduct->product->id }}', // Product ID
                        'name': '{{ $cartProduct->product->name }}', // Product name
                        'category': '{{ $cartProduct->product->category->name }}', // Category
                        'price': '{{ $cartProduct->product->price }}', // Price
                        'quantity': '{{ $cartProduct->quantity }}', // Quantity
                    },
                    @endforeach
                ]
            }
        }
    });
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script> 
    {{-- <script src="https://eu-gateway.mastercard.com/checkout/version/59/checkout.js"
        data-error="errorCallback"
        data-cancel="cancelCallback">
    </script>
    <script type="text/javascript">
    
        let session_id = ''
    
        function errorCallback(error) {
            console.log(JSON.stringify(error));
        }
    
        function cancelCallback() {
            console.log('Payment cancelled');
        }
    
        $('#makeOrder').on('click', function (){
            var paymentMethodId = $('.payment_method:checked').val();
    
            if(paymentMethodId == 2){
                $('#checkout-error-msg').hide();
                let button = $(this);
                var data = getFormData($('#orderForm'));
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{ url('masterCardPayment') }}',
                    data: data,
                    beforeSend: function () {
                        $('#ec-overlay').removeAttr( 'style' );
                    },
                    success: function(data){
                        if(data.success){
                            session_id = data.session_id
                            Checkout.showPaymentPage();
                        }
                        else{
                            $('#checkout-error-msg').text(data.msg).show();
                            button.prop("disabled", false);
                        }
                    },
                    error: function(xhr, status, error){
        
                        var errorHtml = '';
                        $.each(xhr.responseJSON.errors, function (key, item) {
                            errorHtml += '<li>' + item + '</li>';
                        });
                        $('#checkout-error-msg').html(errorHtml).show();
                    }
                });
            }else{
                $('#orderForm').submit();
            }
            
        });
    
        Checkout.configure({
            session: {
                id: function(){
                    return session_id
                }
            },
        });
    
        function getFormData($form){
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};
    
            $.map(unindexed_array, function(n, i){
                indexed_array[n['name']] = n['value'];
            });
    
            return indexed_array;
        }
    
    </script>--}}

<script>
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
                if(data.paymentMethodFees != null){
                    $('.payment_value').html(data.paymentMethodFees + " {{trans('home.SAR')}}");
                }else{
                    $('.payment_value').html("0 {{trans('home.SAR')}}");
                }
                $('.shipping_value').html(data.shippingMethodFees + " {{trans('home.SAR')}}");
                $('.shipping_total').html(data.shippingTotal + " {{trans('home.SAR')}}");
                $('.total_price').html(data.totalPrice + " {{trans('home.SAR')}}");
            }
        });
    });
</script>
    
    @if(Session::has('order_not_completed'))
        <script>
            $.alert({
                title: "{{trans('home.not_completed')}}",
                content: "{{Session::get('order_not_completed')}}",
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
        Session::forget('order_not_completed')
    @endphp
    

@endsection