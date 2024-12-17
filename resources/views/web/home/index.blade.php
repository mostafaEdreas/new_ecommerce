@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp
    @php echo $schema @endphp
@endsection
@section('content')


<div class="page-content bg-white">
    @include('web.home.sliders')
    @include('web.home.categories')
    @include('web.home.grouped-products')
    @include('web.home.products-have-discount')
    @include('web.home.about')
    @include('web.home.products')
    @include('web.home.about-strucs')
</div>

@endsection
@section('script')
@endsection