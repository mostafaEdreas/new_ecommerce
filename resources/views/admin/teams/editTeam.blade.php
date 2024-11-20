@extends('layouts.admin')
<title>{{trans('home.edit_teams')}}</title>
@section('content')

<div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.teams')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/teams')}}">{{trans('home.teams')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.edit_team')}}</li>
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
                            <h6 class="card-title mb-1">{{trans('home.edit_team')}}</h6>
                        </div>
                        {!! Form::open(['method'=>'PATCH','url' => 'admin/teams/'.$team->id, 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">

                                <div class="form-group col-md-3">
                                    <label class="">{{trans('home.name')}}</label>
                                    <input class="form-control" name="name" type="text" placeholder="{{trans('home.name')}}" value="{{$team->name}}">
                                </div>
                                
                                <div class="form-group col-md-3">
                                    <label class="">{{trans('home.position')}}</label>
                                    <input class="form-control" name="position" type="text" placeholder="{{trans('home.position')}}" value="{{$team->position}}">
                                </div>
                                
                                <div class="form-group  col-md-3">
                                    <label>{{trans('home.image')}}</label>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> {{trans('home.upload')}}</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="img">
                                            <label class="custom-file-label" for="inputGroupFile01">{{trans('home.choose_image')}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="helperText">{{trans('home.lang')}}</label>
                                    <select class="form-control select2" name="lang" required>
                                        <option value="en">{{trans('home.english')}}</option>
                                        <option value="ar">{{trans('home.arabic')}}</option>
                                    </select>
                                </div>

                                @if($team->img)
                                    <div class="form-group  col-md-12">
                                        <img src="{{url('\uploads\teams\source')}}\{{$team->img}}" width="200" height="150">
                                    </div>
                                @endif
                                
                                <div class="form-group col-md-3">
                                    <label class="">{{trans('home.mobile')}}</label>
                                    <input class="form-control" name="mobile" type="text" placeholder="{{trans('home.mobile')}}" value="{{$team->mobile}}">
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="">{{trans('home.facebook')}}</label>
                                    <input class="form-control" name="facebook" type="text" placeholder="{{trans('home.facebook')}}" value="{{$team->facebook}}">
                                </div>
                                
                                <div class="form-group col-md-3">
                                    <label class="">{{trans('home.instagram')}}</label>
                                    <input class="form-control" name="instgram" type="text" placeholder="{{trans('home.instagram')}}" value="{{$team->instgram}}">
                                </div>
                                
                                <div class="form-group col-md-3">
                                    <label class="">{{trans('home.linkedin')}}</label>
                                    <input class="form-control" name="linkedin" type="text" placeholder="{{trans('home.linkedin')}}" value="{{$team->linkedin}}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="ckbox">
                                        <input name="status" value="1" {{($team->status == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                                    </label>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin/teams')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
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
