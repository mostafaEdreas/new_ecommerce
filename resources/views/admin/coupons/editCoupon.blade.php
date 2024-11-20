@extends('layouts.admin')
<title>{{trans('home.edit_coupon')}}</title>
@section('content')

<div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.coupons')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/coupons')}}">{{trans('home.coupons')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.edit_coupon')}}</li>
                </ol>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
    
                    <div class="card-body">
                        <div>
                            <h6 class="card-title">{{trans('home.edit_coupon')}}</h6>
                        </div>
                        {!! Form::open(['method'=>'PATCH','url' => 'admin/coupons/'.$coupon->id, 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">

                                <div class="form-group col-md-4">
                                    <label for="name">{{trans('home.name')}}</label>
                                    <input type="text"  class="form-control" placeholder="{{trans('home.name')}}" name="name" value="{{$coupon->name}}" required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="code">{{trans('home.code')}}</label>
                                    <input type="text"  class="form-control" placeholder="{{trans('home.code')}}" name="code" value="{{$coupon->code}}" required> 
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="code">{{trans('home.expire_date')}}</label>
                                    <div class="input-group">
                                        <input type='text' class="form-control" name="expire_date" placeholder="{{trans('home.expire_date')}}" value="{{$coupon->expire_date}}" id="datepicker" readonly/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                                
                                <div class="form-group col-md-6">
                                    <label for="value_type">{{trans('home.value_type')}}</label>
                                    <select class="form-control value_type select2" name="value_type">
                                        <option value="value" {{($coupon->value_type == 'value')?'selected':''}}>{{trans('home.value')}}</option>   
                                        <option value="percentage" {{($coupon->value_type == 'percentage')?'selected':''}}>{{trans('home.percentage')}}</option>
                                    </select>
                                </div> 
                                
                                <div class="form-group col-md-6">
                                    <label for="value">{{trans('home.value')}}</label>
                                    <input type="number" min="0" class="form-control" placeholder="{{trans('home.value')}}" name="value" value="{{$coupon->value}}" required>
                                </div>   

                                <div class="col-md-6">
                                    <label for="max_used">{{trans('home.max_used')}}</label>
                                    <input type="number" min="0" class="form-control" placeholder="{{trans('home.max_used')}}" name="max_used" value ="{{$coupon->max_used}}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="order_min_price">{{trans('home.order_min_price')}}</label> <span style="color:red; font-size:12px">{{trans('home.order_price_in_egp')}}</span>
                                    <input type="number" min="0" class="form-control" placeholder="{{trans('home.order_min_price')}}" name="order_min_price" value="{{$coupon->order_min_price}}" required>
                                </div>  
                                
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label for="coupon_type">{{trans('home.coupon_type')}}</label>
                                        <select class="form-control coupon_type select2" name="coupon_type">
                                            <option value="general" {{($coupon->coupon_type == 'general')?'selected':''}}>{{trans('home.general')}}</option>
                                            <option value="category" {{($coupon->coupon_type == 'category')?'selected':''}}>{{trans('home.category')}}</option>
                                            <option value="product" {{($coupon->coupon_type == 'product')?'selected':''}}>{{trans('home.product')}}</option>
                                            <option value="brand" {{($coupon->coupon_type == 'brand')?'selected':''}}>{{trans('home.brand')}}</option>
                                            <option value="user" {{($coupon->coupon_type == 'user')?'selected':''}}>{{trans('home.user')}}</option>
                                            <option value="region" {{($coupon->coupon_type == 'region')?'selected':''}}>{{trans('home.region')}}</option>
                                            <option value="free_shipping" {{($coupon->coupon_type == 'free_shipping')?'selected':''}}>{{trans('home.free_shipping')}}</option>
                                        </select>
                                    </fieldset>
                                </div>
                                
                                <div class="col-md-12 type">
                                    @if($coupon->coupon_type != 'general')
                                    <div class="col-md-12">
                                        <hr>
                                        <fieldset class="form-group">
                                            <label for="categories">{{trans("home.$coupon->coupon_type")}}</label>
                                            <select class="form-control multiple select2" name="{{$coupon->coupon_type.'_id[]'}}" multiple>
                                                @foreach($values as $value)
                                                    <option value="{{$value->id}}" {{(in_array($value->id,$selectedValueIds))?'selected':''}}>@if($coupon->coupon_type == 'user'){{$value->name}}@else @if(app()->getLocale() == 'en') {{$value->name_en}} @else {{$value->name_ar}} @endif @endif</option>
                                                @endforeach
                                            </select>
                                            <input type="checkbox" class="checkbox" >  {{trans('home.selectall')}}
                                        </fieldset>
                                    </div>
                                    @endif
                                </div>

                                <br>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin/coupons')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
                                </div>
                                
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>

@endsection


@section('script')
    <script>
        $( "#datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });

        $('.coupon_type').select2();
        $('.value_type').select2();

        $('.coupon_type').on('change',function(){
            var type = $('.coupon_type option:selected').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:" {{route('couponType')}}",
                method:'POST',
                data:{type:type},
                success:function(html)
                {
                    $('.type').html(html.html);
                }
            });
        });

        $(document).ready(function() {
            $('.multiple').select2();
        });

        $(".checkbox").click(function(){
            if($(".checkbox").is(':checked') ){
                $(".multiple > option").prop("selected",true);
                $(".multiple").trigger("change");
            }else{
                $('.multiple option:selected').prop("selected", false);
                $(".multiple").trigger("change");
            }
        });
    </script>
@endsection
