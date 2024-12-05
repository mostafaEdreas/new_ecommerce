@extends('layouts.admin')
@section('meta')
<title>{{trans('home.add_products')}}</title>
@endsection
@section('content')
<div class="spainer"></div>
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
                    <label>{{trans('home.name_en')}}</label>
                    <input class="form-control" name="name_en" value="{{old('name_en')}}" type="text" placeholder="{{trans('home.name_en')}}" required>
                 </div>

                 <div class="form-group col-md-6">
                    <label>{{trans('home.name_ar')}}</label>
                    <input class="form-control" name="name_ar" value="{{old('name_ar')}}" type="text" placeholder="{{trans('home.name_ar')}}" required>
                </div>

                <div class="form-group col-md-3">
                    <label>{{trans('home.code')}}</label>
                    <input class="form-control" name="code" value="{{old('code')}}" type="text" placeholder="{{trans('home.code')}}">
                </div>

                <div class="form-group col-md-3">
                    <label>{{trans('home.category')}}</label>
                    <select class="form-control select2" name="category_id" >
                        <option value="null" @selected(!old('category_id') )> {{__('home.no category') }} </option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" @selected(old('category_id') == $category->id )>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>{{trans('home.brands')}}</label>
                    <select class="form-control select2" name="brand_id">
                        <option value="null" @selected(!old('brand_id') )> {{__('home.no brand') }} </option>
                        @foreach($brands as $brand)
                            <option value="{{$brand->id}}" @selected(old('brand_id') == $brand->id )>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>{{trans('home.order')}}</label>
                    <input class="form-control" name="order" value="{{old('order')}}" type="text" placeholder="{{trans('home.order')}}" >
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

                <div class="form-group col-md-12">
                    <label for="helperText">{{trans('home.attributes')}}</label>
                    <select class="form-control role select2" name="attributes[]" multiple>
                        @foreach($attributes as $attribut)
                            <option @selected(old('attributs')?in_array($attribut,old('attributes',[])):false) value="{{$attribut->id}}" >{{ $attribut->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label> {{ trans('home.short_text_en') }} </label>
                    <textarea class="form-control" name="short_text_en"  rows="10" placeholder="{{ trans('home.short_text_en') }}" > {{old('short_text_en')}} </textarea>
                </div>
                <div class="form-group col-md-6">
                    <label> {{ trans('home.short_text_ar') }}</label>
                    <textarea class="form-control" name="short_text_ar" rows="10" placeholder="{{ trans('home.short_text_ar') }}"> {{old('short_text_ar')}} </textarea>
                </div>
                <div class="form-group col-md-6">
                    <label> {{ trans('home.text_en') }} </label>
                    <textarea class="area1" name="text_en" placeholder="{{ trans('home.text_en') }}"> {{old('text_en')}} </textarea>
                </div>
                <div class="form-group col-md-6">
                    <label> {{ trans('home.text_ar') }} </label>
                    <textarea class="area1" name="text_ar" placeholder="{{ trans('home.text_ar') }}">  {{old('text_ar')}} </textarea>
                </div>
                <div class="form-group col-md-12">
                    <label class="ckbox">
                        <input name="status" checked value="1" type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
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
                    <input type="text" autocomplete="off" value="{{old('link_en')}}"  class="form-control" placeholder="{{trans('home.link_en')}}" name="link_en">
                </div>

                <div class="form-group col-md-5">
                    <label for="meta_title"> {{trans('home.meta_title_en')}}</label>
                    <textarea class="form-control" name="meta_title_en" placeholder="{{trans('home.meta_title_en')}}"> {{old('meta_title_en') }} </textarea>
                </div>

                <div class="form-group col-md-5">
                    <label for="meta_desc"> {{trans('home.meta_desc_en')}}</label>
                    <textarea class="form-control" name="meta_desc_en" placeholder="{{trans('home.meta_desc_en')}}"> {{old('meta_desc_en') }} </textarea>
                </div>

                <div class="form-group col-md-12">
                    <hr>
                    <span class="badge badge-success">{{trans('home.ar')}}</span>
                </div>

                <div class="form-group col-md-2">
                    <label for="name_ar">{{trans('home.link_ar')}}</label>
                    <input type="text" autocomplete="off" value="{{old('link_ar') }}"  class="form-control" placeholder="{{trans('home.link_ar')}}" name="link_ar">
                </div>

                <div class="form-group col-md-5">
                    <label for="meta_title"> {{trans('home.meta_title_ar')}}</label>
                    <textarea class="form-control" name="meta_title_ar" placeholder="{{trans('home.meta_title_ar')}}"> {{old('meta_title_ar') }}</textarea>
                </div>

                <div class="form-group col-md-5">
                    <label for="meta_desc"> {{trans('home.meta_desc_ar')}}</label>
                    <textarea class="form-control" name="meta_desc_ar" placeholder="{{trans('home.meta_desc')}}"> {{old('meta_desc_ar') }}</textarea>
                </div>

                <div class="form-group col-md-12">
                    <label class="ckbox">
                        <input name="index" value="{{old('index') ?? 1}}" checked type="checkbox"><span class="tx-13">{{trans('home.meta_robots')}} (index)</span>
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

