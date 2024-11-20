@if(count($new_discount)>0)
    <!-- rts category feature area start -->
        <div class="category-feature-area rts-section-gapTop">
            <div class="container">
                <div class="row g-4">
                    @foreach ($new_discount as $product )
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="single-feature-card bg_image two" style="background-image: url('{{$product->lessPriceByGroub()->image->image? Helper::uploadedImagesPath("products", $product->lessPriceByGroub()->image->image):url("resources/assets/back/img/noimage.png") }}')">
                                <div class="content-area">
                                    <a href="{{ LaravelLocalization::localizeUrl('product/' . $product->{'link_' . $lang}) }}" class="rts-btn btn-primary"> @lang('home.exclusive discounts') </a>
                                    <h3 class="title">
                                        {{ $product->{'name_' . $lang} }}
                                    </h3>
                                    <a href="{{ LaravelLocalization::localizeUrl('product/' . $product->{'link_' . $lang}) }}" class="shop-now-goshop-btn">
                                        <span class="text"> @lang('home.Shop Now') </span>
                                        <div class="plus-icon">
                                            <i class="fa-sharp fa-regular fa-plus"></i>
                                        </div>
                                        <div class="plus-icon">
                                            <i class="fa-sharp fa-regular fa-plus"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    <!-- rts category feature area end -->
@endif
