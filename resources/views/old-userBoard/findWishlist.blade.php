@extends('layouts.app')
@section('meta')
    <title>{{trans('home.find wishlist')}}</title>
@endsection
@section('content')
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="page-title"><h1>{{trans('home.find wishlist')}}</h1></div>
                    <!--Breadcrumbs-->
                    <div class="breadcrumbs">
                        <span class="main-title fw-bold">{{trans('home.find wishlist')}}</span>
                        <a href="{{LaravelLocalization::localizeUrl('/')}}" title="Back to the home page"><i
                                class="icon anm anm-angle-right-l"></i>{{trans('home.home')}}</a>
                    </div>
                    <!--End Breadcrumbs-->
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-5">
        <form action="{{url('find-wishlist')}}" method="POST">
            <div class="input-group m-auto text-center justify-content-center">
                    @csrf
                    <div class="form-outline col-6" data-mdb-input-init>
                        <input type="search" id="form1" name="wishlist_code" class="form-control" placeholder="{{__('home.wish_list_code')}}" />
                    </div>
                    <button type="sub" class="btn btn-primary" data-mdb-ripple-init>
                        <i class="icon anm anm-search"></i>
                    </button>
            </div>
        </form>
    </div>
    @if(isset($products))
        @if(count($products)>0)
            <div class="container mb-5">
                <div>
                    <h1 class="text-center">{{__('home.wishlist_items')}}</h1>
                    <table class="table align-middle table-bordered">
                        <thead class="thead-bg">
                        <tr class="text-center">
                            <th class="product-name" colspan="2">{{__('home.product')}}</th>
                            <th class="product-price text-center">{{__('home.price')}}</th>
                            <th class="stock-status text-center">{{__('home.status')}}</th>
                            <th class="product-subtotal text-center">{{trans('home.Add to cart')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $wishProduct)
                            <tr>
                                <td class="product-thumbnail">
                                    <a class="product-img" href="{{LaravelLocalization::localizeUrl('product/'.$wishProduct->{'link_'.$lang})}}">
                                        <img class="image rounded-0 blur-up lazyload" data-src="{{Helper::uploadedImagesPath('products',$wishProduct->images()[0])}}"
                                             src="{{Helper::uploadedImagesPath('products',$wishProduct->images()[0])}}" alt="{{$wishProduct->name_en}}" title="{{$wishProduct->name_en}}" width="120" height="170" /></a>
                                </td>
                                <td class="product-details col-4">
                                    <a class="product-img" href="{{LaravelLocalization::localizeUrl('product/'.$wishProduct->{'link_'.$lang})}}">
                                        <p class="product-name mb-0">{{Illuminate\Support\Str::limit($wishProduct->{'name_'.$lang},80,'...') }}</p> </a>
                                    <p class="variant-cart my-1 text-muted">{{$wishProduct->category->{'name_'.$lang} }}</p>
                                </td>
                                <td class="product-price text-center">
                                    {{--                                <span class="amount fw-500">$ {{$wishProduct->price}}</span>--}}
                                    @if($wishProduct->discount()>0)
                                        <span class="amount fw-500 old-price">{{$wishProduct->price.' '.__('home.EGP') }}</span>
                                        <span class="amount fw-500">{{$wishProduct->condition_discount() .' '.__('home.EGP')  }}</span>
                                    @else
                                        <span class="amount fw-500 ">{{$wishProduct->price.' '.__('home.EGP')  }}</span>
                                    @endif
                                </td>
                                <td class="product-stock text-center"><span class="{{$wishProduct->stock>0? 'text-in-stock':'text-out-stock'}}">
                            {{($wishProduct->stock>0)?__('home.in_stock'):__('home.out of stock')}}
                        </span></td>
                                <td class="product-action text-center">
                                    <a  href="javascript:void(0)"  class="btn btn-secondary {{$wishProduct->stock=='0' ? 'soldOutBtn disabled':' '.'addtocart btn-showCart'}}"
                                        data-product_id="{{$wishProduct->id}}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addtocart_modal">{{trans('home.Add to cart')}}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="container mb-5 text-center justify-content-center">
                <h1>{{trans('home.emptyWishlist')}}</h1>
            </div>
        @endif
    @endif


@endsection

@section('script')

@endsection
