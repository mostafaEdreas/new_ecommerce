@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp

    @php echo $schema @endphp
@endsection
@section('content')



    <div class="rts-contact-main-wrapper-banner bg_image">
        <div class="container">
            <div class="row">
                <div class="co-lg-12">
                    <div class="contact-banner-content">
                        <h1 class="title">
                            @lang('home.contact-us')
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="rts-map-contact-area rts-section-gap2">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="contact-left-area-main-wrapper">

                        <div class="location-single-card">
                            <div class="icon">
                                <i class="fa-light fa-location-dot"></i>
                            </div>
                            <div class="information">
                                <h3 class="title">@lang('home.address')</h3>
                                <p>{{$addresses[0]->{'address_'.$lang} }}</p>
                            </div>
                        </div>
                        <div class="location-single-card">
                            <div class="icon">
                                <i class="fa-light fa-mobile-iphone"></i>
                            </div>
                            <div class="information">
                                <h3 class="title">@lang('home.phone')</h3>
                                <p class="mb-3"><a href="tel:+2{{$setting->mobile}}">{{$setting->mobile}}</a></p>
                            </div>
                        </div>
                        <div class="location-single-card">
                            <div class="icon">
                                <i class="fa-light fa-laptop-mobile"></i>
                            </div>
                            <div class="information">
                                <h3 class="title">@lang('home.social_media')</h3>
                                @if ($setting->facebook)
                                <a href="{{$setting->facebook}}" class="email mb-1">{{$setting->facebook}}</a>
                                @endif
                                @if ($setting->twitter)
                                <a href="{{$setting->twitter}}" class="email mb-1">{{$setting->twitter}}</a>
                                @endif
                                @if ($setting->instagram)
                                <a href="{{$setting->instagram}}" class="email mb-1">{{$setting->instagram}}</a>
                                @endif

                            </div>
                        </div>
                        <div class="location-single-card">
                            <div class="icon">
                                <i class="fa-light fa-mail-bulk"></i>
                            </div>
                            <div class="information">
                                <h3 class="title">@lang('home.email')</h3>
                                <a href="https://gohinstores.com/en" class="email mb-2">www.gohinstores.com</a>
                                <a href="mailto:{{$setting->email}}" class="email">{{$setting->email}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 pl--50 pl_sm--5 pl_md--5">
                    <iframe  src="{{$setting->map_url}}" width="600" height="540" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>

        <!-- rts contact-form area start -->
        <div class="rts-contact-form-area rts-section-gapBottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bg_light-1 contact-form-wrapper-bg">
                            <div class="row">
                                <div class="col-lg-7 pr--30 pr_md--10 pr_sm--5">
                                    <div class="contact-form-wrapper-1">
                                        <h3 class="title mb--50">املأ النموذج إذا كان لديك أي سؤال:</h3>
                                        <form action="{{LaravelLocalization::localizeUrl('save/contact-us')}}" method="post" class="contact-form-1" id="contactSubmit">
                                            <div class="contact-form-wrapper--half-area">
                                                <div class="single">
                                                    <input type="text" name="name" placeholder="@lang('home.name')*">
                                                </div>
                                                <div class="single">
                                                    <input type="text" name="phone" placeholder="@lang('home.phone')*">
                                                </div>
                                            </div>
                                            <div class="contact-form-wrapper--half-area">
                                                <div class="single">
                                                    <input name="email" type="text" placeholder="@lang('home.email')*">
                                                </div>
                                            </div>
                                            {{-- <div class="single-select">
                                                <select>
                                                    <option data-display="اختر المحتوي*">All Categories</option>
                                                    <option value="1">Some option</option>
                                                    <option value="2">Another option</option>
                                                    <option value="3" disabled>A disabled option</option>
                                                    <option value="4">Potato</option>
                                                </select>
                                            </div> --}}
                                            <textarea name="message" placeholder="@lang('home.message')"></textarea>
                                            <button class="size mt--10">@lang('home.send')</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-5 mt_md--30 mt_sm--30">
                                    <div class="thumbnail-area">
                                        <img class="img_contact tilted" src="{{url('resources/assets/front/images/contact/-2.jpg')}}" alt="contact_form">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- rts contact-form area end -->
@endsection

@section('script')
@include('website.partials.show-message', [
  'formName' => '#contactSubmit',
  'urlForm' => LaravelLocalization::localizeUrl('save/contact-us'),
])
    {{-- <script>
        $('form#contact_form').submit(function () {
            $(this).find(':input[type=submit]').prop('disabled', true);
        });

        function initMap() {
            var uluru = {lat: {{$setting->lat}}, lng: {{$setting->lng}}};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 16,
                center: uluru
            });
            var marker = new google.maps.Marker({
                position: uluru,
                map: map
            });
        }
    </script>

    @if(Session::has('contact_message'))
        <script>
            toastr.success("{{ Session::get('contact_message') }}");
        </script>
    @endif
    @php
        Session::forget('contact_message')
    @endphp

    @if($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        </script>
    @endif --}}


@endsection
