@extends('layouts.admin')
@section('meta')
    <title>{{trans('home.Free Shipping')}}</title>
@endsection
@section('content')

    <div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.Free Shipping')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.Free Shipping')}}</li>
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
                            <h6 class="card-title mb-1">{{trans('home.edit_setting')}}</h6>
                        </div>
                        {!! Form::open(['method'=>'POST','url' => 'admin/update_free_shipping', 'data-toggle'=>'validator']) !!}
                        <div class="row">

                            <div class="form-group col-md-2">
                                <label class="">{{trans('home.Free Shipping start at')}}</label>
                                <input type="text" class="form-control"
                                       name="free_shipping" value="{{ number_format($settings->free_shipping, 2, ',', '.') }}" >
                            </div>
                            <div class="form-group col-md-2">
                                <label class="ckbox">
                                    <input name="free_shipping_status" value="1" {{($settings->free_shipping_status == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                                </label>
                            </div>


                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i
                                        class="icon-note"></i> {{trans('home.save')}} </button>
                                <a href="{{url('/admin')}}">
                                    <button type="button" class="btn btn-danger mr-1"><i
                                            class="icon-trash"></i> {{trans('home.cancel')}}</button>
                                </a>
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
