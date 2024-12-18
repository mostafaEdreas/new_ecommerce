@if (!isset($doesnt_use_forloop))
    @foreach ($MainProducts as $product_main)
        @if (Request::segment(2)=='products' )
        {{-- <div class="col-lg-20 col-lg-4 col-md-6 col-sm-6 col-12"> --}}
         <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        @else
        <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        @endif
        {{-- <div class="img_pop_up">
            <div class="product-details-popup-wrapper-procart{{ $product_main->id }} product-details-popup-wrapper" style="z-index: 10000000">
                <div class="rts-product-details-section rts-product-details-section2 product-details-popup-section">
                    <div class="product-details-popup">
                        <button class="product-details-close-btn"><i class="fal fa-times"></i></button>
                        <div class="details-product-area">
                            <div class="product-thumb-area">
                                <div class="cursor"></div>
                                <div class="thumb-wrapper show0 filterd-items figure ">
                                    <div class="product-thumb zoom" onmousemove="zoom(event)"
                                        style="background-image: url({{ Helper::uploadedImagesPath('products', $product_main->lessPriceByGroub()->image->image) }})">
                                        <img src="{{ Helper::uploadedImagesPath('products', $product_main->lessPriceByGroub()->image->image) }}"
                                            alt="product-thumb">
                                    </div>
                                </div>
                                @foreach ($product_main->lessPriceByGroub()->gruopsHasSamePrice($product_main->id) as $index => $SPGroup)
                                    <div class="thumb-wrapper show{{ $index + 1 }} filterd-items hide ">
                                        <div class="product-thumb zoom" onmousemove="zoom(event)"
                                            style="background-image: url({{ Helper::uploadedImagesPath('products', $SPGroup->image->image) }})">
                                            <img src="{{ Helper::uploadedImagesPath('products', $SPGroup->image->image) }}"
                                                alt="product-thumb">
                                        </div>
                                    </div>
                                @endforeach
                                <div class="product-thumb-filter-group">
                                    <div class="thumb-filter filter-btn active " onclick="document.getElementById('d-cart-{{ $product_main->id }}').setAttribute('group_id','{{$product_main->lessPriceByGroub()->id}}')" data-show=".show0">
                                        <img src="{{ Helper::uploadedImagesPath('products', $product_main->lessPriceByGroub()->image->image) }}"
                                            alt="product-thumb-filter">
                                    </div>
                                    @foreach ($product_main->lessPriceByGroub()->gruopsHasSamePrice($product_main->id) as $index => $SPGroup)
                                        <div class="thumb-filter filter-btn" onclick="document.getElementById('d-cart-{{ $product_main->id }}').setAttribute('group_id','{{$SPGroup->id}}')" data-show=".show{{ $index + 1 }}">
                                            <img src="{{ Helper::uploadedImagesPath('products', $SPGroup->image->image) }}"
                                                alt="product-thumb-filter">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="contents">
                                <div class="product-status">
                                    <div class="rating-stars-group">
                                        @include('website.appendes.stars',['rate'=> $product_main->rate->rate])

                                        <span>{{ $product_main->rate->count}} @lang('home.reviews')</span>
                                    </div>
                                </div>
                                <h2 class="product-title">{{ $product_main->{'name_' . $lang} }} <span
                                        class="stock">{{ $product_main->{'stock'} }}</span></h2>
                                <span class="product-price">
                                    @if ($product_main->dicount)
                                        <span
                                            class="old-price">{{ $product_main->lessPriceByGroub()->price_details->old_price }}</span>{{ $product_main->lessPriceByGroub()->price_details->new_price }}
                                    @else
                                        {{ $product_main->lessPriceByGroub()->price_details->new_price }}
                                        @lang('home.EGP')
                                    @endif
                                </span>
                                <p>
                                    {{ $product_main->{'short_desc_' . $lang} }}
                                </p>
                                <div class="product-bottom-action">
                                    <div class="cart-edit">
                                        <div class="quantity-edit action-item">
                                            <button class="button decrease-btn"><i
                                                    class="fal fa-minus minus"></i></button>
                                            <input stock="{{ $product_main->lessPriceByGroub()->stock }}"
                                            id="quan-inp-{{ $product_main->id }}" type="text" class="input edit-cart-quantity" value="1" />
                                            <button class="button plus increase-btn">+<i
                                                    class="fal fa-plus plus"></i></button>
                                        </div>
                                    </div>
                                    <button id="d-cart-{{ $product_main->id }}" quan-input="quan-inp-{{ $product_main->id }}"  group_id="{{ $product_main->lessPriceByGroub()->id }}" onclick="addToCart(this)" class="rts-btn btn-primary radious-sm with-icon">
                                        <div class="btn-text">
                                            @lang('home.Add to Cart')
                                        </div>
                                        <div class="arrow-icon">
                                            <i class="fa-regular fa-cart-shopping"></i>
                                        </div>
                                        <div class="arrow-icon">
                                            <i class="fa-regular fa-cart-shopping"></i>
                                        </div>
                                    </button>
                                    <button  group_id="{{ $product_main->lessPriceByGroub()->id }}" onclick="addToWish(this)"
                                        id="prowish{{ $product_main->id }}" class="rts-btn btn-primary ml--20"><i
                                            class="fa-light fa-heart"></i></button>
                                </div>
                                <div class="product-uniques">
                                    <span class="sku product-unipue"><span>@lang('home.barcode') </span>
                                        {{ $product_main->barcode }}</span>
                                    <span class="catagorys product-unipue"><span>@lang('home.categories'): </span>
                                        {{ $product_main->category->{'name_' . $lang} }}</span>
                                    <span class="tags product-unipue"><span>توجية: </span> منتجات, تخييم</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="single-shopping-card-one">
            <!-- iamge and sction area start -->
            <div class="image-and-action-area-wrapper">
                <a href="{{ LaravelLocalization::localizeUrl('product/' . $product_main->{'link_' . $lang}) }}" class="thumbnail-preview">
                    @if ($product_main->discount)
                        <div class="badge">
                            <span>{{ $product_main->lessPriceByGroub()->price_details->percentage }} <br>
                                @lang('home.discount')
                            </span>
                            <i class="fa-solid fa-bookmark"></i>
                        </div>
                    @endif
                    @if ($product_main->lessPriceByGroub()->image->image)
                        <img src="{{ Helper::uploadedImagesPath('products', $product_main->lessPriceByGroub()->image->image) }}"  alt="grocery">

                    @else
                        <img src="{{url('resources/assets/back/img/noimage.png')}}"  alt="grocery">

                    @endif
                </a>
                @auth
                    <div class="action-share-option">
                        <div class="single-action openuptip  add-to-fev add-to-wish"
                            group_id="{{ $product_main->lessPriceByGroub()->id }}" onclick="addToWish(this)"
                            id="prowish{{ $product_main->id }}" data-flow="up" title="Add To Wishlist">
                            <i class="fa-light fa-heart"></i>
                        </div>
                        {{-- <div product="product-details-popup-wrapper-procart{{ $product_main->id }}"
                            class="single-action openuptip cta-quickview product-details-popup-btn" data-flow="up"
                            title="Quick View">
                            <i class="fa-regular fa-eye"></i>
                        </div> --}}
                    </div>
                @endauth
            </div>
            <!-- iamge and sction area start -->
            <div class="body-content">
                <a href="{{ LaravelLocalization::localizeUrl('product/' . $product_main->{'link_' . $lang}) }}">
                    <h4 class="title">{{ $product_main->{'name_' . $lang} }}  </h4>
                </a>
                <a href="{{ LaravelLocalization::localizeUrl('category/' . $product_main->category->{'link_' . $lang}) }}">
                    <div class="title"><span class="tags product-unipue">  {{ $product_main->category->{'name_' . $lang} }} </span> </div>
                </a>
                <div>
                    <span class="availability"> {{ $product_main->{'short_desc_' . $lang} }} </span>
                </div>
                <div class="price-area">
                    @if ($product_main->discount)
                        <span class="current">{{ $product_main->lessPriceByGroub()->price_details->new_price }}</span>
                        <div class="previous">{{ $product_main->lessPriceByGroub()->price_details->old_price }}</div>
                    @else
                        <span class="current">{{ $product_main->lessPriceByGroub()->price_details->new_price }}</span>
                    @endif
                </div>
                <div class="cart-counter-action">
                    <div class="quantity-edit" style="display: none">
                        <input type="text" stock="{{ $product_main->lessPriceByGroub()->stock }}"
                            id="quan-inp-{{ $product_main->id }}" class="input edit-cart-quantity" value="1">
                        <div class="button-wrapper-action">
                            <button class="button decrease-btn">
                                <i class="fa-regular fa-chevron-down"></i></button>
                            <button class="button plus increase-btn">+<i class="fa-regular fa-chevron-up"></i></button>
                        </div>
                    </div>
                    @if ($product_main->lessPriceByGroub()->stock > 0)
                        <button quan-input="quan-inp-{{ $product_main->id }}"  group_id="{{ $product_main->lessPriceByGroub()->id }}" onclick="addToCart(this)"
                            class="rts-btn btn-primary radious-sm with-icon">
                            <div class="btn-text add-to-card">
                                @lang('home.Add to Cart')
                            </div>
                            <div class="arrow-icon">
                                <i class="fa-regular fa-cart-shopping"></i>
                            </div>
                            <div class="arrow-icon">
                                <i class="fa-regular fa-cart-shopping"></i>
                            </div>
                        </button>
                    @else
                        <div class="text-danger">
                            @lang('home.out of stock')
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endforeach
@else
<div class="single-shopping-card-one">
    <!-- iamge and sction area start -->
    <div class="image-and-action-area-wrapper">
        <a href="{{ LaravelLocalization::localizeUrl('product/' . $product_main->{'link_' . $lang}) }}" class="thumbnail-preview">
            @if ($product_main->discount)
                <div class="badge">
                    <span>{{ $product_main->lessPriceByGroub()->price_details->percentage }} <br>
                        @lang('home.discount')
                    </span>
                    <i class="fa-solid fa-bookmark"></i>
                </div>
            @endif
            @if ($product_main->lessPriceByGroub()->image->image)
                <img src="{{ Helper::uploadedImagesPath('products', $product_main->lessPriceByGroub()->image->image) }}"  alt="grocery">

            @else
                <img src="{{url('resources/assets/back/img/noimage.png')}}"  alt="grocery">

            @endif
        </a>
        @auth
            <div class="action-share-option">
                <div class="single-action openuptip  add-to-fev add-to-wish"
                    group_id="{{ $product_main->lessPriceByGroub()->id }}" onclick="addToWish(this)"
                    id="prowish{{ $product_main->id }}" data-flow="up" title="Add To Wishlist">
                    <i class="fa-light fa-heart"></i>
                </div>
                {{-- <div product="product-details-popup-wrapper-procart{{ $product_main->id }}"
                    class="single-action openuptip cta-quickview product-details-popup-btn" data-flow="up"
                    title="Quick View">
                    <i class="fa-regular fa-eye"></i>
                </div> --}}
            </div>
        @endauth
    </div>
    <!-- iamge and sction area start -->
    <div class="body-content">
        <a href="{{ LaravelLocalization::localizeUrl('product/' . $product_main->{'link_' . $lang}) }}">
            <h4 class="title">{{ $product_main->{'name_' . $lang} }}  </h4>
        </a>
        <a href="{{ LaravelLocalization::localizeUrl('category/' . $product_main->category->{'link_' . $lang}) }}">
            <h6 class="title">{{ $product_main->category->{'name_' . $lang} }}</h6>
        </a>
        <div>
            <span class="availability"> {{ $product_main->{'short_desc_' . $lang} }} </span>
        </div>
        <div class="price-area">
            @if ($product_main->discount)
                <span class="current">{{ $product_main->lessPriceByGroub()->price_details->new_price }}</span>
                <div class="previous">{{ $product_main->lessPriceByGroub()->price_details->old_price }}</div>
            @else
                <span class="current">{{ $product_main->lessPriceByGroub()->price_details->new_price }}</span>
            @endif
        </div>
        <div class="cart-counter-action">
            <div class="quantity-edit" style="display: none">
                <input type="text" stock="{{ $product_main->lessPriceByGroub()->stock }}"
                    id="quan-inp-{{ $product_main->id }}" class="input edit-cart-quantity" value="1">
                <div class="button-wrapper-action">
                    <button class="button decrease-btn">
                        <i class="fa-regular fa-chevron-down"></i></button>
                    <button class="button plus increase-btn">+<i class="fa-regular fa-chevron-up"></i></button>
                </div>
            </div>
            @if ($product_main->lessPriceByGroub()->stock > 0)
                <button quan-input="quan-inp-{{ $product_main->id }}"  group_id="{{ $product_main->lessPriceByGroub()->id }}" onclick="addToCart(this)"
                    class="rts-btn btn-primary radious-sm with-icon">
                    <div class="btn-text add-to-card">
                        @lang('home.Add to Cart')
                    </div>
                    <div class="arrow-icon">
                        <i class="fa-regular fa-cart-shopping"></i>
                    </div>
                    <div class="arrow-icon">
                        <i class="fa-regular fa-cart-shopping"></i>
                    </div>
                </button>
            @else
            <div class="text-danger">
                @lang('home.out of stock')
            </div>
            @endif
        </div>
    </div>
</div>
@endif
