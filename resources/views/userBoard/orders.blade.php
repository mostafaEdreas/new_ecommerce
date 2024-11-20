@extends('layouts.app')
@section('meta')
    <title>{{$configration->app_name}}|{{trans('home.my_orders')}}</title>
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
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
                    <h3>{{trans('home.my_orders')}}</h3>
                    <p>{{trans('home.The following list includes the most recent requests, arranged from newest to oldest')}}</p>
                    @if(count($orders)>0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="alt-font">
                                    <tr>
                                        <th>#</th>
                                        <th>{{trans('home.order_code')}}</th>
                                        <th>{{trans('home.date')}}</th>
                                        <th>{{trans('home.status')}}</th>
                                        <th>{{trans('home.payment_status')}}</th>
                                        <th>{{trans('home.total')}}</th>
                                        <th>{{trans('home.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $key=>$ord)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$ord->tracking_code}}</td>
                                            <td>{{date('Y-m-d', strtotime($ord->created_at ))}}</td>
                                            <td>{{trans("home.$ord->status")}}</td>
                                            <td>{{trans("home.$ord->payment_status")}}</td>
                                            <td>{{$ord->total_price}} {{trans("home.SAR")}}</td>
                                            <td class="d-flex">
                                                <a class="btn view" href="{{url('/track-order')}}/{{$ord->id}}">{{trans('home.view')}}</a>
                                                @if(! in_array($ord->status,['delivered','canceled']))
                                                    <form action="{{url('cancel/Order')}}" method="post" class="cancelOrder">
                                                        @csrf
                                                        <input type="hidden" name="orderId" value="{{$ord->id}}"/>
                                                        <a  class="btn remove-btn" href="#">X</a>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            <img src="{{url('resources/assets/front/images/empty-cart.png')}}">
                            <p><a class="btn" href="{{url('/')}}">{{trans('home.continue_shopping')}}</a></p>
                        </div>
                    @endif
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script>
        $(".review-rating").starRating({
            starSize: 50,
            disableAfterRate:false,
            callback: function(currentRating, $el){
                // make a server call here
                $(".myRate").val(currentRating);
            }
         });

        $('.remove-btn').on('click', function(){
            $.confirm({
                title: '{{trans("home.Cancel Order")}}',
                content: '{{trans("home.Are you to cancel order ?")}}',
                buttons: {
                    confirm: function(){
                        $('.cancelOrder').submit();
                    },
                    cancel: function(){

                    }
                }
            });
        });

    </script>

    @if(Session::has('success'))
        <script>
            $.alert({
                title: "{{trans('home.thank_you')}}",
                content: "{{Session::get('success')}}",
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
        Session::forget('success')
    @endphp


    @if (count($orders)> 0)

        <?php
            $user =auth()->user();
            $order = $orders->first();
        ?>
        {{$layer_data = $order->products->map(function ($order_product) {
                        return ['product_id'=>$order_product['product_id'],'quantity'=>$order_product['quantity']];
                    })}}
        <script>
            $(document).ready(function(){
                console.log("{{$order->products}}");
                function fireGooglePurchase(){
                    gtag("event", "purchase", {
                        transaction_id: "{{$order->tracking_code}}",
                        value: "{{$order->total_price}}",
                        tax: 0.00,
                        shipping: "{{$order->total_shipping}}",
                        user_id: "{{$user?$user->id:'Visitor'}}",
                        email : "{{$user?$user->email:'Visitor'}}",
                        first_name : "{{$user?$user->f_name:'Visitor'}}",
                        last_name : "{{$user?$user->l_name:'Visitor'}}",
                        country : "{{$user?($user->shippingAdress()->country?$user->shippingAdress()->country->name_en:''):'Visitor'}}",
                        city : "{{$user?($user->shippingAdress()->area?$user->shippingAdress()->area->name_en:''):'Visitor'}}",
                        state : "{{$user?($user->shippingAdress()->region?$user->shippingAdress()->region->name_en:''):'Visitor'}}",
                        items:{!!$layer_data!!}
                    });
                }
                fireGooglePurchase();
            });
        </script>
    @endif
@endsection
