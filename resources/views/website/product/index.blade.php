@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp
    @php echo $schema @endphp
@endsection
@section('content')
    <div class="page-content">
        @include('website.product.banner')
        <section class="content-inner py-5">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="dz-product-detail sticky-top">

                            <div class="swiper-btn-center-lr">
                                <div class="swiper product-gallery-swiper2">
                                    <div class="swiper-wrapper" id="lightgallery">

                                        <div class="swiper-slide">
                                            <div class="dz-media DZoomImage">
                                                <a class="mfp-link lg-item" href="{{$product->main_image_source}}"
                                                    data-src="{{$product->main_image_source}}">
                                                    <i class="feather icon-maximize dz-maximize top-left"></i>
                                                </a>
                                                <img src="{{$product->main_image_source}}" alt="image">
                                            </div>
                                        </div>

                                        <div class="swiper-slide">
                                            <div class="dz-media DZoomImage">
                                                <a class="mfp-link lg-item" href="{{$product->second_image_source}}"
                                                    data-src="{{$product->second_image_source}}">
                                                    <i class="feather icon-maximize dz-maximize top-left"></i>
                                                </a>
                                                <img src="{{$product->second_image_source}}" alt="image">
                                            </div>
                                        </div>

                                        @foreach ($product->images as $iamge)
                                            <div class="swiper-slide">
                                                <div class="dz-media DZoomImage">
                                                    <a class="mfp-link lg-item" href="{{$product->image_source}}"
                                                        data-src="{{$product->image_source}}">
                                                        <i class="feather icon-maximize dz-maximize top-left"></i>
                                                    </a>
                                                    <img src="{{$product->image_source}}" alt="image">
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                <div class="swiper product-gallery-swiper thumb-swiper-lg">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <img src="{{$product->main_image_source}}" alt="image">
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="{{$product->second_image_source}}" alt="image">
                                        </div>
                                        @foreach ($product->images as $iamge)
                                        <div class="swiper-slide">
                                            <img src="{{$product->image_source}}" alt="image">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="dz-product-detail style-2 p-t50">
                            <div class="dz-content">
                                <div class="dz-content-footer">
                                    <div class="dz-content-start">
                                        <h4 class="title mb-1"><a href="javascript:void(0);">{{$product->name}}</a></h4>
                                    </div>
                                </div>
                                <p class="para-text">
                                   {!! $product->text !!}
                                </p>
                                <div class="meta-content m-b20 d-flex align-items-end">
                                    <div class="me-3">
                                        <span class="price-name">@lang('home.price')</span>
                                        <span class="price-num price"> {{$product->net_price}} </span>
                                    </div>
                                    <div class="btn-quantity quantity-sm light d-xl-none d-blcok d-sm-block me-0">
                                        <label class="form-label">@lang('home.quantity')</label>
                                        <input type="text" value="1" name="quantity">
                                    </div>
                                </div>
                                <div class="product-num">
                                    <div class="btn-quantity light d-xl-block d-sm-none d-none">
                                        <label class="form-label">@lang('home.quantity')</label>
                                        <input type="text" value="1" name="quantity">
                                    </div>
                                    <div class="d-block">
                                        <label class="form-label">@lang('home.size')</label>
                                        <div class="btn-group product-size mb-0">
                                            @foreach ($size?->value ?? [] as $index => $value)
                                                <input type="radio" class="btn-check" name="size" id="btnradio{{$value->value_id.$index}}" checked="">
                                                <label class="btn btn-light" for="btnradio{{$value->value_id.$index}}">{{$value->value}}</label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="meta-content">
                                        <label class="form-label">@lang('home.color')</label>
                                        <div class="d-flex align-items-center color-filter">
                                            @foreach ($color?->value ?? [] as $index => $value)

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioNoLabe{{$value->value_id.$index}}"
                                                    id="radioNoLabel{{$value->value_id.$index}}" value="{{$value->value}}" aria-label="..." checked>
                                                <span></span>
                                            </div>
                                            @endforeach
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-group cart-btn">
                                    <a href="shop-cart.html" class="btn btn-secondary text-uppercase">Add To Cart</a>
                                    <a href="shop-checkout.html" class="btn btn-light btn-icon">
                                        @lang('home.Buy Now')
                                    </a>
                                </div>


                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-inner-1 overlay-white-middle overflow-hidden">
            <div class="container">
                <div class="section-head style-2">
                    <div class="left-content">
                        <h2 class="title mb-0">@lang('home.related_products')</h2>
                    </div>
                    <a href="{{LaravelLocalization::localizeUrl('products')}}" class="text-secondary font-14 d-flex align-items-center gap-1">
                        @lang('home.all_products')
                        <i class="icon feather icon-chevron-right font-18"></i>
                    </a>
                </div>

                <div class="swiper-btn-center-lr">
                    <div class="swiper swiper-four">
                        <div class="swiper-wrapper">
                            @foreach ($related_products ?? [] as $index => $relateProduct)
                                <div class="swiper-slide">
                                    <div class="shop-card wow fadeInUp" data-wow-delay="0.{{$index ? $index + 1 : $index + 2 }}s">
                                        <div class="dz-media">
                                            <img src="{{$relateProduct->main_image_source}}" alt="image">
                                            <div class="shop-meta">
                                                <a class="btn btn-secondary btn-icon">
                                                    <i class="fa-solid fa-eye d-md-none d-block"></i>
                                                    <span class="d-md-block d-none">@lang('home.Add to Cart')</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="dz-content">
                                            <h5 class="title"><a href="{{LaravelLocalization::localizeUrl('product/'.$relateProduct->link)}}">{{$relateProduct->name}}</a></h5>

                                            <h6 class="price">

                                                {{$relateProduct->net_price}}
                                            </h6>
                                        </div>


                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="pagination-align">
                        <div class="tranding-button-prev btn-prev">
                            <i class="flaticon flaticon-left-chevron"></i>
                        </div>
                        <div class="tranding-button-next btn-next">
                            <i class="flaticon flaticon-chevron"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
@endsection
