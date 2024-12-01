@extends('layouts.admin')
@section('meta')
    <title>{{trans('home.edit_setting')}}</title>
@endsection
@section('content')

<div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.edit_setting')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.edit_setting')}}</li>
                </ol>
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

        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">

                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{trans('home.edit_setting')}}</h6>
                        </div>
                        {!! Form::open(['method'=>'PATCH','url' => 'admin/settings/'.$settings->id, 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">

                                <div class="form-group col-md-2">
                                    <label for="helperText">{{trans('home.default_lang')}}</label>
                                    <select class="form-control select2" name="default_lang" required>
                                        <option value="en" {{ (config('site_lang')=="en")?'selected':'' }}>{{trans('home.english')}}</option>
                                        <option value="ar" {{ (config('site_lang')=="ar")?'selected':'' }}>{{trans('home.arabic')}}</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="">{{trans('home.contact_email')}}</label>
                                    <input type="text" class="form-control" placeholder="{{trans('home.contact_email')}}" name="contact_email" value="{{ config('site_contact_email') }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="">{{trans('home.email')}}</label>
                                    <input type="text" class="form-control" placeholder="{{trans('home.email')}}" name="email" value="{{ config('site_email') }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="">{{trans('home.telphone')}}</label>
                                    <input type="number"  min="0" class="form-control" placeholder="{{trans('home.telephone')}}" name="telephone" value="{{ config('site_telephone')}}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="">{{trans('home.mobile')}}</label>
                                    <input type="number"  min="0" class="form-control" placeholder="{{trans('home.mobile')}}" name="mobile" value="{{ config('site_mobile') }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="">{{trans('home.fax')}}</label>
                                    <input type="fax"  min="0" class="form-control" placeholder="{{trans('home.fax')}}" name="fax" value="{{ config('site_fax') }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="">{{trans('home.whatsapp')}}</label>
                                    <input type="whatsapp"  min="0" class="form-control" placeholder="{{trans('home.whatsapp')}}" name="whatsapp" value="{{ config('site_whatsapp') }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="">{{trans('home.snapchat')}}</label>
                                    <input type="snapchat"  min="0" class="form-control" placeholder="{{trans('home.snapchat')}}" name="snapchat" value="{{ config('site_snapchat') }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="facebook">{{trans('home.facebook')}}</label>
                                    <input type="text"  class="form-control" placeholder="{{trans('home.facebook')}}" name="facebook" value="{{config('site_facebook') }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="linkedin">{{trans('home.linkedin')}}</label>
                                    <input type="text" class="form-control" placeholder="{{trans('home.linkedin')}}" name="linkedin" value="{{config('site_linkedin') }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="instgram">{{trans('home.instgram')}}</label>
                                    <input type="text"  class="form-control" placeholder="{{trans('home.instgram')}}" name="instgram" value="{{ config('site_instgram') }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="twitter">{{trans('home.twitter')}}</label>
                                    <input type="text" class="form-control" placeholder="{{trans('home.twitter')}}" name="twitter" value="{{config('site_twitter') }}">
                                </div>

                                 <div class="form-group col-md-12">
                                    <label>{{trans('home.map_url')}}</label>
                                    <textarea class="form-control" name="map_url" type="text" placeholder="{{trans('home.map_url')}}">{{config('site_map_url')}}</textarea>
                                </div>

                                <div class="form-group col-md-12 ">
                                    <iframe src="{{config('site_map_url')}}" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>


                                <div class="form-group col-md-12">
                                    <label>{{trans('home.place_order_msg')}}</label>
                                    <textarea class="form-control" name="place_order_msg" type="text" placeholder="{{trans('home.place_order_msg')}}">{{$settings->place_order_msg}}</textarea>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
                                </div>

                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>

@endsection
@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2DM4_HwOA3s6WsWcyhRt5Q_NO9CoxZpU&callback=initMap2" async defer></script>
    <script>

        $('.lang').select2({
        });

    </script>
@endsection
