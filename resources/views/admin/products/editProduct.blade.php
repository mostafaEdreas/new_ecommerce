@extends('layouts.admin')
@section('meta')
    <title>
        {{ trans('home.edit_product') }}</title>

@endsection
@section('style')
    <style>
        img {
            display: block !important;
        }

        .dz-hidden-input {
            position: absolute !important;
            top: 0px !important;
            left: 250px !important;
        }

        .unchecked-val:hover {
            background-color: #ff473d93;

        }
    </style>
    @include('images.select_with_image.style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{ trans('home.products') }}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">{{ trans('home.admin') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin/products') }}">{{ trans('home.products') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('home.edit_product') }}</li>
                </ol>
            </div>
            <div class="btn btn-list">
                <a href="{{ route('discounts.index', $product->id) }}">
                    <button class="btn ripple btn-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-percent" viewBox="0 0 16 16">
                            <path d="M13.442 2.558a.625.625 0 0 1 0 .884l-10 10a.625.625 0 1 1-.884-.884l10-10a.625.625 0 0 1 .884 0M4.5 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5m7 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                        </svg>
                        {{trans('home.discounts')}}
                    </button>
                </a>
                <a href="{{ route('products.attributes.index', $product->id) }}">
                    <button class="btn ripple btn-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-diagram-3-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5zm-6 8A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5zm6 0A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5zm6 0a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5z"/>
                          </svg>
                        {{trans('home.attributes')}}
                    </button>
                </a>
                <a href="{{ route('products.images.index', $product->id) }}" >
                    <button class="btn ripple btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-images" viewBox="0 0 16 16">
                            <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                            <path d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2M14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1M2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1z"/>
                        </svg>
                        {{trans('home.images')}}
                    </button>
                </a>

                <a href="{{ route('products.stocks.index', $product->id) }}" >
                    <button class="btn ripple btn-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-save2" viewBox="0 0 16 16">
                            <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.5h2a.5.5 0 0 1 .354.854l-2.5 2.5a.5.5 0 0 1-.708 0l-2.5-2.5A.5.5 0 0 1 5.5 6.5h2V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1z"/>
                        </svg>
                        {{trans('home.stocks')}}
                    </button>
                </a>
            </div>
        </div>


        <!-- End Page Header -->


        <!-- Row-->
        {!! Form::open([
            'method' => 'PATCH',
            'url' => 'admin/products/' . $product->id,
            'data-toggle' => 'validator',
            'files' => 'true',
        ]) !!}

        <div class="card p-3 mb-3">
            <div class="row ">
                <div class="mb-3 col-12">
                    <h6 class="card-title mb-1">{{ trans('home.product_main_info') }}</h6>
                </div>

                <div class="form-group col-md-6">
                    <label>{{ trans('home.name_en') }}</label>
                    <input class="form-control" name="name_en" value="{{ $product->name_en }}" type="text"  placeholder="{{ trans('home.name_en') }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label>{{ trans('home.name_ar') }}</label>
                    <input class="form-control" name="name_ar" value="{{ $product->name_ar }}" type="text" placeholder="{{ trans('home.name_ar') }}" required>
                </div>

                <div class="form-group col-md-3">
                    <label>{{ trans('home.code') }}</label>
                    <input class="form-control" name="code" value="{{ $product->code }}" type="text"  placeholder="{{ trans('home.code') }}" >
                </div>
                <div class="form-group col-md-3">
                    <labe>{{ trans('home.category') }}</labe>
                    <select class="form-control select2" name="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($product->category_id == $category->id)>
                                {{  $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>{{ trans('home.brands') }}</label>
                    <select class="form-control select2" name="brand_id">
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" @selected($product->brang_id == $brand->id)>
                                {{  $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>{{ trans('home.order') }}</label>
                    <input class="form-control" name="order" value="{{ $product->order }}" type="number" min="1" step="1"  placeholder="{{ trans('home.order') }}" required>
                </div>
                <div class="form-group col-md-12">
                    <label for="helperText">{{trans('home.attributes')}}</label>
                    <select id="select-attribute"  class="form-control role select2" name="attributes[]" multiple>
                        @foreach($attributes as $attribut)
                            <option @selected(in_array( $attribut->id, $product->attributes->pluck('attribute_id')->toArray())) value="{{$attribut->id}}" >{{ $attribut->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label>{{trans('home.main_image')}} (50px  * 50px max 1mb)</label>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> {{trans('home.upload')}}</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="main_image">
                            <label class="custom-file-label" for="inputGroupFile01">{{trans('home.choose_image')}}</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label>{{trans('home.second_image')}} (50px  * 50px max 1mb)</label>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> {{trans('home.upload')}}</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="second_image">
                            <label class="custom-file-label" for="inputGroupFile01">{{trans('home.choose_image')}}</label>
                        </div>
                    </div>
                </div>
                <div class="row col-12">
                    <div class="col-md-6">
                        <img src="{{$product->main_image_200}}" width="150">
                    </div>

                    <div class="col-md-6">
                        <img src="{{$product->second_image_200}}" width="150">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label> {{ trans('home.short_text_en') }}</label>
                    <textarea class="form-control" name="short_text_en">{!! $product->short_text_en !!}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label> {{ trans('home.short_text_ar') }}</label>
                    <textarea class="form-control" name="short_text_ar">{!! $product->short_text_ar !!}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label> {{ trans('home.text_en') }}</label>
                    <textarea class="area1" name="text_en">{!! $product->text_en !!}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label> {{ trans('home.text_ar') }}</label>
                    <textarea class="area1" name="text_ar">{!! $product->text_ar !!}</textarea>
                </div>
                <div class="form-group col-md-12">
                    <label class="ckbox">
                        <input name="status" value="1" {{($product->status == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="card p-3 mb-3">
            <div class="row ">
                <div class="mb-3 col-12">
                    <h6 class="card-title mb-1">{{ trans('home.seo') }}</h6>
                </div>

                <div class="form-group col-md-12">
                    <hr>
                    <span class="badge badge-success">{{trans('home.en')}}</span>
                </div>
                <div class="form-group col-md-2">
                    <label for="name_ar">{{trans('home.link_en')}}</label>
                    <input type="text" autocomplete="off"  value="{{$product->link_en}}"  class="form-control" placeholder="{{trans('home.link_en')}}" name="link_en">
                </div>

                <div class="form-group col-md-5">
                    <label for="meta_title"> {{trans('home.meta_title_en')}}</label>
                    <textarea class="form-control"  value="{{$product->meta_title_en}}" name="meta_title_en" placeholder="{{trans('home.meta_title_en')}}"></textarea>
                </div>

                <div class="form-group col-md-5">
                    <label for="meta_desc"> {{trans('home.meta_desc_en')}}</label>
                    <textarea class="form-control"  value="{{$product->meta_desc_en}}" name="meta_desc_en" placeholder="{{trans('home.meta_desc_en')}}"></textarea>
                </div>

                <div class="form-group col-md-12">
                    <hr>
                    <span class="badge badge-success">{{trans('home.ar')}}</span>
                </div>

                <div class="form-group col-md-2">
                    <label for="name_ar">{{trans('home.link_ar')}}</label>
                    <input type="text" autocomplete="off"  value="{{$product->link_ar}}"  class="form-control" placeholder="{{trans('home.link_ar')}}" name="link_ar">
                </div>

                <div class="form-group col-md-5">
                    <label for="meta_title"> {{trans('home.meta_title_ar')}}</label>
                    <textarea class="form-control"  name="meta_title_ar" value="{{$product->meta_title_ar}}" placeholder="{{trans('home.meta_title_ar')}}"></textarea>
                </div>

                <div class="form-group col-md-5">
                    <label for="meta_desc"> {{trans('home.meta_desc_ar')}}</label>
                    <textarea class="form-control" name="meta_desc_ar"  value="{{$product->meta_desc_ar}}" placeholder="{{trans('home.meta_desc')}}"></textarea>
                </div>

                <div class="form-group col-md-12">
                    <label class="ckbox">
                        <input name="meta_robots" value="1" @checked($product->meta_robots) type="checkbox"><span class="tx-13">{{trans('home.meta_robots')}} (index)</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <button type="submit" class="btn btn-success"> {{ trans('home.save') }} </button>
                <a href="{{ url('/admin/products') }}"><button type="button" class="btn btn-danger mr-1"><i
                            class="icon-trash"></i> {{ trans('home.cancel') }}</button></a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>


@endsection
