@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp
    @php echo $schema @endphp
@endsection
@section('content')


    <div class="page-content">

        @include('website.products.banner')

        <section class="content-inner-1 pt-3 z-index-unset">
            <div class="container">
                <div class="row">
                    @include('website.products.sidebar')
                    <div class="col-xl-9 col-lg-12">
                        <div class="filter-wrapper">

                            <div class="filter-right-area">
                                <a href="javascript:void(0);" class="panel-btn">
                                    <svg class="me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25" width="20" height="20"><g id="Layer_28" data-name="Layer 28"><path d="M2.54,5H15v.5A1.5,1.5,0,0,0,16.5,7h2A1.5,1.5,0,0,0,20,5.5V5h2.33a.5.5,0,0,0,0-1H20V3.5A1.5,1.5,0,0,0,18.5,2h-2A1.5,1.5,0,0,0,15,3.5V4H2.54a.5.5,0,0,0,0,1ZM16,3.5a.5.5,0,0,1,.5-.5h2a.5.5,0,0,1,.5.5v2a.5.5,0,0,1-.5.5h-2a.5.5,0,0,1-.5-.5Z"></path><path d="M22.4,20H18v-.5A1.5,1.5,0,0,0,16.5,18h-2A1.5,1.5,0,0,0,13,19.5V20H2.55a.5.5,0,0,0,0,1H13v.5A1.5,1.5,0,0,0,14.5,23h2A1.5,1.5,0,0,0,18,21.5V21h4.4a.5.5,0,0,0,0-1ZM17,21.5a.5.5,0,0,1-.5.5h-2a.5.5,0,0,1-.5-.5v-2a.5.5,0,0,1,.5-.5h2a.5.5,0,0,1,.5.5Z"></path><path d="M8.5,15h2A1.5,1.5,0,0,0,12,13.5V13H22.45a.5.5,0,1,0,0-1H12v-.5A1.5,1.5,0,0,0,10.5,10h-2A1.5,1.5,0,0,0,7,11.5V12H2.6a.5.5,0,1,0,0,1H7v.5A1.5,1.5,0,0,0,8.5,15ZM8,11.5a.5.5,0,0,1,.5-.5h2a.5.5,0,0,1,.5.5v2a.5.5,0,0,1-.5.5h-2a.5.5,0,0,1-.5-.5Z"></path></g></svg>
                                    @lang('home.filter')
                                </a>
                                <div class="form-group">
                                    <select class="default-select" name="sortBY" >
                                        <option value=""></option>
                                        <option value="min_price">@lang('home.min_price')</option>
                                        <option value="max_price">@lang('home.max_price')</option>
                                        <option value="rate">@lang('home.rate')</option>
                                        <option value="best-seling">@lang('home.best-seling')</option>
                                        <option value="name-A-Z">@lang('home.name-A-Z')</option>
                                        <option value="name-from-z-A">@lang('home.name-Z-A')</option>
                                        <option value="date-old-new">@lang('home.date-old-new')</option>
                                        <option value="date-new-old">@lang('home.date-new-old')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @include('website.products.carts.cart-lg-4')
                        </div>
                       @include('website.products.pagination', ['paginator' => $products])
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
@section('script')
@endsection