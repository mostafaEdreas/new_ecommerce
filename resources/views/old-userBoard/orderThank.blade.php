@extends('layouts.app')
@section('meta')
    <title>{{trans('home.order_completed')}}</title>
@endsection
@section('content')

     <div class="breadcrumb-wrap">
      <div class="banner">
        <img class="bg-img bg-top" src="assets/images/inner-page/banner-p.jpg" alt="banner" />

        <div class="container-lg">
          <div class="breadcrumb-box">
            <div class="heading-box">
              <h1>{{trans('home.order_completed')}}</h1>
            </div>
            <ol class="breadcrumb">
              <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{trans('home.home')}}</a></li>
              <li>
                <a href="javascript:void(0)"><i data-feather="chevron-right"></i></a>
              </li>
              <li class="current"><a >{{trans('home.order_completed')}}</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- Breadcrumb End -->


<main class="main">
    <!-- Start of PageContent -->
    <div class="page-content pt-2 my-account">
        <div class="container">

            <div class="tab tab-vertical row gutter-lg">

                <div class="tab-content mb-6">

                    <div class="tab-pane mb-4  active in text-center" id="account-orders">
                        <img src="{{url('uploads/settings/source/'.$configration->app_logo)}}" height="150px"/>
                        <p class="m-4">{{trans('home.thank you your order completed successfully')}}</p>
                        <a href="{{LaravelLocalization::localizeUrl('/products')}}" class="btn text-white" style="background-color: #3a54a5">{{trans('home.continue_shopping')}}</a>

                        <a class="view" href="{{ LaravelLocalization::localizeUrl('/user/account-settings') }}"><button class="btn btn-dark"> <i class="fas fa-eye"></i> <span>{{trans('home.order_tracking')}}</span> </button></a>
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
        $(document).ready(function(){
            function fireGooglePurchase(){
                gtag("event", "purchase", {
                    transaction_id: "{{$order->tracking_code}}",
                    value: {{$order->total_price}},
                    tax: 0.00,
                    shipping: {{$order->total_shipping}},
                    currency: "EGP",
                    items:{!!$items!!}
                });
            }
            fireGooglePurchase();
        });
    </script>
@endsection
