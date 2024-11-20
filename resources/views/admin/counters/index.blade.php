@extends('layouts.admin')
<title>{{trans('home.reports')}}</title>
@section('content')
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.reports')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.reports')}}</li>
                </ol>
            </div>

            <div class="btn btn-list">
                <a href="{{url('admin/counters/create')}}"><button class="btn ripple btn-primary"><i class="fas fa-plus-circle"></i> {{trans('home.add')}}</button></a>
                <a id="btn_active" url ="{{url('admin/counters')}}"><button class="btn ripple btn-dark"><i class="fas fa-eye"></i> {{trans('home.publish/unpublish')}}</button></a>
                <a id="btn_delete" url="{{url('admin/counters')}}" ><button class="btn ripple btn-danger"><i class="fas fa-trash"></i> {{trans('home.delete')}}</button></a>
            </div>
        </div>
        <!-- End Page Header -->
{{-- 
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->pull('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif --}}

        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{trans('home.reports')}}</h6>
                            <p class="text-muted card-sub-title">{{trans('home.table_contain_all_data_shortly_you_can_view_more_details')}}</p>
                        </div>

                        <div class="table-responsive">
                        <table class="table" id="exportexample">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"/></th>
                                    <th>{{trans('home.id')}}</th>
                                    <th class="wd-20p">{{trans('home.name_ar')}}</th>
                                    <th class="wd-20p">{{trans('home.name_en')}}</th>
                                    <th class="wd-20p">{{trans('home.number')}}</th>
                                    <th class="wd-20p">{{trans('home.icon')}}</th>
                                    <th class="wd-15p">{{trans('home.status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                    <tr id="{{$report->id}}">
                                        <td> <input type="checkbox" name="checkbox"  class="tableChecked" value="{{$report->id}}"/></td>
                                        <td><a href="{{ route('counters.edit', $report->id) }}">{{$report->id}}</a></td>
                                        <td><a href="{{ route('counters.edit', $report->id) }}">{{$report->name_ar}}</a></td>
                                        <td><a href="{{ route('counters.edit', $report->id) }}">{{$report->name_en }}</a></td>
                                        <td><a href="{{ route('counters.edit', $report->id) }}">{{$report->number}}</a></td>
                                        <td>
                                            <a href="{{ route('counters.edit', $report->id) }}">
                                                @if($report->icon)
                                                    <img src="{{url('/uploads/reports/source')}}/{{$report->icon}}" width="70">
                                                @else
                                                    <img src="{{url('resources/assets/back/img/noimage.png')}}" width="70">
                                                @endif
                                            </a>
                                        </td>
                                        <td><a href="{{ route('counters.edit', $report->id) }}">@if($report->status == 1) {{trans('home.yes')}} @else  {{trans('home.no')}} @endif</a></td>
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
