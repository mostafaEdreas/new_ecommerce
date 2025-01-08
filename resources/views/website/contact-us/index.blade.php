@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp
    @php echo $schema @endphp
@endsection
@section('content')
    <div class="page-content">
        @include('website.contact-us.banner')
        <div class="contact-bnr">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        @include('website.contact-us.details')
                    </div>
                    <div class="col-lg-6">
                        @include('website.contact-us.form')
                    </div>
                </div>
            </div>
        </div>

        <div class="content-inner-2 pt-0">
            <div class="map-iframe map">
               <iframe src="{{config('site_map_url')}}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
@endsection
@section('script')
@include('website.contact-us.send-message', [
  'formName' => '#contactSubmit',
  'urlForm' => LaravelLocalization::localizeUrl('save/contact-us'),
])@endsection