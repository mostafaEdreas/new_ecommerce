@extends('layouts.admin')
@section('meta')
    <title>{{ trans('home.attributes') }}</title>
@endsection
@section('content')
    <div class="spainer"></div>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{ trans('home.attributes') }}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/admin') }}"> {{ trans('home.admin') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin/products') }}">{{ trans('home.products') }} </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin/products/' . $product->id.'/edit') }}">
                            {{ $product->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('home.attributes') }}</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        @forelse ($product->attributes as $attribute)
                            <div class="card text-bg-light mb-3" style="max-width: 18rem;">
                                <div class="card-header bg-primary text-white"> @lang('home.add_values_to') {{$attribute->attribute_name}}</div>
                                <div class="card-body">
                                    <h5 class="card-title  badge badge-pill badge-info text-white">{{$attribute->attribute_name}}</h5>
                                    <br>
                                    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                                        <div class="form-group col-md-12">
                                            <label for="helperText">{{trans('home.attributes')}}</label>
                                            <select id="select-attribute"  class="form-control role select2" name="{{$attribute->id}}[]" multiple>
                                                @foreach($attribute->all_values as $value)
                                                    <option @selected(old($attribute->id)?in_array($value->id,old($attribute->id,[])):false) value="{{ $value->id }}" >{{ $value->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <h4 class="text-center">
                                {{__('home.doesn\'t have')}}
                            </h4>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
