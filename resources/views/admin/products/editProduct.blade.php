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
        </div>
        <!-- End Page Header -->

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->pull('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

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
                    <label class="">{{ trans('home.name_en') }}</label>
                    <input class="form-control" name="name_en" value="{{ $product->name_en }}" type="text"
                        placeholder="{{ trans('home.name_en') }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label class="">{{ trans('home.name_ar') }}</label>
                    <input class="form-control" name="name_ar" value="{{ $product->name_ar }}" type="text"
                        placeholder="{{ trans('home.name_ar') }}" required>
                </div>
                <div class="form-group col-md-12">
                    <label for="parent">{{ trans('home.category') }}</label>
                    <select class="form-control select2" name="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($product->category_id == $category->id)>
                                {{ app()->getLocale() == 'en' ? $category->name_en : $category->name_ar }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="form-group col-md-6">
                    <label for="parent">{{ trans('home.brands') }}</label>
                    <select class="form-control select2" name="brand_id">
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" @selected($product->brang_id == $brand->id)>
                                {{ app()->getLocale() == 'en' ? $brand->name_en : $brand->name_ar }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="form-group col-md-6">
                    <label for="short_desc_en"> {{ trans('home.short_desc_en') }}</label>
                    <textarea class="form-control" name="short_desc_en">{!! $product->short_desc_en !!}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="short_desc_ar"> {{ trans('home.short_desc_ar') }}</label>
                    <textarea class="form-control" name="short_desc_ar">{!! $product->short_desc_ar !!}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="long_desc_en"> {{ trans('home.long_desc_en') }}</label>
                    <textarea class="area1" name="long_desc_en">{!! $product->long_desc_en !!}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="long_desc_ar"> {{ trans('home.long_desc_ar') }}</label>
                    <textarea class="area1" name="long_desc_ar">{!! $product->long_desc_ar !!}</textarea>
                </div>
                {{-- <div class="form-group col-md-6">
                    <label class="">{{ trans('home.rate') }}</label>
                    <input class="form-control" name="rate" type="number" max="10" min="0"
                        value="{{ $product->rate }}" placeholder="{{ trans('home.rate') }}">
                </div> --}}
                {{-- <div class="form-group col-md-12">
                    <label class="">{{ trans('home.stock') }}</label>
                    <input class="form-control" name="stock" type="number" min="0"
                        value="{{ $product->stock }}" placeholder="{{ trans('home.stock') }}">
                </div> --}}
                <div class="form-group col-md-12">
                    <label class="ckbox">
                        <input name="status" value="1" {{($product->status == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                    </label>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="form-group col-md-4">
                                <label class="">{{ trans('home.price') }}</label>
                                <input class="form-control" name="price" step="0.01" value="{{ $product->price }}"
                                    type="number" placeholder="{{ trans('home.price') }}">
                            </div> --}}
                            <div class="form-group col-md-3">
                                <label class="">{{ trans('home.discount') }}</label>
                                <input class="form-control" name="value" value="{{ $product->discount?->value }}"
                                    step="0.01" type="number" placeholder="{{ trans('home.discount') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="parent">{{ trans('home.value_type') }}</label>
                                <select class="form-control" name="value_type">
                                    <option value="percentage" @selected($product->discount?->value_type == 'percentage')>@lang('home.percentage') </option>
                                    <option value="value" @selected($product->discount?->value_type == 'value')>@lang('home.value')</option>
                                </select>

                            </div>
                            <div class="form-group col-md-3">
                                <label class="">{{ trans('home.start_date') }}</label>
                                <input class="form-control" name="start_date" value="{{ $product->discount?->start_date }}"
                                     type="date" placeholder="{{ trans('home.start_date') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="">{{ trans('home.end_date') }}</label>
                                <input class="form-control" name="end_date" value="{{ $product->discount?->end_date }}"
                                     type="date" placeholder="{{ trans('home.end_date') }}">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="card p-3 mb-3">
            <div class="row ">
                <div class="mb-3 col-12">
                    <h6 class="card-title mb-1">{{ trans('home.seo') }}</h6>
                </div>
                <!--<div class="form-group col-md-12">-->
                <!--    <hr>-->
                <!--    <span class="badge badge-success">{{trans('home.en')}}</span>-->
                <!--</div>-->

                <!--<div class="form-group col-md-2">-->
                <!--    <label for="name_ar">{{trans('home.link')}}</label>-->
                <!--    <input type="text" autocomplete="off"  class="form-control" placeholder="{{trans('home.link')}}" name="link_en">-->
                <!--</div> -->

                <!--<div class="form-group col-md-5">-->
                <!--    <label for="meta_title"> {{trans('home.meta_title')}}</label>-->
                <!--    <textarea class="form-control" name="meta_title_en" placeholder="{{trans('home.meta_title')}}"></textarea>-->
                <!--</div>-->

                <!--<div class="form-group col-md-5">-->
                <!--    <label for="meta_desc"> {{trans('home.meta_desc')}}</label>-->
                <!--    <textarea class="form-control" name="meta_desc_en" placeholder="{{trans('home.meta_desc')}}"></textarea>-->
                <!--</div>-->
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
        {{-- <div class="col-lg-6 col-md-6">
                <div class="card custom-card">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{ trans('home.images') }}</h6>
                            <hr>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <button type="button" class="btn"
                                        style="position: absolute; top: -70px; right: -35px;" data-toggle="modal"
                                        data-target="#Modal2"><i class="fas fa-edit" color="black"></i></button>
                                    <select class="form-control select2" multiple disabled>
                                        @foreach ($colors as $color)
                                            <option value="{{ $color->id }}"
                                                {{ in_array($color->id, $productColorIds) ? 'selected' : '' }}>
                                                {{ app()->getLocale() == 'en' ? $color->name_en : $color->name_ar }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="ckbox">
                                        <input value="1" type="checkbox" class="product-images"><span
                                            class="tx-13">{{ trans('home.show_images_uploaders') }}</span>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="product-images" style="display:none">
            @foreach ($productColors as $productColor)
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div>
                                    <h6 class="card-title mb-1">
                                        {{ app()->getLocale() == 'en' ? $productColor->name_en : $productColor->name_ar }}
                                        {{ trans('home.images') }} <span class="badge badge-secondary">(1000px *
                                            1297px)</span></h6>
                                    <hr>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="form-group col-md-12">
                                            <div class="dropzone col-md-12 upload_images"
                                                data-colorId="{{ $productColor->id }}"></div>
                                        </div>
                                        <br>
                                        <!-- image gallery -->
                                        @if ($productColor->images($product->id))
                                            <div class="col-md-12">
                                                <div class="row">
                                                    @foreach ($productColor->images($product->id) as $key => $image)
                                                        <div class="col-md-2">
                                                            <img class="img-responsive"
                                                                src="{{ url('uploads/products/source/' . $image->image) }}"
                                                                width="120px" height="120px">

                                                            <button data-image='{{ $image->id }}'
                                                                class='btn btn-danger delete_img_btn'
                                                                style="margin-right:70px;">
                                                                {{ trans('home.delete') }}</button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">

                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{ trans('home.main_info') }}</h6>
                            <hr>
                        </div>

                        <div class="row">

                            <div class="form-group col-md-4">
                                <label class="">{{ trans('home.name_en') }}</label>
                                <input class="form-control" name="name_en" type="text"
                                    placeholder="{{ trans('home.name_en') }}" value="{{ $product->name_en }}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ trans('home.name_ar') }}</label>
                                <input class="form-control" name="name_ar" type="text"
                                    placeholder="{{ trans('home.name_ar') }}"value="{{ $product->name_ar }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="parent">{{ trans('home.brands') }}</label>
                                <select class="form-control select2" name="brand_id" resonly>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'en' ? $brand->name_en : $brand->name_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="">{{trans('home.rate')}}</label>
                                <input class="form-control" name="rate" type="number" placeholder="{{trans('home.rate')}}" value="{{ $product->rate }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label class="code">{{ trans('home.code') }}</label>
                                <input class="form-control noEnterSubmit" name="code" type="text"
                                    placeholder="{{ trans('home.code') }}" value="{{ $product->code }}" readonly>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="ean">{{ trans('home.ean') }}</label>
                                <input class="form-control noEnterSubmit" name="ean" type="text"
                                    placeholder="{{ trans('home.ean') }}" value="{{ $product->ean }}"
                                    autocomplete="off">
                            </div>

                            <div class="form-group col-md-3">
                                <label class="code">{{ trans('home.sku_code') }}</label>
                                <input class="form-control noEnterSubmit" name="sku_code" type="text"
                                    placeholder="{{ trans('home.sku_code') }}" value="{{ $product->sku_code }}"
                                    autocomplete="off">
                            </div>

                            <div class="form-group col-md-3">
                                <label class="barcode">{{ trans('home.barcode') }}</label>
                                <input class="form-control noEnterSubmit barcode" name="barcode" type="text"
                                    placeholder="{{ trans('home.barcode') }}" value="{{ $product->barcode }}"
                                    autocomplete="off" readonly>
                            </div>

                            <div class="form-group col-md-12 print text-center">
                                <div class="codeDiv">
                                    <img src="data:image/png;base64,{{ base64_encode($barcode) }}" style="margin: auto">
                                    <h5>{{ $product->barcode }}</h5>
                                </div>
                                <button type="button" class="btn btn-primary printBarcode" onclick="printDiv();"><i
                                        class="fas fa-print"></i> {{ trans('home.print') }}</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        @if ($attributes->count() > 0)
            <div class="product-attributes">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div>
                                    <h6 class="card-title mb-1">{{ trans('home.attributes') }}</h6>
                                    <hr>
                                </div>
                                <div class="row">
                                    @foreach ($attributes as $attribute)
                                        <div class="form-group col-md-6">
                                            <label
                                                for="attribute">{{ app()->getLocale() == 'en' ? $attribute->name_en : $attribute->name_ar }}</label>
                                             <select class="form-control select2" id="attributes" name="attribute[]" multiple>
                                                @foreach ($attribute->values() as $value)
                                                    <option value="{{$attribute->id}}-{{$value->id}}" @if (in_array($value->id, $adAttributeValueIds)) selected @endif> @if (\App::getLocale() == 'en') {{ $value->value_en }} @else {{ $value->value_ar }} @endif</option>
                                                @endforeach
                                            </select>
                                            <select class="form-control select2" id="attributes" name="attribute[]"
                                                multiple>
                                                @foreach ($attribute->values() as $value)
                                                    <option value="{{ $attribute->id }}-{{ $value->id }}"
                                                        @if (in_array($value->id, $adAttributeValueIds)) selected @endif>
                                                        @if (\App::getLocale() == 'en')
                                                            {{ $value->value_en }}
                                                        @else
                                                            {{ $value->value_ar }}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row" id="product-options-container">
                                    @foreach ($attributes as $attribute)
                                        @foreach ($attribute->values() as $value)
                                            @if (in_array($value->id, $adAttributeValueIds))
                                                <div class="form-group col-md-2">
                                                    <div class="form-group ">
                                                        <label for="product_option"> سعر المنتج ل </label>
                                                        <span>{{ $value->{'value_' . $lang} }}</span>
                                                        <input type="number" step="0.01"
                                                            value="{{ $productOptions->where('attribute_value_id', $value->id)->first()->price ?? '' }}"
                                                            class="form-control" autocomplete="off"
                                                            name="product_options[]">
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{ trans('home.features') }}</h6>
                            <hr>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="weight"> {{ trans('home.weight') }}({{ trans('home.in_kg') }})</label>
                                <input type="number" step="0.01" class="form-control" autocomplete="off"
                                    placeholder="{{ trans('home.weight') }}" name="weight"
                                    value="{{ $product->weight }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="tall"> {{ trans('home.tall') }}({{ trans('home.in_cm') }})</label>
                                <input type="number" step="0.01" class="form-control" autocomplete="off"
                                    placeholder="{{ trans('home.tall') }}" name="tall" value="{{ $product->tall }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="width"> {{ trans('home.width') }}({{ trans('home.in_cm') }})</label>
                                <input type="number" step="0.01" class="form-control" autocomplete="off"
                                    placeholder="{{ trans('home.width') }}" name="width"
                                    value="{{ $product->width }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="height"> {{ trans('home.height') }}({{ trans('home.in_cm') }})</label>
                                <input type="number" step="0.01" class="form-control" autocomplete="off"
                                    placeholder="{{ trans('home.height') }}" name="height"
                                    value="{{ $product->height }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="code">سعر اول قوة</label>
                                <input class="form-control noEnterSubmit" name="price" type="number" min="0"
                                    placeholder="{{ trans('home.price') }}" value="{{ $product->price }}"
                                    autocomplete="off" required>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="shipping_fees">{{ trans('home.shipping_fees') }}</label>
                                <input class="form-control noEnterSubmit" name="shipping_fees" type="number"
                                    min="0" placeholder="{{ trans('home.shipping_fees') }}"
                                    value="{{ $product->shipping_fees }}" autocomplete="off">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="visits">{{ trans('home.visits') }}</label>
                                <input class="form-control" name="visits" type="text"
                                    placeholder="{{ trans('home.visits') }}" value="{{ $product->visits }}" readonly>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="ordered">{{ trans('home.ordered') }}</label>
                                <input class="form-control" name="ordered" type="text"
                                    placeholder="{{ trans('home.ordered') }}" value="{{ $product->ordered }}" readonly>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="available">{{ trans('home.available') }}</label>
                                <input class="form-control" name="available" type="text"
                                    placeholder="{{ trans('home.available') }}" value="{{ $product->available }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="stock">{{ trans('home.stock') }}</label>
                                <input class="form-control" name="stock" type="number" min="0"
                                    placeholder="{{ trans('home.stock') }}" value="{{ $product->stock }}"
                                    autocomplete="off" required>
                            </div>


                            <div class="form-group col-md-3">
                                <label class="ckbox">
                                    <input name="status" value="1" {{ $product->status == 1 ? 'checked' : '' }}
                                        type="checkbox"><span class="tx-13">{{ trans('home.status') }}</span>
                                </label>
                            </div>


                            <div class="form-group col-md-3">
                                <label class="ckbox">
                                    <input name="featurd" value="1" {{ $product->featurd == 1 ? 'checked' : '' }}
                                        type="checkbox"><span class="tx-13">{{ trans('home.featurd') }}</span>
                                </label>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="ckbox">
                                    <input name="home" value="1" {{ $product->home == 1 ? 'checked' : '' }}
                                        type="checkbox"><span class="tx-13">{{ trans('home.publish_in_home') }}</span>
                                </label>
                            </div>


                            <!--<div class="form-group col-md-3">-->
                            <!--    <label class="ckbox">-->
                            <!--        <input value="1"  type="checkbox" {{ $productQuantityPrices->count() > 0 ? 'checked' : '' }} class="quantity-prices"><span class="tx-13">{{ trans('home.quantity_prices') }} ({{ trans('home.press_to_add') }})</span>-->
                            <!--    </label>-->
                            <!--</div> -->

                            <div class="form-group col-md-3">
                                <label class="ckbox">
                                    <input value="1" type="checkbox" {{ $productDiscount ? 'checked' : '' }}
                                        class="discount"><span class="tx-13">{{ trans('home.discount') }}
                                        ({{ trans('home.press_to_add') }})</span>
                                </label>
                            </div>

                            <!--<div class="form-group col-md-3">-->
                            <!--    <label class="ckbox">-->
                            <!--        <input value="1"  type="checkbox" {{ $productOptions->count() > 0 ? 'checked' : '' }} class="options"><span class="tx-13">{{ trans('home.options') }} ({{ trans('home.press_to_add') }})</span>-->
                            <!--    </label>-->
                            <!--</div>  -->

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="quantity-prices"
            style="@if ($productQuantityPrices->count() > 0) display:block @else display:none @endif">
            <div class="col-lg-12 col-md-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{ trans('home.prices') }}</h6>
                            <p class="text-muted card-sub-title">
                                {{ trans('home.for not applying quantity prices, you can press undo button') }}</p>
                            <hr>
                        </div>

                        <div class="prices_field_wrapper ">
                            <div class="row">
                                <button type="button" class="btn unset-prices"
                                    style="position: absolute; top:1px; left: 1040px;"><i
                                        class="fas fa-undo"></i></button>

                                @if ($productQuantityPrices->count() > 0)
                                    @foreach ($productQuantityPrices as $productQuantityPrice)
                                        <div class="form-group col-md-4">
                                            <label for="quantity_from">{{ trans('home.quantity_from') }}</label>
                                            <input type="number" min="0" autocomplete="off" class="form-control"
                                                placeholder="{{ trans('home.quantity_from') }}" name="quantity_from[]"
                                                value="{{ $productQuantityPrice->quantity_from }}" readonly>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="quantity_to">{{ trans('home.quantity_to') }}</label>
                                            <input type="number" min="0" autocomplete="off"
                                                class="form-control quantity_to"
                                                placeholder="{{ trans('home.quantity_to') }}" name="quantity_to[]"
                                                value="{{ $productQuantityPrice->quantity_to }}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="quantity_price">{{ trans('home.quantity_price') }}</label>
                                            <input type="number" min="0" autocomplete="off"
                                                class="form-control quantity_price"
                                                placeholder="{{ trans('home.quantity_price') }}" name="quantity_price[]"
                                                value="{{ $productQuantityPrice->quantity_price }}">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="form-group col-md-4">
                                        <label for="quantity_from">{{ trans('home.quantity_from') }}</label>
                                        <input type="number" min="0" autocomplete="off" class="form-control"
                                            placeholder="{{ trans('home.quantity_from') }}" name="quantity_from[]"
                                            value="1" readonly>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="quantity_to">{{ trans('home.quantity_to') }}</label>
                                        <input type="number" min="0" autocomplete="off"
                                            class="form-control quantity_to"
                                            placeholder="{{ trans('home.quantity_to') }}" name="quantity_to[]">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="quantity_price">{{ trans('home.quantity_price') }}</label>
                                        <input type="number" min="0" autocomplete="off"
                                            class="form-control quantity_price"
                                            placeholder="{{ trans('home.quantity_price') }}" name="quantity_price[]">
                                    </div>
                                @endif

                            </div>
                        </div>
                        <a href="javascript:void(0);" class="add_price_button btn" title="Add field"
                            style="margin-left:-20px;"><i class="fas fa-plus-square"></i></a>

                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="discount"
            style="@if ($productDiscount) display:block @else display:none @endif">
            <div class="col-lg-12 col-md-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{ trans('home.discount') }}</h6>
                            <p class="text-muted card-sub-title">
                                {{ trans('home.for not applying discount, you can press undo button') }}</p>
                            <p class="text-muted card-sub-title">
                               يتم تطبيق الخصم على المنتج عامة بمختلف القوة</p>
                            <hr>
                        </div>

                        <div class="row">
                            <button type="button" class="btn unset-discount"
                                style="position: absolute; top:1px; left: 1200px;"><i class="fas fa-undo"></i></button>

                            <div class="form-group col-md-3">
                                <label for="value_type">{{ trans('home.value_type') }}</label>
                                <select class="form-control select2" name="value_type">
                                    <option value="value"
                                        {{ $productDiscount && $productDiscount->value_type == 'value' ? 'selected' : '' }}>
                                        {{ trans('home.value') }}</option>
                                    <option value="percentage"
                                        {{ $productDiscount && $productDiscount->value_type == 'percentage' ? 'selected' : '' }}>
                                        {{ trans('home.percentage') }}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="discount_price"> {{ trans('home.discount_price') }}</label>
                                <input type="number"class="form-control discount_price"
                                    placeholder="{{ trans('home.discount_price') }}" name="value"
                                    value="{{ $productDiscount ? $productDiscount->value : '' }}" autocomplete="off">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="start_date"> {{ trans('home.start_date') }}</label>

                                <div class="input-group">
                                    <input type='text' class="form-control start_date" name="start_date"
                                        placeholder="{{ trans('home.start_date') }}"
                                        value="{{ $productDiscount ? $productDiscount->start_date : '' }}"
                                        id="datepicker1" readonly />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="end_date"> {{ trans('home.end_date') }}</label>

                                <div class="input-group">
                                    <input type='text' class="form-control end_date" name="end_date"
                                        placeholder="{{ trans('home.end_date') }}"
                                        value="{{ $productDiscount ? $productDiscount->end_date : '' }}" id="datepicker2"
                                        readonly />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{ trans('home.meta_and_descriptions') }}</h6>
                            <hr>
                        </div>

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="short_desc_ar"> {{ trans('home.short_desc_ar') }}</label>
                                <textarea class="form-control" name="short_desc_ar">{!! $product->short_desc_ar !!}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="short_desc_en"> {{ trans('home.short_desc_en') }}</label>
                                <textarea class="form-control" name="short_desc_en">{!! $product->short_desc_en !!}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="long_desc_ar"> {{ trans('home.long_desc_ar') }}</label>
                                <textarea class="area1" name="long_desc_ar">{!! $product->long_desc_ar !!}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="long_desc_en"> {{ trans('home.long_desc_en') }}</label>
                                <textarea class="area1" name="long_desc_en">{!! $product->long_desc_en !!}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="char_desc_ar"> {{__('home.char')}}{{__('home.ar')}}</label>
                                <textarea class="area1" name="char_desc_ar">{!! $product->char_desc_ar !!}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="char_desc_en"> {{__('home.char')}}{{__('home.en')}}</label>
                                <textarea class="area1" name="char_desc_en">{!! $product->char_desc_en !!}</textarea>
                            </div>


                            <div class="col-12">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <hr>
                                        <span class="badge badge-success">{{ trans('home.en') }}</span>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="link_en">{{ trans('home.link') }}</label>
                                        <input type="text" autocomplete="off" class="form-control"
                                            placeholder="{{ trans('home.link') }}" name="link_en"
                                            value="{{ $product->link_en }}">
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="meta_title"> {{ trans('home.meta_title') }}</label>
                                        <textarea class="form-control" name="meta_title_en" placeholder="{{ trans('home.meta_title') }}">{{ $product->meta_title_en }}</textarea>
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="meta_desc"> {{ trans('home.meta_desc') }}</label>
                                        <textarea class="form-control" name="meta_desc_en" placeholder="{{ trans('home.meta_desc') }}">{{ $product->meta_desc_en }}</textarea>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <hr>
                                        <span class="badge badge-success">{{ trans('home.ar') }}</span>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="link_ar">{{ trans('home.link_ar') }}</label>
                                        <input type="text" autocomplete="off" class="form-control"
                                            placeholder="{{ trans('home.link') }}" name="link_ar"
                                            value="{{ $product->link_ar }}">
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="meta_title"> {{ trans('home.meta_title_ar') }}</label>
                                        <textarea class="form-control" name="meta_title_ar" placeholder="{{ trans('home.meta_title') }}">{{ $product->meta_title_ar }}</textarea>
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="meta_desc"> {{ trans('home.meta_desc_ar') }}</label>
                                        <textarea class="form-control" name="meta_desc_ar" placeholder="{{ trans('home.meta_desc') }}">{{ $product->meta_desc_ar }}</textarea>
                                    </div>

                                     <div class="form-group col-md-2">
                                        <label for="link_ar">{{ trans('home.link_en') }}</label>
                                        <input type="text" autocomplete="off" class="form-control"
                                            placeholder="{{ trans('home.link') }}" name="link_en"
                                            value="{{ $product->link_ar }}">
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="meta_title"> {{ trans('home.meta_title_en') }}</label>
                                        <textarea class="form-control" name="meta_title_en" placeholder="{{ trans('home.meta_title') }}">{{ $product->meta_title_ar }}</textarea>
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="meta_desc"> {{ trans('home.meta_desc_en') }}</label>
                                        <textarea class="form-control" name="meta_desc_en" placeholder="{{ trans('home.meta_desc') }}">{{ $product->meta_desc_ar }}</textarea>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label class="ckbox">
                                            <input name="meta_robots" value="1"
                                                {{ $product->meta_robots == 1 ? 'checked' : '' }} type="checkbox"><span
                                                class="tx-13">{{ trans('home.meta_robots') }} (index)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="form-group col-md-12">
                <button type="submit" class="btn btn-success"> {{ trans('home.save') }} </button>
                <a href="{{ url('/admin/products') }}"><button type="button" class="btn btn-danger mr-1"><i
                            class="icon-trash"></i> {{ trans('home.cancel') }}</button></a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>


    <div class="card mb-3">
        <div>
            <div class="mb-3 col-12 pr-0  pl-0 d-flex  align-items-center">
                {{-- <h6 class="card-title mb-1">{{ trans('home.attributes') }}</h6> --}}
                <button type="button" class="btn" data-toggle="modal" onclick="getDoesntHaveAttr()" data-target="#add-attributes">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                    </svg>
                </button>
                <h5 class=" p-0 m-0">
                    {{ trans('home.attributes') }}
                </h5>
                @include('admin.products.add_attribute_modal')
            </div>
            <div style="max-height: 100vh; overflow: auto;" class="mr-2 ml-2">
                <div class="row bg-white" id="append-attributes">
                    @foreach ($product->attributes as $attribute)
                        {{-- <div class="col-md-6 bg-white rounded"  style="width: max-content; display: inline-block">
                            <div class="bg-light  d-flex pr-0  pl-0 align-items-center">
                                <button type="button" class="btn" data-toggle="modal"  onclick="getDoesntHaveVal('{{ $attribute->id }}')" data-target="#add-value-to-attribute">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"   fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                                    </svg>
                                </button>
                                <h5 class="p-0 m-0">
                                    {{ $attribute->{'name_' . $lang} }}
                                </h5>
                            </div>
                            @include('admin.products.add_values_to_attribute_modal')
                            <div class="d-flex flex-wrap" id="{{ $attribute->{'name_' . $lang} . $attribute->id }}">
                                @foreach ($attribute->productAttributeValues($product->id) as $value)
                                    <div class="d-flex flex-column m-2" style="border: solid 1px black">
                                        <label class="val-title bg-primary text-white mb-0">{{ $value->attributeValue->{'value_' . $lang} }}</label>
                                        <div class="d-flex p-0 align-items-center">
                                            <div class= "bg-light d-flex justify-content-center align-items-center"  style="height: 100%; width: 30px">
                                                <input type="checkbox" class="remveValue{{ $attribute->id }}" value="{{ $value->id }}" checked>
                                            </div>
                                            <input type="number" step="0.01" pro_attr_id ="{{$value->id}}" onkeydown="changPrice(this,event)" onchange="changPrice(this,event)" class="change-price" value="{{$value->price}}"  placeholder="@lang('home.price')">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div style="display: inline-block; border:solid #ff473d 1px !important; cursor: pointer;"
                                onclick="removeValues('remveValue{{ $attribute->id }}')"
                                class="unchecked-val btn btn-white m-2">@lang('home.remove unchecked values')</div>
                        </div> --}}

                        @include('admin.products.append_attr_with_val')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class=" col-12 pr-0  pb-3 pl-0 d-flex bg-white  align-items-center">
            {{-- <h6 class="card-title mb-1">{{ trans('home.attributes') }}</h6> --}}
            <button type="button" class="btn"  onclick="addNewGroup()" >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                </svg>
            </button>
            <h5 class=" p-0 m-0">
                {{ trans('home.add')  }}  {{ trans('home.stock')  }}
            </h5>
        </div>
        <div class="d-flex justify-content-center flex-wrap" style="max-height: 30rem;overflow: auto;" id="add-new-group">
            @foreach ($product->Groups as $stock )
                @include('admin.products.add_new_group',['imagesStoc'=>$product->images()])
            @endforeach
        </div>
    </div>
    @include('images.upload_images', ['folder' => 'products', 'showImages' => $product->images()])
@endsection

@section('script')
    @include('images.images_script', [
        'folder' => 'products',
        'saveImageUrl' => url("admin/products/images/save-image/$product->id"),
        'deleteImageUrl' => url('admin/products/images/delete-image'),
    ])


    <script>
        function removeValues(className) {
            let inputs = document.getElementsByClassName(className);
            let group_container = document.getElementById('add-new-group');
            let needsRemove = Array.from(inputs).filter(input => input.type == 'checkbox' && !input.checked);

            if (needsRemove.length > 0) {
                Swal.fire({
                    title: "@lang('home.are you sure?')",
                    text: `@lang('home.to remove')${needsRemove.length} ${needsRemove.length > 1 ?"@lang('home.values')":"@lang('home.value')"}`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "@lang('home.yes'), @lang('home.remove')",
                    cancelButtonText: "@lang('home.no'), @lang('home.cancel')",
                }).then((result) => {
                    if (result.isConfirmed) {
                        needsRemove.forEach(ele => {
                            let cartElement = ele.parentNode.parentNode.parentNode;
                            let attrSection = cartElement.parentNode.parentNode;
                            $.ajax({
                                type: "delete",
                                url: `{{ url($lang . '/admin/products/remove-product-attribute-value') }}/${ele.value}`,
                                dataType: "json",
                                accept: 'application/json',
                                success: function(response) {
                                    if (response.status) {

                                        cartElement.remove()
                                        if (attrSection.querySelectorAll('.' + className)
                                            .length < 1) {
                                            attrSection.remove();
                                        }
                                        group_container.innerHTML=response.html_stock
                                        document.querySelectorAll('[data-dynamic-select]').forEach(select => new DynamicSelect(select));
                                        $(group_container).find('.select2').select2();
                                    } else {
                                        toastr.warning(response.message);
                                    }


                                },
                                error: function(errors) {
                                    toastr.error(errors.message);
                                }
                            });
                        });
                    }
                });
            }
        }
    </script>

    <script>
        document.getElementById('addAttrVal').addEventListener('click', addValAttr);

        function addValAttr() {
            let inputs = document.getElementsByClassName('add-val-attr');
            let needsRemove = Array.from(inputs).filter(input => input.type === 'checkbox' && input.checked);
            let group_container = document.getElementById('add-new-group');

            console.log(needsRemove.length);

            if (needsRemove.length > 0) {
                needsRemove.forEach(ele => {
                    $.ajax({
                        type: "post",
                        url: `{{ url($lang . '/admin/products/add-product-attribute-value') }}`,
                        dataType: "json",
                        accept: 'application/json',
                        async: false, // Set async to false to make the request synchronous
                        data: {
                            'product_id': '{{ $product->id }}',
                            'attr_id': ele.getAttribute('parentVal'),
                            'val_id': ele.value
                        },
                        success: function(response) {
                            if (response.status) {
                                if (ele.parentNode.parentNode.parentNode.parentNode.querySelectorAll(
                                        '.add-val-attr')) {
                                    ele.parentNode.parentNode.parentNode.parentNode.remove();
                                } else {
                                    ele.parentNode.remove()
                                }
                                if (response.id == 'append-attributes') {
                                    $('#' + response.id).append(response.html)
                                } else {
                                    $('#' + response.id).html(response.html)
                                }
                                group_container.innerHTML=response.html_stock
                                $(group_container).find('.select2').select2();
                                document.querySelectorAll('[data-dynamic-select]').forEach(select => new DynamicSelect(select));


                            }  else {
                                        toastr.warning(response.message);
                                    }
                        },
                        error: function(mes) {
                            console.log(mes);
                            if (mes.responseJSON && mes.responseJSON.errors) {
                                for (let key in mes.responseJSON.errors) {
                                    toastr.error(mes.responseJSON.errors[key]);
                                }
                            } else {
                                toastr.error(mes.responseJSON.message);
                            }

                        }
                    });
                });
            }
        }
    </script>

    <script>
        document.getElementById('addVal').addEventListener('click', addAttr);

        function addAttr() {
            let inputs = document.getElementsByClassName('add-val');
            let needsRemove = Array.from(inputs).filter(input => input.type === 'checkbox' && input.checked);
            let group_container = document.getElementById('add-new-group');

            if (needsRemove.length > 0) {
                needsRemove.forEach(ele => {
                    $.ajax({
                        type: "post",
                        url: `{{ url($lang . '/admin/products/add-product-attribute-value') }}`,
                        dataType: "json",
                        accept: 'application/json',
                        async: false, // Set async to false to make the request synchronous
                        data: {
                            'product_id': '{{ $product->id }}',
                            'attr_id': ele.getAttribute('parentVal'),
                            'val_id': ele.value
                        },
                        success: function(response) {
                            console.log(response);
                            let cartElement = ele.parentNode.parentNode.parentNode;
                            if (response.status) {
                                cartElement.remove()
                                if (response.id == 'append-attributes') {
                                    $('#' + response.id).append(response.html)
                                } else {
                                    $('#' + response.id).html(response.html)
                                }
                                group_container.innerHTML=response.html_stock
                                document.querySelectorAll('[data-dynamic-select]').forEach(select => new DynamicSelect(select));
                                $(group_container).find('.select2').select2();
                            }  else {
                                        toastr.warning(response.message);
                                    }
                        },
                        error: function(mes) {
                            console.log(mes);
                            if (mes.responseJSON && mes.responseJSON.errors) {
                                for (let key in mes.responseJSON.errors) {
                                    toastr.error(mes.responseJSON.errors[key]);
                                }
                            } else {
                                toastr.error(mes.responseJSON.message);
                            }

                        }
                    });
                });
            }
        }
    </script>

    <script>
        function getDoesntHaveAttr() {
            $.ajax({
                type: "get",
                url: `{{ url("$lang/admin/products/appends/doesntHaveAttr/$product->id") }}`,
                dataType: "json",
                accept: 'application/json',
                async: false,
                success: function(response) {
                    if (response.status) {
                        $('#new-attrs').html(response.html)
                    }else {
                        toastr.warning(response.message);
                    }
                },
                error: function(mes) {
                    console.log(mes);
                    if (mes.responseJSON && mes.responseJSON.errors) {
                        for (let key in mes.responseJSON.errors) {
                            toastr.error(mes.responseJSON.errors[key]);
                        }
                    } else {
                        toastr.error(mes.responseJSON.message);
                    }

                }
            });
        }
    </script>

    <script>
        function getDoesntHaveVal(attr_id) {
            let data = {
                'attr_id': attr_id,
                'product_id': '{{ $product->id }}'
            }
            $.ajax({
                type: "get",
                url: `{{ url("$lang/admin/products/appends/doesntHaveVal") }}`,
                dataType: "json",
                accept: 'application/json',
                data: data,
                async: false,
                success: function(response) {
                    if (response.status) {
                        $('#append-vals').html(response.html)
                    }else {
                        toastr.warning(response.message);
                    }
                },
                error: function(mes) {
                    console.log(mes);
                    if (mes.responseJSON && mes.responseJSON.errors) {
                        for (let key in mes.responseJSON.errors) {
                            toastr.error(mes.responseJSON.errors[key]);
                        }
                    } else {
                        toastr.error(mes.responseJSON.message);
                    }

                }
            });
        }
    </script>

    <script>

        function changPrice(ele,e) {
        let   pressEnter = true ;
            if (e.type === "keydown" && e.key === "Enter") {
                pressEnter = false;
                priceAjaxRequest(ele)
            }
        }


        function priceAjaxRequest(ele){
            let data = {
                    'pro_attr_id': ele.getAttribute('pro_attr_id'),
                    'price': ele.value
                }
                $.ajax({
                    type: "PUT",
                    url: `{{ url("$lang/admin/products/product-attribute/save-price") }}`,
                    dataType: "json",
                    accept: 'application/json',
                    data: data,
                    async: false,
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                        } else {
                            toastr.warning(response);
                        }
                    },
                    error: function(mes) {
                        console.log(mes);
                        if (mes.responseJSON && mes.responseJSON.errors) {
                            for (let key in mes.responseJSON.errors) {
                                toastr.error(mes.responseJSON.errors[key]);
                            }
                        } else {
                            toastr.error(mes.responseJSON.message);
                        }

                    }
                });
        }
    </script>

<script>

    function addNewGroup(){
        let cartPrent = document.getElementById('add-new-group');
            $.ajax({
                type: "post",
                url: `{{ url("$lang/admin/products/stock/new-group/$product->id") }}`,
                dataType: "json",
                accept: 'application/json',
                success: function(response) {
                    console.log(response);

                    if (response.status) {
                        cartPrent.insertAdjacentHTML('beforeend', response.html);
                        document.querySelectorAll('[data-dynamic-select]').forEach(select => new DynamicSelect(select));
                        toastr.success(response.message);
                    } else {
                        return  location.reload();
                        toastr.warning(response.message);
                    }
                },
                error: function(mes) {

                    if (mes.responseJSON && mes.responseJSON.errors) {
                        for (let key in mes.responseJSON.errors) {
                            toastr.error(mes.responseJSON.errors[key]);
                        }
                    } else {
                        console.log(mes);

                        // toastr.error(mes.responseJSON.message);
                    }

                }
            });
    }


    function saveToStockId(ele,key,id){
        let avilableValSelect = document.getElementById('stockAvilableVal'+id);
        let groupVal = document.getElementById('stockGroupVal'+id);
        let priceInput = document.getElementById('stockPrice'+id);
        let stockInput = document.getElementById('stockStock'+id);
        let stockImgSelect = document.getElementById('stockImg'+id);
        let data =  key ==='image'?{[key]:ele.querySelectorAll('input')[0].value} : {[key]:ele.value}
        $.ajax({
                type: "post",
                url: `{{ url("$lang/admin/products/stock/add-to-group") }}/${id}`,
                dataType: "json",
                accept: 'application/json',
                data: data,
                success: function(response) {
                    if (response.status) {
                        if (key==='image') {
                            stockImgSelect.select = response.data.image_id ;
                        }else if(key === 'product_attribute_id') {
                            avilableValSelect.innerHTML = response.html.avilable_values;
                            $(avilableValSelect).find('.select2').select2();
                            groupVal.innerHTML = response.html.group_values;
                        }else if(key === 'price'){
                            priceInput.value = response.data.price
                        }else if(key === 'stock'){
                            stockInput.value = response.data.stock
                        }
                        toastr.success(response.message);
                    } else {
                        toastr.warning(response.message);
                    }
                },
                error: function(mes) {
                    if (mes.responseJSON && mes.responseJSON.errors) {
                        for (let key in mes.responseJSON.errors) {
                            toastr.error(mes.responseJSON.errors[key]);
                        }
                    } else {
                        console.log(mes);

                        toastr.error(mes);
                    }

                }
            });

    }

    function removeStock(stock_id,product_attribute_id,id){
        let avilableValSelect = document.getElementById('stockAvilableVal'+id)
        let groupVal = document.getElementById('stockGroupVal'+id)
        let data = {'stock_id':stock_id,'product_attribute_id':product_attribute_id}
        $.ajax({
            type: "delete",
                url: `{{ url("$lang/admin/products/stock/delete-value") }}`,
                dataType: "json",
                accept: 'application/json',
                data: data,
                success: function(response) {
                    if (response.status) {
                        avilableValSelect.innerHTML = response.html.avilable_values;
                        $(avilableValSelect).find('.select2').select2();
                        if(response.html.group_values){
                            groupVal.innerHTML = response.html.group_values;

                        }else{
                            groupVal.parentNode.parentNode.remove();
                        }
                        toastr.success(response.message);
                    } else {
                        toastr.warning(response.message);
                    }
                },
                error: function(mes) {
                    if (mes.responseJSON && mes.responseJSON.errors) {
                        for (let key in mes.responseJSON.errors) {
                            toastr.error(mes.responseJSON.errors[key]);
                        }
                    } else {
                        toastr.error(mes.responsetext);
                    }

                }
            });

    }

</script>
@include('images.select_with_image.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
    <script>
        ////////// get sub categories///////////
        $('#category').on('change', function() {
            var categoryId = $('#category option:selected').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: " {{ url('admin/products/sub-categories') }}",
                method: 'POST',
                data: {
                    categoryId: categoryId
                },
                success: function(html) {
                    $('.sub-sub-categories').html('');
                    $('.sub-categories').html(html.html);
                    $('.select2').select2({
                        placeholder: "@lang('home.choose')"
                    });
                    subCategories();
                }
            });
        });

        function subCategories() {
            $('#sub-category').on('change', function() {
                var categoryId = $('#sub-category option:selected').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: " {{ url('admin/products/sub-categories') }}",
                    method: 'POST',
                    data: {
                        categoryId: categoryId
                    },
                    success: function(html) {
                        $('.sub-sub-categories').html(html.html);
                        $('.select2').select2({
                            placeholder: "@lang('home.choose')"
                        });
                    }
                });
            });
        }
        //////////// dispaly discount /////////
        $(".discount").click(function() {
            if ($(".discount").is(':checked')) {
                $("#discount").removeAttr("style");
            } else {
                $("#discount").css({
                    'display': 'none'
                });
            }
        });

        //////////// dispaly quantity-prices /////////
        $(".quantity-prices").click(function() {
            if ($(".quantity-prices").is(':checked')) {
                $("#quantity-prices").removeAttr("style");
            } else {
                $("#quantity-prices").css({
                    'display': 'none'
                });
            }
        });

        //////////// dispaly options /////////
        $(".options").click(function() {
            if ($(".options").is(':checked')) {
                $("#options").removeAttr("style");
            } else {
                $("#options").css({
                    'display': 'none'
                });
            }
        });


        //////////// dispaly images /////////
        $(".product-images").click(function() {
            if ($(".product-images").is(':checked')) {
                $("#product-images").css({
                    'display': 'block'
                });
            } else {
                $("#product-images").css({
                    'display': 'none'
                });
            }
        });


        /////////// unset discount ////////
        $('.unset-discount').on('click', function() {
            $('.discount_price').val('');
            $('.start_date').val('');
            $('.end_date').val('');
        });

        /////////// unset discount ////////
        $('.unset-prices').on('click', function() {
            $('.quantity_from').val('');
            $('.quantity_to').val('');
            $('.quantity_price').val('');
        });

        ///////// add prices///////////
        $(document).ready(function() {
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_price_button'); //Add button selector
            var wrapper = $('.prices_field_wrapper'); //Input field wrapper
            var fieldHTML =
                '<div class="row"><hr><div class="form-group col-md-4"><label for="quantity_from">{{ trans('home.quantity_from') }}</label><input type="number" min="0" autocomplete="off" class="form-control quantity_from" placeholder="{{ trans('home.quantity_from') }}" name="quantity_from[]"></div>';
            fieldHTML +=
                '<div class="form-group col-md-4"><label for="quantity_to">{{ trans('home.quantity_to') }}</label><input type="number" min="0" autocomplete="off" class="form-control quantity_to" placeholder="{{ trans('home.quantity_to') }}" name="quantity_to[]"></div>';
            fieldHTML +=
                '<div class="form-group col-md-3"><label for="price">{{ trans('home.quantity_price') }}</label><input type="number" min="0" autocomplete="off" class="form-control quantity_price" placeholder="{{ trans('home.quantity_price') }}" name="quantity_price[]"></div>';
            fieldHTML +=
                '<div class="form-group col-md-1"><a href="javascript:void(0);" style="margin-top: 30px;" class="remove_button btn"><i class="fas fa-trash-alt"></i></a></div></div>';

            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function() {
                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
                $('.status').select2({
                    'placeholder': "@lang('home.choose')",
                });
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent().parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });

        /////// add options ///////////
        $(document).ready(function() {
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_option_button'); //Add button selector
            var wrapper = $('.options_field_wrapper'); //Input field wrapper
            var fieldHTML =
                '<div class="row"><hr><div class="form-group col-md-4"><label for="name_en">{{ trans('home.option') }} {{ trans('home.name_en') }}</label><input type="text" autocomplete="off" class="form-control option_name_en" placeholder="{{ trans('home.option') }} {{ trans('home.name_en') }}" name="option_name_en[]"></div>';
            fieldHTML +=
                '<div class="form-group col-md-4"><label for="name_ar">{{ trans('home.option') }} {{ trans('home.name_ar') }}</label><input type="text" autocomplete="off" class="form-control option_name_ar" placeholder="{{ trans('home.option') }} {{ trans('home.name_ar') }}" name="option_name_ar[]"></div>';
            fieldHTML +=
                '<div class="form-group col-md-3"><label for="price">{{ trans('home.option') }} {{ trans('home.price') }}</label><input type="text"  autocomplete="off" class="form-control option_price" placeholder="{{ trans('home.option') }} {{ trans('home.price') }}" name="option_price[]"></div>';
            fieldHTML +=
                '<div class="form-group col-md-1"><a href="javascript:void(0);" style="margin-top: 30px;" class="remove_button btn"><i class="fas fa-trash-alt"></i></a></div></div>';

            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function() {
                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
                $('.status').select2({
                    'placeholder': "@lang('home.choose')",
                });
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent().parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });

        $('.delete_img_btn').on('click', function() {
            var image = $(this).data('image');
            var productId = {{ $product->id }};
            var btn = $(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: " {{ url('admin/product/deleteImege') }}",
                method: 'POST',
                data: {
                    image: image,
                    productId: productId
                },
                success: function(data) {
                    //btn.parent().remove();
                    location.reload();
                }
            });
        });

        $("#datepicker1").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });

        $("#datepicker2").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
    </script>

    <script type="text/javascript">
        var token = "{{ csrf_token() }}";
        //Dropzone.autoDiscover = true;
        Dropzone.autoDiscover = false;

        $("div.upload_images").on("click", function() {
            colorId = $(this).attr("data-colorId");
        });

        $("div.upload_images").dropzone({

            addRemoveLinks: true,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.webp",
            url: "{{ URL::to('admin/products/uploadImages') }}",

            init: function() {
                this.on("sending", function(file, xhr, formData) {
                    formData.append("colorId", colorId);
                    formData.append("productId", {{ $product->id }});
                });
            },

            params: {
                _token: token,
                type: 'product_image',
            },

            removedfile: function(file) {

                var fileName = file.name;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ URL::to('admin/products/removeUploadImages') }}",
                    data: {
                        type: 'product_image',
                        name: fileName,
                        request: 'delete'
                    },
                    sucess: function(data) {
                        console.log('success: ' + data);
                    }
                });
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) :
                    void 0;
            }

        });


        Dropzone.options.myAwesomeDropzone = {
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 3, // MB
            accept: function(file, done) {

            },
        };

        function printDiv() {
            var divToPrint = $('.codeDiv');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html><body onload="window.print()">' + divToPrint[0].innerHTML + '</body></html>');
            newWin.document.close();
            setTimeout(function() {
                newWin.close();
            }, 10);
        }
    </script>
@endsection
