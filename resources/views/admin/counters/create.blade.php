@extends('layouts.admin')
@section('meta')
    <title>{{trans('home.add_report')}}</title>
@endsection
@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.reports')}}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                <li class="breadcrumb-item"><a href="{{url('admin/counters')}}">{{trans('home.reports')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans('home.add_report')}}</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    {!! Form::open(['method'=>'post','url' => 'admin/counters/', 'data-toggle'=>'validator', 'files'=>'true']) !!}
        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">

                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{trans('home.add_report')}}</h6>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label class= "">{{trans('home.name_en')}}</label>
                                <input class="form-control" name="name_en" type="text" placeholder="{{trans('home.name_en')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label class= "">{{trans('home.name_ar')}}</label>
                                <input class="form-control" name="name_ar" type="text" placeholder="{{trans('home.name_ar')}}" >
                            </div>
                            <div class="form-group col-md-4">
                                <label class= "">{{trans('home.number')}}</label>
                                <input class="form-control" name="number" type="text" placeholder="{{trans('home.number')}}" >
                            </div>
                            <div class="form-group  col-md-12">
                                <label class="">{{trans('home.char')}}</label>
                                <input type="text"  class="form-control" name="icon">                               
                            </div>
                        
                            <br>

                            <div class="form-group col-md-4">
                                <label class="ckbox">
                                    <input name="status" value="1" type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->

        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                <a href="{{url('/admin/counters')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    {!! Form::close() !!}
</div>

@endsection
@section('script')        
@if(session()->has('success'))
   <script>
        toastr.options = successOption ;
        toastr.success( "{{session()->get('success')}}" );
   </script>
@endif
@if($errors->any())
   <script>
      toastr.options = errorOption ;
    @foreach ($errors->all() as $error)
      
        toastr.error( "{{$error}}" );
    @endforeach
        
   </script>
@endif
@endsection
