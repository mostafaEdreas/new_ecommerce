@extends('layouts.admin')
<title>{{trans('home.add_coupon')}}</title>
@section('content')

<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.coupons')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/coupons')}}">{{trans('home.coupons')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.add_coupon')}}</li>
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
                            <h6 class="card-title mb-1">{{trans('home.add_coupon')}}</h6>
                        </div>
                        {!! Form::open(['route' => 'coupons.store', 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">

                                <div class="form-group col-md-4">
                                    <label for="name">{{trans('home.name')}}</label>
                                    <input type="text"  class="form-control" placeholder="{{trans('home.name')}}" name="name" required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="code">{{trans('home.code')}}</label>
                                    <input type="text"  class="form-control" placeholder="{{trans('home.code')}}" name="code" required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="code">{{trans('home.expire_date')}}</label>
                                    <div class="input-group">
                                        <input type='text' class="form-control" name="expire_date" placeholder="{{trans('home.expire_date')}}" id="datepicker" readonly/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="value_type">{{trans('home.value_type')}}</label>
                                    <select class="form-control select2" name="value_type">
                                        <option value="value">{{trans('home.value')}}</option>   
                                        <option value="percentage">{{trans('home.percentage')}}</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="value">{{trans('home.value')}}</label>
                                    <input type="number" min="0" class="form-control" placeholder="{{trans('home.value')}}" name="value" required>
                                </div> 
                                
                                
                                <div class="form-group col-md-6">
                                    <label for="max_used">{{trans('home.max_used')}}</label>
                                    <input type="number" min="0" class="form-control" placeholder="{{trans('home.max_used')}}" name="max_used" value ="1" required>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="order_min_price">{{trans('home.order_min_price')}}</label> <span>{{trans('home.order_price_in_egp')}}</span>
                                    <input type="number" min="0" class="form-control" placeholder="{{trans('home.order_min_price')}}" name="order_min_price" value="100" required>
                                </div>

                                
                                <div class="col-md-12 ">
                                    <label for="coupon_type">{{trans('home.coupon_type')}}</label>
                                    <select class="form-control coupon_type select2" name="coupon_type">
                                        <option value="general">{{trans('home.general')}}</option>
                                        <option value="category">{{trans('home.category')}}</option>
                                        <option value="product">{{trans('home.product')}}</option>
                                        <option value="brand">{{trans('home.brand')}}</option>
                                        <option value="user">{{trans('home.user')}}</option>
                                        <option value="region">{{trans('home.region')}}</option>
                                        <option value="free_shipping">{{trans('home.free_shipping')}}</option>
                                    </select>
                                </div>

                                <div class="col-md-12  type">

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
    </script>
@endsection
