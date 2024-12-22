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
                    <form method="post" action="{{ route('products.attributes.value.store', $product->id) }}" class="card-body row justify-content-between">
                        @forelse ($product->attributes as $attribute)
                            <div class="card text-bg-light mb-3 col-md-3 p-0">
                                <div class="card-header bg-primary text-white"> @lang('home.add_values_to') {{$attribute->attribute_name}}</div>
                                <div class="card-body p-0 m-1">
                                    <br>
                                        <div class="form-group col-md-12">
                                            <h5 class="card-title  badge badge-pill badge-info text-white">{{$attribute->attribute_name}}</h5>
                                            <select  class="form-control role select2" name="{{$attribute->id}}[]" multiple>
                                                @foreach($attribute->all_values as $value)
                                                    <option    data-color="{{ $value->value }}"  @selected(in_array($value->id,$attribute->values->pluck('value_id')->toArray())) value="{{ $value->id }}" >{{ $value->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                            </div>
                        @empty
                            <h4 class="text-center">
                                {{__('home.doesn\'t have')}}
                            </h4>
                        @endforelse
                        @csrf
                        <div class="col-12"><button class="btn btn-primary">@lang('home.save')</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('script')
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    templateResult: function(data) {
                        if (!data.id) return data.text; // No styling for placeholder
                        var color = $(data.element).data('color');
                        return $('<span>').css('background-color', color).text(data.text);
                    },
                    templateSelection: function(data) {
                        return data.text; // Selected option text
                    }
                });
            });
        </script>
    @endsection
