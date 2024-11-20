@extends('layouts.admin')
<title>{{trans('home.orders')}}</title>
@section('content')
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.orders')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.orders')}}</li>
                </ol>
            </div>

            <div class="d-flex">
                <div class="">
                    <a href="#" class="btn ripple btn-secondary navresponsive-toggler mb-0" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fe fe-filter mr-1"></i> {{trans('home.filter')}} <i class="fas fa-caret-down ml-1"></i>
                    </a>
                </div>
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

        <div class="responsive-background">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="advanced-search">
                    <div class="row align-items-center">

                        <div class="form-group col-md-4">
                            <label for="code">{{trans('home.from')}}</label>
                            <div class="input-group">
                                <input type='text' class="form-control dateFrom"placeholder="{{trans('home.to')}}" id="datepicker1" readonly/>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="code">{{trans('home.to')}}</label>
                            <div class="input-group">
                                <input type='text' class="form-control dateTo" placeholder="{{trans('home.to')}}" id="datepicker2" readonly/>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="helperText">{{trans('home.order_status')}}</label>
                            <select class="form-control select2" name="order_status" id="order-status">
                                <option></option>
                                <option value="pending">{{trans('home.pending')}}</option>
                                <option value="accept">{{trans('home.accept')}}</option>
                                <option value="process">{{trans('home.process')}}</option>
                                <option value="shipping">{{trans('home.shipping')}}</option>
                                <option value="delivered">{{trans('home.delivered')}}</option>
                                <option value="canceled">{{trans('home.canceled')}}</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="text-right">
                        <a href="#" class="btn btn-primary order-filter">{{trans('home.applay')}}</a>
                        <a href="#" class="btn btn-secondary reset">{{trans('home.reset')}}</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">

                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div class="filter-result">
                            <div>
                                <h6 class="card-title mb-1">{{trans('home.orders')}}</h6>
                                <p class="text-muted card-sub-title">{{trans('home.table_contain_all_data_shortly_you_can_view_more_details')}}</p>
                            </div>
                            <div class="table-responsive">
{{--                                {{ $orders }}--}}
                                <table class="table" id="exportexample" data-order='[[ 1, "desc" ]]'>
                                    <thead>
                                        <tr>
                                            <th>{{trans('home.order_number')}}</th>
                                            <th>{{trans('home.order_date')}}</th>
                                            <th>{{trans('home.order_user')}}</th>
                                            <th>{{trans('home.order_address')}}</th>
                                            <th>{{trans('home.order_phone_numbers')}}</th>
                                            <!--<th>{{trans('home.order_products')}}</th>-->
                                            <th>{{trans('home.order_status')}}</th>
                                            <th>{{trans('home.payment_status')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $key=>$order)
                                            <tr @if($order->admin_seen == 0) style="background: #e1e6f1" @endif>
                                                <td><a href="{{ route('orders.edit', $order->id) }}">{{$order->id}}</a></td>
                                                <td>{{date('Y-m-d', strtotime($order->created_at ))}}</td>
                                                <td><a href="{{ route('orders.edit', $order->id) }}">{{$order->user->f_name.' '.$order->user->l_name}}</a></td>
                                                <td><a href="{{ route('orders.edit', $order->id) }}">{{($order->address)?$order->address->address:trans('home.unknown_address')}}</a></td>
                                                <td><a href="{{ route('orders.edit', $order->id) }}">{{($order->address)?$order->address->phone1:trans('home.unknown_phone')}} </a></td>

                                                <!--<td>-->
                                                <!--    @foreach($order->products() as $orderProduct)-->
                                                <!--        {{(app()->getLocale() > 0)?$orderProduct->product->name_en:$orderProduct->product->name_ar}}-->
                                                <!--        @if(!$loop->last)-->
                                                <!--            --->
                                                <!--            <br>-->
                                                <!--        @endif-->
                                                <!--    @endforeach-->
                                                <!--</td>-->

                                                <td>
                                                    @if($order->status == 'pending')
                                                        <span class="badge badge-primary">{{trans('home.pending')}}</span>
                                                    @elseif($order->status == 'accept')
                                                        <span class="badge badge-secondary">{{trans('home.accept')}}</span>
                                                    @elseif($order->status == 'process')
                                                        <span class="badge badge-info">{{trans('home.process')}}</span>
                                                    @elseif($order->status == 'shipping')
                                                        <span class="badge badge-default">{{trans('home.shipping')}}</span>
                                                    @elseif($order->status == 'delivered')
                                                        <span class="badge badge-success">{{trans('home.delivered')}}</span>
                                                    @elseif($order->status == 'canceled')
                                                        <span class="badge badge-danger">{{trans('home.canceled')}}</span>
                                                    @elseif($order->status == 'canceled_by_admin')
                                                        <span class="badge badge-danger">{{trans('home.canceled_by_admin')}}</span>
                                                    @endif
                                                </td>
                                                @if($order->payment_status == 'payed')
                                                     <td><a href="{{ route('orders.edit', $order->id) }}">{{ __('home.paid')}} </a></td>
                                                @else
                                                    <td><a href="{{ route('orders.edit', $order->id) }}">{{ __('home.unpaid')}} </a></td>
                                                @endif

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>
@endsection


@section('script')
    <script>

        $(document).on({
            ajaxStart: function() { $('#loader').show();},
            ajaxStop: function() {  $('#loader').hide();}
        });

        $('.order-filter').on('click',function(){
            var dateFrom = $('.dateFrom').val();
            var dateTo = $('.dateTo').val();
            var status = $('#order-status option:selected').val();

            if(dateFrom && dateTo){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:" {{url('admin/orders/filter')}}",
                    method:'POST',
                    data:{dateFrom:dateFrom,dateTo:dateTo,status:status},
                    success:function(html)
                    {
                        $('.filter-result').html(html.html);
                    }
                });
            }else{
                alert("{{trans('home.Please Select Date From And Date To')}}");
            }
        });

        $('.reset').click(function(){
            $('input[type="text"]').val('');
            $('select').val('').trigger('change');;
        });

        $( "#datepicker1" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });

        $( "#datepicker2" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });

    </script>
@endsection