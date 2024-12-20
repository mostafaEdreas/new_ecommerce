@extends('layouts.admin')
@section('meta')
<title>{{trans('home.edit_page')}}</title>
@endsection
@section('content')

<div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.pages')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/pages')}}">{{trans('home.pages')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.edit_page')}}</li>
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
                            <h6 class="card-title mb-1">{{trans('home.edit_page')}}</h6>
                        </div>
                        {!! Form::open(['method'=>'PATCH','url' => 'admin/pages/'.$page->id, 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">

                            <div class="form-group col-md-6">
                                    <label class="">{{trans('home.title_en')}}</label>
                                    <input class="form-control" name="title_en" type="text" placeholder="{{trans('home.title_en')}}" value="{{$page->title_en}}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="">{{trans('home.title_ar')}}</label>
                                    <input class="form-control" name="title_ar" type="text" placeholder="{{trans('home.title_ar')}}" value="{{$page->title_ar}}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="text_en"> {{trans('home.text_en')}}</label>
                                    <textarea class="area1" name="text_en">{!! $page->text_en !!}</textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="text_ar"> {{trans('home.text_ar')}}</label>
                                    <textarea class="area1" name="text_ar">{!! $page->text_ar !!}</textarea>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="ckbox">
                                        <input name="status" value="1" {{($page->status == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                                    </label>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <hr>
                                            <span class="badge badge-success">{{trans('home.en')}}</span>
                                        </div>
                                        <div class="form-group col-md-6">-->
                                            <label for="meta_title"> {{trans('home.meta_title')}}</label>
                                            <textarea class="form-control" name="meta_title_en" placeholder="{{trans('home.meta_title')}}">{{$page->meta_title_en}}</textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="meta_desc"> {{trans('home.meta_desc')}}</label>
                                            <textarea class="form-control" name="mete_description_en" placeholder="{{trans('home.meta_desc')}}">{{$page->mete_description_en}}</textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <hr>
                                            <span class="badge badge-success">{{trans('home.ar')}}</span>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="meta_title"> {{trans('home.meta_title')}}</label>
                                            <textarea class="form-control" name="meta_title_ar" placeholder="{{trans('home.meta_title')}}">{{$page->meta_title_ar}}</textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="meta_desc"> {{trans('home.meta_desc')}}</label>
                                            <textarea class="form-control" name="mete_description_ar" placeholder="{{trans('home.meta_desc')}}">{{$page->mete_description_ar}}</textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="ckbox">
                                                <input name="index" checked value="1" {{($page->index == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.meta_robots')}} (index)</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin/pages')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
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
