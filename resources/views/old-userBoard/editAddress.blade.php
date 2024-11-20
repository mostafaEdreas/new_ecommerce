@extends('layouts.app')
@section('meta')
    <title>{{trans('home.edit_shipping_address')}}</title>
@endsection   

@section('content')


<main class="main">
    <!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav mb-10">
        <div class="container">
            <div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">{{trans('home.edit_shipping_address')}}</h1>
                     <ul class="breadcrumb">
                        <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{trans('home.home')}}</a></li>
                        <li>{{trans('home.edit_shipping_address')}}</li>
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
                        <h4 class="billing-address"> {{trans('home.edit_shipping_address')}} <i class="w-icon-map-marker"></i></h4>
                        <hr>
                        
                        <form action="{{url('update/userAddress')}}/{{$address->id}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-8">
                                    <label for="inputName4">{{trans('home.address')}}:<span style="color: red;padding: 0 3px">*</span></label>
                                    <input type="text" class="form-control" placeholder="{{trans('home.address')}}" name="address" value="{{$address->address}}" required>
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label for="inputName4">{{trans('home.landmark')}}:<span style="color: red;padding: 0 3px">*</span></label>
                                    <input type="text" class="form-control" placeholder="{{trans('home.landmark')}}" name="landmark" value="{{$address->landmark}}">
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="inputName4">{{trans('home.phone1')}}:<span style="color: red;padding: 0 3px">*</span></label>
                                    <input type="tel"  pattern="^01[0-2]\d{1,8}$" class="form-control" placeholder="{{trans('home.phone1')}}" name="phone1" value="{{$address->phone1}}" >
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="inputName4">{{trans('home.phone2')}}:</label>
                                   <input type="tel"  pattern="^01[0-2]\d{1,8}$" class="form-control" placeholder="{{trans('home.phone2')}}" name="phone2" value="{{$address->phone2}}" >
                                </div>
    
                                {{--<div class="form-group col-sm-12 col-md-6">
                                    <label for="inputName4"> {{trans('home.lat')}}:</label>
                                    <input type="text" class="form-control latitude" placeholder="{{trans('home.latitude')}}"  name="latitude" id="latitude" value="{{$address->lat}}" readonly>
                                </div>
    
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="inputName4"> {{trans('home.lng')}}:<span style="color: red;padding: 0 3px">*</span></label>
                                    <input type="text" class="form-control longitude" placeholder="{{trans('home.longtude')}}"  name="longtude" id="longitude" value="{{$address->lng}}" readonly>
                                </div>
                                
                                <div class="form-group col-sm-12 col-md-12">    
                                    <div id="map-canvas" style="height: 250px"></div>
                                </div>--}}
                                    
                                <div class="form-group col-4">
                                    <label for="inputName4">{{trans('home.country')}}: <span style="color: red;padding: 0 3px">*</span></label>
                                    <select class="form-control country select2" name="country_id"  >
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}" @if($address->country_id == $country->id) selected @endif>{{(app()->getLocale() == 'en')?$country->name_en:$country->name_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputName4">{{trans('home.region')}}: <span style="color: red;padding: 0 3px">*</span></label>
                                    <select class="form-control region select2" name="region_id"  required>
                                        @foreach($regions as $region)
                                            <option value="{{$region->id}}" @if($address->region_id == $region->id) selected @endif>{{(app()->getLocale() == 'en')?$region->name_en :$region->name_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputName4">{{trans('home.area')}}: <span style="color: red;padding: 0 3px">*</span></label>
                                    <select class="form-control area select2" name="area_id" required >
                                        @foreach($areas as $area)
                                            <option value="{{$area->id}}"@if($address->area_id == $area->id) selected @endif>{{(app()->getLocale() == 'en')?$area->name_en :$area->name_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-dark btn-rounded btn-icon-right">{{trans('home.save')}}</button>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2DM4_HwOA3s6WsWcyhRt5Q_NO9CoxZpU&callback=initMap2" async defer></script>

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


                    