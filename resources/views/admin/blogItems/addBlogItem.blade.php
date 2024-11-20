@extends('layouts.admin')
@section('meta')
<title>{{trans('home.add_blog_item')}}</title>
@endsection
@section('content')

<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.blogItems')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/blog-items')}}">{{trans('home.blogItems')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.add_blog_item')}}</li>
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
                            <h6 class="card-title ">{{trans('home.add_blog_item')}}</h6>
                        </div>
                        {!! Form::open(['route' => 'blog-items.store', 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">

                                <div class="form-group col-md-4">
                                    <label for="title_en">{{trans('home.title_en')}}</label>
                                    <input type="text"  class="form-control" placeholder="{{trans('home.title_en')}}" name="title_en" required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="title_ar">{{trans('home.title_ar')}}</label>
                                    <input type="text"  class="form-control" placeholder="{{trans('home.title_ar')}}" name="title_ar">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="parent">{{trans('home.blogCategory')}}</label>
                                    <select class="form-control select2" name="blogcategory_id">
                                        @foreach($blogCategories as $blogCategory)
                                            <option value="{{$blogCategory->id}}">{{(app()->getLocale()=='en')? $blogCategory->title_en:$blogCategory->title_ar}}</option>
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

                                {{-- <div class="form-group col-md-4">
                                    <label for="writer">{{trans('home.writer')}}</label>
                                    <input type="text"  class="form-control" placeholder="{{trans('home.writer')}}" name="writer" required>
                                </div> --}}

                                <div class="form-group col-md-4">
                                    <label for="code">{{trans('home.date')}}</label>
                                    <div class="input-group">
                                        <input type='text' class="form-control" name="date" placeholder="{{trans('home.date')}}" id="datepicker"  required />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6 ">
                                    <label for="text_en">{{trans('home.text_en')}}</label>
                                    <textarea class="form-control area1" name="text_en" placeholder="{{trans('home.text_en')}}" ></textarea>
                                </div>

                                <div class="form-group col-md-6 ">
                                    <label for="text_ar">{{trans('home.text_ar')}}</label>
                                    <textarea class="form-control area1" name="text_ar" placeholder="{{trans('home.text_ar')}}" ></textarea>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="ckbox">
                                        <input name="status" value="1" type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                                    </label>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <hr>
                                            <span class="badge badge-success">{{trans('home.en')}}</span>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="link_en">{{trans('home.link_en')}}</label>
                                            <input type="text"  class="form-control" placeholder="{{trans('home.link_en')}}" name="link_en">
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="meta_title"> {{trans('home.meta_title')}}</label>
                                            <textarea class="form-control" name="meta_title_en" placeholder="{{trans('home.meta_title')}}"></textarea>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="meta_desc"> {{trans('home.meta_desc')}}</label>
                                            <textarea class="form-control" name="meta_desc_en" placeholder="{{trans('home.meta_desc')}}"></textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <hr>
                                            <span class="badge badge-success">{{trans('home.ar')}}</span>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="link_ar">{{trans('home.link_ar')}}</label>
                                            <input type="text"  class="form-control" placeholder="{{trans('home.link_ar')}}" name="link_ar">
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="meta_title"> {{trans('home.meta_title')}}</label>
                                            <textarea class="form-control" name="meta_title_ar" placeholder="{{trans('home.meta_title')}}"></textarea>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="meta_desc"> {{trans('home.meta_desc')}}</label>
                                            <textarea class="form-control" name="meta_desc_ar" placeholder="{{trans('home.meta_desc')}}"></textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="ckbox">
                                                <input name="meta_robots" value="1" type="checkbox"><span class="tx-13">{{trans('home.meta_robots')}} (index)</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="image-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin/blog-items')}}"><button type="button" class="btn btn-danger mr-1"><i class="image-trash"></i> {{trans('home.cancel')}}</button></a>
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

        $( "#datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
    </script>
@endsection
