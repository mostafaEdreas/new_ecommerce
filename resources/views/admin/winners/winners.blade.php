@extends('layouts.admin')
<title>{{trans('home.winners')}}</title>
@section('content')
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.winners')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.winners')}}</li>
                </ol>
            </div>

            <div class="btn btn-list">
                <a href="{{url('admin/winners/create')}}"><button class="btn ripple btn-primary"><i class="fas fa-plus-circle"></i> {{trans('home.add')}}</button></a>
                <a id="btn_active"><button class="btn ripple btn-dark"><i class="fas fa-eye"></i> {{trans('home.publish/unpublish')}}</button></a>
                <a id="btn_delete" ><button class="btn ripple btn-danger"><i class="fas fa-trash"></i> {{trans('home.delete')}}</button></a>
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
                            <h6 class="card-title mb-1">{{trans('home.winners')}}</h6>
                            <p class="text-muted card-sub-title">{{trans('home.table_contain_all_data_shortly_you_can_view_more_details')}}</p>
                        </div>

                        <div class="table-responsive">
                        <table class="table" id="exportexample">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"/></th>
                                    <th>{{trans('home.id')}}</th>
                                    <th class="wd-20p">{{trans('home.name')}}</th>
                                    <th class="wd-25p">{{trans('home.phone')}}</th>
                                    <th class="wd-15p">{{trans('home.email')}}</th>
                                    <th class="wd-20p">{{trans('home.image')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($winners as $winner)
                                    <tr id="{{$winner->id}}">
                                        <td><input type="checkbox" name="checkbox"  class="tableChecked" value="{{$winner->id}}"/></td>
                                        <td><a href="{{ route('winners.edit', $winner->id) }}">{{$winner->id}}</a></td>
                                        <td><a href="{{ route('winners.edit', $winner->id) }}">{{$winner->name}}</a></td>
                                        <td><a href="{{ route('winners.edit', $winner->id) }}">{{$winner->phone}}</a></td>
                                        <td><a href="{{ route('winners.edit', $winner->id) }}">{{$winner->email}}</a></td>
                                        <td>
                                            <a href="{{ route('winners.edit', $winner->id) }}">
                                                @if($winner->image)
                                                    <img src="{{url('/uploads/winners/resize200')}}/{{$winner->image}}" width="70">
                                                @else
                                                    <img src="{{url('resources/assets/back/img/noimage.png')}}" width="70">
                                                @endif
                                            </a>
                                        </td>
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
