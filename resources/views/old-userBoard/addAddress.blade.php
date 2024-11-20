@extends('layouts.app')
@section('meta')
    <title>{{trans('home.add_shipping_address')}}</title>
@endsection    
@section('content')

<main class="main">
    <!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav mb-10">
        <div class="container">
            <div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">{{trans('home.add_shipping_address')}}</h1>
                     <ul class="breadcrumb">
                        <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{trans('home.home')}}</a></li>
                        <li>{{trans('home.add_shipping_address')}}</li>
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
                        <h4 class="billing-address"> {{trans('home.add_shipping_address')}} <i class="w-icon-map-marker"></i></h4>
                        <hr>
                        
                        <form action="{{url('store/shipping-address')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-8">
                                    <label for="inputName4">{{trans('home.address')}}:<span style="color: red;padding: 0 3px">*</span></label>
                                    <input type="text" class="form-control" name="address" required>
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label for="inputName4">{{trans('home.landmark')}}:<span style="color: red;padding: 0 3px">*</span></label>
                                    <input type="text" class="form-control" name="landmark" required>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="inputName4">{{trans('home.phone1')}}:<span style="color: red;padding: 0 3px">*</span></label>
                                    <input type="tel"  pattern="^01[0-2]\d{1,8}$" class="form-control" name="phone1"  required>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="inputName4">{{trans('home.phone2')}}:</span></label>
                                   <input type="tel"  pattern="^01[0-2]\d{1,8}$" class="form-control" name="phone2"  >
                                </div>
                                {{--<div class="form-group col-sm-12 col-md-6">
                                    <label for="inputName4">{{trans('home.lat')}}:</label>
                                    <input type="text" class="form-control latitude"  name="latitude" id="latitude" required readonly >
                                </div>
                                
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="inputName4">{{trans('home.lng')}}:<span style="color: red;padding: 0 3px">*</span></label>
                                    <input type="text" class="form-control longitude" name="longtude" id="longitude" required readonly>
                                </div>
                                
                                <div class="form-group col-sm-12 col-md-12">
                                    <div  id="map-canvas" style="height: 250px"></div>
                                </div>--}}
                                
                                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                    <label for="inputName4">{{trans('home.country')}}:<span style="color: red;padding: 0 3px">*</span></label>
                                    <select class="form-control country select2" name="country_id"  required>
                                        <option></option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{(app()->getLocale() == 'en')?$country->name_en:$country->name_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                    <label for="inputName4">{{trans('home.region')}}:<span style="color: red;padding: 0 3px">*</span></label>
                                    <select class="form-control region select2" name="region_id"  required>
                                        <option></option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                    <label for="inputName4">{{trans('home.area')}}:<span style="color: red;padding: 0 3px">*</span></label>
                                    <select class="form-control area select2" name="area_id"  required>
                                        <option></option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-dark btn-rounded btn-icon-right">{{trans('home.save')}}</button>
                                </div>
                            </div>
                            
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of PageContent -->
</main>
@endsection

@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2DM4_HwOA3s6WsWcyhRt5Q_NO9CoxZpU&callback=initMap1" async defer></script>

    <script>

        $('.country').select2({
            'placeholder':'{{trans("home.countries")}}'
        });

        $('.region').select2({
            'placeholder':'{{trans("home.regions")}}'
        });

        $('.area').select2({
            'placeholder':'{{trans("home.areas")}}'
        });

        $('.country').change(function () {
            var id = $(this).val();
            var region = $('.region');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{url('getRegions')  }}',
                data: {id: id},
                success: function( data ) {
                    var html = '';
                    html += '<option></option>'
                    for(var i=0;i<data.length;i++){
                        html += '<option  value="'+ data[i].id +'">@if(\App::getLocale() == 'en')'+ data[i].name_en +' @else '+ data[i].name_ar +' @endif</option>';
                    }
                    region.html(html);
                }
            });
        });

        $('.region').change(function () {
            var id = $(this).val();
            var area = $('.area');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{url('getAreas')  }}',
                data: {id: id},
                success: function( data ) {
                    var html = '';
                    html += '<option></option>'
                    for(var i=0;i<data.length;i++){
                        html += '<option  value="'+ data[i].id +'">@if(\App::getLocale() == 'en')'+ data[i].name_en +' @else '+ data[i].name_ar +' @endif</option>';
                    }
                    area.html(html);
                }
            });
        });
    
    </script>
@endsection