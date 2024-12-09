@extends('layouts.admin')
@section('meta')
    <title>{{ trans('home.stocks') }}</title>
@endsection
@section('content')
    <div class="spainer"></div>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{ trans('home.stocks') }}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/admin') }}"> {{ trans('home.admin') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin/products') }}">{{ trans('home.products') }} </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ url('admin/products/' . $product->id.'/edit') }}">{{ $product->name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('home.stocks') }}</li>
                </ol>
            </div>
            <div class="btn btn-list">
                <a id="btn_delete"  ><button class="btn ripple btn-danger"><i class="fas fa-trash"></i> {{trans('home.delete')}}</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <form action="{{ route('products.stocks.store', $product->id) }}" method="post">
                            <div class="row">
                                @csrf
                                <div class="form-group col-md-4">
                                    <label class="">{{ trans('home.price') }}</label>
                                    <input class="form-control" name="price" type="number" step="0.01" placeholder="{{ trans('home.price') }}" value="{{request()->method() == 'post' ? old('price') : ''}}" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="">{{ trans('home.stock') }}</label>
                                    <input class="form-control" name="stock" type="number" step="0.01" placeholder="{{ trans('home.stock') }}" value="{{request()->method() == 'post' ? old('stock') : ''}}" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="">{{ trans('home.values') }}</label>
                                    <select  class="form-control role select2" name="values[]" multiple>
                                        @foreach($product->AttributeValues as $value)
                                            <option @selected(old('values') ? in_array($value->id,old('values')) : false ) value="{{ $value->id }}" >{{ $value->value_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"> {{trans('home.save')}} </button>
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
                            <h6 class="card-title mb-1">{{ trans('home.stocks') }}</h6>
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
                                        <th class="wd-20p">{{ trans('home.price') }}</th>
                                        <th class="wd-25p">{{ trans('home.stock') }}</th>
                                        <th class="wd-20p">{{ trans('home.values') }}</th>
                                        <th class="wd-20p">{{ trans('home.edit') }}</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($product->stocks as $key => $stock)
                                        <tr id="{{ $stock->id }}" >
                                            <td>
                                                @if ($stock->can_edit_or_delete)
                                                
                                                        <input type="checkbox" name="checkbox" class="tableChecked" value="{{ $stock->id }}" />
                                                @else
                                                    {{__('home.cannot delete it')}}
                                            
                                                @endif
                                            </td>
                                            <td> {{ $key + 1 }} </td>

                                            <td> {{ $stock->price }}  </td>
                                            <td> {{ $stock->stock }}  </td>
                                            <td> {{ $stock->values->count()  }} @lang('home.values') </td>
                                            <td>
                                                @if ($stock->can_edit_or_delete)
                                                    <button type="button"  class="btn btn-info" data-toggle="modal" data-target="#stockForm_{{$key}}"><i class="fas fa-edit"></i></button>
                                                @else
                                                    {{__('home.cannot update it')}}
                                                @endif
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
        @foreach ($product->stocks as $key => $stock)
            <div class="modal fade text-left" id="stockForm_{{ $key }}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel34" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel34">{{ trans('home.edit_product_stock') }}</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('products.stocks.update', $stock->id ) }}" method="post">
                            @method('PATCH')
                            @csrf
                            <div class="modal-body">
                                <div class="row">

                                    <div class="form-group col-md-4">
                                        <label>{{ trans('home.price') }}</label>
                                        <input type="text" class="form-control"  placeholder="{{ trans('home.price') }}" name="price"
                                            value="{{ $stock->price }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label >{{ trans('home.stock') }}</label>
                                        <input type="text" class="form-control"
                                            placeholder="{{ trans('home.stock') }}" name="stock"
                                            value="{{ $stock->stock }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="">{{ trans('home.values') }}</label>
                                        <select  class="form-control role select2" name="values[]" multiple>
                                            @foreach($product->AttributeValues as $value)
                                                <option @selected(in_array($value->id, $stock->values->pluck('product_attribute_value_id')->toArray())) value="{{ $value->id }}" >{{ $value->value_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>                                    
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-info">{{ trans('home.update') }} </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endsection
