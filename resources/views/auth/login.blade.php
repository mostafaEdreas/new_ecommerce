<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="description"
        content="Ekomart-Grocery-Store(e-Commerce) HTML Template: A sleek, responsive, and user-friendly HTML template designed for online grocery stores.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Grocery, Store, stores">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ $configration->app_name }} @lang('home.login') </title>
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ url('uploads/settings/source/' . $configration->about_image) }}">
    <!-- plugins css -->
    <link rel="stylesheet preload" href="{{ Helper::cssFilesPath('plugins.css') }}" as="style">
    <link rel="stylesheet preload" href="{{ Helper::cssFilesPath('style.css') }}" as="style">
    <link rel="stylesheet preload" href="{{ Helper::cssFilesPath('Youseff.css') }}" as="style">
    <link rel="stylesheet preload" href="{{ Helper::cssFilesPath('styleRtl.css') }}" as="style">
</head>

<body>

    <!-- header style two End -->

    <!-- rts header area end -->
    <!-- rts header area end -->

    <!-- rts register area start -->
    <div class="rts-register-area rts-section-gap bg_light-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="registration-wrapper-1">
                        <a href="{{ LaravelLocalization::localizeUrl('/') }}">
                            <div class="logo-area mb--0">
                                <img class="mb--10"
                                    src="{{ url('uploads/settings/source/' . $configration->about_image) }}"
                                    alt="logo">
                            </div>
                        </a>
                        <h3 class="title">@lang('home.login')</h3>
                        <form action="{{ route('login') }}" method="POST" class="registration-form">
                          @csrf
                            <div class="input-wrapper">
                                <label for="email">@lang('home.email')*</label>
                                <input type="email" required name="email" id="email"
                                    value="{{ old('email') }}">
                            </div>
                            <div class="input-wrapper">
                                <label for="password">@lang('home.password')*</label>
                                <input type="password"required name="password" id="password">
                            </div>
                            <button class="rts-btn btn-primary">@lang('home.login')</button>
                            <div class="another-way-to-registration">
                                <div class="registradion-top-text">
                                    <span>@lang('home.login_using')</span>
                                </div>
                                <div class="login-with-brand">
                                    <a href="{{ url('login/google') }}" class="single">
                                        <img src="{{ url('resources/assets/front/images/form/google.svg') }}"
                                            alt="login">
                                    </a>
                                    {{-- <a href="#" class="single">
                                        <img src="assets/images/form/facebook.svg" alt="login">
                                    </a> --}}
                                </div>
                                <p>{{ __('home.Haven_t an account yet?') . '  ' }} <a
                                        href="{{ LaravelLocalization::localizeUrl('register') }}">{{ trans('home.Create account') }}</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- rts register area end -->













    <!-- plugins js -->
    <script defer src="{{ Helper::jsFilesPath('plugins.js') }}"></script>

    <!-- custom js -->
    <script defer src="{{ Helper::jsFilesPath('main.js') }}"></script>
    <!-- header style two End -->
    <!-- remove when developing -->
    {{-- <!--  -->
    <script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script>
        $('#footer').load('footer.html')
    </script>
    <!--  --> --}}

</body>

</html>
