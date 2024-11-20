@extends('layouts.admin')

@section('content')
<div>
    <div class="text-center"><h2>{{trans('home.accounting_report')}}</h2></div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="date_from"> {{trans('home.from')}}</label>
            <input type="text" class="form-control date_from" id="datepicker1" placeholder="{{trans('home.date_from')}}" name="date_from" autocomplete="off" >
        </div>
    
        <div class="form-group col-md-6">
            <label for="date_to">{{trans('home.to')}}</label>
            <input type="text" class="form-control date_to" id="datepicker2"   placeholder="{{trans('home.date_to')}}" name="date_to" autocomplete="off" >
        </div>
    </div>
    
    <div class="row">

        <div class="form-group select-group col-md-4">
            <label for="user">{{trans('home.payment_method')}}</label>
            <select class="form-control paymentMethodId" name="payment_id" id="payment_method" >
                <option></option>
                @foreach($paymentMethods as $paymentMethod)
                    <option value="{{$paymentMethod->id}}">{{$paymentMethod->name_en}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group select-group col-md-4">
            <label for="status">{{trans('home.status')}}</label>
            <select class="form-control status" name="status" id="status" >
                <option></option>
                <option value="paid">{{ trans('home.paid')}}</option>
                <option value="unpaid">{{ trans('home.unpaid')}}</option>
            </select>
        </div>
        
    </div>
    <div>
        <button class="btn btn-primary search">Search</button>
        <button class="btn btn-primary print">Print</button>
        <button class="btn btn-danger reset">Reset</button>
    </div>
    
    <div class="searchResult">
            
    </div>
   
</div>

@endsection
@section('script')
<script src="{{url('resources/assets/back/js/jquery.PrintArea.js')}}"></script>
    
<script>
    $('#payment_method').select2({
        'placeholder' : 'Payment Method',
    });
    
    $('#status').select2({
        'placeholder' : 'Status',
    });
    
    $( function() {
        $( "#datepicker1" ).datepicker({
          changeMonth: true,
          changeYear: true
        });
    });
    
   $( function() {
        $( "#datepicker2" ).datepicker({
          changeMonth: true,
          changeYear: true
        });
    });
      
    $('.reset').click(function(){
       $('input[type="text"]').val('');
       $('select').val('').trigger('change');;
    });
      
    $('.search').on('click',function(){
        var status = $('.status option:selected').val();
        var paymentMethodId = $('.paymentMethodId option:selected').val();
        var dateFrom = $('.date_from').val();
        var dateTo = $('.date_to').val();
        if(dateFrom && dateTo){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        
                $.ajax({
                    url:" {{url('accountingReportRseult')}}",
                    method:'POST',
                    data:{paymentMethodId:paymentMethodId,dateFrom:dateFrom,dateTo:dateTo,status:status},
                    success:function(html)
                    {
                        $('.searchResult').html(html.html);
                        $('#datatable').DataTable();
                    }
                });
        }else{
            alert('Please Select Date From And Date To');
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