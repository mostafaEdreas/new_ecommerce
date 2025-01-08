<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/x-icon" href="{{config('site_favicon')}}">

<!-- plugins css -->
@yield('meta')

@include('layouts.partials.hreflang')
<link rel="stylesheet" type="text/css" href="{{Helper::frontFilesPath('vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{Helper::frontFilesPath('icons/fontawesome/css/all.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{Helper::frontFilesPath('icons/themify/themify-icons.css')}}">
<link rel="stylesheet" type="text/css" href="{{Helper::frontFilesPath('icons/flaticon/flaticon_mooncart.css')}}">
<link rel="stylesheet" type="text/css" href="{{Helper::frontFilesPath('vendor/swiper/swiper-bundle.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{Helper::frontFilesPath('vendor/nouislider/nouislider.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{Helper::frontFilesPath('vendor/animate/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{Helper::frontFilesPath('vendor/lightgallery/dist/css/lightgallery.css')}}">
<link rel="stylesheet" type="text/css" href="{{Helper::frontFilesPath('vendor/lightgallery/dist/css/lg-thumbnail.css')}}">
<link rel="stylesheet" type="text/css" href="{{Helper::frontFilesPath('vendor/lightgallery/dist/css/lg-zoom.css')}}">
<link rel="stylesheet" type="text/css" href="{{Helper::frontFilesPath('css/style.css')}}">


<!-- GOOGLE FONTS-->
<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&amp;family=Roboto:wght@100;300;400;500;700;900&amp;display=swap"rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" type="text/css" href="{{Helper::frontFilesPath('css/toastr.css')}}">


@yield('style')