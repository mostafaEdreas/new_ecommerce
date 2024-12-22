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
                                        <label class="form-label">Quantity</label>
                                        <input type="text" value="1" name="demo_vertical2">
                                    </div>
                                    <div class="d-block">
                                        <label class="form-label">Size</label>
                                        <div class="btn-group product-size mb-0">
                                            <input type="radio" class="btn-check" name="btnradio1" id="btnradio11"
                                                checked="">
                                            <label class="btn btn-light" for="btnradio11">S</label>

                                            <input type="radio" class="btn-check" name="btnradio1" id="btnradio21">
                                            <label class="btn btn-light" for="btnradio21">M</label>

                                            <input type="radio" class="btn-check" name="btnradio1" id="btnradio31">
                                            <label class="btn btn-light" for="btnradio31">L</label>
                                        </div>
                                    </div>
                                    <div class="meta-content">
                                        <label class="form-label">Color</label>
                                        <div class="d-flex align-items-center color-filter">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioNoLabel"
                                                    id="radioNoLabel1" value="#24262B" aria-label="..." checked>
                                                <span></span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioNoLabel"
                                                    id="radioNoLabel2" value="#8CB2D1" aria-label="...">
                                                <span></span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioNoLabel"
                                                    id="radioNoLabel3" value="#0D775E" aria-label="...">
                                                <span></span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioNoLabel"
                                                    id="radioNoLabel4" value="#C7D1CF" aria-label="...">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-group cart-btn">
                                    <a href="shop-cart.html" class="btn btn-secondary text-uppercase">Add To Cart</a>
                                    <a href="shop-checkout.html" class="btn btn-light btn-icon">


                                        BUY IT NOW
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
                        <h2 class="title mb-0">Related products</h2>
                    </div>
                    <a href="shop-list.html" class="text-secondary font-14 d-flex align-items-center gap-1">See all
                        products
                        <i class="icon feather icon-chevron-right font-18"></i>
                    </a>
                </div>

                <div class="swiper-btn-center-lr">
                    <div class="swiper swiper-four">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="shop-card wow fadeInUp" data-wow-delay="0.2s">
                                    <div class="dz-media">
                                        <img src="images/shop/product/5.png" alt="image">
                                        <div class="shop-meta">
                                            <a href="shop-cart.html" class="btn btn-secondary btn-icon">
                                                <i class="fa-solid fa-eye d-md-none d-block"></i>
                                                <span class="d-md-block d-none">Add to Cart</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="dz-content">
                                        <h5 class="title"><a href="product-thumbnail.html">Product</a></h5>

                                        <h6 class="price">

                                            15 LE
                                        </h6>
                                    </div>


                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="shop-card wow fadeInUp" data-wow-delay="0.3s">
                                    <div class="dz-media">
                                        <img src="images/shop/product/6.png" alt="image">

                                        <div class="shop-meta">
                                            <a href="shop-cart.html" class="btn btn-secondary btn-icon">
                                                <i class="fa-solid fa-eye d-md-none d-block"></i>
                                                <span class="d-md-block d-none">Add to Cart</span>
                                            </a>

                                        </div>
                                    </div>
                                    <div class="dz-content">
                                        <h5 class="title"><a href="shop-sidebar.html">Product </a></h5>

                                        <h6 class="price">

                                            50 LE
                                        </h6>
                                    </div>

                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="shop-card wow fadeInUp" data-wow-delay="0.4s">
                                    <div class="dz-media">
                                        <img src="images/shop/product/7.png" alt="image">
                                        <div class="shop-meta">
                                            <a href="shop-cart.html" class="btn btn-secondary btn-icon">
                                                <i class="fa-solid fa-eye d-md-none d-block"></i>
                                                <span class="d-md-block d-none">Add to Cart</span>
                                            </a>

                                        </div>
                                    </div>
                                    <div class="dz-content">
                                        <h5 class="title"><a href="shop-sidebar.html">Product</a></h5>

                                        <h6 class="price">

                                            40 LE
                                        </h6>
                                    </div>


                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="shop-card wow fadeInUp" data-wow-delay="0.5s">
                                    <div class="dz-media">
                                        <img src="images/shop/product/8.png" alt="image">
                                        <div class="shop-meta">
                                            <a href="shop-cart.html" class="btn btn-secondary btn-icon">
                                                <i class="fa-solid fa-eye d-md-none d-block"></i>
                                                <span class="d-md-block d-none">Add to Cart</span>
                                            </a>

                                        </div>
                                    </div>
                                    <div class="dz-content">
                                        <h5 class="title"><a href="shop-sidebar.html">Product</a></h5>
                                        <h6 class="price">

                                            400 LE
                                        </h6>
                                    </div>


                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="shop-card wow fadeInUp" data-wow-delay="0.6s">
                                    <div class="dz-media">
                                        <img src="images/shop/product/8.png" alt="image">
                                        <div class="shop-meta">
                                            <a href="shop-cart.html" class="btn btn-secondary btn-icon">
                                                <i class="fa-solid fa-eye d-md-none d-block"></i>
                                                <span class="d-md-block d-none">Add to Cart</span>
                                            </a>

                                        </div>
                                    </div>
                                    <div class="dz-content">
                                        <h5 class="title"><a href="shop-sidebar.html">Product</a></h5>
                                        <h6 class="price">

                                            4000 LE
                                        </h6>
                                    </div>


                                </div>
                            </div>
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
