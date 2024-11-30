@extends('layouts.admin')
<title>{{trans('home.weekly_report')}}</title>
@section('content')

<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.weekly_report')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.weekly_report')}}</li>
                </ol>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    
                    <div class="card-body">
                        <h6 class="card-title mb-1">{{trans('home.weekly_report')}}</h6>
                        <hr>
                        
                        <div class="row">                        
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


    $('.search').on('click',function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:" {{url('admin/weekly-report')}}",
            method:'POST',
            success:function(html)
            {
                $('.searchResult').html(html.html);
                $('#datatable').DataTable();
            }
        });     
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