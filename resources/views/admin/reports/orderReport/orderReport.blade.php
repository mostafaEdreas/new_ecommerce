@extends('layouts.admin')
<title>{{trans('home.order_report')}}</title>
@section('content')

<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.order_report')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.order_report')}}</li>
                </ol>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    
                    <div class="card-body">
                        <h6 class="card-title mb-1">{{trans('home.order_report')}}</h6>
                        <hr>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="date_from"> {{trans('home.from')}}</label>
                                <div class="input-group">
                                    <input type='text' class="form-control date_from" name="date_from" placeholder="{{trans('home.date_from')}}" id="datepicker1" readonly/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="form-group col-md-6">
                                <label for="date_to">{{trans('home.to')}}</label>
                                <div class="input-group">
                                    <input type='text' class="form-control date_to" name="date_to" placeholder="{{trans('home.date_to')}}" id="datepicker2" readonly/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group col-md-3">
                                <label for="brands">{{trans('home.brands')}}</label>
                                <select class="form-control select2" name="brand_id" id="brand" >
                                    <option></option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{(app()->getLocale() == 'en')?$brand->name_en:$brand->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                                    
                            <div class="form-group col-md-3">
                                <label for="categories">{{trans('home.categories')}}</label>
                                <select class="form-control select2" name="category_id" id="category" >
                                    <option></option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{(app()->getLocale() == 'en')?$category->name_en:$category->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                                    
                            <div class="form-group col-md-3">
                                <label for="shippingMethod">{{trans('home.shipping_methods')}}</label>
                                <select class="form-control select2" name="shipping_id" id="shippingMethod" >
                                    <option></option>
                                    @foreach($shippingMethods as $shippingMethod)
                                        <option value="{{$shippingMethod->id}}">{{(app()->getLocale() == 'en')?$shippingMethod->name_en:$shippingMethod->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                                    
                            <div class="form-group col-md-3">
                                <label for="paymentMethods">{{trans('home.payment_methods')}}</label>
                                <select class="form-control select2" name="payment_id" id="paymentMethods" >
                                    <option></option>
                                    @foreach($paymentMethods as $paymentMethod)
                                        <option value="{{$paymentMethod->id}}">{{(app()->getLocale() == 'en')?$paymentMethod->name_en:$paymentMethod->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="products">{{trans('home.products')}}</label>
                                <select class="form-control select2" name="products_id" id="products" >
                                    <option></option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{(app()->getLocale() == 'en')?$product->name_en:$product->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="regions">{{trans('home.regions')}}</label>
                                <select class="form-control select2" name="region_id" id="regions">
                                    <option></option>
                                    @foreach($regions as $region)
                                        <option value="{{$region->id}}">{{(app()->getLocale() == 'en')?$region->name_en:$region->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12">
                                <a href="javascript:void(0);" class="search btn" title="{{trans('home.search')}}" ><i class="fas fa-search"></i></a>
                                <a href="javascript:void(0);" class="print btn" title="{{trans('home.print')}}" ><i class="fas fa-print"></i></a>
                                <a href="javascript:void(0);" class="reset btn" title="{{trans('home.reset')}}" ><i class="fas fa-undo-alt"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
        
        <div class="searchResult">
                                
        </div>
    </div>

@endsection

@section('script')
<script src="{{url('resources/assets/back/js/jquery.PrintArea.js')}}"></script>
<script>

   $( function() {
        $( "#datepicker2" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
    });
    
    $( function() {
        $( "#datepicker1" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
    });
      
    $('.reset').click(function(){
       $('input[type="text"]').val('');
       $('select').val('').trigger('change');;
    });
      
    $('.search').on('click',function(){
        var brandId = $('#brand option:selected').val();
        var categoryId = $('#category option:selected').val();
        var paymentId = $('#paymentMethods option:selected').val();
        var shippingId = $('#shippingMethod option:selected').val();
        var productId = $('#products option:selected').val();
        var regionId = $('#regions option:selected').val();

        var dateFrom = $('.date_from').val();
        var dateTo = $('.date_to').val();
        if(dateFrom && dateTo){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        
                $.ajax({
                    url:" {{url('admin/order-report')}}",
                    method:'POST',
                    data:{regionId:regionId,brandId:brandId,productId:productId,categoryId:categoryId,paymentId:paymentId,shippingId:shippingId,dateFrom:dateFrom,dateTo:dateTo},
                    success:function(html)
                    {
                        $('.searchResult').html(html.html);
                        $('#datatable').DataTable();
                    }
                });
        }else{
            alert("{{trans('home.Please Select Date From And Date To')}}");
        }
     
    });


    $('#status').select2({
        'placeholder' : 'Status',
    });
    
    $('#paymentMethods').select2({
        'placeholder' : 'Payment Method',
    });
    
    $('#shippingMethod').select2({
        'placeholder' : 'Shipping Method',
    });
    
    $('#category').select2({
        'placeholder' : 'category',
    });
    
    $('#brand').select2({
        'placeholder' : 'Brand',
    });
    
    $('#product').select2({
        'placeholder' : 'product',
    });
    

    
    ///////////////////// print report/////////////////////////////////
    
    $(document).ready(function(){
        $(".print").click(function(){
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = { mode : mode, popClose : close};
            $("#DivIdToPrint").printArea( options );
        });
    });
    
    
</script>
@endsection