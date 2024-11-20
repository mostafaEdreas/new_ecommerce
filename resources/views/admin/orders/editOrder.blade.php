@extends('layouts.admin')
<title>{{trans('home.order_details')}}</title>
@section('style')
    <style type="text/css">
        #loader {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        background: rgba(0,0,0,0.75) url(https://mix-cosmetic.com/resources/assets/back/img/loader.gif) no-repeat center center;
        z-index: 10000;
        }
    </style>
@endsection
@section('content')

<div id="loader"></div>

<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.order_details')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/orders')}}">{{trans('home.orders')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.order_details')}}</li>
                </ol>
            </div>
        </div>
        <!-- End Page Header -->

        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->pull('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">

                    <div class="card-body">

                        <div aria-multiselectable="true" class="accordion" id="accordion" role="tablist">
                            <div class="card">
                                <div class="card-header" id="headingOne" role="tab">
                                    <a aria-controls="collapseOne" aria-expanded="false" data-toggle="collapse" href="#collapseOne" class="collapsed">{{trans('home.order_details')}}</a>
                                </div>
                                <div aria-labelledby="headingOne" class="collapse" data-parent="#accordion" id="collapseOne" role="tabpanel" style="">
                                    <div class="card-body">
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
                                                <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.total')}} :</strong> {{$order->total_price}} {{trans("home.EGP")}} </p></div>
                                                <div class="col-sm-12 col-md-6"><p><strong>{{trans('home.order_note')}} :</strong> {{$order->order_note}}</p></div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="table-responsive-sm order-table">
                                            <table class="bg-white table table-bordered table-hover text-center">
                                                <thead>
                                                    <tr>
                                                    	<th class="text-left">{{trans('home.image')}}</th>
                                                        <th class="text-left">{{trans('home.name')}}</th>
                                                        <th>{{trans('home.price')}}</th>
                                                        <th>{{trans('home.quantity')}}</th>
                                                        <th>@lang('home.attributes')</th>
                                                        <th>{{trans('home.subtotal')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   @foreach($order->products as $product)
                                                        @if($product->group)
                                                            <tr>
                                                            	<td>
                                                            	    <a href="{{($lang == 'en')?url('product/'.$product->group->id.'/'.$product->group->product->name_en):url('product/'.$product->group->id.'/'.$product->product->name_ar)}}" class="thumb">
                                                            	        @if($product->group->image->image)
                                                                            <img width="60px" class="checkout-image" src="{{url('uploads/products/resize200/'.$product->group->image->image)}}">
                                                                        @else
                                                                            <img width="60px" class="checkout-image" src="{{url('resources/assets/front/images/noimage.png')}}">
                                                                        @endif
                                                            	    </a>
                                                            	</td>
                                                                <td class="text-left">
                                                                    <a href="{{($lang == 'en')?url('product/'.$product->group->id.'/'.$product->group->product->name_en):url('product/'.$product->group->id.'/'.$product->group->product->name_ar)}}" class="thumb">
                                                                        {{($lang == 'en')?$product->group->product->name_en : $product->group->product->name_ar}}
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
                                                                <td>
                                                                    @foreach ($product->group->getProductGroupsAttribute() as $attribute)
                                                                        {{$attribute->attribute->{'name_'.$lang} }}: {{$attribute->attributeValue->{'value_'.$lang} }}<br>
                                                                    @endforeach
                                                            </td>
                                                                <td>{{$product->price * $product->quantity}} {{trans('home.EGP')}}</td>
                                                            </tr>
                                                            <div class="modal fade exampleModal_{{$product->group->product->id}}" id="exampleModal_{{$product->group->product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
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
                                                            	<td colspan="6">{{trans('home.order_item_not_availbale_now')}}</td>
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
                        <br>

                        <div>
                            <h6 class="card-title mb-1">{{trans('home.order_tracking')}}</h6>
                        </div>

                        <div class="form-wizard-steps order-tracking">

                        	<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="12.25" data-number-of-steps="4" style="width: 12.25%;"></div>
                    		</div>

                            <div class="step-track">
                                <div class="step-icon">
                                    <button type="button" class="btn btn-primary track-order" disabled>
                                    	<img style="display:none;"  src="{{url('resources/assets/back/img/box.png')}}">
                                    	<i class="fa fa-unlock-alt"></i>
                                    </button>
                                </div>
                                <p>{{trans('home.pending')}}</p>
                            </div>


                            <div class="step-track">
                                <div class="step-icon">
                                    <button type="button" class="btn btn-primary track-order" data-status="accept" @if(in_array('accept', $orderStatuses)) disabled @endif>
                                    	<img style="display:none;" src="{{url('resources/assets/back/img/check.png')}}">
                                    	<i class="fa fa-check"></i>
                                    </button>
                                </div>
                                <p>{{trans('home.accept')}}</p>
                            </div>

                            <div class="step-track">
                                <div class="step-icon">
                                    <button type="button" class="btn btn-primary track-order" data-status="process" @if(in_array('process', $orderStatuses) || $newActions[0] !='process' || in_array('canceled_by_admin', $orderStatuses)) disabled @endif>
                                    	<img style="display:none;" src="{{url('resources/assets/back/img/hourglass.png')}}">
                                   		<i class="fa fa-recycle"></i>
                                    </button>
                                </div>
                                <p>{{trans('home.process')}}</p>
                            </div>


                            <div class="step-track">
                                <div class="step-icon">
                                    <button  type="button" class="btn btn-primary track-order" data-status="shipping" @if(in_array('shipping', $orderStatuses) || $newActions[0] !='shipping' || in_array('canceled_by_admin', $orderStatuses)) disabled @endif>
                                    	<img style="display:none;" src="{{url('resources/assets/back/img/truck.png')}}">
                                    	<i class="fa fa-shipping-fast"></i>
                                    </button>
                                </div>
                                <p>{{trans('home.shipping')}}</p>
                            </div>

                             <div class="step-track">
                                <div class="step-icon">
                                    <button type="button" class="btn btn-primary track-order" data-status="delivered" @if(in_array('delivered', $orderStatuses) || $newActions[0] !='delivered' || in_array('canceled_by_admin', $orderStatuses)) disabled @endif>
                                    	<img style="display:none;" src="{{url('resources/assets/back/img/like.png')}}">
                                    	<i class="fa fa-handshake"></i>
                                    </button>
                                </div>
                                <p>{{trans('home.delivered')}}</p>
                            </div>

                        </div>

                        <br>
                        <div class="table-responsive">
                            <table class="table mg-b-0">
                                <thead>
                                    <tr>
                                        <th>{{trans('home.date')}}</th>
                                        <th>{{trans('home.time')}}</th>
                                        <th>{{trans('home.status')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orderStatus as $status)
                                        <tr>
                                            <th scope="row">{{date('Y/m/d', strtotime($status->created_at ))}}</th>
                                            <td>{{date('h:i:s', strtotime($status->created_at ))}}</td>
                                            <td>{{trans("home.$status->status")}}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{url('admin/order/'.$order->id.'/invoice')}}" target="_blank">
                            <button type="button" class="btn ripple btn-primary mb-1"><i class="fe fe-credit-card mr-1"></i>{{trans('home.generate_invoice')}}</button>
                        </a>
                    </div>
                    <div class="card-footer text-left">
                        <form action="{{url('admin/order/'.$order->id.'/cancel')}}" method="POST">
                            @csrf
                            <button @if(in_array('canceled_by_admin', $orderStatuses)) disabled @endif type="submit" class="btn ripple btn-primary mb-1"><i class="fa fa-lock-alt"></i>{{trans('home.cancel_order')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{trans('home.select_order_delivery')}}</h6>
                        </div>
                        <form action="{{url('admin/order/delivery/'.$order->id)}}" method="POST">
                            @csrf
                            <div class="row align-items-center">

                                <div class="form-group col-md-5">
                                    <label for="code">{{trans('home.delivery_date')}}</label>
                                    <div class="input-group">
                                        <input type='text' class="form-control dateFrom" value="{{$order->delivery_date}}" placeholder="{{trans('home.delivery_date')}}" id="datepicker1" name="delivery_date" readonly required/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group col-md-5">
                                    <label for="helperText">{{trans('home.deliver_man')}}</label>
                                    <select class="form-control select2" name="delivery_id" required>
                                        <option></option>
                                        @foreach($deliveries as $delivery)
                                            <option value="{{$delivery->id}}" {{($delivery->id == $order->delivery_id )?'selected':''}}>{{$delivery->name}} - {{$delivery->phone1}}</option>
                                        @endforeach

                                    </select>
                                </div>

                                @if(! $order->delivery_id )
                                    <div class="form-group col-md-2">
                                        <button type="submit" class="btn btn-success" style="margin-top: 25px"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>

        $(document).on({
            ajaxStart: function() { $('#loader').show();},
            ajaxStop: function() {  $('#loader').hide();}
        });

        $('.track-order').on('click',function(){
            var status = $(this).data('status');
            var orderId = {{$order->id}};
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:" {{url('admin/orders/changeStatus')}}",
                method:'POST',
                data:{orderId:orderId,status:status},
                success:function(html)
                {
                    location.reload();
                }
            });
        });

        $( "#datepicker1" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });

    </script>
@endsection

