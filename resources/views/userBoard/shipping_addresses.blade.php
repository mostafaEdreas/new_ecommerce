@extends('layouts.app')
@section('meta')
    <title>{{$configration->app_name}}|{{trans('home.shipping_addresses')}}</title>
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection
@section('content')
<!-- Page Title -->
<div class="page section-header text-center mb-0">
    <div class="page-title">
        <div class="wrapper"><h1 class="page-width">{{trans('home.shipping_addresses')}}</h1></div>
    </div>
</div>
<!-- End Page Title -->
<div class="bredcrumbWrap bredcrumbWrapPage bredcrumb-style2 text-center">
    <div class="container breadcrumbs">
        <a href="{{url('/')}}" title="Back to home page">{{trans('home.home')}}</a><span aria-hidden="true">|</span><span class="title-bold">{{trans('home.shipping_addresses')}}</span>
    </div>
</div>

<!--End Breadcrumbs-->
<div class="container">
    @include('userBoard.partials.profile')
    <div class="row mb-5">
        @include('userBoard.partials.nav-links')

        <div class="col-xs-10 col-lg-10 col-md-12">
            <!-- Tab panes -->
            <div class="dashboard-content padding-30px-all md-padding-15px-all">
                <!-- Dashboard -->
                <div id="dashboard" class="tab-pane fade active show">
                    <h3>{{trans('home.shipping_addresses')}}</h3>
                    <p class="xs-fon-13 margin-10px-bottom">{{trans('home.The following addresses will be used on the checkout page by default')}}</p>
                    @if(count($addresses) > 0)
                        </br>
                        <a class="btn" href="{{url('user/add/shipping-address')}}">{{trans('home.create_new_address')}}</a>
                        <hr>

                        @foreach($addresses as $address)
                            <div class="shipping-addresses">
                                <p><strong>{{trans('home.landmark')}} : </strong>{{($address->land_mark)?$address->land_mark:trans('home.no_landmark')}}</p>
                                <p><strong>{{trans('home.address')}} : </strong>{{$address->address}}</p>
                                <p><strong>{{trans('home.region')}} : </strong>@if($address->region) {{(app()->getLocale() == 'en')?$address->region->name_en:$address->region->name_ar}} @endif</p>
                                <p><strong>{{trans('home.area')}} : </strong>@if($address->area) {{(app()->getLocale() == 'en')?$address->area->name_en:$address->area->name_ar}} @endif</p>
                                <p><strong>{{trans('home.country')}} : </strong>@if($address->country) {{(app()->getLocale() == 'en')?$address->country->name_en:$address->country->name_ar}} @endif</p>
                                <p><strong>{{trans('home.phone1')}} : </strong>{{$address->phone1}}</p>
                                @if($address->phone2)
                                    <p><strong>{{trans('home.phone2')}} : </strong>{{$address->phone2}}</p>
                                @endif
                            </div>
                            <div class="d-flex">
                                <a class="btn" href="{{url('/user/shipping-address/edit/'.$address->id)}}">{{trans('home.edit')}}</a>

                                @if($address->is_primary == 0)
                                    <form action="{{url('make/userAddress/primary/'.$address->id)}}" method="post" id="primary_address">
                                        @csrf
                                        <a class="btn make_primary" href="#">{{trans('home.make primary')}}</a>
                                    </form>
                                @endif

                                <form action="{{url('delete/userAddress')}}/{{$address->id}}" method="post" class="deleteAddress">
                                    @csrf
                                    <a class="btn delete_address" href="#">{{trans('home.delete')}}</a>
                                </form>

                            </div>
                            @if(!$loop->last)
                            <hr>
                            @endif
                        @endforeach
                    @else
                        <div class="text-center">
                            <img src="{{url('resources/assets/front/images/no-address.png')}}"/>
                            <p>{{trans('home.no_address_created')}}</p>
                            <a class="btn" href="{{url('user/add/shipping-address')}}">{{trans('home.create_new_address')}}</a>
                        </div>
                    @endif

                </div>
                <!-- End Dashboard -->
            </div>
            <!-- End Tab panes -->
        </div>
    </div>
</div>
<!--End Body Container-->
@endsection


@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    {{-- <script>
        $(".review-rating").starRating({
            starSize: 50,
            disableAfterRate:false,
            callback: function(currentRating, $el){
                // make a server call here
                $(".myRate").val(currentRating);
            }
        });

        $('.make_primary').on('click', function(){
            btn= $(this);
            $.confirm({
                title: '{{trans("home.make primary address")}}',
                content: '{{trans("home.Are you sure you want to make that address is primary?")}}',
                buttons: {
                    confirm: function(){
                        btn.closest("form").submit();
                    },
                    cancel: function(){

                    }
                }
            });
        });


        $('.delete_address').on('click', function(){
            btn= $(this);
            $.confirm({
                title: '{{trans("home.delete address")}}',
                content: '{{trans("home.Are you sure you want to delete that ?")}}',
                buttons: {
                    confirm: function(){
                        btn.closest("form").submit();
                    },
                    cancel: function(){

                    }
                }
            });
        });

    </script>   --}}

    @if(Session::has('error'))
        <script>
            $.alert({
                title: "{{Session::get('error')}}",
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

