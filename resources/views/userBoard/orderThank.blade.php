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
        <div class="col-xs-12 col-lg-12 col-md-12">
            <!-- Tab panes -->
            <div class="dashboard-content padding-30px-all md-padding-15px-all">
                <!-- Dashboard -->
                <div id="dashboard" class="tab-pane fade active show">
                    <div class="tab-content mb-6">
                        <div class="tab-pane mb-4  active in text-center" id="account-orders">
                            <img src="{{url('uploads/settings/resize200/'.$configration->app_logo)}}" />
                            <p class="m-4">{{trans('home.thank you your order placed successfully')}}</p>
                            <a class="view" href="{{ LaravelLocalization::localizeUrl('/user/orders') }}"><button class="btn btn-dark">  <span>{{trans('home.my_orders')}}</span> </button></a>
                        </div>
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
    <?php 
    $user =auth()->user();
    ?>
    <script>
        $(document).ready(function(){
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
                    items:{!!$items!!}
                });
            }
            fireGooglePurchase();
        });
    </script>
   

@endsection