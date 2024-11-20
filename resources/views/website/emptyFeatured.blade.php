@extends('layouts.app')
@section('title')
    <title>{{trans('home.emptyFeaturedProducts')}}</title>
@endsection    
@section('content')
<main class="main">
    <nav class="breadcrumb-nav mb-10">
        <div class="container">
            <div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">{{trans('home.emptyFeaturedProducts')}}</h1>
                     <ul class="breadcrumb">
                        <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{trans('home.home')}}</a></li>
                        <li>{{trans('home.emptyFeaturedProducts')}}</li>
                    </ul>
                </div>
           </div>
        </div>
    </nav>

    <div class="page-content">
        <section id="empty-content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center empty-page mb-5">
                        <i class="icon an an-life-ring"></i>
                        <h2>{{trans('home.emptyFeaturedProducts')}} !</h2>
                        <p class="mb-3 pb-1">{{trans('home.no items available')}}</p>
                        <a href="{{LaravelLocalization::localizeUrl('/')}}" class="btn btn-primary">{{trans('home.continue_shopping')}}</a>
                    </div>
                </div>
            </div>
        </section>
    </div>        
</main>
@endsection


                    


                    