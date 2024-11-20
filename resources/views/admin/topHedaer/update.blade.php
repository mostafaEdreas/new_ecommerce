@extends('layouts.admin')
<title>{{trans('home.topHeader')}}</title>
@section('content')

<div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.topHeader')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.topHeader')}}</li>
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

        {!! Form::open(['method'=>'PATCH','url' => 'admin/top_header', 'data-toggle'=>'validator']) !!}
            <!-- Row-->
                <div class="row">
                    <div class="col-sm-12 col-xl-12 col-lg-12">
                        <div class="card custom-card overflow-hidden">

                            <div class="card-body">
                                <div>
                                    <h6 class="card-title mb-1">{{trans('home.top_header')}}</h6>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input class="form-control" name="text" placeholder="{{trans('home.top_header')}}" value="{{$TopHeader->text}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Row-->
                <div class="row">
                    <div class="col-sm-12 col-xl-12 col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                        <a href="{{url('/admin')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <!-- End Row -->

        {!! Form::close() !!}
    </div>
@endsection
