@extends('layouts.app')
@section('meta')
    <title>{{trans('home.shipping_addresses')}}</title>
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
                    <h1 class="page-title mb-0">{{trans('home.shipping_addresses')}}</h1>
                     <ul class="breadcrumb">
                        <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{trans('home.home')}}</a></li>
                        <li>{{trans('home.shipping_addresses')}}</li>
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
                   <div class="tab-pane mb-4  active in" id="account-addresses">
                        <h4 class="billing-address"> {{trans('home.shipping_addresses')}}<i class="w-icon-map-marker"></i></h4>
                        <p class="xs-fon-13 margin-10px-bottom">{{trans('home.The following addresses will be used on the checkout page by default')}}</p>
                        <a class="address" href="{{url('user/add/shipping-address')}}">{{trans('home.create_new_address')}}</a>
                        <hr>
                        @if(count($addresses) > 0)
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

                                    <div class="d-flex">
                                         <a class="view margin-5px-bottom" href="{{url('/user/shipping-address/edit/'.$address->id)}}">{{trans('home.edit')}}</a>

                                        @if($address->is_primary == 0)
                                            <form action="{{url('make/userAddress/primary/'.$address->id)}}" method="post" id="primary_address">
                                                @csrf
                                                <a class="view-1 margin-5px-bottom make_primary" href="#">{{trans('home.make primary')}}</a>
                                            </form>
                                        @endif

                                        <form action="{{url('delete/userAddress')}}/{{$address->id}}" method="post" class="deleteAddress">
                                            @csrf
                                            <a class="view-2 margin-5px-bottom delete_address" href="#">{{trans('home.delete')}}</a>
                                        </form>
                                    </div>
                                </div>

                                <hr>
                            @endforeach
                        @else
                            <div class="text-center">
                                <img src="{{url('resources/assets/front/images/no-address.png')}}"/>
                                <p>{{trans('home.no_address_created')}}</p>
                                <a href="{{url('user/add/shipping-address')}}">{{trans('home.create_new_address')}}</a>
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

