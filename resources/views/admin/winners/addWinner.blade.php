@extends('layouts.admin')
<title>{{trans('home.add_winner')}}</title>
@section('content')

<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.winners')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/winners')}}">{{trans('home.winners')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.add_winner')}}</li>
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
                            <h6 class="card-title mb-1">{{trans('home.add_winner')}}</h6>
                        </div>
                        {!! Form::open(['route' => 'winners.store', 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">

                                <div class="form-group col-md-4">
                                    <label class="name">{{trans('home.name')}}</label>
                                    <input class="form-control" name="name" type="text" placeholder="{{trans('home.name')}}" required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="">{{trans('home.email')}}</label>
                                    <input class="form-control" name="email" type="email" placeholder="{{trans('home.email')}}">
                                </div>
                                
                                <div class="form-group col-md-4">
                                    <label class="">{{trans('home.phone')}}</label>
                                    <input class="form-control" name="phone" type="number" min="0" placeholder="{{trans('home.phone')}}">
                                </div>

                                <div class="col-md-8">
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
                                
                                <div class="form-group col-md-3">
                                    <label class="">{{trans('home.text')}}</label>
                                    <input class="form-control" name="text" type="text" placeholder="{{trans('home.text')}}">
                                </div>
                                
                                <div class="form-group col-md-1">
                                    <label class="">{{trans('home.order')}}</label>
                                    <input class="form-control" name="order" type="number" min="0" placeholder="{{trans('home.order')}}">
                                </div>
                                
                                <div class="form-group col-md-4">
                                    <label class="ckbox">
                                        <input name="status" value="1" type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                                    </label>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin/winners')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
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

