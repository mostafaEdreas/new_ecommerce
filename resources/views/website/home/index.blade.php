@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp
    @php echo $schema @endphp
@endsection
@section('content')


<div class="page-content bg-white">
    @include('website.home.sliders')
    @include('website.home.categories')
    @include('website.home.grouped-products')
    @include('website.home.products-have-discount')
    @include('website.home.about')
    @include('website.home.products')
    @include('website.home.about-strucs')
</div>

@endsection
@section('script')
@endsection