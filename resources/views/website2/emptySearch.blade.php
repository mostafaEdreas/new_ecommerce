@extends('layouts.app')
@section('meta')
    <title>{{trans('home.emptySearchProducts')}}</title>
@endsection
@section('content')

    <div class="breadcrumb-wrap">
      <div class="banner">
        <img class="bg-img bg-top" src="assets/images/inner-page/banner-p.jpg" alt="banner" />

        <div class="container-lg">
          <div class="breadcrumb-box">
            <div class="heading-box">
              <h1>{{trans('home.emptySearchProducts')}}</h1>
            </div>
            <ol class="breadcrumb">
              <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{trans('home.home')}}</a></li>
              <li>
                <a href="javascript:void(0)"><i data-feather="chevron-right"></i></a>
              </li>
              <li class="current"><a >{{trans('home.emptySearchProducts')}}</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- Breadcrumb End -->


<main class="main">
    <div class="page-content">
        <section id="empty-content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center empty-page mb-5">
                        <i class="icon an an-life-ring"></i>
                        <h2>{{trans('home.emptySearchProducts')}} !</h2>
                        <p class="mb-3 pb-1">{{trans('home.no items available')}}</p>
                        <a href="{{LaravelLocalization::localizeUrl('/')}}" class="btn text-white" style="background-color: #3a54a5">
                        {{trans('home.continue_shopping')}}</a>

                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection








