@extends('layouts.app')
@section('meta')
    <title>{{$configration->app_name}}|{{trans('home.shopping_cart')}}</title>
@endsection
@section('content')
<!-- Page Title -->
<div class="page section-header text-center mb-0">
    <div class="page-title">
        <div class="wrapper"><h1 class="page-width">{{trans('home.shopping_cart')}}</h1></div>
    </div>
</div>
<!-- End Page Title -->

<!-- Breadcrumbs -->
<div class="bredcrumbWrap bredcrumbWrapPage bredcrumb-style2 text-center mb-0">
    <div class="container breadcrumbs">
        <a href="{{url('/')}}" title="Back to home page">{{trans('home.home')}}</a><span aria-hidden="true">|</span><span class="title-bold">{{trans('home.shopping_cart')}}</span>
    </div>
</div>
<!-- End Breadcrumbs -->

<div class="container">
    <div class="row">
		<!--Main Content-->
		<div class="col-12 col-sm-12 col-md-9 col-lg-9 main-col">

		    @if(session()->has('success'))

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                         {{ session()->pull('success') }}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            @endif

        	<div class="cart style2">
        		<table>
                    <thead class="cart__row cart__header">
                        <tr>
                            <th colspan="2" class="text-center">{{trans('home.product')}}</th>
                            <th class="text-center">{{trans('home.price')}}</th>
                            <th class="text-center">{{trans('home.quantity')}}</th>
                            <th class="text-center">{{trans('home.total')}}</th>
                            <th class="action">&nbsp;</th>
                        </tr>
                    </thead>
            		<tbody>
            		    @foreach($cartProducts as $cartProduct)
                            <tr class="cart__row border-bottom line1 cart-flex border-top">
                                <td class="cart__image-wrapper cart-flex-item">
                                    <a href="{{($lang == 'en')?url('product/'.$cartProduct->product->link_en):url('product/'.$cartProduct->product->link_en)}}">
                                        @if($cartProduct->product->firstImage())
                                            <img class="cart__image" src="{{url('uploads/products/resize200/'.$cartProduct->product->firstImage()->image)}}" alt="{{$cartProduct->product->name_en}}">
                                        @else
                                            <img class="cart__image" src="{{url('resources/assets/front/images/noimage.png')}}" alt="{{$cartProduct->product->name_en}}">
                                        @endif
                                    </a>
                                </td>

                                <td class="cart__meta small--text-left cart-flex-item">
                                    <div class="list-view-item__title">
                                        <a href="{{($lang == 'en')?url('product/'.$cartProduct->product->link_en):url('product/'.$cartProduct->product->link_en)}}">
                                            {{($lang == 'en')?$cartProduct->product->name_en : $cartProduct->product->name_ar}}
                                        </a>
                                    </div>

                                    <div class="cart__meta-text">
                                        <ul style="list-style:none;">
                                            <li><span>{{trans('home.brand')}} : </span>@if($cartProduct->product->brand)@if(\App::isLocale('ar')){{$cartProduct->product->brand->name_ar}}@else {{$cartProduct->product->brand->name_en}} @endif @endif</li>
                                            @if($cartProduct->product->code)<li><span>{{trans('home.code')}} : </span>{{$cartProduct->product->code}}</li>@endif
                                            {{--@if($cartProduct->product->weight)<li><span>{{trans('home.weight')}} : </span>{{$cartProduct->product->weight}}</li>@endif
                                            @if($cartProduct->product->tall || $cartProduct->product->width || $cartProduct->product->height)<li><span>{{trans('home.dimension')}} : </span>({{$cartProduct->product->tall}} X {{$cartProduct->product->width}} X {{$cartProduct->product->height}})</li>@endif
                                            <li><span>{{trans('home.color')}} : </span>{{($cartProduct->color)?$cartProduct->color->name_en:trans('home.no_color')}}</li>

                                            @if(count($cartProduct->options())>0)
                                                <li>
                                                    <span>{{trans('home.options')}} :</span>
                                                    @foreach($cartProduct->options() as $option)
                                                        @if($option->option) {{$option->option->name_en}} @endif
                                                        @if(!$loop->last)
                                                            -
                                                        @endif
                                                    @endforeach
                                                </li>
                                            @endif--}}
                                        </ul>
                                    </div>
                                </td>
                                <td class="cart__price-wrapper cart-flex-item text-center">
                                    @if($cartProduct->before_disc > $cartProduct->price)
                                        <span class="money">{{(($cartProduct->price) + ($cartProduct->optionPrice()))}}  {{trans("home.SAR")}}</span>
                                        <del>{{$cartProduct->before_disc + $cartProduct->optionPrice()}}</del>
                                    @else
                                        {{(($cartProduct->price) + ($cartProduct->optionPrice()))}}  {{trans("home.SAR")}}
                                    @endif
                                </td>
                                <td class="cart__update-wrapper cart-flex-item text-center">
                                    <div class="cart__qty text-center">
                                        <div class="qtyField">
                                            <a class="qtyBtn minus change-quantity" href="javascript:void(0);"><i class="icon an an-minus"></i></a>
                                            <input class="cart__qty-input qty" data-product_id="{{$cartProduct->id}}" type="number" min="1" max="{{min($cartProduct->product->stock,5)}}" value="{{$cartProduct->quantity}}" readonly>
                                            <a class="qtyBtn plus change-quantity" href="javascript:void(0);"><i class="icon an an-plus"></i></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="small--hide cart-price text-center">
                                    <div>
                                        <span class="money">{{(($cartProduct->price) + ($cartProduct->optionPrice())) * $cartProduct->quantity}}  {{trans("home.SAR")}}</span>
                                    </div>
                                </td>
                                <td class="text-center small--hide">
                                    <form action="{{url('/removeCartProduct')}}" method="post">
                                            @csrf
                                        <input  class="productId" type='hidden' name='CartProductId' value="{{$cartProduct->id}}"/>
                                        <a href="#" class="btn btn--secondary cart__remove delete_product" title="Remove tem"><i class="icon an an-times"></i></a>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
            		<tfoot>
                        <tr>
                            <td colspan="3" class="text-left"><a href="{{url('/')}}" class="btn btn--link btn--small cart-continue"><i class="anm anm-chevron-cir-left"></i>{{trans('home.continue_shopping')}}</a></td>
                        </tr>
                    </tfoot>
            </table>
            </div>
       	</div>
       	<div class="col-12 col-sm-12 col-md-3 col-lg-3">
            <div class="solid-border">
                <div class="row border-bottom pb-2">
                    <span class="col-12 col-sm-6 cart__subtotal-title">{{trans('home.products_price')}}</span>
                    <span class="col-12 col-sm-6 text-right"><span class="money">{{$productsPrice}} {{trans('home.SAR')}}</span></span>
                </div>

                @if($couponDiscount)
                    <div class="row border-bottom pb-2 pt-2">
                        <span class="col-12 col-sm-6 cart__subtotal-title">{{trans('home.discount')}}</span>
                        <span class="col-12 col-sm-6 text-right">{{$couponDiscount}} {{trans('home.SAR')}}</span>
                    </div>
                @endif
                <div class="row border-bottom pb-2 pt-2">
                    <span class="col-12 col-sm-6 cart__subtotal-title"><strong>{{trans('home.total')}}</strong></span>
                    <span class="col-12 col-sm-6 cart__subtotal-title cart__subtotal text-right"><span class="money">{{$totalPrice}} {{trans('home.SAR')}}</span></span>
                </div>
                @auth
                    <a href="{{url('order-checkOut')}}"><button id="cartCheckout" class="btn btn--small-wide checkout">{{trans('home.Proceed to checkout')}}</button></a>
                @endauth
                @guest
                    <a href="{{url('guest-order-checkOut')}}"><button id="cartCheckout" class="btn btn--small-wide checkout">{{trans('home.Proceed to checkout')}}</button></a>
                @endguest
            </div>

            <br>

            <div class="solid-border">
                <h5>{{trans('home.Discount Codes')}}</h5>
                <div>
                	<div class="form-group">
                        <label for="address_zip">{{trans('home.enter your coupon code if you have one')}}</label>
                        <input type="text" id="coupon_code" name="couponcode" placeholder="{{trans('home.Enter Coupon Code')}}" autocomplete="off">
                    </div>
                    <div class="actionRow">
                        <div>
                            <button class="btn btn-secondary btn--small getCode">{{trans('home.apply_coupon')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<!--End Main Content-->
	</div>
</div>
<!--End Body Container-->
@endsection

@section('script')
    <script>
        $('.getCode').click(function () {
            var couponCode=$('#coupon_code').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{url('check/coupon')}}",
                method:'POST',
                data: {couponCode:couponCode},
                success:function(data) {
                    location.reload();
                },
                error: function (xhr) {
                    if (xhr.status == 401) {
                        window.location.href = "{{url('login')}}" ;
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
@endsection

