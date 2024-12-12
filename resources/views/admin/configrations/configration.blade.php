@extends('layouts.admin')
@section('meta')
    <title>{{trans('home.edit_configration')}} {{trans("home.$edit_lang")}}</title>
@endsection
@section('content')

<div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.edit_configration')}} {{trans("home.$edit_lang")}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.edit_configration')}} {{trans("home.$edit_lang")}}</li>
                </ol>
            </div>
        </div>
        <!-- End Page Header -->

        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->pull('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">

                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{trans('home.edit_configration')}} {{trans("home.$edit_lang")}}</h6>
                        </div>
                        {!! Form::open(['method'=>'PATCH','url' => 'admin/configrations/'.$edit_lang, 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">

                                <div class="form-group col-md-12">
                                    <label for="app_name">{{trans('home.app_name')}}</label>
                                    <input type="text"  class="form-control" placeholder="{{trans('home.app_name')}}" name="app_name" value="{{ config('site_app_name') }}">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="app_name">{{trans('home.top text')}}</label>
                                    <input type="text"  class="form-control" placeholder="{{trans('home.top text')}}" name="top_text" value="{!! config('site_top_text') !!}">
                                </div>

                                <div class="form-group col-md-12">
                                    <fieldset class="form-group">
                                        <label for="about_app">{{trans('home.about_app')}}</label>
                                        <textarea class="form-control area1" placeholder="{{trans('home.about_app')}}" name="about_app"> {!! config('site_about_app') !!}</textarea>
                                    </fieldset>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>{{trans('home.app_logo')}}</label>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> {{trans('home.upload')}}</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="logo">
                                            <label class="custom-file-label" for="inputGroupFile01">{{trans('home.choose_image')}}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>{{trans('home.app_footer_logo')}}</label>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> {{trans('home.upload')}}</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="logo_footer">
                                            <label class="custom-file-label" for="inputGroupFile01">{{trans('home.choose_image')}}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>favicon</label>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> {{trans('home.upload')}}</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="favicon">
                                            <label class="custom-file-label" for="inputGroupFile01">{{trans('home.choose_image')}}</label>
                                        </div>
                                    </div>
                                </div>

                                 <div class="form-group col-md-3">
                                    <label>{{trans('home.inspection_request_image')}}</label>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> {{trans('home.upload')}}</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="inspection_image">
                                            <label class="custom-file-label" for="inputGroupFile01">{{trans('home.choose_image')}}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <img src="{{config('image_200_logo')}}" width="150">
                                </div>



                                <div class="form-group col-md-3">
                                    <img src="{{ config('image_200_logo_footer')}}" width="150">
                                </div>

                                <div class="form-group col-md-3">
                                    <img src="{{config('image_200_favicon')}}" width="150">
                                </div>

                                <div class="form-group col-md-3">
                                    <img src="{{ config('image_200_inspection_image')}}" width="150">
                                </div>



                                <div class="form-group col-md-6">
                                    <fieldset class="form-group">
                                        <label for="address1">{{trans('home.address1')}}</label>
                                        <input type="text" class="form-control" placeholder="{{trans('home.address1')}}" name="address1" value="{{ config('site_address1') }}">
                                    </fieldset>
                                </div>

                                <div class="form-group col-md-6">
                                    <fieldset class="form-group">
                                        <label for="address2">{{trans('home.address2')}}</label>
                                        <input type="text" class="form-control" placeholder="{{trans('home.address2')}}" name="address2" value="{{ config('site_address2') }}">
                                    </fieldset>
                                </div>


                                <div class="form-group col-md-6">
                                    <label>{{trans('home.place_order_msg')}}</label>
                                    <textarea class="form-control" name="place_order_msg" type="text" placeholder="{{trans('home.place_order_msg')}}">{{config('site_place_order_msg')}}</textarea>
                                </div>


                                <div class="form-group col-md-6">
                                    <label>{{trans('home.place_order_msg')}}</label>
                                    <textarea class="form-control" name="place_order_message" type="text" placeholder="{{trans('home.place_order_msg')}}">{{config('site_place_order_msg')}}</textarea>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
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
