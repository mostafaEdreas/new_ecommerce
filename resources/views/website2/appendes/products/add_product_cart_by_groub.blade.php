@if (!isset($doesnt_use_forloop))
    @foreach ($groups as $group)
        @if (Request::segment(2)=='products' )
        <div class="col-lg-20 col-lg-4 col-md-6 col-sm-6 col-12">
        @else
        <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        @endif
            {{-- <div class="img_pop_up">
                <div class="product-details-popup-wrapper-procart{{ $group->id }} product-details-popup-wrapper">
                    <div class="rts-product-details-section rts-product-details-section2 product-details-popup-section">
                        <div class="product-details-popup">
                            <button class="product-details-close-btn"><i class="fal fa-times"></i></button>
                            <div class="details-product-area">
                                <div class="product-thumb-area">
                                    <div class="cursor"></div>
                                    <div class="thumb-wrapper show0 filterd-items figure ">
                                        <div class="product-thumb zoom" onmousemove="zoom(event)"
                                            style="background-image: url({{ Helper::uploadedImagesPath('products', $group->image->image) }})">
                                            <img src="{{ Helper::uploadedImagesPath('products', $group->image->image) }}"
                                                alt="product-thumb">
                                        </div>
                                    </div>
                                    @foreach ($group->gruopsHasSamePrice($group->product->id) as $index => $SPGroup)
                                        <div class="thumb-wrapper show{{ $index + 1 }} filterd-items hide ">
                                            <div class="product-thumb zoom" onmousemove="zoom(event)"
                                                style="background-image: url({{ Helper::uploadedImagesPath('products', $SPGroup->image->image) }})">
                                                <img src="{{ Helper::uploadedImagesPath('products', $SPGroup->image->image) }}"
                                                    alt="product-thumb">
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="product-thumb-filter-group">
                                        <div class="thumb-filter filter-btn active "
                                            onclick="document.getElementById('d-cart-{{ $group->product->id }}').setAttribute('group_id','{{ $group->id }}')"
                                            data-show=".show0">
                                            <img src="{{ Helper::uploadedImagesPath('products', $group->image->image) }}"
                                                alt="product-thumb-filter">
                                        </div>
                                        @foreach ($group->gruopsHasSamePrice($group->product->id) as $index => $SPGroup)
                                            <div class="thumb-filter filter-btn"
                                                onclick="document.getElementById('d-cart-{{ $group->product->id }}').setAttribute('group_id','{{ $SPGroup->id }}')"
                                                data-show=".show{{ $index + 1 }}">
                                                <img src="{{ Helper::uploadedImagesPath('products', $SPGroup->image->image) }}"
                                                    alt="product-thumb-filter">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="contents">
                                    <div class="product-status">
                                        <div class="rating-stars-group">
                                            @include('website.appendes.stars', [
                                                'rate' => $group->product->rate->rate,
                                            ])

                                            <span>{{ $group->product->rate->count }} @lang('home.reviews')</span>
                                        </div>
                                    </div>
                                    <h2 class="product-title">{{ $group->product->{'name_' . $lang} }} <span class="stock"> {{$group->stock>0?__('home.in_stock').' '.$group->stock:__('home.out of stock')}}</span></h2>
                                    <span class="product-price">
                                        @if ($group->product->discount)
                                            <span
                                                class="old-price">{{ $group->price_details->old_price }}</span>{{ $group->price_details->new_price }}
                                        @else
                                            {{ $group->price_details->new_price }}
                                            @lang('home.EGP')
                                        @endif
                                    </span>
                                    <p>
                                        {{ $group->product->{'short_desc_' . $lang} }}
                                    </p>
                                    <div class="product-bottom-action">
                                        <div class="cart-edit">
                                            <div class="quantity-edit action-item">
                                                <button class="button decrease-btn"><i
                                                        class="fal fa-minus minus"></i></button>
                                                <input stock="{{ $group->stock }}"
                                                    id="quan-inp4-{{ $group->id }}" type="text"
                                                    class="input edit-cart-quantity" value="{{ $group->stock > 0?1:0 }}" />
                                                <button class="button plus increase-btn">+<i
                                                        class="fal fa-plus plus"></i></button>
                                            </div>
                                        </div>
                                        <button
                                            quan-input="quan-inp4-{{ $group->id }}"
                                            group_id="{{ $group->id }}" onclick="addToCart(this)"
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
                                        <button group_id="{{ $group->id }}" onclick="addToWish(this)"
                                            id="prowish{{ $group->product->id }}" class="rts-btn btn-primary ml--20"><i
                                                class="fa-light fa-heart"></i></button>
                                    </div>
                                    <div class="product-uniques">
                                        <span class="sku product-unipue"><span>@lang('home.barcode') </span>
                                        {{ $group->product->barcode }}</span>
                                        <span class="catagorys product-unipue"><span>@lang('home.categories'): </span>
                                            {{ $group->product->category->{'name_' . $lang} }}</span>
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
                    <a href="{{ LaravelLocalization::localizeUrl('product/' . $group->product->{'link_' . $lang} ) }}?group={{ $group->id }}"
                        class="thumbnail-preview">
                        @if ($group->product->discount)
                            <div class="badge">
                                <span>{{ $group->price_details->percentage }} <br>
                                    @lang('home.discount')
                                </span>
                                <i class="fa-solid fa-bookmark"></i>
                            </div>
                        @endif
                        @if ($group->image->image)
                            <img src="{{ Helper::uploadedImagesPath('products', $group->image->image) }}"  alt="grocery">

                        @else
                            <img src="{{url('resources/assets/back/img/noimage.png')}}"  alt="grocery">

                        @endif
                    </a>
                    @auth
                    <div class="action-share-option">
                            <div class="single-action openuptip  add-to-fev add-to-wish" group_id="{{ $group->id }}"
                                onclick="addToWish(this)" data-flow="up" title="Add To Wishlist">
                                <i class="fa-light fa-heart"></i>
                            </div>
                        {{-- <div product="product-details-popup-wrapper-procart{{ $group->id }}"
                            class="single-action openuptip cta-quickview product-details-popup-btn" data-flow="up"
                            title="Quick View">
                            <i class="fa-regular fa-eye"></i>
                        </div> --}}
                    </div>
                    @endauth
                </div>
                <!-- iamge and sction area start -->
                <div class="body-content">
                    <a
                        href="{{ LaravelLocalization::localizeUrl('product/' . $group->product->{'link_' . $lang}) }}?group={{ $group->id }}">
                        <h4 class="title">{{ $group->product->{'name_' . $lang} }}</h4>
                    </a>
                    <a
                        href="{{ LaravelLocalization::localizeUrl('products?category_ids[]=' . $group->product->category->id) }}">
                        <span class="tags product-unipue"><span>@lang('home.category') </span>
                            {{ $group->product->category->{'name_' . $lang} }}</span>

                    </a>
                    <span class="availability"> {{ $group->product->{'short_desc_' . $lang} }} </span>
                    <div class="price-area">
                        @if ($group->product->discount)
                            <span class="current">{{ $group->price_details->new_price }}</span>
                            <div class="previous">{{ $group->price_details->old_price }}</div>
                        @else
                            <span class="current">{{ $group->price_details->new_price }}</span>
                        @endif
                    </div>
                    <div class="cart-counter-action">
                        <div class="quantity-edit" style="display: none !important">
                            <input type="text" stock="{{ $group->stock }}"
                                id="quan-inp1-{{ $group->id }}" class="input edit-cart-quantity"
                                value="{{ $group->stock > 0?1:0 }}">
                            <div class="button-wrapper-action">
                                <button class="decrease-btn">
                                    <i class="fa-regular fa-chevron-down"></i></button>
                                <button class="plus increase-btn">+<i
                                        class="fa-regular fa-chevron-up"></i></button>
                            </div>
                        </div>
                        @if ($group->stock > 0)
                        <button quan-input="quan-inp1-{{ $group->id }}" group_id="{{ $group->id }}"
                            onclick="addToCart(this)" class="rts-btn btn-primary radious-sm with-icon">
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
{{-- <div class="product-details-popup-wrapper-procart{{ $group->id }} product-details-popup-wrapper">
    <div class="rts-product-details-section rts-product-details-section2 product-details-popup-section">
        <div class="product-details-popup">
            <button class="product-details-close-btn"><i class="fal fa-times"></i></button>
            <div class="details-product-area">
                <div class="product-thumb-area">
                    <div class="cursor"></div>
                    <div class="thumb-wrapper show0 filterd-items figure ">
                        <div class="product-thumb zoom" onmousemove="zoom(event)"
                            style="background-image: url({{ Helper::uploadedImagesPath('products', $group->image->image) }})">
                            <img src="{{ Helper::uploadedImagesPath('products', $group->image->image) }}"
                                alt="product-thumb">
                        </div>
                    </div>
                    @foreach ($group->gruopsHasSamePrice($group->product->id) as $index => $SPGroup)
                        <div class="thumb-wrapper show{{ $index + 1 }} filterd-items hide ">
                            <div class="product-thumb zoom" onmousemove="zoom(event)"
                                style="background-image: url({{ Helper::uploadedImagesPath('products', $SPGroup->image->image) }})">
                                <img src="{{ Helper::uploadedImagesPath('products', $SPGroup->image->image) }}"
                                    alt="product-thumb">
                            </div>
                        </div>
                    @endforeach
                    <div class="product-thumb-filter-group">
                        <div class="thumb-filter filter-btn active "
                            onclick="document.getElementById('d-cart-{{ $group->product->id }}').setAttribute('group_id','{{ $group->id }}')"
                            data-show=".show0">
                            <img src="{{ Helper::uploadedImagesPath('products', $group->image->image) }}"
                                alt="product-thumb-filter">
                        </div>
                        @foreach ($group->gruopsHasSamePrice($group->product->id) as $index => $SPGroup)
                            <div class="thumb-filter filter-btn"
                                onclick="document.getElementById('d-cart-{{ $group->product->id }}').setAttribute('group_id','{{ $SPGroup->id }}')"
                                data-show=".show{{ $index + 1 }}">
                                <img src="{{ Helper::uploadedImagesPath('products', $SPGroup->image->image) }}"
                                    alt="product-thumb-filter">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="contents">
                    <div class="product-status">
                        <div class="rating-stars-group">
                            @include('website.appendes.stars', [
                                'rate' => $group->product->rate->rate,
                            ])

                            <span>{{ $group->product->rate->count }} @lang('home.reviews')</span>
                        </div>
                    </div>
                    <h2 class="product-title">{{ $group->product->{'name_' . $lang} }}<span class="stock"> {{$group->stock>0?__('home.in_stock').' '.$group->stock:__('home.out of stock')}}</span></h2>
                    <span class="product-price">
                        @if ($group->product->discount)
                            <span
                                class="old-price">{{ $group->price_details->old_price }}</span>{{ $group->price_details->new_price }}
                        @else
                            {{ $group->price_details->new_price }}
                            @lang('home.EGP')
                        @endif
                    </span>
                    <p>
                        {{ $group->product->{'short_desc_' . $lang} }}
                    </p>
                    <div class="product-bottom-action">
                        <div class="cart-edit">
                            <div class="quantity-edit action-item">
                                <button class="button decrease-btn"><i
                                        class="fal fa-minus minus"></i></button>
                                <input stock="{{ $group->stock }}"
                                    id="quan-inp5-{{ $group->id }}" type="text"
                                    class="input edit-cart-quantity" value="{{ $group->stock > 0?1:0 }}" />
                                <button class="button plus increase-btn">+<i
                                        class="fal fa-plus plus"></i></button>
                            </div>
                        </div>
                        <button
                            quan-input="quan-inp5-{{ $group->id }}"
                            group_id="{{ $group->id }}" onclick="addToCart(this)"
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
                        <button group_id="{{ $group->id }}" onclick="addToWish(this)"
                            id="prowish{{ $group->product->id }}" class="rts-btn btn-primary ml--20"><i
                                class="fa-light fa-heart"></i></button>
                    </div>
                    <div class="product-uniques">
                        <span class="sku product-unipue"><span>@lang('home.barcode') </span>
                        {{ $group->product->barcode }}</span>
                        <span class="catagorys product-unipue"><span>@lang('home.categories'): </span>
                            {{ $group->product->category->{'name_' . $lang} }}</span>
                        <span class="tags product-unipue"><span>توجية: </span> منتجات, تخييم</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
    <div class="single-shopping-card-one">
        <!-- iamge and sction area start -->
        <div class="image-and-action-area-wrapper">
            <a href="{{ LaravelLocalization::localizeUrl('product/' . $group->product->{'link_' . $lang}) }}?group={{ $group->id }}"
                class="thumbnail-preview">
                @if ($group->product->discount)
                    <div class="badge">
                        <span>{{ $group->price_details->percentage }} <br>
                            @lang('home.discount')
                        </span>
                        <i class="fa-solid fa-bookmark"></i>
                    </div>
                @endif
                @if ($group->image->image)
                    <img src="{{ Helper::uploadedImagesPath('products', $group->image->image) }}"  alt="grocery">

                @else
                    <img src="{{url('resources/assets/back/img/noimage.png')}}"  alt="grocery">

                @endif
            </a>
            @auth
            <div class="action-share-option">

                    <div class="single-action openuptip  add-to-fev add-to-wish" group_id="{{ $group->id }}"
                        onclick="addToWish(this)" id="prowish{{ $group->product->id }}" data-flow="up"
                        title="Add To Wishlist">
                        <i class="fa-light fa-heart"></i>
                    </div>

                {{-- <div product="product-details-popup-wrapper-procart{{ $group->id }}"
                    class="single-action openuptip cta-quickview product-details-popup-btn" data-flow="up"
                    title="Quick View">
                    <i class="fa-regular fa-eye"></i>
                </div> --}}
            </div>
            @endauth
        </div>
        <!-- iamge and sction area start -->
        <div class="body-content">
            <a
                href="{{ LaravelLocalization::localizeUrl('product/' . $group->product->{'link_' . $lang}) }}?group={{ $group->id }}">
                <h4 class="title">{{ $group->product->{'name_' . $lang} }}</h4>
            </a>
            <a
                href="{{ LaravelLocalization::localizeUrl('products?category_ids[]=' . $group->product->category->id) }}">
                <span class="tags product-unipue"><span>@lang('home.category') </span>
                    {{ $group->product->category->{'name_' . $lang} }}</span>

            </a>
            <span class="availability"> {{ $group->product->{'short_desc_' . $lang} }} </span>
            <div class="price-area">
                @if ($group->product->discount)
                    <span class="current">{{ $group->price_details->new_price }}</span>
                    <div class="previous">{{ $group->price_details->old_price }}</div>
                @else
                    <span class="current">{{ $group->price_details->new_price }}</span>
                @endif
            </div>
            <div class="cart-counter-action">
                <div class="quantity-edit" style="display: none !important">
                    <input type="text" stock="{{ $group->stock }}" id="quan-inp2-{{ $group->id }}"
                        class="input edit-cart-quantity" value="{{ $group->stock > 0 ? 1 : 0 }}">
                    <div class="button-wrapper-action">
                        <button class=" decrease-btn">
                            <i class="fa-regular fa-chevron-down"></i></button>
                        <button class=" plus increase-btn">+<i class="fa-regular fa-chevron-up"></i></button>
                    </div>
                </div>
                @if ($group->stock > 0)
                <button quan-input="quan-inp2-{{ $group->id }}" group_id="{{ $group->id }}"
                    onclick="addToCart(this)" class="rts-btn btn-primary radious-sm with-icon">
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
