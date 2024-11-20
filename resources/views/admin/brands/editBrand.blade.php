@extends('layouts.admin')
@section('meta')
<title>{{trans('home.edit_brand')}}</title>
@endsection
@section('content')

<div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.brands')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/brands')}}">{{trans('home.brands')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.edit_brand')}}</li>
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
                            <h6 class="card-title mb-1">{{trans('home.edit_brand')}}</h6>
                        </div>
                        {!! Form::open(['method'=>'PATCH','url' => 'admin/brands/'.$brand->id, 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label class="">{{trans('home.name_en')}}</label>
                                    <input class="form-control" name="name_en" type="text" placeholder="{{trans('home.name_en')}}"  value="{{$brand->name_en}}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="">{{trans('home.name_ar')}}</label>
                                    <input class="form-control" name="name_ar" type="text" placeholder="{{trans('home.name_ar')}}" value="{{$brand->name_ar}}" >
                                </div>
                                     <div class="form-group col-md-3">
                                    <label class="">Rate 1:5</label>
                                    <input  class="form-control" name="rate" type="number" value="{{$brand->rate}}"  placeholder="rate 1:5">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="">quality</label>
                                    <input class="form-control" name="quality" type="number" value="{{$brand->quality}}"  placeholder="quality">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="">answer speed</label>
                                    <input class="form-control" name="answer_speed" type="number" value="{{$brand->answer_speed}}"  placeholder="answer speed">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="">overall rate</label>
                                    <input class="form-control" name="overall_rate" type="number" value="{{$brand->overall_rate}}"  placeholder="overall rate">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="">{{trans('home.address')}}</label>
                                    <input class="form-control" name="address" type="text" value="{{$brand->address}}"  placeholder="{{trans('home.address')}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="">{{trans('home.phone')}}</label>
                                    <input class="form-control" name="phone" type="tel" value="{{$brand->phone}}"  placeholder="{{trans('home.phone')}}">
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="">{{trans('home.text')}}</label>
                                    <textarea class="form-control area1"  name="text" type="text" placeholder="{{trans('home.text')}}">{{$brand->text}}</textarea>
                                </div>


                                <div class="col-md-6">
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

                                <div class="col-md-6">
                                    @if($brand->logo)
                                    <img src="{{url('\uploads\brands\resize200')}}\{{$brand->logo}}" width="150">
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="ckbox">
                                        <input name="status" value="1" {{($brand->status == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                                    </label>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="ckbox">
                                        <input name="view_products" value="1" {{($brand->view_products == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.view_products')}}</span>
                                    </label>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="ckbox">
                                        <input name="menu" value="1" {{($brand->menu == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.menu')}}</span>
                                    </label>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <hr>
                                            <span class="badge badge-success">{{trans('home.en')}}</span>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="name_ar">{{trans('home.link')}}</label>
                                            <input type="text" autocomplete="off"  class="form-control" placeholder="{{trans('home.link')}}" name="link_en" value="{{$brand->link_en}}">
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="meta_title"> {{trans('home.meta_title')}}</label>
                                            <textarea class="form-control" name="meta_title_en" placeholder="{{trans('home.meta_title')}}">{{$brand->meta_title_en}}</textarea>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="meta_desc"> {{trans('home.meta_desc')}}</label>
                                            <textarea class="form-control" name="meta_desc_en" placeholder="{{trans('home.meta_desc')}}">{{$brand->meta_desc_en}}</textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <hr>
                                            <span class="badge badge-success">{{trans('home.ar')}}</span>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="name_ar">{{trans('home.link')}}</label>
                                            <input type="text" autocomplete="off"  class="form-control" placeholder="{{trans('home.link')}}" name="link_ar" value="{{$brand->link_ar}}">
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="meta_title"> {{trans('home.meta_title')}}</label>
                                            <textarea class="form-control" name="meta_title_ar" placeholder="{{trans('home.meta_title')}}">{{$brand->meta_title_ar}}</textarea>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="meta_desc"> {{trans('home.meta_desc')}}</label>
                                            <textarea class="form-control" name="meta_desc_ar" placeholder="{{trans('home.meta_desc')}}">{{$brand->meta_desc_ar}}</textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="ckbox">
                                                <input name="meta_robots" value="1" {{($brand->meta_robots == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.meta_robots')}} (index)</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin/brands')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
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
