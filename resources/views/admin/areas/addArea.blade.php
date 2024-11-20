@extends('layouts.admin')
<title>{{trans('home.add_area')}}</title>
@section('content')



<div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.areas')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/areas')}}">{{trans('home.areas')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.add_area')}}</li>
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
                            <h6 class="card-title mb-1">{{trans('home.add_area')}}</h6>
                        </div>
                        {!! Form::open(['route' => 'areas.store', 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">

                                <div class="form-group col-md-3">
                                    <label class="">{{trans('home.name_en')}}</label>
                                    <input class="form-control" name="name_en" type="text" placeholder="{{trans('home.name_en')}}" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="">{{trans('home.name_ar')}}</label>
                                    <input class="form-control" name="name_ar" type="text" placeholder="{{trans('home.name_ar')}}">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="parent">{{trans('home.region')}}</label>
                                    <select class="form-control select2" name="region_id">
                                        @foreach($regions as $region)
                                            <option value="{{$region->id}}">{{(app()->getLocale()=='en')? $region->name_en:$region->name_ar}}</option>
                                        @endforeach    
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-3">
                                    <label class="">{{trans('home.shipping_fees')}} (rate)</label>
                                    <input class="form-control" name="shipping_fees" type="number" min="0" placeholder="{{trans('home.shipping_fees')}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="ckbox">
                                        <input name="status" value="1" type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                                    </label>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label class="ckbox">
                                        <input name="available_beranche" value="1" type="checkbox"><span class="tx-13">{{trans('home.available_beranche')}}</span>
                                    </label>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin/areas')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
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

