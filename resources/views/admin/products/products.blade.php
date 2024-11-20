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
            
            <!--<form action="{{url('admin/product/updatePriceList')}}" method="post" enctype="multipart/form-data">-->
            <!--    @csrf-->
            <!--    <div class="custom-file">-->
            <!--        <input type="file" class="custom-file-input" name="excel"  onchange="form.submit()">-->
            <!--        <label class="custom-file-label" for="inputGroupFile01">{{trans('home.update_price_list')}}</label>-->
            <!--    </div>-->
            <!-- </form>-->
             

            <div class="btn btn-list">
                <a href="{{url('admin/products/create')}}"><button class="btn ripple btn-primary"><i class="fas fa-plus-circle"></i> {{trans('home.add')}}</button></a>
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
        
        
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                        <strong>{{ $error }}</strong>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->pull('error') }}
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
                            <h6 class="card-title mb-1">{{trans('home.products')}}</h6>
                            <p class="text-muted card-sub-title">{{trans('home.table_contain_all_data_shortly_you_can_view_more_details')}}</p>
                        </div>

                        <div class="table-responsive">
                        <table class="table" id="exportexample">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"/></th>
                                    <!--<th>{{trans('home.id')}}</th>-->
                                    <th>#</th>
                                    <th>ID</th>
                                    <th class="wd-20p">{{trans('home.name_en')}}</th>
                                    <th class="wd-25p">{{trans('home.name_ar')}}</th>
                                    <th class="wd-25p">{{trans('home.price')}}</th>
                                    <th class="wd-20p">{{trans('home.image')}}</th>
                                    <th class="wd-20p">{{trans('home.category')}}</th>
                                    <th class="wd-20p">{{trans('home.brand')}}</th>
                                    <th class="wd-20p">{{trans('home.stock')}}</th>
                                    <th class="wd-20p">{{trans('home.hot_offers')}}</th>
                                    <th class="wd-15p">{{trans('home.status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $key=>$product)
                                    <tr id="{{$product->id}}">
                                        <td> <input type="checkbox" name="checkbox"  class="tableChecked" value="{{$product->id}}" /> </td>
                                        <!--<td><a href="{{ route('products.edit', $product->id) }}">{{$product->id}}</a></td>-->
                                        <td><a href="{{ route('products.edit', $product->id) }}">{{$key+1}}</a></td>
                                        <td><a href="{{ route('products.edit', $product->id) }}">{{$product->id}}</a></td>
                                        <td><a href="{{ route('products.edit', $product->id) }}">{{$product->name_en}}</a></td>
                                        <td><a href="{{ route('products.edit', $product->id) }}">{{$product->name_ar}}</a></td>
                                        <td><a href="{{ route('products.edit', $product->id) }}">{{$product->price}} {{trans('home.EGP')}}</a></td>
                                        <td>
                                            <a href="{{ route('products.edit', $product->id) }}">
                                                @if($product->firstImage())
                                                    <img style="border-radius:50%" src="{{url('uploads/products/source/'.$product->firstImage()->image)}}"  alt="product-image" title="{{$product->name_en}}" width="50" height="50">
                                                @else
                                                    <img style="border-radious:50%" src="{{url('resources/assets/front/images/noimage.png')}}" alt="product-image" title="{{$product->name_en}}" width="50" height="50">
                                                @endif
                                            </a>
                                        </td>
                                        <td><a href="{{ route('products.edit', $product->id) }}">@if($product->category){{(app()->getLocale() == 'en')?$product->category->name_en:$product->category->name_ar}}@endif</a></td>
                                        <td><a href="{{ route('products.edit', $product->id) }}">@if($product->brand){{(app()->getLocale() == 'en')?$product->brand->name_en:$product->brand->name_ar}}@endif</a></td>
                                        <td><a href="{{ route('products.edit', $product->id) }}">{{$product->stock}}</a></td>
                                        <td>
                                            <a href="{{ route('products.edit', $product->id) }}">
                                                @if($product->hot_offer())
                                                    <span class="badge badge-success">{{trans('home.yes')}}</span>
                                                @else
                                                    <span class="badge badge-danger">{{trans('home.no')}}</span>
                                                @endif
                                            </a>
                                        </td>
                                        
                                        <td>
                                            <a href="{{ route('products.edit', $product->id) }}">
                                                @if($product->status == 1)
                                                    <span class="badge badge-success">{{trans('home.yes')}}</span>
                                                @else
                                                    <span class="badge badge-danger">{{trans('home.no')}}</span>
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
