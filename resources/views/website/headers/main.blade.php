<!-- Main Header -->
<div class="sticky-header main-bar-wraper navbar-expand-lg">
    <div class="main-bar clearfix">
        <div class="container-fluid clearfix">
            <!-- Website Logo -->
            <div class="logo-header logo-dark me-md-5">
                <a href="{{LaravelLocalization::localizeUrl('/')}}"><img src="{{config('site_logo')}}" alt="logo"></a>
            </div>

            <!-- Nav Toggle Button -->
            <button class="navbar-toggler collapsed navicon justify-content-end" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- EXTRA NAV -->
            <div class="extra-nav">
                <div class="extra-cell">
                    <ul class="header-right">
                        <li class="nav-item login-link">
                            <a class="nav-link" href="shop-my-account.html">
                                @lang('home.login') / @lang('home.register')
                            </a>
                        </li>
                        <li class="nav-item search-link">
                            <a class="nav-link" href="javascript:void(0);" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="10.0535" cy="10.55" r="7.49047" stroke="var(--white)"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M15.2632 16.1487L18.1999 19.0778" stroke="var(--white)"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </li>
                        @auth
                        <li class="nav-item wishlist-link">
                            <a class="nav-link" href="{{LaravelLocalization::localizeUrl('profile')}}">
                                <svg fill="#fff" width="21" height="21" version="1.1" id="Layer_1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 402.161 402.161" xml:space="preserve">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke="var(--white)" stroke-linecap="round"
                                        stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g>
                                            <g>
                                                <g>
                                                    <path
                                                        d="M201.08,49.778c-38.794,0-70.355,31.561-70.355,70.355c0,18.828,7.425,40.193,19.862,57.151 c14.067,19.181,32,29.745,50.493,29.745c18.494,0,36.426-10.563,50.494-29.745c12.437-16.958,19.862-38.323,19.862-57.151 C271.436,81.339,239.874,49.778,201.08,49.778z M201.08,192.029c-13.396,0-27.391-8.607-38.397-23.616 c-10.46-14.262-16.958-32.762-16.958-48.28c0-30.523,24.832-55.355,55.355-55.355s55.355,24.832,55.355,55.355 C256.436,151.824,230.372,192.029,201.08,192.029z"
                                                        stroke="var(--white)"></path>
                                                    <path
                                                        d="M201.08,0C109.387,0,34.788,74.598,34.788,166.292c0,91.693,74.598,166.292,166.292,166.292 s166.292-74.598,166.292-166.292C367.372,74.598,292.773,0,201.08,0z M201.08,317.584c-30.099-0.001-58.171-8.839-81.763-24.052 c0.82-22.969,11.218-44.503,28.824-59.454c6.996-5.941,17.212-6.59,25.422-1.615c8.868,5.374,18.127,8.099,27.52,8.099 c9.391,0,18.647-2.724,27.511-8.095c8.201-4.97,18.39-4.345,25.353,1.555c17.619,14.93,28.076,36.526,28.895,59.512 C259.25,308.746,231.178,317.584,201.08,317.584z M296.981,283.218c-3.239-23.483-15.011-45.111-33.337-60.64 c-11.89-10.074-29.1-11.256-42.824-2.939c-12.974,7.861-26.506,7.86-39.483-0.004c-13.74-8.327-30.981-7.116-42.906,3.01 c-18.31,15.549-30.035,37.115-33.265,60.563c-33.789-27.77-55.378-69.868-55.378-116.915C49.788,82.869,117.658,15,201.08,15 c83.423,0,151.292,67.869,151.292,151.292C352.372,213.345,330.778,255.448,296.981,283.218z">
                                                    </path>
                                                    <path
                                                        d="M302.806,352.372H99.354c-4.142,0-7.5,3.358-7.5,7.5c0,4.142,3.358,7.5,7.5,7.5h203.452c4.142,0,7.5-3.358,7.5-7.5 C310.307,355.73,306.948,352.372,302.806,352.372z">
                                                    </path>
                                                    <path
                                                        d="M302.806,387.161H99.354c-4.142,0-7.5,3.358-7.5,7.5c0,4.142,3.358,7.5,7.5,7.5h203.452c4.142,0,7.5-3.358,7.5-7.5 C310.307,390.519,306.948,387.161,302.806,387.161z">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </li>
                        @endauth
                        
                        <li class="nav-item cart-link">
                            <a href="javascript:void(0);" class="nav-link cart-btn" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M1.08374 2.61947C1.08374 2.27429 1.36356 1.99447 1.70874 1.99447H3.29314C3.91727 1.99447 4.4722 2.39163 4.67352 2.98239L5.06379 4.1276H15.4584C17.6446 4.1276 19.4168 5.89981 19.4168 8.08593V11.5379C19.4168 13.7241 17.6446 15.4963 15.4584 15.4963H9.22182C7.30561 15.4963 5.66457 14.1237 5.32583 12.2377L4.00967 4.90953L3.49034 3.3856C3.46158 3.30121 3.3823 3.24447 3.29314 3.24447H1.70874C1.36356 3.24447 1.08374 2.96465 1.08374 2.61947ZM5.36374 5.3776L6.55614 12.0167C6.78791 13.3072 7.91073 14.2463 9.22182 14.2463H15.4584C16.9542 14.2463 18.1668 13.0337 18.1668 11.5379V8.08593C18.1668 6.59016 16.9542 5.3776 15.4584 5.3776H5.36374Z"
                                        fill="var(--white)" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.16479 17.8278C8.16479 17.1374 8.72444 16.5778 9.4148 16.5778H9.42313C10.1135 16.5778 10.6731 17.1374 10.6731 17.8278C10.6731 18.5182 10.1135 19.0778 9.42313 19.0778H9.4148C8.72444 19.0778 8.16479 18.5182 8.16479 17.8278Z"
                                        fill="var(--white)" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M14.8315 17.8278C14.8315 17.1374 15.3912 16.5778 16.0815 16.5778H16.0899C16.7802 16.5778 17.3399 17.1374 17.3399 17.8278C17.3399 18.5182 16.7802 19.0778 16.0899 19.0778H16.0815C15.3912 19.0778 14.8315 18.5182 14.8315 17.8278Z"
                                        fill="var(--white)" />
                                </svg>
                                <span class="badge badge-circle">5</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Nav -->
            <div class="header-nav navbar-collapse collapse justify-content-start" id="navbarNavDropdown">
                <div class="logo-header logo-dark">
                    <a href="{{LaravelLocalization::localizeUrl('/')}}"><img src="{{config('site_logo')}}" alt="logo"></a>
                </div>
                <ul class="nav navbar-nav dark-nav">
                    @foreach ($menus as $menu)
                        @if ($menu->segment === 'home')
                            <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{$menu->name}}</a></li>
                        @else
                            <li><a href="{{LaravelLocalization::localizeUrl($menu->segment)}}">{{$menu->name}}</a></li>
                        @endif
                        
                    @endforeach
                    
                </ul>

                <div class="dz-social-icon">
                    <ul>
                        @if(config('site_facebook'))
                            <li><a class="fab fa-facebook-f" target="_blank" href="{{config('site_facebook')}}"></a> </li>
                        @endif
                        @if(config('site_twitter'))
                            <li><a class="fab fa-twitter" target="_blank" href="{{config('site_twitter')}}"></a></li>
                        @endif
                        @if(config('site_twitter'))
                            <li><a class="fab fa-linkedin-in" target="_blank" href="{{config('site_linkedin-in')}}"></a></li>
                        @endif
                        @if(config('site_instagram'))
                            <li><a class="fab fa-instagram" target="_blank" href="{{config('site_instagram')}}"></a></li>
                        @endif
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Header End -->
