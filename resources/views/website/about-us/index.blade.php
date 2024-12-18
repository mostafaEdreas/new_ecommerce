@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp
    @php echo $schema @endphp
@endsection
@section('content')
<div class="page-content">
</div>
    @include('website.partials.Home-Slideshow')
    @include('website.partials.seasonal_products')
    @include('website.partials.BestSelling')
    @include('website.partials.featured_products')

@endsection
@section('script')
@endsection