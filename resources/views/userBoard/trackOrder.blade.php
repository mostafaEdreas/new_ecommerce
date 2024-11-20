@extends('layouts.app')

@section('meta')
<title>{{$configration->app_name}}|{{trans('home.order_tracking')}}</title>
@endsection

@section('content')


<!--Body Container-->
<!--Breadcrumbs-->
<div class="breadcrumbs-wrapper">
	<div class="container">
    	<div class="breadcrumbs"><a href="{{url('/')}}" title="Back to the home page">{{trans('home.home')}}</a> <span aria-hidden="true">|</span> <span>{{trans('home.my_orders')}}</span></div>
    </div>
</div>

<!--End Breadcrumbs-->
<div class="container">
	<div class="page-title"><h1>{{trans('home.My Account')}}</h1></div>
    @include('userBoard.partials.profile')
    <div class="row mb-5">
        @include('userBoard.partials.nav-links')
        <div class="col-xs-10 col-lg-10 col-md-12">
            <!-- Tab panes -->
            <div class="dashboard-content padding-30px-all md-padding-15px-all">
                <!-- Dashboard -->
                <div id="dashboard" class="tab-pane fade active show">
                    <h3>{{trans('home.order_details')}}</h3>
                    <div aria-multiselectable="true" class="accordion" id="accordion" role="tablist">
                        <div class="card">
                            <div class="card-header" id="headingOne" role="tab">
                                <a style="display: block;" aria-bs-controls="collapseOne" aria-bs-expanded="false" data-bs-toggle="collapse" href="#collapseOne" class="collapsed btn">{{trans('home.view').' '.__('home.order_details')}}</a>
                            </div>
                            <div aria-bs-labelledby="headingOne" class="collapse" data-bs-parent="#accordion" id="collapseOne" role="tabpanel" style="">
                                <div class="card-body">
                                    <div class="order_details">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.tracking_code')}} :</strong>  {{$order->tracking_code}}</p></div>
                                            <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.order_date')}} :</strong> {{date('Y-m-d', strtotime($order->created_at ))}}</p></div>
                                            <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.address')}} :</strong>@if($order->address) {{$order->address->address}} @else {{trans('home.unknow_address')}} @endif</p></div>
                                            <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.payment_status')}} :</strong>  {{trans("home.$order->payment_status")}}</p></div>
                                            <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.payment_method')}} :</strong> {{(app()->getLocale() == 'en')?$order->paymentMethod->name_en:$order->paymentMethod->name_ar}}</p></div>
                                            <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.shipping_method')}} :</strong> {{(app()->getLocale() == 'en')?$order->shippingMethod->name_en:$order->shippingMethod->name_ar}}</p></div>
                                            @if($order->payment_method_fees) <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.payment_method_fees')}} :</strong> {{$order->payment_method_fees}} {{trans("home.SAR")}} </p></div> @endif
                                            @if($order->shipping_method_fees) <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.shipping_method_fees')}} :</strong> {{$order->shipping_method_fees}} {{trans("home.SAR")}} </p></div> @endif
                                            @if($order->total_shipping) <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.total_shipping')}} :</strong> {{$order->total_shipping}} {{trans("home.SAR")}} </p></div> @endif
                                            @if($order->products_price) <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.products_price')}} :</strong> {{$order->products_price}} {{trans("home.SAR")}} </p></div> @endif
                                            @if($order->coupoun_discount)<div class="col-sm-12 col-md-6"><p><strong>{{trans('home.coupoun_discount')}} :</strong> {{$order->coupoun_discount}} {{trans("home.SAR")}} </p></div> @endif
                                            <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.total')}} :</strong> {{$order->total_price}} {{trans("home.SAR")}} </p></div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive-sm order-table">
                                        <table class="bg-white table table-bordered table-hover text-center">
                                            <thead>
                                                <tr>
                                                	<th class="text-left">{{trans('home.image')}}</th>
                                                    <th class="text-left">{{trans('home.name')}}</th>
                                                    <th>@lang('home.attributes')</th>
                                                    <th>{{trans('home.price')}}</th>
                                                    <th>{{trans('home.quantity')}}</th>
                                                    <th>{{trans('home.subtotal')}}</th>
                                                    @if($order->status == 'delivered')
                                                        <th>{{trans('home.actions')}}</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @foreach($order->products as $product)
                                                    @if($product->product)
                                                        <tr>
                                                        	<td>
                                                        	    <a href="{{($lang == 'en')?url('product/'.$product->group->product->link_en.'?group='.$product->group->id):url('product/'.$product->group->product->link_en.'?group='.$product->group->id)}}" class="thumb">
                                                        	        @if($product->group->image)
                                                                        <img width="60px" class="checkout-image" src="{{url('uploads/products/resize200/'.$product->group->image->image)}}">
                                                                    @else
                                                                        <img width="60px" class="checkout-image" src="{{url('resources/assets/front/images/noimage.png')}}">
                                                                    @endif
                                                        	    </a>
                                                        	</td>
                                                            <td class="text-left">
                                                                <a href="{{($lang == 'en')?url('product/'.$product->group->product->link_en.'?group='.$product->group->id):url('product/'.$product->group->product->link_en.'?group='.$product->group->id)}}" class="thumb">
                                                                    {{($lang == 'en')?$product->group->product->name_en : $product->group->product->name_ar}}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                @foreach ($product->group->getProductGroupsAttribute() as $attribute)
                                                                    {{$attribute->attribute->{'name_'.$lang} }}: {{$attribute->attributeValue->{'value_'.$lang} }}<br>
                                                                @endforeach
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
                                                            @if($order->status == 'delivered')
                                                                <td>
                                                                    @if(! in_array($product->group->product->id, $checkRateRevivew))
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal_{{$product->group->product->id}}">{{trans('home.rate_and_review')}}</a>
                                                                    @else
                                                                        <a href="#">{{trans('home.rated_before')}}</a>
                                                                    @endif
                                                                </td>
                                                            @endif
                                                        </tr>

                                                        <div class="modal fade exampleModal_{{$product->group->product->id}}" id="exampleModal_{{$product->group->product->id}}" tabindex="-1" role="dialog" aria-bs-labelledby="exampleModalLabel1" aria-bs-hidden="true">
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
                                                                            <input type="hidden" name="product_id" value="{{$product->group->product->id}}"/>
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-indicator">
                        <div class="step-track step1 @if(in_array('pending',$status)) active @endif">
                            <div class="step-icon"><img src="{{url('resources/assets/back/img/box.png')}}" alt="..."></div>
                            <p>{{trans('home.pending')}}</p>
                        </div>
                        <div class="indicator-line @if(in_array('accept',$status)) active @endif"></div>
                        <div class="step-track step2 @if(in_array('accept',$status)) active @endif">
                            <div class="step-icon"><img src="{{url('resources/assets/back/img/check.png')}}" alt="..."></div>
                            <p>{{trans('home.accept')}}</p>
                        </div>
                        <div class="indicator-line @if(in_array('process',$status)) active @endif"></div>
                        <div class="step-track step3 @if(in_array('process',$status)) active @endif">
                            <div class="step-icon"><img src="{{url('resources/assets/back/img/hourglass.png')}}" alt="..."></div>
                            <p>{{trans('home.process')}}</p>
                        </div>
                        <div class="indicator-line @if(in_array('shipping',$status)) active @endif"></div>
                        <div class="step-track step3 @if(in_array('shipping',$status)) active @endif">
                            <div class="step-icon"><img src="{{url('resources/assets/back/img/truck.png')}}" alt="..."></div>
                            <p>{{trans('home.shipping')}}</p>
                        </div>
                        <div class="indicator-line @if(in_array('delivered',$status)) active @endif"></div>
                        <div class="step-track step3 @if(in_array('delivered',$status)) active @endif">
                            <div class="step-icon"><img src="{{url('resources/assets/back/img/like.png')}}" alt="..."></div>
                            <p>{{trans('home.delivered')}}</p>
                        </div>
                    </div>

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
                                        <td>{{trans("home.$status->status")}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Dashboard -->
            </div>
            <!-- End Tab panes -->
        </div>
    </div>
</div>
<!--End Body Container-->

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
