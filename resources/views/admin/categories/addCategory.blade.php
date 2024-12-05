@extends('layouts.admin')
@section('meta')
<title>{{trans('home.add_category')}}</title>
@endsection
@section('content')

<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.categories')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/categories')}}">{{trans('home.categories')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.add_category')}}</li>
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
                            <h6 class="card-title mb-1">{{trans('home.add_category')}}</h6>
                        </div>
                        {!! Form::open(['route' => 'categories.store', 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">

                                <div class="form-group col-md-4">
                                    <label class="">{{trans('home.name_en')}}</label>
                                    <input class="form-control" name="name_en" type="text" value="{{old('name_en')}}" placeholder="{{trans('home.name_en')}}" required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="">{{trans('home.name_ar')}}</label>
                                    <input class="form-control" name="name_ar" type="text" value="{{old('name_ar')}}" placeholder="{{trans('home.name_ar')}}">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="parent">{{trans('home.parent')}}</label>
                                    <select class="form-control select2" name="parent_id">
                                        <option value="null" {{ !old('parent_id') ? 'selected' : '' }}>{{ trans('home.no_parent') }}</option>
                                        @foreach($categories as $categ)
                                            <option @selected(old('parent_id') == $categ->id ) value="{{$categ->id}}">{{ $categ->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-1">
                                    <label class="">{{trans('home.order')}}</label>
                                    <input class="form-control" name="order" value="{{old('order')}}" type="number" value="1" min="1" placeholder="{{trans('home.order')}}"/>
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
                                <div class="form-group col-md-6">
                                    <label class="">{{trans('home.desc_en')}}</label>
                                    <textarea class="form-control area1" name="text_en"  type="text" placeholder="{{trans('home.desc_en')}}" >{!! old('text_en') !!}</textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="">{{trans('home.desc_ar')}}</label>
                                    <textarea class="form-control area1" name="text_ar"  type="text" placeholder="{{trans('home.desc_ar')}}">{!! old('text_ar') !!}</textarea>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="ckbox">
                                        <input name="status" value="1"  value="{{ old('status') }}" checked type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
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
                                            <input type="text" autocomplete="off"  class="form-control" placeholder="{{trans('home.link_en')}}" name="link_en"  value="{{old('link_en') }}" >
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label> {{trans('home.meta_title_en')}}</label>
                                            <textarea class="form-control" name="meta_title_en" placeholder="{{trans('home.meta_title_en')}}"> {!! old('meta_title_en') !!}</textarea>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="meta_desc"> {{trans('home.meta_desc_en')}}</label>
                                            <textarea class="form-control" name="meta_desc_en" placeholder="{{trans('home.meta_desc_en')}}">{!! old('meta_desc_en') !!}</textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <hr>
                                            <span class="badge badge-success">{{trans('home.ar')}}</span>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label>{{trans('home.link_ar')}}</label>
                                            <input type="text" autocomplete="off"  class="form-control" placeholder="{{trans('home.link_ar')}}" name="link_ar" value="{{old('link_ar') }}" >
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label > {{trans('home.meta_title_ar')}}</label>
                                            <textarea class="form-control" name="meta_title_ar" placeholder="{!!trans('home.meta_title_ar')!!}"></textarea>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label> {{trans('home.meta_desc_ar')}}</label>
                                            <textarea class="form-control" name="meta_desc_ar" placeholder="{!! trans('home.meta_desc') !!}"></textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="ckbox">
                                                <input name="index" value="1" checked type="checkbox"><span class="tx-13">{{trans('home.meta_robots')}} (index)</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin/categories')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
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

