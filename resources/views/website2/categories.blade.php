@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp

    @php echo $schema @endphp
@endsection

@section('content')

<main class="main">
    <nav class="breadcrumb-nav mb-10">
        <div class="container">
            <div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">{{ trans('home.categories') }}</h1>
                     <ul class="breadcrumb">
                        <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{ trans('home.home') }}</a></li>
                        <li>{{ trans('home.categories') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="page-content contact-us">
        <div class="container">
            @if(count($MainCategories) > 0)
                <section class="mian-categs">
                    <div class="container-fluid">
                        <h2 class="title title-center pt-3 mb-5 appear-animate fadeIn appear-animation-visible" style="animation-duration: 1.2s;">{{trans('home.main_categories')}}</h2>
                        <div class="top-categories-wrapper appear-animate">
                            <div class="pl-2 pr-2">
                                <div class="row">
                                    @foreach($MainCategories as $MainCategory)
                                        <div class="col-md-3">
                                            <div class="banner banner-1 banner-fixed">
                                                <figure class="banner-media br-sm cat-img">
                                                    <img src="{{url('uploads/categories/source/'.$MainCategory->image)}}" alt="{{$MainCategory->name_en}} Image"/>
                                                </figure>
                                                <div class="banner-content1">
                                                    <h3 class="banner-title ls-25"> {{($lang == 'en')?$MainCategory->name_en:$MainCategory->name_ar}} </h3>
                                                </div>
                                                <a href="{{($lang == 'en')?LaravelLocalization::localizeUrl('category/'.$MainCategory->link_en):LaravelLocalization::localizeUrl('category/'.$MainCategory->link_ar)}}" class="btn btn-dark btn-rounded btn-icon-right">{{trans('home.shop_now')}}<i class="w-icon-long-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                @endif

        </div>
    </div>
</main>

@endsection