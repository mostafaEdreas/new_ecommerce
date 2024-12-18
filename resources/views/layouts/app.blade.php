<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}">

    <head>
        @include('website.head')
    </head>

    <body>
        <div class="page-wraper" id="scroll-container">
            @include('website.loader')
            @include('website.headers.index')
            @yield('content')
            <!-- Footer -->
            @include('website.footer.index')
            <!-- Footer End -->
            @include('website.socialite-and-scroltop')
            <!-- Designed by Mohamed Seif -->
            <!-- Modal -->
        </div>
        @include('website.scripts.index')

        @yield('script')

        @include('website.scripts.session-messages')

    </body>

</html>
