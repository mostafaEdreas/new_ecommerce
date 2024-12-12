@extends('layouts.admin')
<title>{{trans('home.edit_coupon')}}</title>
@section('content')

<div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.coupons')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/coupons')}}">{{trans('home.coupons')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.edit_coupon')}}</li>
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
                            <h6 class="card-title">{{trans('home.edit_coupon')}}</h6>
                        </div>
                        {!! Form::open(['method'=>'PATCH','url' => 'admin/coupons/'.$coupon->id, 'data-toggle'=>'validator', 'files'=>'true']) !!}
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="name">{{trans('home.name_en')}}</label>
                                <input type="text"  class="form-control" value="{{ $coupon->name_en }}" placeholder="{{trans('home.name_en')}}" name="name_en" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="name">{{trans('home.name_ar')}}</label>
                                <input type="text"  class="form-control" value="{{ $coupon->name_ar }}" placeholder="{{trans('home.name_ar')}}" name="name_ar" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="code">{{trans('home.code')}}</label>
                                <input type="text"  class="form-control" value="{{ $coupon->code }}" placeholder="{{trans('home.code')}}" name="code" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="code">{{trans('home.start_date')}}</label>
                                <input type='date' class="form-control " value="{{ \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d') }}" name="start_date" placeholder="{{trans('home.start_date')}}" id="datepicker" />

                            </div>
                            <div class="form-group col-md-6">
                                <label for="code">{{trans('home.end_date')}}</label>
                                <input type='date' class="form-control" value="{{ \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d') }}" name="end_date" placeholder="{{trans('home.end_date')}}" id="datepicker" />
                            </div>

                            <div class="form-group col-md-3">
                                <label for="code">{{trans('home.discount')}}</label>
                                <input type="number"  step="0.01" class="form-control" value="{{$coupon->discount}}" placeholder="{{trans('home.discount')}}" name="discount" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="discount_type">{{trans('home.discount_type')}}</label>
                                <select class="form-control select2" name="discount_type">
                                    <option @selected(!$coupon->discount_type) value="0">{{trans('home.value')}}</option>
                                    <option @selected($coupon->discount_type) value="1">{{trans('home.percentage')}}</option>
                                </select>
                            </div>


                            <div class="form-group col-md-3">
                                <label for="max_used">{{trans('home.max_used')}}</label>
                                <input type="number" min="0" value="{{$coupon->max_use}}" class="form-control" placeholder="{{trans('home.max_used')}}" name="max_use" value ="1" required>
                            </div>


                            <div class="form-group col-md-3">
                                <label for="order_min_price">{{trans('home.order_min_price')}}</label> <span>{{trans('home.order_price_in_egp')}}</span>
                                <input type="number" min="0" value="{{$coupon->min_price}}" class="form-control" placeholder="{{trans('home.order_min_price')}}" name="min_price" value="100" required>
                            </div>


                            <div class="col-md-12 ">
                                <label for="coupon_type">{{trans('home.type')}}</label>
                                <select class="form-control coupon_type select2" name="type">
                                    <option selected value="general">{{trans('home.general')}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                <a href="{{url('/admin/coupons')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
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

