@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp
    @php echo $schema @endphp
@endsection
@section('content')
    <div class="page-content">
        @include('website.about-us.banner')
        @include('website.about-us.about')
        @include('website.about-us.aboutStrucs')
    </div>
@endsection
@section('script')
@endsection