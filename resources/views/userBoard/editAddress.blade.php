@extends('layouts.app')
@section('meta')
    <title>{{$configration->app_name}}|{{trans('home.edit_shipping_address')}}</title>
@endsection   

@section('content')
<!-- Page Title -->
<div class="page section-header text-center mb-0">
    <div class="page-title">
        <div class="wrapper"><h1 class="page-width">{{trans('home.edit_shipping_address')}}</h1></div>
    </div>
</div>
<!-- End Page Title -->
<div class="bredcrumbWrap bredcrumbWrapPage bredcrumb-style2 text-center">
    <div class="container breadcrumbs">
        <a href="{{url('/')}}" title="Back to home page">{{trans('home.home')}}</a><span aria-hidden="true">|</span><span class="title-bold">{{trans('home.edit_shipping_address')}}</span>
    </div>
</div>

<div class="container">
    @include('userBoard.partials.profile')
    <div class="row mb-5">
        @include('userBoard.partials.nav-links')

        <div class="col-xs-10 col-lg-10 col-md-12">
            <!-- Tab panes -->
            <div class="dashboard-content padding-30px-all md-padding-15px-all">
                <!-- Dashboard -->
                <div id="dashboard" class="tab-pane fade active show">
                    <h3>{{trans('home.edit_shipping_address')}}</h3>
                    <form action="{{url('update/userAddress')}}/{{$address->id}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="inputName4">{{trans('home.address')}}:<span style="color: red;padding: 0 3px">*</span></label>
                                <input type="text" class="form-control" placeholder="{{trans('home.address')}}" name="address" value="{{$address->address}}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="inputName4">{{trans('home.landmark')}}:<span style="color: red;padding: 0 3px">*</span></label>
                                <input type="text" class="form-control" placeholder="{{trans('home.landmark')}}" name="landmark" value="{{$address->land_mark}}">
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="inputName4">{{trans('home.phone1')}}:<span style="color: red;padding: 0 3px">*</span></label>
                                <input type="text" class="form-control" placeholder="{{trans('home.phone1')}}" name="phone1" value="{{$address->phone1}}" pattern="^01[0-2]\d{1,8}$" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="inputName4">{{trans('home.phone2')}}:</label>
                               <input type="text" class="form-control" placeholder="{{trans('home.phone2')}}" name="phone2" value="{{$address->phone2}}" pattern="^01[0-2]\d{1,8}$">
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
                            </div> --}} 
                                
                            <div class="form-group col-md-4">
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
                        <button type="submit" class="btn float main-btn">{{trans('home.save')}}</button>
                    </form>
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


                    