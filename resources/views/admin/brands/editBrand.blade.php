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
                            <div class="form-group col-md-4">
                                <label class="">{{trans('home.name_en')}}</label>
                                <input class="form-control" name="name_en" type="text" placeholder="{{trans('home.name_en')}}"  value="{{$brand->name_en}}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="">{{trans('home.name_ar')}}</label>
                                <input class="form-control" name="name_ar" type="text" placeholder="{{trans('home.name_ar')}}" value="{{$brand->name_ar}}" required>
                            </div>


                             <div class="form-group col-md-4">
                                <label class="">{{trans('home.order')}}</label>
                                <input class="form-control" name="order" type="number" min="0" placeholder="{{trans('home.order')}}" value="{{$brand->order}}">
                            </div>

                            <div class="col-md-6">
                                <label>{{trans('home.image')}} (225px  * 225px max 1mb)</label>
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

                            <div class="col-md-6">
                                <label>{{trans('home.icon')}} (50px  * 50px max 1mb)</label>
                                <div class="input-group mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> {{trans('home.upload')}}</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="icon">
                                        <label class="custom-file-label" for="inputGroupFile01">{{trans('home.choose_icon')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-12">
                                <div class="col-md-6">
                                    @if($brand->image)
                                        <img src="{{$brand->image_200}}" width="150">
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    @if($brand->icon)
                                        <img src="{{$brand->icon_200}}" width="150">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="">{{trans('home.desc_en')}}</label>
                                <textarea class="form-control area1" name="text_en" type="text" placeholder="{{trans('home.desc_en')}}" >{{$brand->desc_en}}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{trans('home.desc_ar')}}</label>
                                <textarea class="form-control area1" name="text_ar" type="text" placeholder="{{trans('home.desc_ar')}}">{{$brand->desc_ar}}</textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="ckbox">
                                    <input name="status" value="1" {{($brand->status == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                                </label>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <hr>
                                        <span class="badge badge-success">{{trans('home.en')}}</span>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="name_ar">{{trans('home.link_en')}}</label>
                                        <input type="text" autocomplete="off"  class="form-control" placeholder="{{trans('home.link')}}" name="link_en" value="{{$brand->link_en}}">
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="meta_title"> {{trans('home.meta_title_en')}}</label>
                                        <textarea class="form-control" name="meta_title_en" placeholder="{{trans('home.meta_title_en')}}">{{$brand->meta_title_en}}</textarea>
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="meta_desc"> {{trans('home.meta_desc_en')}}</label>
                                        <textarea class="form-control" name="meta_desc_en" placeholder="{{trans('home.meta_desc_en')}}">{{$brand->meta_desc_en}}</textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <hr>
                                        <span class="badge badge-success">{{trans('home.ar')}}</span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="name_ar">{{trans('home.link_ar')}}</label>
                                        <input type="text" autocomplete="off"  class="form-control" placeholder="{{trans('home.link_ar')}}" name="link_ar" value="{{$brand->link_ar}}">
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="meta_title"> {{trans('home.meta_title_ar')}}</label>
                                        <textarea class="form-control" name="meta_title_ar" placeholder="{{trans('home.meta_title_ar')}}">{{$brand->meta_title_ar}}</textarea>
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="meta_desc"> {{trans('home.meta_desc_ar')}}</label>
                                        <textarea class="form-control" name="meta_desc_ar" placeholder="{{trans('home.meta_desc_ar')}}">{{$brand->meta_desc_ar}}</textarea>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <hr>
                                        <span class="badge badge-success">{{trans('home.ar')}}</span>
                                    </div>


                                    <div class="form-group col-md-12">
                                        <label class="ckbox">
                                            <input name="index" value="1" {{($brand->index == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.meta_robots')}} (index)</span>
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
