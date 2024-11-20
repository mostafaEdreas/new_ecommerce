@extends('layouts.admin')
<title>{{trans('home.deliveries')}}</title>
@section('content')
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.deliveries')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.deliveries')}}</li>
                </ol>
            </div>

            <div class="btn btn-list">
                <a href="{{url('admin/deliveries/create')}}" class="btn ripple btn-primary"><i class="fe fe-plus"></i> {{trans('home.add')}}</a>
                <a id="btn_delete" class="btn ripple btn-danger"><i class="fe fe-x"></i> {{trans('home.delete')}}</a>
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
                            <h6 class="card-title mb-1">{{trans('home.deliveries')}}</h6>
                            <p class="text-muted card-sub-title">{{trans('home.table_contain_all_data_shortly_you_can_view_more_details')}}</p>
                        </div>

                        <div class="table-responsive">
                        <table class="table" id="exportexample">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"/></th>
                                    <th>{{trans('home.id')}}</th>
                                    <th>{{trans('home.name')}}</th>
                                    <th>{{trans('home.phone1')}}</th>
                                    <th>{{trans('home.phone2')}}</th>
                                    <th>{{trans('home.status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deliveries as $delivery)
                                    <tr id="{{$delivery->id}}">
                                        <td> <input type="checkbox" name="checkbox"  class="tableChecked" value="{{$delivery->id}}" /> </td>
                                        <td><a href="{{ route('deliveries.edit',$delivery->id) }}">{{$delivery->id}}</a></td>
                                        <td><a href="{{ route('deliveries.edit',$delivery->id) }}">{{$delivery->name}}</a></td>
                                        <td><a href="{{ route('deliveries.edit',$delivery->id) }}">{{$delivery->phone1}}</a></td>
                                        <td><a href="{{ route('deliveries.edit',$delivery->id) }}">{{$delivery->phone2}}</a></td>                               
                                        <td><a href="{{ route('deliveries.edit',$delivery->id) }}">@if($delivery->status == 'active') {{trans('home.active')}} @elseif($delivery->status == 'inactive') {{trans('home.inactive')}} @else  {{trans('home.block')}} @endif</a></td>                                    </tr>
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

