@extends('layouts.admin')
@section('meta')
<title>{{trans('home.add_products')}}</title>
@endsection
@section('content')
<div class="spainer"> </div>
<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.products')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/products')}}">{{trans('home.products')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.add_products')}}</li>
                </ol>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Row-->
        {!! Form::open(['route' => 'products.store', 'data-toggle'=>'validator', 'files'=>'true']) !!}
        <div class="card p-3 mb-3">
            <div class="row ">
                <div class="mb-3 col-12
                ">
                    <h6 class="card-title mb-1">{{trans('home.product_main_info')}}</h6>
                </div>
                <div class="form-group col-md-6">
                    <label class="">{{trans('home.name_en')}}</label>
                    <input class="form-control" name="name_en" type="text" placeholder="{{trans('home.name_en')}}" required>
                 </div>

                 <div class="form-group col-md-6">
                    <label class="">{{trans('home.name_ar')}}</label>
                    <input class="form-control" name="name_ar" type="text" placeholder="{{trans('home.name_ar')}}" required>
                </div>
                <div class="form-group col-md-12">
                    <label for="parent">{{trans('home.category')}}</label>
                    <select class="form-control select2" name="category_id" >
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{(app()->getLocale() == 'en')?$category->name_en:$category->name_ar}}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="form-group col-md-6">
                    <label for="parent">{{trans('home.brands')}}</label>
                    <select class="form-control select2" name="brand_id">
                        @foreach($brands as $brand)
                            <option value="{{$brand->id}}">{{(app()->getLocale() == 'en')?$brand->name_en:$brand->name_ar}}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="form-group col-md-6">
                    <label for="short_desc_ar"> {{ trans('home.short_desc_ar') }}</label>
                    <textarea class="form-control" name="short_desc_ar"></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="short_desc_en"> {{ trans('home.short_desc_en') }}</label>
                    <textarea class="form-control" name="short_desc_en"></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="long_desc_ar"> {{ trans('home.long_desc_ar') }}</label>
                    <textarea class="area1" name="long_desc_ar"></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="long_desc_en"> {{ trans('home.long_desc_en') }}</label>
                    <textarea class="area1" name="long_desc_en"></textarea>
                </div>
                <div class="form-group col-md-12">
                    <label class="ckbox">
                        <input name="status" type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                    </label>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="form-group col-md-3">
                                <label class="">{{trans('home.price')}}</label>
                                <input class="form-control" name="price" step="0.01" type="number" placeholder="{{trans('home.price')}}">
                            </div> --}}
                            <div class="form-group col-md-3">
                                <label class="">{{trans('home.discount')}}</label>
                                <input class="form-control" name="discount" step="0.01" type="number" placeholder="{{trans('home.discount')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="parent">{{trans('home.value_type')}}</label>
                                <select class="form-control" name="value_type">
                                        <option value="percentage">@lang('home.percentage') </option>
                                        <option value="percentage">@lang('home.percentage') </option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="">{{ trans('home.start_date') }}</label>
                                <input class="form-control" name="start_date" 
                                     type="date" placeholder="{{ trans('home.start_date') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="">{{ trans('home.end_date') }}</label>
                                <input class="form-control" name="end_date" 
                                     type="date" placeholder="{{ trans('home.end_date') }}">
                            </div>
                            {{-- <div class="form-group col-md-3">
                                <label class="">{{trans('home.rate')}}</label>
                                <input class="form-control" name="rate" type="number" max="5" min="1" value="5" placeholder="{{trans('home.rate')}}">
                            </div> --}}

                            {{-- <div class="form-group col-md-12">
                                <label for="parent">{{trans('home.color')}} <span class="badge badge-secondary">{{trans('home.first_select_category')}}</span></label>
                                <select class="form-control select2 colors" name="color_id[]" multiple required>

                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="code">{{trans('home.code')}}</label>
                                <input class="form-control noEnterSubmit" name="code" type="text"  placeholder="{{trans('home.code')}}" value="{{$code}}" readonly>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="ean">{{trans('home.ean')}}</label>
                                <input class="form-control noEnterSubmit" name="ean" type="text"  placeholder="{{trans('home.ean')}}" autocomplete="off">
                            </div>

                            <div class="form-group col-md-3">
                                <label class="code">{{trans('home.sku_code')}}</label>
                                <input class="form-control noEnterSubmit" name="sku_code" type="text"  placeholder="{{trans('home.sku_code')}}" autocomplete="off">
                            </div>

                            <div class="form-group col-md-3">
                                <label class="barcode">{{trans('home.barcode')}}</label>
                                <input class="form-control noEnterSubmit barcode readonly" name="barcode" type="text"  placeholder="{{trans('home.barcode')}}" autocomplete="off"  required>
                                <button type="button" role="button" class="btn generate-barcode">{{trans('home.generate_barcode')}}</button>
                            </div>

                            <div class="form-group col-md-12 print text-center">

                            </div> --}}

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
                    <input type="text" autocomplete="off"  class="form-control" placeholder="{{trans('home.link_en')}}" name="link_en">
                </div>
                
                <div class="form-group col-md-5">
                    <label for="meta_title"> {{trans('home.meta_title_en')}}</label>
                    <textarea class="form-control" name="meta_title_en" placeholder="{{trans('home.meta_title_en')}}"></textarea>
                </div>
                
                <div class="form-group col-md-5">
                    <label for="meta_desc"> {{trans('home.meta_desc_en')}}</label>
                    <textarea class="form-control" name="meta_desc_en" placeholder="{{trans('home.meta_desc_en')}}"></textarea>
                </div>

                <div class="form-group col-md-12">
                    <hr>
                    <span class="badge badge-success">{{trans('home.ar')}}</span>
                </div>
                
                <div class="form-group col-md-2">
                    <label for="name_ar">{{trans('home.link_ar')}}</label>
                    <input type="text" autocomplete="off"  class="form-control" placeholder="{{trans('home.link_ar')}}" name="link_ar">
                </div>
                
                <div class="form-group col-md-5">
                    <label for="meta_title"> {{trans('home.meta_title_ar')}}</label>
                    <textarea class="form-control" name="meta_title_ar" placeholder="{{trans('home.meta_title_ar')}}"></textarea>
                </div>
                
                <div class="form-group col-md-5">
                    <label for="meta_desc"> {{trans('home.meta_desc_ar')}}</label>
                    <textarea class="form-control" name="meta_desc_ar" placeholder="{{trans('home.meta_desc')}}"></textarea>
                </div>
                
                <div class="form-group col-md-12">
                    <label class="ckbox">
                        <input name="meta_robots" value="1" type="checkbox"><span class="tx-13">{{trans('home.meta_robots')}} (index)</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">

            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <button type="submit" class="btn btn-success"> {{trans('home.save_and_continue')}} </button>
                <a href="{{url('/admin/products')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
            </div>
        </div>

        {!! Form::close() !!}


        <!-- End Row -->
    </div>

@endsection

@section('script')
    <script>

        $(".readonly").keydown(function(e){
            e.preventDefault();
        });

        $body = $("body");
        $(document).on({
            ajaxStart: function() { $body.addClass("loading");    },
            ajaxStop: function() { $body.removeClass("loading"); }
        });

        $('#category').on('change',function(){
            colors = $('.colors');
            var categoryId = $('#category option:selected').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:" {{url('admin/products/sub-categories')}}",
                method:'POST',
                data:{categoryId:categoryId},
                success:function(html)
                {
                    $('.sub-sub-categories').html('');
                    $('.sub-categories').html(html.html);
                    $('.select2').select2({placeholder: 'Choose One'});
                    subCategories();

                    var colorSelect = '';
                    colorSelect += '<option></option>'
                    for(var i=0;i< html.colors.length;i++){
                        colorSelect += '<option  value="'+ html.colors[i].id +'">@if(\App::getLocale() == 'en')'+ html.colors[i].name_en +' @else '+ html.colors[i].name_ar +' @endif</option>';
                    }
                    colors.html(colorSelect);
                }
            });
        });

        function subCategories(){
            $('#sub-category').on('change',function(){
                colors = $('.colors');
                var categoryId = $('#sub-category option:selected').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:" {{url('admin/products/sub-categories')}}",
                    method:'POST',
                    data:{categoryId:categoryId},
                    success:function(html)
                    {
                        $('.sub-sub-categories').html(html.html);
                        $('.select2').select2({placeholder: 'Choose One'});

                        var colorSelect = '';
                        colorSelect += '<option></option>'
                        for(var i=0;i< html.colors.length;i++){
                            colorSelect += '<option  value="'+ html.colors[i].id +'">@if(\App::getLocale() == 'en')'+ html.colors[i].name_en +' @else '+ html.colors[i].name_ar +' @endif</option>';
                        }
                        colors.html(colorSelect);
                    }
                });
            });
        }

        $('.generate-barcode').on('click',function(){
            var barcode = $('.barcode').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:" {{url('admin/products/generate-barcode')}}",
                method:'POST',
                data:{barcode:barcode},
                success:function(data)
                {
                    $('.print').html('<div class="codeDiv"><img src="data:image/png;base64,' +data[0]+ '"><h3>'+data[1]+ '</h3></div>');
                    $('.barcode').val(data[1]);
                    $('.generate_code').remove();
                }
            });
        });

    </script>
@endsection

