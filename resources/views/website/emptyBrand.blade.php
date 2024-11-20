@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp

    @php echo $schema @endphp
@endsection
@section('content')
<main class="main">
    <!--Page Header-->
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="page-title"><h1>{{trans('home.emptyBrand')}}</h1></div>
                    <!--Breadcrumbs-->
                    <div class="breadcrumbs">
                    <span class="main-title fw-bold">
                        {{trans('home.emptyBrand')}}
                    </span>
                        <a href="{{LaravelLocalization::localizeUrl('/')}}" title="Back to the home page">
                            <i class="icon anm anm-angle-right-l"></i> {{trans('home.home')}} </a>
                    </div>
                    <!--End Breadcrumbs-->
                </div>
            </div>
        </div>
    </div>
    <!--End Page Header-->

    <div class="page-content">
        <section id="empty-content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center empty-page mb-5">
                        <i class="icon an an-life-ring"></i>
                        <h2>{{trans('home.emptyBrand')}} !</h2>
                        <p class="mb-3 pb-1">{{trans('home.no items available in this category')}}</p>
                        <a href="{{LaravelLocalization::localizeUrl('/')}}" class="btn btn-primary">{{trans('home.continue_shopping')}}</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection


