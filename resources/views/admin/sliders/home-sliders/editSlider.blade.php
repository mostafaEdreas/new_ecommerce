@extends('layouts.admin')
<title>{{trans('home.edit_slider')}}</title>
@section('content')

<div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.sliders')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/sliders')}}">{{trans('home.sliders')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.edit_slider')}}</li>
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
                            <h6 class="card-title mb-1">{{trans('home.edit_slider')}}</h6>
                        </div>
                        {!! Form::open(['method'=>'PATCH','url' => 'admin/sliders/'.$slider->id, 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">
                               
                                <div class="form-group col-md-4">
                                    <label class="">{{trans('home.title_en')}}</label>
                                    <input class="form-control" name="title_en" type="text" placeholder="{{trans('home.title_en')}}" value="{{$slider->title_en}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="">{{trans('home.title_ar')}}</label>
                                    <input class="form-control" name="title_ar" type="text" placeholder="{{trans('home.title_ar')}}" value="{{$slider->title_ar}}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="">{{trans('home.order')}}</label>
                                    <input class="form-control" name="order" type="number" min="0" autocomplete="off" placeholder="{{trans('home.order')}}" value="{{$slider->order}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="">{{trans('home.text_en')}}</label>
                                    <input class="form-control" name="text_en" type="text" placeholder="{{trans('home.text_en')}}" value="{{$slider->text_en}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="">{{trans('home.text_ar')}}</label>
                                    <input class="form-control" name="text_ar" type="text" placeholder="{{trans('home.text_ar')}}" value="{{$slider->text_ar}}">
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="">{{trans('home.video_link')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{trans('home.video_link')}}</span>
                                        </div>
                                        <input type="text" class="form-control" name="video_link" placeholder="{{trans('home.video_link')}}"  value="{{$slider->video_link}}">
                                    </div>
                                </div>
                                @if ($slider->video_link)
                                    <div class="embed-responsive col-md-4 embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" src="{{$slider->video_link}}" allowfullscreen></iframe>
                                    </div>
                                @endif

                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <div class="form-group  col-md-10">
                                            <label>{{trans('home.image')}} (max 1mb, extension must .webp)</label>
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

                                        <div class="form-group  col-md-2">
                                            <img src="{{$slider->image_200}}" width="350" height="150">   
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group col-md-4">
                                    <label class="ckbox">
                                        <input name="status" value="1" {{($slider->status == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                                    </label>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin/sliders')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
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
