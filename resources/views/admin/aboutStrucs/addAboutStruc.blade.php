@extends('layouts.admin')
@section('meta')
<title>{{trans('home.add_aboutStruc')}}</title>
@endsecti
@section('content')

<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.aboutStrucs')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/aboutStrucs')}}">{{trans('home.aboutStrucs')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.add_aboutStruc')}}</li>
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
                            <h6 class="card-title mb-1">{{trans('home.add_aboutStruc')}}</h6>
                        </div>
                        {!! Form::open(['route' => 'aboutStrucs.store', 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label class="">{{trans('home.name_en')}}</label>
                                    <input class="form-control" name="name_en" type="text" placeholder="{{trans('home.name_en')}}" required value="{{old('name_en')}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="">{{trans('home.name_ar')}}</label>
                                    <input class="form-control" name="name_ar" type="text" placeholder="{{trans('home.name_ar')}}" value="{{old('name_ar')}}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="">{{trans('home.text_en')}}</label>
                                    <textarea class="form-control" name="text_en"  placeholder="{{trans('home.text_en')}}">{!! old('text_en') !!}</textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="">{{trans('home.text_ar')}}</label>
                                    <textarea class="form-control" name="text_ar"  placeholder="{{trans('home.text_ar')}}">{!! old('text_ar') !!}</textarea>
                                </div>

                                <div class="col-md-12">
                                    <label>{{trans('home.image')}}</label>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> {{trans('home.upload')}}</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image">
                                            <label class="custom-file-label" for="inputGroupFile01">{{trans('home.choose_image')}}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="ckbox">
                                        <input name="status" value="{{old('status') ?? 1}}" type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                                    </label>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin/aboutStrucs')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
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

