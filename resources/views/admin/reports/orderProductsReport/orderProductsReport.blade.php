@extends('layouts.admin')
<title>{{trans('home.orders_products_report')}}</title>
@section('content')

<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.orders_products_report')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.orders_products_report')}}</li>
                </ol>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    
                    <div class="card-body">
                        <h6 class="card-title mb-1">{{trans('home.orders_products_report')}}</h6>
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
       $('select').val('').trigger('change');
    });
      
    $('.search').on('click',function(){
        var productId = $('#product option:selected').val();
        var dateFrom = $('.date_from').val();
        var dateTo = $('.date_to').val();

        if(dateFrom && dateTo){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:" {{url('admin/orderProducts-report')}}",
                method:'POST',
                data:{dateFrom:dateFrom,dateTo:dateTo},
                success:function(html)
                {
                    $('.searchResult').html(html.html);
                    $('#datatable').DataTable();
                }
            });
        }else{
            alert("{{trans('home.Please Select Date From And Date To and Product')}}");
        }
     
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