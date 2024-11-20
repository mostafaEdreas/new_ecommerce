@extends('layouts.app') 
    <title>{{__('home.not_found')}}</title>
@section('content')
<!-- Breadcrumb Start -->
<div class="error-area-main-wrapper rts-section-gap2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="error-main-wrapper">
                    <div class="thumbnail">
                        <img src="{{url('resources/assets/front/images/contact/01.png')}}" alt="error">
                    </div>
                    <div class="content-main">
                        <h2 class="title">@lang('home.This page cannot be found.')</h2>
                        <p>@lang('home.Sorry, we couldn\'t find the page you were looking for. We suggest you return to the home page.')</p>
                        <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="rts-btn btn-primary">@lang('home.go_home')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection