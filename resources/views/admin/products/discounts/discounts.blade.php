@extends('layouts.admin')
@section('meta')
    <title>{{ trans('home.discounts') }}</title>
@endsection
@section('content')
    <div class="spainer"></div>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{ trans('home.discounts') }}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">{{ trans('home.admin') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin/products') }}">{{ trans('home.products') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin/product/' . $product->link) }}">{{ $product->name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('home.discounts') }}</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <form action="{{ route('discounts.store') }}" method="post">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="">{{ trans('home.discount') }}</label>
                                    <input class="form-control" name="discount" step="0.01" type="number"
                                        placeholder="{{ trans('home.discount') }}" value="{{request()->method() == 'post' ? old('discount') : ''}}" >
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="parent">{{ trans('home.type') }}</label>
                                    <select class="form-control" name="type">
                                        <option value="percentage" @selected(request()->isMethod('post') && old('start_date') == "percentage" )>@lang('home.percentage') </option>
                                        <option value="amount" @selected(request()->isMethod('post') && old('type') == "amount" )>@lang('home.amount') </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="">{{ trans('home.start_date') }}</label>
                                    <input class="form-control" name="start_date" type="date" value="{{request()->isMethod('post') ? old('start_date'): ''}}"
                                        placeholder="{{ trans('home.start_date') }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="">{{ trans('home.end_date') }}</label>
                                    <input class="form-control" name="end_date" type="date" value="{{request()->isMethod('post') ? old('end_date') : ''}}"
                                        placeholder="{{ trans('home.end_date') }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{ trans('home.products') }}</h6>
                            <p class="text-muted card-sub-title">
                                {{ trans('home.table_contain_all_data_shortly_you_can_view_more_details') }}
                            </p>
                        </div>

                        <div class="table-responsive">
                            <table class="table" id="exportexample">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkAll" /></th>
                                        <th>#</th>
                                        <th>{{ trans('home.id') }}</th>
                                        <th class="wd-20p">{{ trans('home.start_date') }}</th>
                                        <th class="wd-25p">{{ trans('home.end_date') }}</th>
                                        <th class="wd-20p">{{ trans('home.discount') }}</th>
                                        <th class="wd-20p">{{ trans('home.type') }}</th>
                                        <th class="wd-20p">{{ trans('home.edit') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr id="{{ $product->id }}">
                                            <td>
                                                <input type="checkbox" name="checkbox" class="tableChecked" value="{{ $product->id }}" />
                                            </td>
                                            <td> {{ $key + 1 }} </td>

                                            <td> {{ $discount->start_date }}  </td>
                                            <td> {{ $discount->end_date }}  </td>
                                            <td> {{ $discount->discount }}  </td>
                                            <td> {{ $discount->discount_type  }} </td>
                                            <td>
                                                <button type="button" style="margin-top: 28px;" class="btn btn-info" data-toggle="modal" data-target="#discForm_{{$key}}"><i class="fas fa-edit"></i></button>
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
        @foreach ($attribute->values as $key => $value)
            <div class="modal fade text-left" id="discForm_{{ $key }}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel34" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel34">{{ trans('home.edit_attribute_value') }}</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('discount.update') }}" method="post">
                            @method('put')
                            @csrf
                            <div class="modal-body">
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label>{{ trans('home.start_date') }}</label>
                                        <input type="text" class="form-control"  placeholder="{{ trans('home.start_date') }}" name="start_date"
                                            value="{{ $value->start_date }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label >{{ trans('home.end_date') }}</label>
                                        <input type="text" class="form-control"
                                            placeholder="{{ trans('home.end_date') }}" name="end_date"
                                            value="{{ $value->end_date }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="">{{ trans('home.discount') }}</label>
                                        <input class="form-control" name="discount" step="0.01" type="number"  value="{{ $value->discount }}"  placeholder="{{ trans('home.discount') }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="parent">{{ trans('home.type') }}</label>
                                        <select class="form-control" name="value_type">
                                            <option value="percentage">@lang('home.percentage') </option>
                                            <option value="amount">@lang('home.amount') </option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-success">{{ trans('home.save') }} </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
