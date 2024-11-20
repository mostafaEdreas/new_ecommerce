@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp

    @php echo $schema @endphp
@endsection
@section('content')

@include('website.partials.blogs')
@endsection

