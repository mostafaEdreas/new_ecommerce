@extends('layouts.app')
@section('meta')
    <title>{{trans('home.emptyCompareList')}}</title>
@endsection    
@section('content')
<main class="main">
    <nav class="breadcrumb-nav mb-10">
        <div class="container">
            <div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">{{trans('home.emptyCompareList')}}</h1>
                     <ul class="breadcrumb">
                        <li><a href="{{url('/')}}">{{trans('home.home')}}</a></li>
                        <li>{{trans('home.emptyCompareList')}}</li>
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
                        <h2>{{trans('home.emptyCompareList')}} !</h2>
                        <p class="mb-3 pb-1">{{trans('home.no items available')}}</p>
                        <a href="{{url('/')}}" class="btn btn-primary">{{trans('home.continue_shopping')}}</a>
                    </div>
                </div>
            </div>
        </section>
    </div>        
</main>
@endsection


                    


                    


                    
