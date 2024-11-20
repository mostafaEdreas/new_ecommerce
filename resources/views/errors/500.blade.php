@extends('layouts.app') 
<title>500</title>
@section('content')

<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <div class="banner">
        <img class="bg-img bg-top" src="{{Helper::uploadedImagesPath('aboutStrucs',$about->banner)}}" alt="banner" />

        <div class="container-lg">
        <div class="breadcrumb-box">
            <div class="heading-box">
            <h1>{{__('home.505')}}</h1>
            </div>
            <ol class="breadcrumb">
            <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{__('home.home')}}</a></li>
            <li>
                <a href="javascript:void(0)"><i data-feather="chevron-right"></i></a>
            </li>
            <li class="current"><a >{{__('home.505')}}</a></li>
            </ol>
        </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->


<div class="text-center mt-5">
    <a href="{{url('/')}}" class="btn btn-dark btn-rounded px-5" style="background-color: #3a54a5">{{trans('home.go_home')}}</a>
    <p></p>
</div>
<div id="errors">
    <div class="text-center">
        <img src="{{url('resources/assets/front/images/505.png')}}" style="mix-blend-mode: multiply;" class="col-lg-4 col-sm-12"/>
    </div>
    <br>
</div>
@endsection