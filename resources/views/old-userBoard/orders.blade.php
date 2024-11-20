@extends('layouts.app')
@section('meta')
    <title>{{trans('home.my_orders')}}</title>
@endsection   
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection
@section('content')

<main class="main">
    <!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav mb-10">
        <div class="container">
            <div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">{{trans('home.my_orders')}}</h1>
                     <ul class="breadcrumb">
                        <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{trans('home.home')}}</a></li>
                        <li>{{trans('home.my_orders')}}</li>
                    </ul>
                </div>
           </div>
        </div>
    </nav>
    <!-- End of Breadcrumb -->

    <!-- Start of PageContent -->
    <div class="page-content pt-2 my-account">
        <div class="container">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->pull('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <div class="tab tab-vertical row gutter-lg">
                
                @include('userBoard.partials.nav-links')
                
                <div class="tab-content mb-6">

                    <div class="tab-pane mb-4  active in" id="account-orders">
                        <div class="icon-box icon-box-side icon-box-light">
                            <span class="icon-box-icon icon-orders">
                                <i class="w-icon-orders"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title text-capitalize ls-normal mb-0">{{trans('home.orders')}}</h4>
                            </div>
                        </div>

                        @if(count($orders)>0)
                            <table class="shop-table account-orders-table mb-6">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{trans('home.order_code')}}</th>
                                        <th>{{trans('home.date')}}</th>
                                        <th>{{trans('home.order_status')}}</th>
                                        <th>{{trans('home.payment_status')}}</th>
                                        <th>{{trans('home.total')}}</th>
                                        <th>{{trans('home.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $key=>$order)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$order->tracking_code}}</td>
                                            <td>{{date('Y-m-d', strtotime($order->created_at ))}}</td>
                                            <td>{{trans("home.$order->status")}}</td>
                                            <td>{{trans("home.$order->payment_status")}}</td>
                                            <td>{{$order->total_price}} {{trans("home.EGP")}}</td>
                                            <td class="ord-action">
                                                <a class="view" href="{{url('/track-order')}}/{{$order->id}}"><i class="fas fa-eye"></i></a>
                                                @if($order->status != 'delivered' && $order->status != 'canceled')
                                                    <a class="remove-btn" href="#"><i class="fas fa-times"></i></i> </a>
                                                    <form action="{{url('cancel/Order')}}" method="post" class="cancelOrder">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$order->id}}"/>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center">
                                <img src="{{url('resources/assets/front/images/empty-cart.png')}}">
                                <p><a href="{{url('/')}}">{{trans('home.continue_shopping')}}</a></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of PageContent -->
</main>


@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script> 
    <script>
        $(".review-rating").starRating({
            starSize: 50,
            disableAfterRate:false,
            callback: function(currentRating, $el){
                // make a server call here
                $(".myRate").val(currentRating);
            }
         });
         
        $('.remove-btn').on('click', function(){
            $.confirm({
                title: '{{trans("home.Cancel Order")}}',
                content: '{{trans("home.Are you to cancel order ?")}}',
                buttons: {
                    confirm: function(){
                        $('.cancelOrder').submit();
                    },
                    cancel: function(){
                        
                    }
                }
            });
        });
        
    </script>

    @if(Session::has('success'))
        <script>
            $.alert({
                title: "{{trans('home.thank_you')}}",
                content: "{{Session::get('success')}}",
                buttons: {
                    ok: {
                        text: "{{trans('home.OK')}}",
                        btnClass: 'btn main-btn',
                    },
                },
                columnClass: 'col-md-6'
            });
        </script>
    @endif
    @php
        Session::forget('success')
    @endphp
    
@endsection
