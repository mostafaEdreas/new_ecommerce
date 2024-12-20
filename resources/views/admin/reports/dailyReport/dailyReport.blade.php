@extends('layouts.admin')
<title>{{trans('home.daily_report')}}</title>
@section('content')

<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.daily_report')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.daily_report')}}</li>
                </ol>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    
                    <div class="card-body">
                        <h6 class="card-title mb-1">{{trans('home.daily_report')}}</h6>
                        <hr>
                        
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="date_from"> {{trans('home.date')}}</label>
                                <div class="input-group">
                                    <input type='text' class="form-control date" name="date" placeholder="{{trans('home.date')}}" id="datepicker" readonly/>
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
        $( "#datepicker" ).datepicker({
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

        var date = $('.date').val();
 
        if(date){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $.ajax({
                url:" {{url('admin/daily-report')}}",
                method:'POST',
                data:{date:date},
                success:function(html)
                {
                    $('.searchResult').html(html.html);
                    $('#datatable').DataTable();
                }
            });
        }else{
            alert('Please Select Date ');
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