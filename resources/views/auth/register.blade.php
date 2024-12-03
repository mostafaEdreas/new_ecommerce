<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="description"
        content="Ekomart-Grocery-Store(e-Commerce) HTML Template: A sleek, responsive, and user-friendly HTML template designed for online grocery stores.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Grocery, Store, stores">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ config('site_app_name') }} @lang('home.login') </title>
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ url('uploads/settings/source/' . config('site_logo')) }}">
    <!-- plugins css -->
    <link rel="stylesheet preload" href="{{ Helper::cssFilesPath('plugins.css') }}" as="style">
    <link rel="stylesheet preload" href="{{ Helper::cssFilesPath('style.css') }}" as="style">
    <link rel="stylesheet preload" href="{{ Helper::cssFilesPath('Youseff.css') }}" as="style">
    <link rel="stylesheet preload" href="{{ Helper::cssFilesPath('styleRtl.css') }}" as="style">
</head>

<body>
    <!-- rts register area start -->
    <div class="rts-register-area rts-section-gap bg_light-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="registration-wrapper-1">
                        <a href="{{ LaravelLocalization::localizeUrl('/') }}">
                            <div class="logo-area mb--0">
                                <img class="mb--10" src="{{ url('uploads/settings/source/' . config('site_logo')) }}" alt="logo">
                            </div>
                        </a>
                        <h3 class="title">{{ trans('home.register') }}</h3>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('register') }}" class="registration-form">
                            @csrf
                            <div class="input-wrapper">
                                <label for="f_name">{{ trans('home.f_name') }}*</label>
                                <input type="text" id="f_name" name="f_name">

                            </div>

                            <div class="input-wrapper">
                                <label for="l_name">{{ trans('home.l_name') }}*</label>
                                <input type="text" id="l_name" name="l_name">
                            </div>

                            <div class="input-wrapper">
                                <label for="email">@lang('home.email')*</label>
                                <input type="email" id="email" name="email">

                            </div>
                            <div class="input-wrapper">
                                <label for="password">@lang('home.password')*</label>
                                <input type="password" id="password" name="password">

                            </div>

                            <div class="input-wrapper">
                                <label for="password_confirmation">@lang('home.confirm_password')*</label>
                                <input type="password" id="password_confirmation" name="password_confirmation">

                            </div>
                            <button class="rts-btn btn-primary">{{ trans('home.Create account') }}</button>
                            <div class="another-way-to-registration">
                                <div class="registradion-top-text">
                                    <span>@lang('home.login_using')</span>
                                </div>
                                <div class="login-with-brand">
                                    <a href="{{ LaravelLocalization::localizeUrl('login/google') }}" class="single">
                                        <img src="{{ url('resources/assets/front/images/form/google.svg') }}"
                                            alt="login">
                                    </a>
                                    {{-- <a href="#" class="single">
                                      <img src="assets/images/form/facebook.svg" alt="login">
                                  </a> --}}
                                </div>
                                <p>{{ trans('home.have an account back to login?') }} <a
                                        href="{{ LaravelLocalization::localizeUrl('/login') }}">{{ __('home.Login now') }}</a>
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
