@extends('layouts.admin')
<title>{{trans('home.products')}}</title>
@section('content')
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.products')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.products')}}</li>
                </ol>
            </div>

            <div class="btn btn-list">
                <a href="{{url('admin/products/create')}}"><button class="btn ripple btn-primary"><i class="fas fa-plus-circle"></i> {{trans('home.add')}}</button></a>
                <a id="btn_active"><button class="btn ripple btn-dark"><i class="fas fa-eye"></i> {{trans('home.publish/unpublish')}}</button></a>
                <a id="btn_delete" ><button class="btn ripple btn-danger"><i class="fas fa-trash"></i> {{trans('home.delete')}}</button></a>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{trans('home.products')}}</h6>
                            <p class="text-muted card-sub-title">{{trans('home.table_contain_all_data_shortly_you_can_view_more_details')}}</p>
                        </div>

                        <div class="table-responsive">
                        <table class="table" id="exportexample">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"/></th>
                                    <th>#</th>
                                    <th>{{trans('home.id')}}</th>
                                    <th class="wd-20p">{{trans('home.name_en')}}</th>
                                    <th class="wd-25p">{{trans('home.name_ar')}}</th>
                                    <th class="wd-20p">{{trans('home.image')}}</th>
                                    <th class="wd-20p">{{trans('home.category')}}</th>
                                    <th class="wd-20p">{{trans('home.brand')}}</th>
                                    <th class="wd-20p">{{trans('home.hot_offers')}}</th>
                                    <th class="wd-20p">{{trans('home.images')}}</th>
                                    <th class="wd-15p">{{trans('home.status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $key=>$product)
                                    <tr id="{{$product->id}}">
                                        <td> <input type="checkbox" name="checkbox"  class="tableChecked" value="{{$product->id}}" /> </td>
                                        <td><a href="{{ route('products.edit', $product->id) }}">{{$key+1}}</a></td>
                                        <td><a href="{{ route('products.edit', $product->id) }}">{{$product->id}}</a></td>
                                        <td><a href="{{ route('products.edit', $product->id) }}">{{$product->name_en}}</a></td>
                                        <td><a href="{{ route('products.edit', $product->id) }}">{{$product->name_ar}}</a></td>
                                        <td>
                                            <a href="{{ route('products.edit', $product->id) }}">
                                                <img style="border-radius:50%" src="{{$product->main_image_200}}"  alt="product-image" title="{{$product->name}}" width="50" height="50">
                                            </a>
                                        </td>
                                        <td><a href="{{ route('products.edit', $product->id) }}"> {{ $product->category_name ?? __('home.no category') }} </a></td>
                                        <td><a href="{{ route('products.edit', $product->id) }}"> {{ $product->brand_name ?? __('home.no brand') }} </a></td>
                                        <td>
                                            <a href="{{ route('discounts.index', $product->id) }}">
                                                @if($product->discount)
                                                    <span class="btn badge-success" style="min-width: 100%">{{trans('home.yes')}}</span>
                                                @else
                                                    <span class="btn badge-light" style="min-width: 100%">{{trans('home.no')}}</span>
                                                @endif
                                            </a>
                                        </td>
                                        <td><a href="{{ route('products.images.index', $product->id) }}">{{__('home.view')}} <br>({{$product->images()->count();}} {{__('home.image')}}) </a></td>
                                        <td>
                                            <a href="{{ route('products.edit', $product->id) }}" class="status">
                                                @if($product->status == 1)
                                                    <span class="btn badge-success" style="min-width: 100%">{{trans('home.yes')}}</span>
                                                @else
                                                    <span class="btn badge-danger" style="min-width: 100%">{{trans('home.no')}}</span>
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
