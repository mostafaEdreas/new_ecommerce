@extends('layouts.admin')
<title>{{trans('home.add_delivery')}}</title>
@section('content')



<div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.deliveries')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/deliveries')}}">{{trans('home.deliveries')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.add_delivery')}}</li>
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
                            <h6 class="card-title">{{trans('home.add_delivery')}}</h6>
                        </div>
                        {!! Form::open(['route' => 'deliveries.store', 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">
                                <div class="col-md-3">   
                                    <fieldset class="form-group">
                                        <label for="name">{{trans('home.name')}}</label>
                                        <input type="text"  class="form-control" placeholder="{{trans('home.name')}}" name="name" required>
                                    </fieldset>
                                </div>

                                <div class="col-md-3">
                                    <fieldset class="form-group">
                                        <label for="phone1">{{trans('home.phone1')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-phone"></i>
                                                </span>
                                            </div>
                                            <input type="number" min="0" class="form-control" placeholder="{{trans('home.phone1')}}" name="phone1" autocomplete="off" required>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-3">
                                    <fieldset class="form-group">
                                        <label for="phone2">{{trans('home.phone2')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-phone"></i>
                                                </span>
                                            </div>
                                            <input type="number" min="0" class="form-control" placeholder="{{trans('home.phone2')}}" name="phone2"autocomplete="off" >
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-3">
                                    <fieldset class="form-group">
                                        <label for="helperText">{{trans('home.status')}}</label>
                                        <select class="form-control status select2" name="status" required>
                                            <option value="active">{{trans('home.active')}}</option>
                                            <option value="inactive">{{trans('home.inactive')}}</option>
                                            <option value="block">{{trans('home.block')}}</option>
                                        </select>
                                    </fieldset>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin/deliveries')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
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