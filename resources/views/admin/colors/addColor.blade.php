@extends('layouts.admin')
<title>{{trans('home.add_color')}}</title>
@section('content')

<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.colors')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/colors')}}">{{trans('home.colors')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.add_color')}}</li>
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
                            <h6 class="card-title mb-1">{{trans('home.add_color')}}</h6>
                        </div>
                        {!! Form::open(['route' => 'colors.store', 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">

                                <div class="form-group col-md-2">
                                    <label class="">{{trans('home.name_en')}}</label>
                                    <input class="form-control" name="name_en" type="text" placeholder="{{trans('home.name_en')}}" required>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="">{{trans('home.name_ar')}}</label>
                                    <input class="form-control" name="name_ar" type="text" placeholder="{{trans('home.name_ar')}}">
                                </div>
                                
                                 <div class="form-group col-md-3">
                                    <label for="parent">{{trans('home.parent')}}</label>
                                    <select class="form-control select2" name="parent_id">
                                    <option value="0">{{trans('home.no_parent')}}</option>
                                        @foreach($colors as $col)
                                            <option value="{{$col->id}}"2>{{(app()->getLocale()=='en')? $col->name_en:$col->name_ar}}</option>
                                        @endforeach    
                                    </select>
                                </div>

                                <div class="col-md-4">
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
                                
                                <div class="col-md-1">
                                    <label>{{trans('home.hex_code')}}</label>
                                    <input class="form-control" name="hex_code" type="color"/>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="category">{{trans('home.categories')}}</label>
                                    <select class="form-control select2" name="category_id[]" multiple>
                                        @foreach($categories as $categ)
                                            <option value="{{$categ->id}}">{{(app()->getLocale()=='en')? $categ->name_en:$categ->name_ar}}</option>
                                        @endforeach    
                                    </select>
                                    <br>
                                    <input type="checkbox" id="checkbox">  {{trans('home.selectall')}}
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="ckbox">
                                        <input name="status" value="1" type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                                    </label>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin/colors')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
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

@section('script')
    <script>
        $("#checkbox").click(function(){
            if($("#checkbox").is(':checked') ){
                $(".select2 > option").prop("selected",true);
                $(".select2").trigger("change");
            }else{
                $('.select2 option:selected').prop("selected", false);
                $(".select2").trigger("change");
            }select2
        });
    </script>
@endsection    

