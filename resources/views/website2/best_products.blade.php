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
                    <div class="page-title"><h1>{{__('home.bestSeller_products')}}</h1></div>
                    <!--Breadcrumbs-->
                    <div class="breadcrumbs">
                        <span class="main-title fw-bold">{{__('home.bestSeller_products') }}</span>
                        <span class="main-title fw-bold">
                            <i class="icon anm anm-angle-right-l"></i>
                            <a href="{{LaravelLocalization::localizeUrl('/products')}}">
                            {{__('home.products')}}
                        </a>

                        </span>
                        <a href="{{LaravelLocalization::localizeUrl('/')}}"
                           title="Back to the home page"><i class="icon anm anm-angle-right-l"></i> {{trans('home.home')}}</a>

                    </div>
{{--                    <div class="breadcrumbs"><a href="{{LaravelLocalization::localizeUrl('/')}}" title="Back to the home page">{{trans('home.home')}}</a><span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>{{__('home.products')}}</span></div>--}}
                    <!--End Breadcrumbs-->
                </div>
            </div>
        </div>
    </div>
    <!--End Page Header-->
    <!--Main Content-->
    <div class="container product-page">
        <form >
            <!--Toolbar-->
            <div class="toolbar toolbar-wrapper shop-toolbar">
                <div class="row align-items-center">
                    <div class="col-4 col-sm-2 col-md-4 col-lg-4 text-left filters-toolbar-item d-flex order-1 order-sm-0">
                        <div class="filters-item d-flex align-items-center">
                            <label class="mb-0 ms-2 d-none d-lg-inline-block">{{__('home.reshape')}}:</label>
                            <div class="grid-options view-mode d-flex">
                                <a class="icon-mode mode-grid grid-3 d-md-block" data-col="3"></a>
                                <a class="icon-mode mode-grid grid-4 d-lg-block" data-col="4"></a>
                                <a class="icon-mode mode-grid grid-5 d-xl-block active" data-col="5"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 text-center product-count order-0 order-md-1 mb-3 mb-sm-0">
                    </div>
                    <div class="col-8 col-sm-6 col-md-4 col-lg-4 text-right filters-toolbar-item d-flex justify-content-end order-2 order-sm-2">
                        <div class="filters-item d-flex align-items-center me-2 ms-lg-3">

                                <label for="ShowBy" class="mb-0 ms-2 text-nowrap d-none d-sm-inline-flex">{{__('home.sort_by')}}</label>
                                <select name="sort_by" class="filters-toolbar-show" onchange="this.form.submit()">
                                    <option  selected>{{__('home.selectall')}}</option>
                                    <option value="latest" {{(isset($_GET['sort_by'])  && $_GET['sort_by'] == 'latest')?'selected':''}}>{{trans('home.latest')}}</option>
                                    <option value="price-low" {{(isset($_GET['sort_by'])  && $_GET['sort_by'] == 'price-low')?'selected':''}}>{{trans('home.pric: low to high')}}</option>
                                    <option value="price-high" {{(isset($_GET['sort_by'])  && $_GET['sort_by'] == 'price-high')?'selected':''}}>{{trans('home.price: high to low')}}</option>
                                </select>


                        </div>
                    </div>
                </div>
            </div>
            <!--End Toolbar-->
            <div class="row">
                <!--Sidebar-->
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 sidebar sidebar-bg filterbar">
    {{--                <div class="closeFilter"><i class="icon anm anm-times-r"></i></div>--}}
                    <div class="sidebar-tags clearfix">

                        <!--Categories-->
                        <div class="sidebar-widget clearfix categories filterBox filter-widget">
                            <div class="widget-title"><h2>{{__('home.categories')}}</h2></div>
                            <div class="widget-content filterDD">
                                <ul class="sidebar-categories scrollspy morelist clearfix">
                                    @foreach($MainCategories as $MainCategorie)
                                        @if(count($MainCategorie->subCategories()) > 0)
                                            <li class="lvl1 sub-level more-item"><a href="#" class="site-nav">{{$MainCategorie->{'name_'.$lang} }} </a>
                                            <ul class="sublinks">
                                                @foreach($MainCategorie->subCategories() as $SubCategory)
                                                    <li class="lvl3"><a href="{{LaravelLocalization::localizeUrl('category/'.$SubCategory->{'link_'.$lang} )}}" class="site-nav"> {{$SubCategory->{'name_'.$lang} }} <span class="count">({{$SubCategory->productsCount()}})</span></a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        @else
                                        <li class="lvl1 more-item"><a href="{{LaravelLocalization::localizeUrl('category/'.$MainCategorie->{'link_'.$lang} )}}" class="site-nav"> {{$MainCategorie->{'name_'.$lang} }}<span class="count">({{$MainCategorie->productsCount()}})</span></a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!--Categories-->
                        <!--Price Filter-->
                        <div class="sidebar-widget filterBox filter-widget">
                            <div class="widget-title"><h2>{{__('home.price')}}</h2></div>
                            <div class="widget-content price-filter filterDD" >
                                <div id="slider-range" class="mt-2"></div>
                                <div class="row">
                                    <input type="hidden" id="max_price" value="{{$max}}">
                                    <input type="hidden" id="min_price" value="{{$min}}">
                                    {{--changed amound--}}
                                    <input type="hidden" id="f_max_price" name="to"  value="{{$MainProducts->max('price')}}">
                                    <input type="hidden" id="f_min_price" name="from" value="{{$MainProducts->min('price')}}">
                                    <div class="col-12"><input id="amount" type="text" /></div>
                                    <div class="col-6 text-right">
                                        <button type="submit"  class="btn btn-sm">{{__('home.filter')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End Price Filter-->
                    </div>
                </div>
                <!--End Sidebar-->

                <!--Products-->
                <div class="col-12 col-sm-12 col-md-12 col-lg-9 main-col">
                    <!--Product Grid-->
                    <div class="grid-products grid-view-items">
                        <div class="row col-row product-options row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2">
                            @foreach($MainProducts as $MainProduct)
                                <div class="item col-item">
                                    <div class="product-box">
                                        <!-- Start Product Image -->
                                        <div class="product-image">
                                            <!-- Start Product Image -->
                                            <a href="{{LaravelLocalization::localizeUrl('product/'.$MainProduct->{'link_'.$lang})}}" class="product-img rounded-3">
                                                <img class="blur-up lazyload"
                                                     src="{{Helper::uploadedImagesPath('products',$MainProduct->images()[0])}}" alt="{{$MainProduct->{'name_'.$lang} }}"
                                                     title="{{$MainProduct->{'name_'.$lang} }}" width="625" height="808" /></a>
                                            <!-- End Product Image -->
                                            <!-- Product label -->
                                            @if($MainProduct->stockCount()==0)
                                                <div class="product-labels"><span class="lbl on-sale">{{__('home.outstock')}}</span></div>
                                            @elseif($MainProduct->featurd==1)
                                                <div class="product-labels "><span class="lbl pr-label1">{{__('home.special')}}</span></div>
                                            @elseif($MainProduct->new()==true)
                                                <div class="product-labels "><span class="lbl pr-label3">{{__('home.new')}}</span></div>
                                            @elseif($MainProduct->discount()>0)
                                                <div class="product-labels "><span class="lbl pr-label3">{{__('home.Sale')}}</span></div>
                                            @endif
                                            <!-- End Product label -->
                                            <!--Product Button-->
                                            <div class="button-set style1">
                                                @if($MainProduct->stockCount()>0)
                                                <!--Cart Button-->
                                                <a href="javascript:void(0);" class="btn-icon btn-showCart addtocart " data-bs-toggle="modal" data-bs-target="#addtocart_modal" data-product_id="{{$MainProduct->id}}">
                                                    <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="{{__('home.Add to cart')}}">
                                                        <i class="icon anm anm-cart-l"></i>
                                                        <span class="text">{{__('home.Add to cart')}}</span>
                                                    </span>
                                                </a>
                                                <!--End Cart Button-->
                                                @endif
                                                <!--Wishlist Button-->
                                                <a href="javascript:void(0);" class="btn-icon btn-wishlist  wishlist" data-bs-toggle="tooltip" data-bs-placement="left" title="{{__('home.Add to Wishlist')}}" data-product_id="{{$MainProduct->id}}">
                                                    <i class="icon anm anm-heart-l"></i>
                                                    <span class="text">{{__('home.Add to Wishlist')}}</span>
                                                </a>
                                                <!--End Wishlist Button-->
                                            </div>
                                            <!--End Product Button-->
                                        </div>
                                        <!-- End Product Image -->
                                        <!-- Start Product Details -->
                                        <div class="product-details">
                                            <!-- Product Name -->
                                            <div class="product-name">
                                                <a href="{{LaravelLocalization::localizeUrl('product/'.$MainProduct->{'link_'.$lang})}}">
                                                    {{ Illuminate\Support\Str::limit($MainProduct->{'name_'.$lang}, $limit = 50, $end = '...') }}
                                                </a>
                                            </div>
                                            <!-- End Product Name -->
                                            <!-- Product Price -->
                                            <div class="product-price">
                                                @if($MainProduct->discount()>0)
                                                    <span class="price old-price">{{$MainProduct->price.' '.__('home.EGP')  }}</span>
                                                    <span class="price">{{$MainProduct->condition_discount() .' '.__('home.EGP')   }}</span>
                                                @else
                                                    <span class="price">{{$MainProduct->price.' '.__('home.EGP')  }}</span>
                                                @endif
                                            </div>
                                            <!-- End Product Price -->
                                            <!-- Product Review -->
                                            <div class="product-review">
                                                    <?php $rate = intval($MainProduct->rate()); ?>

                                                @for($i = 1; $i <= $rate; $i++)
                                                    <i class="icon anm anm-star"></i>
                                                @endfor
                                                @for($i = 1; $i <= 5-$rate; $i++)
                                                    <i class="icon anm anm-star-o"></i>
                                                @endfor
    {{--                                            <span class="caption me-1">{{$MainProduct->reviewCount()}} {{__('home.reviews')}} </span>--}}
                                            </div>
                                            <!-- End Product Review -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Pagination -->
                            <nav class="clearfix pagination-bottom">
                            <ul class="pagination justify-content-center" style="display: flex!important;">


                                    @if($MainProducts->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link"><i class="icon anm anm-angle-right-l"></i></span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $MainProducts->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}"><i class="icon anm anm-angle-right-l"></i></a></li>
                                    @endif

                                    @foreach ($MainProducts->getUrlRange(1, $MainProducts->lastPage()) as $page => $url)
                                        @php
                                            $urlWithParams = $url . '&' . http_build_query(request()->except('page'));
                                        @endphp

                                        @if($page == $MainProducts->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $urlWithParams }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    @if($MainProducts->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $MainProducts->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}"><i class="icon anm anm-angle-left-l"></i></a></li>
                                    @else
                                        <li class="page-item disabled"><span class="page-link"><i class="icon anm anm-angle-left-l"></i></span></li>
                                    @endif
                            </ul>
                        </nav>
                        <!-- End Pagination -->

                    </div>
                    <!--End Product Grid-->
                </div>
                <!--End Products-->
            </div>
        </form>
    </div>
    <!--End Main Content-->

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>

    <script type="text/javascript">
        $('ul.pagination').hide();
        $(function() {
            $('.scrolling-pagination').jscroll({
                autoTrigger: true,
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.scrolling-pagination',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });
        });
        $(document).ready(function(){
            $("form").on("change", "input:checkbox", function(){
                $("form").submit();
            });
        });
    </script>

@endsection
