@extends('layouts.app')
@section('meta')
    <title>{{$configration->app_name}}|{{trans('home.emptyCart')}}</title>
@endsection
@section('content')
<div class="page section-header text-center">
    <div class="page-title">
        <div class="wrapper"><h1 class="page-title">{{trans('home.emptyCart')}}</h1></div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12 text-center empty-page mb-5">
            <i class="icon an an-cart-arrow-down"></i>
            <h2>{{trans('home.your shopping cart is empty')}} !</h2>
            <p class="mb-3 pb-1">{{trans('home.you have no items in your shopping cart')}}</p>
            <a href="{{url('/')}}" class="btn btn-primary">{{trans('home.continue_shopping')}}</a>
        </div>
    </div>
</div>
@endsection


