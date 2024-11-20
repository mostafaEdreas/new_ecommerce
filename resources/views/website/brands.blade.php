@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp
    @php echo $schema @endphp
@endsection
@section('content')

    <!--Page Header-->
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="page-title"><h1>{{__('home.brands')}}</h1></div>
                    <!--Breadcrumbs-->
                    <div class="breadcrumbs"><a href="{{LaravelLocalization::localizeUrl('/')}}" title="Back to the home page">{{trans('home.home')}}</a><span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>{{__('home.brands')}}</span></div>
                    <!--End Breadcrumbs-->
                </div>
            </div>
        </div>
    </div>
    <!--End Page Header-->
    <!--Main Content-->
    <div class="container product-page">
            <div class="row">
                <!--brands-->
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col">
                    <!--brands Grid-->
                    <div class="grid-products grid-view-items mb-5">
                        <div class="row col-row product-options row-cols-xl-4 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2 ">
                            @foreach($brands as $brand)
                                <div class="item col-item">
                                    <div class="product-box">
                                        <!-- Start brands Image -->
                                        <div class="d-flex align-items-center justify-content-center" style="height: 10vh;">
                                            <!-- Start brands Image -->
                                            <a href="{{ LaravelLocalization::localizeUrl('brand/'.$brand->{'link_'.$lang}) }}" class="product-img rounded-3">
                                                <img class="blur-up lazyload"
                                                     src="{{ url('uploads/brands/source/', $brand->logo) }}"
                                                     alt="{{ $brand->{'name_'.$lang} }}"
                                                     title="{{ $brand->{'name_'.$lang} }}" style="height: 10vh;"/>
                                            </a>
                                            <!-- End brands Image -->
                                            <!-- End brands Button -->
                                        </div>

                                        <!-- End brands Image -->
{{--                                        <!-- Start brands Details -->--}}
                                        <div class="product-details text-center mt-5">
                                            <!-- brand Name -->
                                            <div class="product-name">
                                                <h1>
                                                    <a href="{{LaravelLocalization::localizeUrl('brand/'.$brand->{'link_'.$lang})}}">
                                                        {{ $brand->{'name_'.$lang} }}
                                                    </a>
                                                </h1>

                                            </div>
                                        </div>
{{--                                        <!-- End brand details -->--}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!--End brands Grid-->
                </div>
                <!--End brands-->
            </div>
    </div>
    <!--End Main Content-->

@endsection

@section('script')


@endsection
