@extends('layouts.admin')
@section('meta')
    <title>{{trans('home.edit_reports')}}</title>
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
                <li class="breadcrumb-item active" aria-current="page">{{trans('home.edit_report')}}</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    {!! Form::open(['method'=>'PATCH','url' => 'admin/counters/'.$report->id, 'data-toggle'=>'validator', 'files'=>'true']) !!}
        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">

                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{trans('home.edit_report')}}</h6>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label class= "">{{trans('home.name_en')}}</label>
                                <input class="form-control" name="name_en" type="text" placeholder="{{trans('home.name_en')}}" value="{{$report->name_en}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label class= "">{{trans('home.name_ar')}}</label>
                                <input class="form-control" name="name_ar" type="text" placeholder="{{trans('home.name_ar')}}" value="{{$report->name_ar}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label class= "">{{trans('home.number')}}</label>
                                <input class="form-control" name="number" type="text" placeholder="{{trans('home.number')}}" value="{{$report->number}}">
                            </div>
                            <div class="form-group  col-md-12">
                                <label class="">{{trans('home.icon')}}</label>
                                <input type="file"  class="form-control" name="icon">                               
                            </div>

                            @if($report->icon)
                                <div class="form-group  col-md-12">
                                    <img src="{{url('\uploads\reports\source')}}\{{$report->icon}}" width="200" height="150">
                                </div>
                            @endif
                            
                            <br>

                            <div class="form-group col-md-4">
                                <label class="ckbox">
                                    <input name="status" value="1" {{($report->status == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
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
    @foreach ($errors->all() as $error)
        toastr.options = errorOption ;
        toastr.error( "{{$error}}" );
    @endforeach
        
   </script>
@endif
@endsection
