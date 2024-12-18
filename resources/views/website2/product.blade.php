@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp
    @php echo $schema @endphp
    {{-- rate css --}}
    <style>
        .star {
            font-size: 26px;
            cursor: pointer;
        }

        .one {
            color: rgb(255, 0, 0);
        }

        .two {
            color: rgb(255, 106, 0);
        }

        .three {
            color: rgb(251, 255, 120);
        }

        .four {
            color: rgb(255, 255, 0);
        }

        .five {
            color: rgb(24, 159, 14);
        }
    </style>
    {{-- end rate css --}}
@endsection

@section('content')
    <!-- Breadcrumb Start -->




    <div class="rts-navigation-area-breadcrumb bg_light-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="navigator-breadcrumb-wrapper">
                        <a href="{{ LaravelLocalization::localizeUrl('/') }}"> {{ __('home.home') }} </a>
                        <i class="fa-regular fa-chevron-right"></i>
                        <a class="#"
                            href="{{ LaravelLocalization::localizeUrl('products') }}">{{ __('home.products') }}</a>
                        <i class="fa-regular fa-chevron-right"></i>
                        <a class="current" href="javascript:void(0)">{{ $product->{'name_' . $lang} }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-seperator bg_light-1">
        <div class="container">
            <hr class="section-seperator">
        </div>
    </div>

    <div class="rts-chop-details-area rts-section-gap bg_light-1">
        <div class="container">
            <div class="shopdetails-style-1-wrapper">
                <div class="row g-5">
                    <div class="col-xl-8 col-lg-8 col-md-12">
                        <div class="product-details-popup-wrapper in-shopdetails">
                            <div class="rts-product-details-section rts-product-details-section2 product-details-popup-section">
                                <div class="product-details-popup">
                                    <div class="details-product-area">
                                        <div class="product-thumb-area">
                                            <div class="cursor"></div>
                                            <div class="thumb-wrapper zero filterd-items figure">
                                                <div class="product-thumb zoom" onmousemove="zoom(event)"
                                                    style="background-image: url({{ Helper::uploadedImagesPath('products', $product->lessPriceByGroub()->image->image) }})">
                                                    <img src="{{ Helper::uploadedImagesPath('products', $product->lessPriceByGroub()->image->image) }}"
                                                        alt="product-thumb">
                                                </div>
                                            </div>
                                            @foreach ($product->lessPriceByGroub()->images as $index => $SPGroup)
                                                <div class="thumb-wrapper {{ 'item-' . ($index + 1) }} filterd-items hide">
                                                    <div class="product-thumb zoom" onmousemove="zoom(event)"
                                                        style="background-image: url({{ Helper::uploadedImagesPath('products', $SPGroup->image) }})">
                                                        <img src="{{ Helper::uploadedImagesPath('products', $SPGroup->image) }}" alt="product-thumb">
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="product-thumb-filter-group">
                                                <div class="thumb-filter filter-btn active" data-show=".zero">
                                                    <img src="{{ Helper::uploadedImagesPath('products', $product->lessPriceByGroub()->image->image) }}"
                                                        alt="product-thumb-filter">
                                                </div>
                                                @foreach ($product->lessPriceByGroub()->images as $index => $SPGroup)
                                                    <div class="thumb-filter filter-btn" data-show=".item-{{ $index + 1 }}">
                                                        <img src="{{ Helper::uploadedImagesPath('products', $SPGroup->image) }}" alt="product-thumb-filter">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="contents">
                                            <div class="product-status">
                                                @if ($product->category)
                                                    <span
                                                        class="product-catagory">{{ $product->category->{'name_' . $lang} }}</span>
                                                @endif
                                                <div class="rating-stars-group">
                                                    @include('website.appendes.stars', [
                                                        'rate' => $product->rate->rate,
                                                    ])
                                                    <span>{{ $product->rate->count }} @lang('home.rate')</span>
                                                </div>
                                            </div>
                                            <h2 class="product-title">{{ $product->{'name_' . $lang} }} <span
                                                    class="stock">
                                                    {{ $product->lessPriceByGroub()->stock > 0 ? __('home.in_stock') . ' ' . $product->lessPriceByGroub()->stock : __('home.out of stock') }}</span>
                                            </h2>
                                            <p class="mt--20 mb--20">
                                                {{ $product->{'short_desc_' . $lang} }}
                                            </p>
                                            
                                            <span class="product-price mb--15 d-block" style="color: #DC2626; font-weight: 600;">
                                                {{ $product->lessPriceByGroub()->price_details->new_price }}
                                                @if ($product->lessPriceByGroub()->price_details->old_price)
                                                <span class="old-price ml--15">{{ $product->lessPriceByGroub()->price_details->old_price }}</span>
                                                @endif
                                            </span>

                                            {{--
                                            <span class="product-price mb--15 d-block"
                                                style="color: #DC2626; font-weight: 600;">
                                                {{ $product->lessPriceByGroub()->price_details->new_price }}
                                                @if ($product->lessPriceByGroub()->price_details->old_price)
                                                    <span
                                                        class="old-price ml--15">{{ $product->lessPriceByGroub()->price_details->old_price }}</span>
                                            </span>
                                            @endif
                                            --}}
                                            <form id="changSiaze" action="{{url()->current()}}" method="post">

                                                <div class="d-flex align-items-center text-drak mb--25">
                                                    
                                                    <span class="ms-2">
                                                        {{ $product->groupsUesr[0]->productGroups[0]->attribute->{'name_' . $lang} }}:
                                                    </span>
                                                    
                                                    @csrf
                                                    <div class="radio-inputs">
                                                        @foreach ($product->groupsUesr as $group)
                                                            <label class="radio" for="GROP{{ $group->id }}">
                                                                <input type="radio"
                                                                    name="group"
                                                                    id="GROP{{ $group->id }}"
                                                                    value="{{ $group->id }}"
                                                                    @if ($group->id != $product->lessPriceByGroub()->id)
                                                                        onchange="document.getElementById('changSiaze').submit()"
                                                                    @else
                                                                        checked
                                                                    @endif>
                                                                    <span class="name">
                                                                        {{ $group->productGroups[0]->attributeValue->{'value_' . $lang} }}
                                                                    </span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                {{--<div class="d-flex text-drak" style="width: 50px;height: 50px;">
                                                    {{$product->groupsUesr[0]->productGroups[0]->attribute->{'name_'.$lang} }}: 
                                                        @csrf
                                                        @foreach ($product->groupsUesr as $group )
                                                            <input type="radio"@if($group->id != $product->lessPriceByGroub()->id) onchange="document.getElementById('changSiaze').submit()" @else checked @endif name="group" id="GROP{{$group->id}}" value="{{$group->id}}" id=""> <label for="GROP{{$group->id}}">{{$group->productGroups[0]->attributeValue->{'value_'.$lang} }}</label>
                                                        @endforeach
                                                </div>--}}
                                            </form>  
                                            <div class="product-bottom-action">
                                                
                                                <div class="cart-edits">
                                                    <div class="quantity-edit action-item">
                                                        <button class="button"><i class="fal fa-minus minus"></i></button>
                                                        <input stock="{{ $product->lessPriceByGroub()->stock }}"
                                                            id="quan-inp3-{{ $product->lessPriceByGroub()->id }}"
                                                            type="text" class="input" value="{{ $product->lessPriceByGroub()->stock > 0?1:0 }}"/>
                                                        <button class="button plus">+<i class="fal fa-plus plus"></i></button>
                                                    </div>
                                                </div>
                                                {{--
                                                <div class="cart-edits">
                                                    <div class="quantity-edit action-item">
                                                        <button class="button"><i class="fal fa-minus minus"></i></button>
                                                        <input stock="{{ $product->lessPriceByGroub()->stock }}"
                                                            id="quan-inp3-{{ $product->lessPriceByGroub()->id }}" type="text"
                                                            class="input" value="{{ $product->lessPriceByGroub()->stock > 0?1:0 }}" />
                                                        <button class="button plus">+<i
                                                                class="fal fa-plus plus"></i></button>
                                                    </div>
                                                </div>
                                                --}}
                                                <button quan-input="quan-inp3-{{ $product->lessPriceByGroub()->id }}"
                                                    group_id="{{ $product->lessPriceByGroub()->id }}" onclick="addToCart(this)"
                                                    class="rts-btn btn-primary radious-sm with-icon">
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
                                                @auth
                                                    <button group_id="{{ $product->lessPriceByGroub()->id }}" onclick="addToWish(this)"
                                                        class="rts-btn btn-primary ml--20">
                                                        <i class="fa-light fa-heart"></i>
                                                    </button>
                                                @endauth
                                            </div>
                                            <div class="product-uniques">
                                                {{-- <span class="sku product-unipue mb--10"><span style="font-weight: 400; margin-right: 10px;">SKU: </span> BO1D0MX8SJ</span> --}}
                                                <span class="catagorys product-unipue mb--10"><span
                                                        style="font-weight: 400; margin-right: 10px;">@lang('home.categories'):
                                                    </span> {{ $product->category->{'name_' . $lang} }}</span>
                                                {{-- <span class="tags product-unipue mb--10"><span style="font-weight: 400; margin-right: 10px;">الوسوم: </span> الموضة، تيشيرتات، رجال</span> --}}
                                                {{-- <span class="tags product-unipue mb--10"><span style="font-weight: 400; margin-right: 10px;">مدة الصلاحية: </span> 6 أشهر</span> --}}
                                                {{-- <span class="tags product-unipue mb--10"><span style="font-weight: 400; margin-right: 10px;">النوع: </span> أصلي</span>
                                                <span class="tags product-unipue mb--10"><span style="font-weight: 400; margin-right: 10px;">الفئة: </span> المشروبات، الألبان والمخابز</span> --}}
                                            </div>

                                            {{-- <div class="share-option-shop-details" >
                                                <div class="single-share-option">
                                                    <div class="icon">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                    <span>@lang('home.add to wishlist')</span>
                                                </div>
                                            </div> --}}

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-discription-tab-shop mt--50">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#home-tab-pane" type="button" role="tab"
                                        aria-controls="home-tab-pane" aria-selected="true">@lang('home.product_desc')</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#profile-tab-pane" type="button" role="tab"
                                        aria-controls="profile-tab-pane" aria-selected="false">@lang('home.attiributes')</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tabt" data-bs-toggle="tab"
                                        data-bs-target="#profile-tab-panes" type="button" role="tab"
                                        aria-controls="profile-tab-panes" aria-selected="false">@lang('home.rate')
                                        ({{ $product->rate->count }})</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                    aria-labelledby="home-tab" tabindex="0">
                                    <div class="single-tab-content-shop-details">
                                        <p class="disc">
                                            {!! $product->{'long_desc_' . $lang} !!}
                                        </p>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel"
                                    aria-labelledby="profile-tab" tabindex="0">
                                    <div class="single-tab-content-shop-details">
                                        {{-- <p class="disc">
                                            يتميز هذا المنتج بتصميم عصري ومميز يضمن لك الراحة والأداء العالي. التفاصيل الدقيقة والإتقان في التصميم يجعلونه خياراً ممتازاً.
                                        </p> --}}
                                        <div class="table-responsive table-shop-details-pd">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>@lang('home.name')</th>
                                                        <th>@lang('home.values')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($product->attributes as $attribute)
                                                        <tr>
                                                            <td> {{ $attribute->{'name_' . $lang} }}</td>
                                                            <td>
                                                                @foreach ($attribute->productAttributeValues($product->id) as $value)
                                                                    {{ $value->attributeValue->{'value_' . $lang} }},
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    <tr>
                                                        <td>@lang('home.brand')</td>
                                                        <td>{{ $product->brand?->{'name_' . $lang} ?? '---' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="note">
                                            {{ $setting->product_note }}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile-tab-panes" role="tabpanel" aria-labelledby="profile-tabt" tabindex="0">
                                    <div class="single-tab-content-shop-details">
                                        <div class="product-details-review-product-style">
                                            @if ($product->rate->count > 0)
                                            <div class="average-stars-area-left">
                                                @if ($product->rate->count > 0)
                                                    <div class="top-stars-wrapper">
                                                        <h4 class="review">
                                                            {{ $product->rate->rate }}
                                                        </h4>
                                                        <div class="rating-disc">
                                                            <span> {{ $product->rate->text_rate }}</span>
                                                            <div class="stars">
                                                                @include('website.appendes.stars', [ 'rate' => $product->rate->rate,  ])
                                                                <span>{{ $product->rate->count }}
                                                                    @lang('home.rate')
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="top-stars-wrapper">
                                                        @lang('home.doesn\'t have rate')
                                                    </div>
                                                @endif

                                                <div class="average-stars-area">
                                                    <h4 class="average">{{ $product->rate->percentage }}%</h4>
                                                    <span>@lang('home.recommended') ({{ $product->rate->count_hight_rate }} @lang('home.from')
                                                        {{ $product->rate->count }})</span>
                                                </div>
                                                {{-- <div class="review-charts-details">
                                                    @foreach ($product->reviews as $review)
                                                        <div class="single-review">
                                                            <div class="stars">
                                                                @include('website.appendes.stars', [
                                                                    'rate' => $review->rate->rate,
                                                                ])
                                                            </div>
                                                            <div class="single-progress-area-incard">
                                                                <div class="progress">
                                                                    <div class="progress-bar wow fadeInLeft"
                                                                        role="progressbar" style="width: 80%"
                                                                        aria-valuenow="{{ $review->rate->percentage }}"
                                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <span class="pac">{{ $review->rate->percentage }}%</span>
                                                            <span class="pac">{{ $review->comment }}</span>
                                                        </div>
                                                    @endforeach

                                                </div> --}}
                                            </div>
                                            @else
                                            @lang('home.doesn\'t have rate')
                                            @endif
                                          
                                            @auth
                                            @if (auth()->user()->isTookProduct($product->id))
                                                <div class="submit-review-area">
                                                    <form action="{{ LaravelLocalization::localizeUrl('add/productReview') }}"  method="POST" class="submit-review-area">
                                                        <h5 class="title">@lang('home.send_review')</h5>
                                                        <div class="your-rating">
                                                            <span>@lang('home.review')</span>
                                                            <div class="stars">
                                                                <span onclick="gfg(1)" class="star">★ </span>
                                                                <span onclick="gfg(2)" class="star">★ </span>
                                                                <span onclick="gfg(3)" class="star">★ </span>
                                                                <span onclick="gfg(4)" class="star">★ </span>
                                                                <span onclick="gfg(5)" class="star">★ </span>
                                                                <input type="hidden" name=rate id="output">
                                                                <input type="hidden" name=product_id value="{{ $product->id }}">
                                                                {{-- <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i> --}}
                                                            </div>
                                                        </div>
                                                    {{--<div class="half-input-wrapper">
                                                            <div class="half-input">
                                                                <input type="text" name="name" placeholder="@lang('home.name')*" required>
                                                            </div>
                                                            <div class="half-input">
                                                                <input type="text" placeholder="@lang('home.email')*" required>
                                                            </div>
                                                        </div> --}}

                                                        @csrf
                                                        <textarea name="comment" id="#" placeholder="@lang('home.note')" required></textarea>
                                                        <button class="rts-btn btn-primary">@lang('home.send_review')</button>
                                                    </form>
                                                </div>
                                            @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-12 offset-xl-1 rts-sticky-column-item">
                        <div class="theiaStickySidebar">
                            <div class="shop-sight-sticky-sidevbar mb--20">
                                <h6 class="title">@lang('home.available home.hot_offers')</h6>
                                <div class="single-offer-area">
                                    <div class="icon">
                                        <img src="{{url('resources/assets/front/images/shop/01.svg')}}" alt="icon">
                                    </div>
                                    <div class="details">
                                        <p>احصل على خصم فوري بنسبة 5% لأول طلب على Flipkart باستخدام Ekomart UPI الشروط والأحكام</p>
                                    </div>
                                </div>
                                <div class="single-offer-area">
                                    <div class="icon">
                                        <img src="{{url('resources/assets/front/images/shop/02.svg')}}" alt="icon">
                                    </div>
                                    <div class="details">
                                        <p>خصم ثابت بقيمة 250 دولار على معاملات EMI باستخدام بطاقة Citi-branded على الطلبات التي قيمتها 30 دولار وما فوق الشروط والأحكام</p>
                                    </div>
                                </div>
                                <div class="single-offer-area">
                                    <div class="icon">
                                        <img src="{{url('resources/assets/front/images/shop/03.svg')}}" alt="icon">
                                    </div>
                                    <div class="details">
                                        <p>شحن مجاني عالمي على جميع الطلبات التي تتجاوز قيمتها 100 دولار</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- <!-- rts grocery feature area start -->
    <div class="rts-grocery-feature-area rts-section-gap bg_light-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area-between">
                        <h2 class="title-left">
                            @lang('home.sizes')
                        </h2>
                        <div class="next-prev-swiper-wrapper">
                            <div class="swiper-button-prev swiper-button-prev0"><i class="fa-regular fa-chevron-left"></i>
                            </div>
                            <div class="swiper-button-next swiper-button-next0"><i
                                    class="fa-regular fa-chevron-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="category-area-main-wrapper-one">
                        <div class="swiper mySwiper-category-1 swiper-data"
                            data-swiper='{
                                "spaceBetween":16,
                                "slidesPerView":6,
                                "loop": true,
                                "speed": 700,
                                "navigation":{
                                    "nextEl":".swiper-button-next0",
                                    "prevEl":".swiper-button-prev0"
                                },
                                "breakpoints":{
                                "0":{
                                    "slidesPerView":1,
                                    "spaceBetween": 12},
                                "380":{
                                    "slidesPerView":1,
                                    "spaceBetween":12},
                                "480":{
                                    "slidesPerView":2,
                                    "spaceBetween":12},
                                "640":{
                                    "slidesPerView":2,
                                    "spaceBetween":16},
                                "840":{
                                    "slidesPerView":3,
                                    "spaceBetween":16},
                                "1540":{
                                    "slidesPerView":6,
                                    "spaceBetween":16}
                                }
                            }'>
                            <div class="swiper-wrapper">
                                @foreach ($size_groups_Product as $group)
                                    <div class="swiper-slide">
                                        <!-- single swiper start -->
                                        @include('website.appendes.products.add_product_cart_by_groub', [
                                            'group' => $group,
                                            'doesnt_use_forloop' => true,
                                        ])
                                    </div>
                                @endforeach
                                <!-- single swiper start -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts grocery feature area end --> --}}

    <!-- rts grocery feature area start -->
    <div class="rts-grocery-feature-area rts-section-gap bg_light-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area-between">
                        <h2 class="title-left">
                            @lang('home.related_products')
                        </h2>
                        <div class="next-prev-swiper-wrapper">
                            <div class="swiper-button-prev1 swiper-button-prev"><i class="fa-regular fa-chevron-left"></i>
                            </div>
                            <div class="swiper-button-next1 swiper-button-next"><i
                                    class="fa-regular fa-chevron-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="category-area-main-wrapper-one">
                        <div class="swiper mySwiper-category-1 swiper-data"
                            data-swiper='{
                                        "spaceBetween":16,
                                        "slidesPerView":6,
                                        "loop": true,
                                        "speed": 700,
                                        "navigation":{
                                            "nextEl":".swiper-button-next1",
                                            "prevEl":".swiper-button-prev1"
                                        },
                                        "breakpoints":{
                                        "0":{
                                            "slidesPerView":1,
                                            "spaceBetween": 12},
                                        "380":{
                                            "slidesPerView":1,
                                            "spaceBetween":12},
                                        "480":{
                                            "slidesPerView":2,
                                            "spaceBetween":12},
                                        "640":{
                                            "slidesPerView":2,
                                            "spaceBetween":16},
                                        "840":{
                                            "slidesPerView":3,
                                            "spaceBetween":16},
                                        "1540":{
                                            "slidesPerView":6,
                                            "spaceBetween":16}
                                        }
                                    }'>
                            <div class="swiper-wrapper">
                                <!-- single swiper start -->
                                @foreach ($related_groups as $product_main)
                                    <div class="swiper-slide">
                                        <!-- single swiper start -->
                                        @include('website.appendes.products.add_product_cart', [
                                            'product_main' => $product_main,
                                            'doesnt_use_forloop' => true,'char'=>'d',
                                        ])
                                    </div>
                                @endforeach
                                <!-- single swiper start -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts grocery feature area end -->
@endsection
@section('script')
    {{-- change price according to power --}}
    <script>
        // $('.size_option').click(function() {
        //     var value_id = $(this).data('value_id');
        //     var product_id = $(this).data('product_id');
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: "{{ LaravelLocalization::localizeUrl('get_option_price') }}",
        //         method: 'POST',
        //         data: {
        //             value_id: value_id,
        //             product_id: product_id,
        //         },
        //         success: function(data) {
        //             $('#data-attribute_value_' + product_id).val(value_id);
        //             $('#product_price').html(data.price);
        //             if (data.price != data.old_price) {
        //                 $('#old_price').html(data.old_price);
        //             }
        //         },

        //     });
        // });

        // rate js
        let stars =
            document.getElementsByClassName("star");
        let output =
            document.getElementById("output");

        // Funtion to update rating
        function gfg(n) {
            remove();
            for (let i = 0; i < n; i++) {
                if (n == 1) cls = "one";
                else if (n == 2) cls = "two";
                else if (n == 3) cls = "three";
                else if (n == 4) cls = "four";
                else if (n == 5) cls = "five";
                stars[i].className = "star " + cls;
            }
            output.value = n;
        }

        // To remove the pre-applied styling
        function remove() {
            let i = 0;
            while (i < 5) {
                stars[i].className = "star";
                i++;
            }
        }
        // end rate js
    </script>
    <script type="text/javascript">
        // Product details popup
        $(function() {
            $(document).on('click', ".product-details-popup-btn", function() {
                $("." + this.getAttribute('product')).addClass("popup")
                $("#anywhere-home").addClass("bgshow");
            });
        })



        document.addEventListener('DOMContentLoaded', function() {
    // Check if the last request was POST and if the user refreshed the page
    if ( performance.navigation.type === performance.navigation.TYPE_RELOAD) {
        // Redirect to the GET route on refresh
        window.location.href = "{{ url()->current()}}";
    }
});

    </script>

    
@endsection
