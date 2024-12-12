@extends('layouts.admin')
@section('meta')
    <title>{{ trans('home.edit_setting') }}</title>
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{ trans('home.edit_setting') }}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">{{ trans('home.admin') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('home.edit_setting') }}</li>
                </ol>
            </div>
        </div>
        <!-- End Page Header -->

        @if (session()->has('success'))
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
                            <h6 class="card-title mb-1">{{ trans('home.edit_setting') }}</h6>
                        </div>
                        {!! Form::open([
                            'method' => 'PATCH',
                            'url' => 'admin/settings/stting',
                            'data-toggle' => 'validator',
                            'files' => 'true',
                        ]) !!}
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="helperText">{{ trans('home.default_lang') }}</label>
                                <select class="form-control select2" name="lang" required>
                                    <option value="en" {{ config('site_lang') == 'en' ? 'selected' : '' }}>
                                        {{ trans('home.english') }}</option>
                                    <option value="ar" {{ config('site_lang') == 'ar' ? 'selected' : '' }}>
                                        {{ trans('home.arabic') }}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="helperText">{{ trans('home.shipping_status') }}</label>
                                <select class="form-control select2 shipping_status" name="shipping_status" required>
                                    @foreach (App\Models\Setting::SHIPPING as $shipping)
                                        <option value="{{ $shipping }}"
                                            {{ config('site_shipping_status') == $shipping ? 'selected' : '' }}>
                                            @lang("home.$shipping") </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="">{{ trans('home.shipping_fees') }}</label>
                                <input type="hidden" id="shipping_fees" name="shipping_fees" value="0.00">
                                <input type="number" name="shipping_fees"  step="0.01" class="form-control shipping_fees" placeholder="{{ trans('home.shipping_fees') }}"  value="{{ config('site_shipping_fees') }}">
                            </div>


                            <div class="form-group col-md-3">
                                <label class="">{{ trans('home.shipping_free_in') }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="hidden" name="shipping_free_in_status" value="0">
                                            <input type="checkbox" name="shipping_free_in_status" value="1"
                                                id="free_in_status" aria-label="Checkbox for following text input">
                                        </div>
                                    </div>
                                    <input type="text" name="shipping_free_in_amount" id="free_in_amount" class="form-control" aria-label="Text input with checkbox">
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="">{{ trans('home.contact_email') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.contact_email') }}"
                                    name="contact_email" value="{{ config('site_contact_email') }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="">{{ trans('home.telphone') }}</label>
                                <input type="number" min="0" class="form-control"
                                    placeholder="{{ trans('home.telephone') }}" name="telephone"
                                    value="{{ config('site_telephone') }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="">{{ trans('home.email') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.email') }}"
                                    name="email" value="{{ config('site_email') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="">{{ trans('home.telphone') }}</label>
                                <input type="number" min="0" class="form-control"
                                    placeholder="{{ trans('home.telephone') }}" name="telephone"
                                    value="{{ config('site_telephone') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="">{{ trans('home.mobile') }}</label>
                                <input type="number" min="0" class="form-control"
                                    placeholder="{{ trans('home.mobile') }}" name="mobile"
                                    value="{{ config('site_mobile') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="">{{ trans('home.fax') }}</label>
                                <input type="fax" min="0" class="form-control"
                                    placeholder="{{ trans('home.fax') }}" name="fax"
                                    value="{{ config('site_fax') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="">{{ trans('home.whatsapp') }}</label>
                                <input type="whatsapp" min="0" class="form-control"
                                    placeholder="{{ trans('home.whatsapp') }}" name="whatsapp"
                                    value="{{ config('site_whatsapp') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="">{{ trans('home.snapchat') }}</label>
                                <input type="snapchat" min="0" class="form-control"
                                    placeholder="{{ trans('home.snapchat') }}" name="snapchat"
                                    value="{{ config('site_snapchat') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="facebook">{{ trans('home.facebook') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.facebook') }}"
                                    name="facebook" value="{{ config('site_facebook') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="linkedin">{{ trans('home.linkedin') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.linkedin') }}"
                                    name="linkedin" value="{{ config('site_linkedin') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="instgram">{{ trans('home.instgram') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.instgram') }}"
                                    name="instgram" value="{{ config('site_instgram') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="twitter">{{ trans('home.twitter') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.twitter') }}"
                                    name="twitter" value="{{ config('site_twitter') }}">
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{ trans('home.map_url') }}</label>
                                <textarea class="form-control" name="map_url" type="text" placeholder="{{ trans('home.map_url') }}">{{ config('site_map_url') }}</textarea>
                            </div>

                            <div class="form-group col-md-12 ">
                                <iframe src="{{ config('site_map_url') }}" width="100%" height="250"
                                    style="border:0;" allowfullscreen=""
                                    loading="lazy"referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>



                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{ trans('home.save') }} </button>
                                <a href="{{ url('/admin') }}"><button type="button" class="btn btn-danger mr-1"><i
                                            class="icon-trash"></i> {{ trans('home.cancel') }}</button></a>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2DM4_HwOA3s6WsWcyhRt5Q_NO9CoxZpU&callback=initMap2"
        async defer></script>
    <script>
        $(function() {
            $(document).on('change', '.shipping_status', function() {
                let val = $(this).val();
                let doesntHaveFees = @json(App\Models\Setting::SHIPPING_DOESNT_HAVE_FEES);
                if (doesntHaveFees.includes(val)) {
                    $('.shipping_fees').prop('disabled', true).val(0);
                } else {
                    $('.shipping_fees').prop('disabled', false);
                }
                $('.shipping_fees').change();
            })

            $(document).on('change', '.shipping_fees', function() {
                let val = $(this).val();
                $('#shipping_fees').val(val);

            })
            $('.shipping_status').change();

            $(document).on('change', '#free_in_status', function() {
                let is_checked = $(this).is(':checked');

                if (!is_checked) {
                    $('#free_in_amount').prop('disabled', true).val(0);
                } else {
                    $('#free_in_amount').prop('disabled', false);
                }
            })
            $('#free_in_status').change();
            $(document).on('change', '.shipping_fees', function() {
                let val = $(this).val();
                $('#shipping_fees').val(val);

            })

        })
    </script>
@endsection
