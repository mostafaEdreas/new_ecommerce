@extends('layouts.admin')
<title>{{trans('home.add_menu')}}</title>
@section('content')

<div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.menus')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/menus')}}">{{trans('home.menus')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.add_menu')}}</li>
                </ol>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">

                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{trans('home.add_menu')}}</h6>
                        </div>
                        {!! Form::open(['route' => 'menus.store', 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">
                                <input type="hidden" name="type" value="main">
                                <div class="form-group col-md-4">
                                    <label class="">{{trans('home.name_en')}}</label>
                                    <input class="form-control" name="name_en" type="text" placeholder="{{trans('home.name_en')}}" value="{{old('name_en')}}" required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="">{{trans('home.name_ar')}}</label>
                                    <input class="form-control" name="name_ar" type="text" placeholder="{{trans('home.name_ar')}}"  value="{{old('name_ar')}}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="">{{trans('home.order')}}</label>
                                    <input class="form-control" name="order" type="number" value="1" min="1" step="1" placeholder="{{trans('home.order')}}"  value="{{old('order')}}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="parent">{{trans('home.parent')}}</label>
                                    <select class="form-control select2" name="parent_id">
                                    <option disabled>{{trans('home.no_parent')}}</option>
                                    <option value="null" {{ !old('parent_id') ? 'selected' : '' }}>{{ trans('home.no_parent') }}</option>
                                        @foreach($menus as $menu)
                                            <option value="{{$menu->id}}" @selected(old('parent_id') == $menu->id)>{{(app()->getLocale()=='en')? $menu->name_en:$menu->name_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @php
                                    $options = [
                                        'home' => trans('home.home'),
                                        'about-us' => trans('home.about-us'),
                                        'contact-us' => trans('home.contact-us'),
                                        'category' => trans('home.category'),
                                        'categories' => trans('home.categories'),
                                        'product' => trans('home.product'),
                                        'products' => trans('home.products'),
                                        'bestSeller' => trans('home.bestSeller_products'),
                                        'brand' => trans('home.brand'),
                                        'brands' => trans('home.brands'),
                                        'blogs' => trans('home.blogs'),
                                    ];
                                    $selectedValue = old('segment'); // Replace 'type' with the name of the select input
                                @endphp
                                <div class="form-group col-md-4">
                                    <label for="">{{trans('home.link')}}</label>
                                    <select name="segment" class="form-control select2">
                                        <option value="null" {{ is_null($selectedValue) ? 'selected' : '' }}>{{ trans('home.link') }}</option>
                                        @foreach ($options as $value => $label)
                                            <option value="{{ $value }}" {{ $value == $selectedValue ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="ckbox">
                                        <input name="status" value="1" type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                                    </label>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin/menus')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
                                </div>

                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>

@endsection

