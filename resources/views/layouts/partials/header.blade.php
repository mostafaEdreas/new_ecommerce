<!-- rts header area start -->
<div class="rts-header-one-area-one">
    <div class="header-mid-one-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-mid-wrapper-between">
                        <div class="nav-sm-left">
                            <p class="para"> {{ $configration->top_text }} </p>
                        </div>
                        <div class="nav-sm-left">
                            <ul class="nav-h_top language">
                                <li class="category-hover-header language-hover">
                                    <a href="javascript:void(0)">{{ LaravelLocalization::getCurrentLocaleNative() }}</a>
                                    <ul class="category-sub-menu">
                                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <li>
                                                <a rel="alternate" hreflang="{{ $localeCode }}"
                                                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                                    class="menu-item">
                                                    <span>{{ $properties['native'] }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="search-header-area-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="logo-search-category-wrapper">
                        <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="logo-area">
                            <img src="{{ url('uploads/settings/source/' . $configration->app_logo) }}"
                                alt="logo-main" class="logo">
                        </a>
                        <div class="category-search-wrapper">
                            <div class="category-btn category-hover-header">
                                <img class="parent" src="{{ url('resources/assets/front/images/icons/bar-1.svg') }}"
                                    alt="icons">
                                <span> @lang('home.categories')</span>
                                <ul class="category-sub-menu" id="category-active-four">
                                    @foreach ($mainCategories as $categoryMenu)
                                        <li>
                                            <a href="{{ !count($categoryMenu->subCategories) ?  LaravelLocalization::localizeUrl('category/' . $categoryMenu->{'link_' . $lang}) : 'javascript:void(0)' }}"
                                                class="menu-item">
                                                <img src="{{ url('uploads/categories/source/' . $categoryMenu->icon) }}"
                                                    alt="icons" width="43">
                                                <span> {{ $categoryMenu->{'name_' . $lang} }} </span>
                                                @if (count($categoryMenu->subCategories))
                                                    <i class="fa-regular fa-plus"></i>
                                                @endif
                                            </a>
                                            @if (count($categoryMenu->subCategories))
                                                <ul class="submenu mm-collapse">
                                                    @foreach ($categoryMenu->subCategories as $subCategories)
                                                        <li><a class="mobile-menu-link"
                                                                href="{{ LaravelLocalization::localizeUrl('category/' . $subCategories->{'link_' . $lang}) }}">{{ $subCategories->{'name_' . $lang} }}
                                                            </a></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="search-header">
                                <input type="text" placeholder="@lang('home.search for') @lang('home.products') ..."
                                    class="Qsearch" name="search" id="Qsearch">
                                <a href="#" class="rts-btn btn-primary radious-sm with-icon Qsearch"
                                    id="btn-Qsearch">
                                    <div class="btn-text">
                                        @lang('home.search')
                                    </div>
                                    <div class="arrow-icon">
                                        <i class="fa-light fa-magnifying-glass"></i>
                                    </div>
                                    <div class="arrow-icon">
                                        <i class="fa-light fa-magnifying-glass"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="actions-area">
                            <div class="search-btn" id="searchs">
                                <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.75 14.7188L11.5625 10.5312C12.4688 9.4375 12.9688 8.03125 12.9688 6.5C12.9688 2.9375 10.0312 0 6.46875 0C2.875 0 0 2.9375 0 6.5C0 10.0938 2.90625 13 6.46875 13C7.96875 13 9.375 12.5 10.5 11.5938L14.6875 15.7812C14.8438 15.9375 15.0312 16 15.25 16C15.4375 16 15.625 15.9375 15.75 15.7812C16.0625 15.5 16.0625 15.0312 15.75 14.7188ZM1.5 6.5C1.5 3.75 3.71875 1.5 6.5 1.5C9.25 1.5 11.5 3.75 11.5 6.5C11.5 9.28125 9.25 11.5 6.5 11.5C3.71875 11.5 1.5 9.28125 1.5 6.5Z"
                                        fill="#1F1F25"></path>
                                </svg>
                            </div>
                            <div class="menu-btn" id="menu-btn">
                                <svg with="20" height="16" viewBox="0 0 20 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect y="14" width="20" height="2" fill="#1F1F25"></rect>
                                    <rect y="7" width="20" height="2" fill="#1F1F25"></rect>
                                    <rect width="20" height="2" fill="#1F1F25"></rect>
                                </svg>

                            </div>
                        </div>
                        <div class="accont-wishlist-cart-area-header">
                            @auth
                                <a href="{{ LaravelLocalization::localizeUrl('user/account-settings') }}" class="btn-border-only account">
                                    <i class="fa-light fa-user"></i>
                                </a>
                                <a href="{{ LaravelLocalization::localizeUrl('user/wish-list') }}" class="btn-border-only wishlist">
                                    <i class="fa-regular fa-heart"></i>
                                    @if ($wishCount > 0)
                                        <span class="abs-number wish-counter-id" id='wish-counter-id'>{{ $wishCount }}</span>
                                    @endif
                                </a>

                                <!-- Cart Button -->
                                <div class="btn-border-only cart category-hover-header header-cart" id="header-cart">
                                    @include('website.appendes.products.carts.add_to_cart_header')
                                </div>

                                <!-- Logout Button -->
                                <a href="{{ route('logout') }}" class="rts-btn btn-primary radious-sm with-icon"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <div class="btn-text">
                                        @lang('home.logout')
                                    </div>
                                    <div class="arrow-icon">
                                        <i class="fa-light fa-arrow-right"></i>
                                    </div>
                                </a>

                                <!-- Logout Form (invisible) -->
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @endauth

                            @guest
                                <!-- Cart Button for Guests -->
                                <div class="btn-border-only cart category-hover-header header-cart" id="header-cart">
                                    @include('website.appendes.products.carts.add_to_cart_header')
                                </div>

                                <!-- Login Button for Guests -->
                                <a href="{{ LaravelLocalization::localizeUrl('login') }}" class="rts-btn btn-primary radious-sm with-icon">
                                    <div class="btn-text">
                                        @lang('home.login')
                                    </div>
                                    <div class="arrow-icon">
                                        <i class="fa-light fa-arrow-right"></i>
                                    </div>
                                </a>
                            @endguest
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rts-header-nav-area-one header--sticky">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="nav-and-btn-wrapper">
                        <div class="nav-area">
                            <nav>
                                <ul class="parent-nav">
                                    @foreach ($menus as $menu)
                                        <li class="parent ">
                                            <a class="nav-link"
                                                href="{{ LaravelLocalization::localizeUrl($menu->type) }}">
                                                {{ $menu->{'name_' . $lang} }} </a>
                                        </li>
                                    @endforeach

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="logo-search-category-wrapper after-md-device-header">
                        <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="logo-area">
                            <img src="{{ url('uploads/settings/source/' . $configration->app_logo) }}"
                                alt="logo-main" class="logo">
                        </a>
                        <div class="category-search-wrapper">
                            <div class="category-btn category-hover-header">
                                <img class="parent" src="{{ url('resources/assets/front/images/icons/bar-1.svg') }}"
                                    alt="icons">
                                <span> @lang('home.categories') </span>
                                <ul class="category-sub-menu">
                                    @foreach ($mainCategories as $categoryMenu)
                                        <li>
                                            <a href="{{ !count($categoryMenu->subCategories) ? LaravelLocalization::localizeUrl('products?') . 'category=' . $categoryMenu->{'link_' . $lang} : 'javascript:void(0)' }}"
                                                class="menu-item">
                                                <img src="{{ url('uploads/categories/source/' . $categoryMenu->icon) }}"
                                                    alt="icons" width="43">
                                                <span> {{ $categoryMenu->{'name_' . $lang} }} </span>
                                                @if (count($categoryMenu->subCategories))
                                                    <i class="fa-regular fa-plus"></i>
                                                @endif
                                            </a>
                                            @if (count($categoryMenu->subCategories))
                                                <ul class="submenu mm-collapse">
                                                    @foreach ($categoryMenu->subCategories as $subCategories)
                                                        <li><a class="mobile-menu-link"
                                                                href="{{ LaravelLocalization::localizeUrl('products') }}?category={{ $subCategories->{'link_' . $lang} }}">{{ $subCategories->{'name_' . $lang} }}
                                                            </a></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <form action="#" class="search-header">
                                <input type="text" class="Qsearch" placeholder="@lang('home.search for') @lang('home.products') ..."
                                    required>
                                <button class="rts-btn btn-primary radious-sm with-icon Qsearch">
                                    <span class="btn-text">
                                        @lang('home.search')
                                    </span>
                                    <span class="arrow-icon">
                                        <i class="fa-light fa-magnifying-glass"></i>
                                    </span>
                                    <span class="arrow-icon">
                                        <i class="fa-light fa-magnifying-glass"></i>
                                    </span>
                                </button>
                            </form>
                        </div>
                        <div class="main-wrapper-action-2 d-flex">
                            <div class="accont-wishlist-cart-area-header">
                                <a href="{{ LaravelLocalization::localizeUrl('user/profile') }}"
                                    class="btn-border-only account">
                                    <i class="fa-light fa-user"></i>
                                </a>
                                <a href="{{ LaravelLocalization::localizeUrl('user/wish-list') }}"
                                    class="btn-border-only wishlist">
                                    <i class="fa-regular fa-heart"></i>
                                    @if (count($wishProds))
                                        <span class="abs-number wish-counter-id" id='wish-counter-id'>{{ count($wishProds) }}</span>
                                    @endif
                                </a>
                                <div class="btn-border-only cart category-hover-header header-cart" id="header-cart">
                                    <i class="fa-sharp fa-regular fa-cart-shopping"></i>
                                    @if (count($cartsPub))
                                        <span class="abs-number">{{ count($cartsPub) }}</span>
                                    @endif
                                    <span>@lang('home.my_card')</span>
                                    <div class="category-sub-menu card-number-show">
                                        <h5 class="shopping-cart-number">@lang('home.my_card')</h5>
                                        @foreach ($cartsPub as $index => $cartProduct)
                                            <div
                                                class="cart-item-1 @if (!$index) border-top @endif ">
                                                <div class="img-name">
                                                    <div class="thumbanil">
                                                        <img src="{{ Helper::uploadedImagesPath('products', $cartProduct->group->image->image) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="details">
                                                        <a href="{{ LaravelLocalization::localizeUrl('product/' . $cartProduct->group->product->{'link_' . $lang}) }}">
                                                            <h5 class="title">
                                                                {{ $cartProduct->group->product->{'name_' . $lang} }}</h5>
                                                        </a>
                                                        <div class="number">
                                                            {{ $cartProduct->quantity }}
                                                            <i class="fa-regular fa-x"></i>
                                                            <span>{{ $cartProduct->group->price_details->new_price }} @lang('home.EGP')</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="close-c1">
                                                    <i class="fa-regular fa-x"></i>
                                                </div> --}}
                                            </div>
                                        @endforeach
                                        <div class="sub-total-cart-balance">
                                            <div class="bottom-content-deals mt--10">
                                                <div class="top">
                                                    <span> @lang('home.total') :</span>
                                                    <span class="number-c">{{count( $cartsPub)? $cartsPub->sum(function ($cartProduct) {  ;return $cartProduct->total_product ;}):0 }}</span>
                                                </div>
                                                <!--<div class="single-progress-area-incard">
                                                    <div class="progress">
                                                        <div class="progress-bar wow fadeInLeft" role="progressbar"
                                                            style="width: 80%" aria-valuenow="25" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>-->
                                                <p>
                                                    {{ $configration->text_top }}
                                                </p>
                                            </div>
                                            <div
                                                class="button-wrapper d-flex align-items-center justify-content-between">
                                                <a href="{{ LaravelLocalization::localizeUrl('carts') }}"
                                                    class="rts-btn btn-primary "> @lang('home.my_card') </a>
                                                <a
                                                    href="{{ LaravelLocalization::localizeUrl('order-checkOut') }}"class="rts-btn btn-primary border-only">@lang('home.checkout')</a>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="javascript::void(0)"
                                        class="over_link"></a>
                                </div>
                            </div>
                            <div class="actions-area">
                                <div class="search-btn" id="search">

                                    <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15.75 14.7188L11.5625 10.5312C12.4688 9.4375 12.9688 8.03125 12.9688 6.5C12.9688 2.9375 10.0312 0 6.46875 0C2.875 0 0 2.9375 0 6.5C0 10.0938 2.90625 13 6.46875 13C7.96875 13 9.375 12.5 10.5 11.5938L14.6875 15.7812C14.8438 15.9375 15.0312 16 15.25 16C15.4375 16 15.625 15.9375 15.75 15.7812C16.0625 15.5 16.0625 15.0312 15.75 14.7188ZM1.5 6.5C1.5 3.75 3.71875 1.5 6.5 1.5C9.25 1.5 11.5 3.75 11.5 6.5C11.5 9.28125 9.25 11.5 6.5 11.5C3.71875 11.5 1.5 9.28125 1.5 6.5Z"
                                            fill="#1F1F25"></path>
                                    </svg>

                                </div>
                                <div class="menu-btn">

                                    <svg width="20" height="16" viewBox="0 0 20 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect y="14" width="20" height="2" fill="#1F1F25"></rect>
                                        <rect y="7" width="20" height="2" fill="#1F1F25"></rect>
                                        <rect width="20" height="2" fill="#1F1F25"></rect>
                                    </svg>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- header style two -->
<div id="side-bar" class="side-bar header-two">
    <button class="close-icon-menu"><i class="far fa-times"></i></button>


    <form action="#" class="search-input-area-menu mt--30">
        <input type="text" class="Qsearch" placeholder="    بحث" required>
        <button class="Qsearch"><i class="fa-light fa-magnifying-glass"></i></button>
    </form>

    <div class="mobile-menu-nav-area tab-nav-btn mt--20">

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true"> @lang('home.menu')
                </button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    @lang('home.categories') </button>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                tabindex="0">
                <!-- mobile menu area start -->
                <div class="mobile-menu-main">
                    <nav class="nav-main mainmenu-nav mt--30">
                        <ul class="mainmenu metismenu" id="mobile-menu-active">
                            @foreach ($menus as $menu)
                                <li class="">
                                    <a href="{{ LaravelLocalization::localizeUrl($menu->type) }}" class="main">
                                        {{ $menu->{'name_' . $lang} }} </a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>

                </div>
                <!-- mobile menu area end -->
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
                tabindex="0">
                <div class="category-btn category-hover-header menu-category">
                    <ul class="category-sub-menu" id="category-active-menu">
                        @foreach ($mainCategories as $categoryMenu)
                            <li>
                                <a href="{{ !count($categoryMenu->subCategories) ? LaravelLocalization::localizeUrl('products') . 'category_id=' . $categoryMenu->{'link_' . $lang} : 'javascript:void(0)' }}" class="menu-item">
                                    <img src="{{ url('uploads/categories/source/' . $categoryMenu->icon) }}" alt="icons" width="43">
                                    <span>{{ $categoryMenu->{'name_' . $lang} }}</span>
                                    @if (count($categoryMenu->subCategories))
                                        <i class="fa-regular fa-plus"></i>
                                    @endif
                                </a>
                                @if (count($categoryMenu->subCategories))
                                <ul class="submenu mm-collapse">
                                    @foreach ($categoryMenu->subCategories as $subCategories)
                                        <li><a class="mobile-menu-link"
                                                href="{{ LaravelLocalization::localizeUrl('products') }}?category_id={{ $subCategories->{'link_' . $lang} }}">{{ $subCategories->{'name_' . $lang} }}
                                            </a></li>
                                    @endforeach
                                </ul>
                            @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <!-- button area wrapper start -->
    <div class="button-area-main-wrapper-menuy-sidebar mt--50">
        <div class="contact-area">
            <div class="phone">
                <i class="fa-light fa-headset"></i>
                <a href="tel:+2{{$setting->mobile}}">{{$setting->mobile}}</a>
            </div>
            <div class="phone">
                <i class="fa-light fa-envelope"></i>
                <a href="mialto:{{$setting->email}}">{{$setting->email}}</a>
            </div>
        </div>
        <div class="buton-area-bottom">
            @guest
            <a href="{{LaravelLocalization::localizeUrl('login')}}" class="rts-btn btn-primary">@lang('home.sign_in')</a>
            <a href="{{LaravelLocalization::localizeUrl('register')}}" class="rts-btn btn-primary">@lang('home.register')</a>
            @endguest
            @auth
            <a href="{{LaravelLocalization::localizeUrl('login')}}" class="rts-btn btn-primary with-icon" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('home.log_out')</a>
            @endauth
        </div>
    </div>
    <!-- button area wrapper end -->

</div>
<!-- header style two End -->
<!-- rts header area end -->
