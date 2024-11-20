@extends('layouts.app')
@section('meta')
<title>{{trans('home.order_tracking')}}</title>
@endsection
@section('content')


<main class="main">
    <!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav mb-10">
        <div class="container">
            <div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">{{trans('home.order_tracking')}}</h1>
                     <ul class="breadcrumb">
                        <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{trans('home.home')}}</a></li>
                        <li>{{trans('home.order_tracking')}}</li>
                    </ul>
                </div>
           </div>
        </div>
    </nav>
    <!-- End of Breadcrumb -->

    <!-- Start of PageContent -->
    <div class="page-content pt-2 my-account">
        <div class="container">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->pull('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="tab tab-vertical row gutter-lg">

                @include('userBoard.partials.nav-links')

                <div class="tab-content mb-6">
                    <div class="tab-pane mb-4  active in" id="account-addresses">
                        <h4 class="billing-address"> {{trans('home.order_tracking')}} <i class="w-icon-map-marker"></i></h4>
                        <hr>

                        <br>
                        <div class="order_details">
                            <div class="row">
                                <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.tracking_code')}} :</strong>  {{$order->tracking_code}}</p></div>
                                <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.order_date')}} :</strong> {{date('Y-m-d', strtotime($order->created_at ))}}</p></div>
                                <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.address')}} :</strong>@if($order->address) {{$order->address->address}} @else {{trans('home.unknow_address')}} @endif</p></div>
                                <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.payment_status')}} :</strong>  {{trans("home.$order->payment_status")}}</p></div>
                                <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.payment_method')}} :</strong> {{(app()->getLocale() == 'en')?$order->paymentMethod->name_en:$order->paymentMethod->name_ar}}</p></div>
                                <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.shipping_method')}} :</strong> {{(app()->getLocale() == 'en')?$order->shippingMethod->name_en:$order->shippingMethod->name_ar}}</p></div>
                                @if($order->payment_method_fees) <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.payment_method_fees')}} :</strong> {{$order->payment_method_fees}} {{trans("home.EGP")}} </p></div> @endif
                                @if($order->shipping_method_fees) <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.shipping_method_fees')}} :</strong> {{$order->shipping_method_fees}} {{trans("home.EGP")}} </p></div> @endif
                                @if($order->total_shipping) <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.total_shipping')}} :</strong> {{$order->total_shipping}} {{trans("home.EGP")}} </p></div> @endif
                                @if($order->products_price) <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.products_price')}} :</strong> {{$order->products_price}} {{trans("home.EGP")}} </p></div> @endif
                                @if($order->coupoun_discount)<div class="col-sm-12 col-md-6"><p><strong>{{trans('home.coupoun_discount')}} :</strong> {{$order->coupoun_discount}} {{trans("home.EGP")}} </p></div> @endif
                                <div class="col-sm-12 col-md-6"><p><strong> :</strong> {{$order->total_price}} {{trans("home.EGP")}} </p></div>
                            </div>{{trans('home.total')}}
                        </div>
                        <br>
                        <div class="table-responsive-sm order-table">
                            <table class="bg-white table table-bordered table-hover">
                                <thead>
                                    <tr>
                                    	<th>{{trans('home.image')}}</th>
                                        <th>{{trans('home.name')}}</th>
                                        <th>{{trans('home.price')}}</th>
                                        <th>{{trans('home.quantity')}}</th>
                                        <th>{{trans('home.subtotal')}}</th>
                                        @if($order->status == 'delivered')
                                            <th>{{trans('home.actions')}}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach($order->products() as $product)
                                        @if($product->product)
                                            <tr>
                                            	<td>
                                            	    <a href="{{($lang == 'en')?url('product/'.$product->product->link_en):url('product/'.$product->product->link_ar)}}" class="thumb">
                                            	        @if($product->product->firstImage())
                                                            <img width="60px" class="checkout-image" src="{{url('uploads/products/resize200/'.$product->product->firstImage()->image)}}">
                                                        @else
                                                            <img width="60px" class="checkout-image" src="{{url('resources/assets/front/images/noimage.png')}}">
                                                        @endif
                                            	    </a>
                                            	</td>
                                                <td>
                                                    <a href="{{($lang == 'en')?url('product/'.$product->product->link_en):url('product/'.$product->product->link_ar)}}" class="thumb">
                                                        {{($lang == 'en')?$product->product->name_en : $product->product->name_ar}}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($product->price_before_disc != $product->price)
                                                        <span>{{$product->price}} {{trans('home.EGP')}}</span><
                                                        <del class="product-old-price">{{$product->price_before_disc}} {{trans('home.EGP')}}</del>
                                                    @else
                                                        <span>{{$product->price}} {{trans('home.EGP')}}</span>
                                                    @endif
                                                </td>
                                                <td>{{$product->quantity}}</td>
                                                <td>{{$product->price * $product->quantity}} {{trans('home.EGP')}}</td>
                                                @if($order->status == 'delivered')
                                                    <td>
                                                        @if(! in_array($product->product->id, $checkRateRevivew))
                                                            <a href="#" data-toggle="modal" data-target="#exampleModal_{{$product->product->id}}">{{trans('home.rate_and_review')}}</a>
                                                        @else
                                                            <a href="javascript::void()">{{trans('home.rated_before')}}</a>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>

                                            <div class="modal fade exampleModal_{{$product->product->id}}" id="exampleModal_{{$product->product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel1">{{trans('home.Rate_&_Review')}}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{url('add/productReview')}}" method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="review-rating"></div>
                                                                <input type="hidden" name="rate" class="myRate"/>
                                                                <input type="hidden" name="product_id" value="{{$product->product->id}}"/>
                                                                <div class="form-group">
                                                                    <label for="message-text" class="col-form-label">{{trans('home.review')}}:</label>
                                                                    <textarea class="form-control text " name="comment" placeholder="{{trans('home.review')}}"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-dismiss="modal">{{trans('home.close')}}</button>
                                                                <button type="submit" class="btn main-btn">{{trans('home.send_review')}}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <tr>
                                            	<td>{{trans('home.order_item_not_availbale_now')}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($order->status == 'canceled')
                            <div class="text-center">
                                <h4>{{trans('home.order_have_been_canceled')}}</h4>
                            </div>
                        @else
                            <div class="step-indicator">
                                <div class="step-track step1 @if(in_array('pending',$status)) active @endif">
                                    <div class="step-icon"><img src="{{url('resources/assets/front/images/box.png')}}" alt="..."></div>
                                    <p class="step-track">{{trans('home.pending')}}</p>
                                </div>
                                <div class="indicator-line @if(in_array('accept',$status)) active @endif"></div>
                                <div class="step-track step2 @if(in_array('accept',$status)) active @endif">
                                    <div class="step-icon"><img src="{{url('resources/assets/front/images/check.png')}}" alt="..."></div>
                                    <p class="step-track">{{trans('home.accept')}}</p>
                                </div>
                                <div class="indicator-line @if(in_array('process',$status)) active @endif"></div>
                                <div class="step-track step3 @if(in_array('process',$status)) active @endif">
                                    <div class="step-icon"><img src="{{url('resources/assets/front/images/hourglass.png')}}" alt="..."></div>
                                    <p class="step-track">{{trans('home.process')}}</p>
                                </div>
                                <div class="indicator-line @if(in_array('shipping',$status)) active @endif"></div>
                                <div class="step-track step3 @if(in_array('shipping',$status)) active @endif">
                                    <div class="step-icon"><img src="{{url('resources/assets/front/images/truck.png')}}" alt="..."></div>
                                    <p class="step-track">{{trans('home.shipping')}}</p>
                                </div>
                                <div class="indicator-line @if(in_array('delivered',$status)) active @endif"></div>
                                <div class="step-track step3 @if(in_array('delivered',$status)) active @endif">
                                    <div class="step-icon"><img src="{{url('resources/assets/front/images/like.png')}}" alt="..."></div>
                                    <p class="step-track">{{trans('home.delivered')}}</p>
                                </div>
                            </div>
                        @endif

                        <br>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="alt-font">
                                    <tr>
                                        <th>{{trans('home.date')}}</th>
                                        <th>{{trans('home.time')}}</th>
                                        <th>{{trans('home.status')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orderStatus as $key=>$status)
                                        <tr>
                                            <td>{{date('Y-m-d', strtotime($status->created_at ))}}</td>
                                            <td>{{date('h:i:s', strtotime($status->created_at ))}}</td>
                                            <td><span class="order-status">{{trans("home.$status->status")}}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of PageContent -->
</main>

@endsection

@section('script')
    <script>
        $(".review-rating").starRating({
            starSize: 40,
            disableAfterRate:false,
            useFullStars: true,
            callback: function(currentRating, $el){
                // make a server call here
                $(".myRate").val(currentRating);
            },
         });
    </script>
@endsection
