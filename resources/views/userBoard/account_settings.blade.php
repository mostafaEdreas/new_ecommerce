@extends('layouts.app')
@section('meta')
    <title>{{$configration->app_name}}|{{trans('home.My Account')}}</title>
@endsection
@section('content')

<!-- Page Title -->
<div class="page section-header text-center mb-0">
    <div class="page-title">
        <div class="wrapper"><h1 class="page-width">{{trans('home.My Account')}}</h1></div>
    </div>
</div>
<!-- End Page Title -->

<div class="rts-navigation-area-breadcrumb bg_light-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="navigator-breadcrumb-wrapper">
                    <a href="{{ LaravelLocalization::localizeUrl('/') }}"> {{ __('home.home') }} </a>
                    <i class="fa-regular fa-chevron-right"></i>
                    <a class="current" href="javascript:void(0)">{{trans('home.My Account')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-seperator bg_light-1">
    <div class="container">
        <hr class="section-seperator">
    </div>
</div>

<!--End Breadcrumbs-->
<div class="container">
    @include('userBoard.partials.profile')
    <div class="row mb-5">
        @include('userBoard.partials.nav-links')

        <div class="col-xs-10 col-lg-10 col-md-12">
            <!-- Tab panes -->
            <div class="dashboard-content padding-30px-all md-padding-15px-all">
                <!-- Dashboard -->
                <div id="dashboard" class="tab-pane fade active show">
                    <h3>{{trans('home.My Account')}}</h3>

                    <p>{{trans('home.from your account you can easily check and view your')}}
                        <a class="text-decoration-underline" href="{{LaravelLocalization::localizeUrl('user/orders')}}">{{trans('home.recent orders')}}</a>, {{trans('home.manage your')}}
                        <a class="text-decoration-underline" href="{{LaravelLocalization::localizeUrl('user/shipping-addresses')}}">{{trans('home.shipping and billing addresses')}}</a> {{trans('home.and')}}
                        <a class="text-decoration-underline" href="{{LaravelLocalization::localizeUrl('/user/edit-account')}}">{{trans('home.edit your account details')}}</a>
                    </p>

                    <p><strong>{{trans('home.name')}} : </strong>{{$user->name()}}</p>
                    <p><strong>{{trans('home.email')}} : </strong>{{$user->email}}</p>
                    <p><strong>{{trans('home.phone')}} : </strong>{{$user->phone}}</p>
                    <p><strong>{{trans('home.password')}} : </strong>******</p>
                    <a class="text-decoration-underline" href="{{LaravelLocalization::localizeUrl('user/edit-account')}}">{{trans('home.edit your password and account details')}}</a>
                </div>
                <!-- End Dashboard -->
            </div>
            <!-- End Tab panes -->
        </div>
    </div>
</div>
<!--End Body Container-->

@endsection
