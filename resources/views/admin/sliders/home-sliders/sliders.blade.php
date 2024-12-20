@extends('layouts.admin')
<title>{{trans('home.home_sliders')}}</title>
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.home_sliders')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.home_sliders')}}</li>
                </ol>
            </div>
            <div class="btn btn-list">
                <a href="{{url('admin/sliders/create')}}"><button class="btn ripple btn-primary">{{trans('home.add')}}</button></a>
                <a id="btn_active"><button class="btn ripple btn-dark">{{trans('home.publish/unpublish')}}</button></a>
                <a id="btn_delete" ><button class="btn ripple btn-danger">{{trans('home.delete')}}</button></a>
            </div>
        </div>
        <!-- End Page Header -->
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->pull('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">

                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{trans('home.home_sliders')}}</h6>
                            <p class="text-muted card-sub-title">{{trans('home.table_contain_all_data_shortly_you_can_view_more_details')}}</p>
                        </div>

                        <div class="table-responsive">
                        <table class="table" id="exportexample">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"/></th>
                                    <th>{{trans('home.id')}}</th>
                                    <th class="wd-20p">{{trans('home.title_en')}}</th>
                                    <th class="wd-20p">{{trans('home.title_ar')}}</th>
                                    <th class="wd-20p">{{trans('home.view')}}</th>
                                    <th class="wd-15p">{{trans('home.status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sliders as $slider)
                                    <tr id="{{$slider->id}}">
                                        <td> <input type="checkbox" name="checkbox"  class="tableChecked" value="{{$slider->id}}"/></td>
                                        <td><a href="{{ route('sliders.edit', $slider->id) }}">{{$slider->id}}</a></td>
                                        <td><a href="{{ route('sliders.edit', $slider->id) }}">{{$slider->title_en}}</a></td>
                                        <td><a href="{{ route('sliders.edit', $slider->id) }}">{{$slider->title_ar}}</a></td>
                                        <td><a href="{{ route('sliders.edit', $slider->id) }}"><img src="{{$slider->view}}" width="70"></a></td>
                                        <td><a class="status" href="{{ route('sliders.edit', $slider->id) }}">@if($slider->status == 1) {{trans('home.yes')}} @else  {{trans('home.no')}} @endif</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
					</div>
                </div>
                    
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>
@endsection
