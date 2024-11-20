@extends('layouts.admin')
<title>{{trans('home.edit_shippingMethod')}}</title>
@section('content')

<div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.shippingMethods')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/shipping-methods')}}">{{trans('home.shippingMethods')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.edit_shippingMethod')}}</li>
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
                            <h6 class="card-title mb-1">{{trans('home.edit_shippingMethod')}}</h6>
                        </div>
                        {!! Form::open(['method'=>'PATCH','url' => 'admin/shipping-methods/'.$shippingMethod->id, 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">

                                <div class="form-group col-md-3">
                                    <label class="">{{trans('home.name_en')}}</label>
                                    <input class="form-control" name="name_en" type="text" placeholder="{{trans('home.name_en')}}"  value="{{$shippingMethod->name_en}}" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="">{{trans('home.name_ar')}}</label>
                                    <input class="form-control" name="name_ar" type="text" placeholder="{{trans('home.name_ar')}}" value="{{$shippingMethod->name_ar}}" >
                                </div>

                                <div class="col-md-2">
                                    <label>{{trans('home.logo')}}</label>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> {{trans('home.upload')}}</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="logo">
                                            <label class="custom-file-label" for="inputGroupFile01">{{trans('home.choose_logo')}}</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label for="value_type">{{trans('home.value_type')}}</label>
                                    <select class="form-control select2" name="value_type">
                                        <option value="value" {{($shippingMethod->value_type =='value')? 'selected':''}}>{{trans('home.value')}}</option>
                                        <option value="percentage" {{($shippingMethod->value_type =='percentage')? 'selected':''}}>{{trans('home.percentage')}}</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="">{{trans('home.value')}}</label>
                                    <input class="form-control" name="value" type="number" min="0" placeholder="{{trans('home.value')}}" value="{{$shippingMethod->value}}">
                                </div>

                                @if($shippingMethod->logo)
                                    <div class="col-md-12">
                                        <img src="{{url('\uploads\shippingMethods\source')}}\{{$shippingMethod->logo}}" width="150">
                                    </div>
                                @endif
                                
                                <div class="form-group col-md-6">
                                    <label class="">{{trans('home.text_en')}}</label>
                                    <textarea class="form-control" name="text_en" type="text" placeholder="{{trans('home.text_en')}}">{{$shippingMethod->text_en}}</textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="">{{trans('home.text_ar')}}</label>
                                    <textarea class="form-control" name="text_ar" type="text" placeholder="{{trans('home.text_ar')}}">{{$shippingMethod->text_ar}}</textarea>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="ckbox">
                                        <input name="status" value="1" {{($shippingMethod->status == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                                    </label>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin/shipping-methods')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
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
