@extends('layouts.app')
@section('meta')
    <title>{{ trans('home.profile') }}</title>
@endsection
@section('style')
@endsection
@section('content')
    <div class="rts-navigation-area-breadcrumb">
        <div class="container-2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="navigator-breadcrumb-wrapper">
                        <a href="{{ LaravelLocalization::localizeUrl('/') }}">@lang('home.home')</a>
                        <i class="fa-regular fa-chevron-right"></i>
                        <a class="current" href="javascript:void(0)">@lang('home.profile')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="account-tab-area-start rts-section-gap">
        <div class="container-2">
            <div class="row">
                <div class="col-lg-3">
                    <div class="nav accout-dashborard-nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile"
                            aria-selected="true"><i class="fa-regular fa-bag-shopping"></i>@lang('home.orders')</button>
                        {{-- <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i class="fa-sharp fa-regular fa-tractor"></i> أتبع طلبك</button> --}}
                        <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-settings" type="button" role="tab"
                            aria-controls="v-pills-settings" aria-selected="false"><i
                                class="fa-sharp fa-regular fa-location-dot"></i>@lang('home.address')</button>
                        <button class="nav-link" id="v-pills-settingsa-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-settingsa" type="button" role="tab"
                            aria-controls="v-pills-settingsa" aria-selected="false"><i
                                class="fa-light fa-user"></i>@lang('home.account_details')</button>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        <button class="nav-link" onclick="document.getElementById('logout-form').submit()"
                            data-bs-toggle="pill" data-bs-target="#v-pills-settingsb" type="button" role="tab"
                            aria-controls="v-pills-settingsb" aria-selected="false"><i
                                class="fa-light fa-right-from-bracket"></i>@lang('home.log_out')</button>
                    </div>
                </div>
                <div class="col-lg-9 pl--50 pl_md--10 pl_sm--10 pt_md--30 pt_sm--30">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                            aria-labelledby="v-pills-profile-tab" tabindex="0">
                            <div class="order-table-account">
                                <div class="h2 title">@lang('home.Orders_details')</div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>@lang('home.order')</th>
                                                <th>@lang('home.date')</th>
                                                <th>@lang('home.status')</th>
                                                <th>@lang('home.total')</th>
                                                <th>@lang('home.view')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @foreach ($orders as $order) --}}
                                            <tr>
                                                <td>#1357</td>
                                                <td>45 مارس 2024</td>
                                                <td>معالجة</td>
                                                <td>125.00 درهم للعنصرين
                                                </td>
                                                <td><a href="#" class="btn-small d-block">مشاهدة</a></td>
                                            </tr>
                                            {{-- @endforeach --}}

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" tabindex="0">
                        <div class="tracing-order-account">
                            <h2 class="title">تتبع طلبك</h2>
                            <p>
                                لمواكبة حالة طلبك، يرجى إدخال معرف الطلب الخاص بك في المربع المخصص أدناه وانقر فوق الزر "تتبع". يمكن العثور على هذا المعرف الفريد في إيصالك وكذلك في رسالة التأكيد الإلكترونية التي تم إرسالها إليك.
                            </p>
                            <form action="#" class="order-tracking">
                                <div class="half-input-wrapper">
                                    <div class="single-input">
                                        <label for="order-id">رقم التعريف الخاص بالطلب</label>
                                        <input type="text" placeholder="وجدت في البريد الإلكتروني لتأكيد الطلب الخاص بك" required>
                                    </div>
                                    <div class="single-input">
                                        <label for="order-id">البريد الالكتروني لقوائم الدفع</label>
                                        <input type="text" placeholder="البريد الإلكتروني الذي تستخدمه أثناء الخروج">
                                    </div>
                                </div>
                                <button class="rts-btn btn-primary">المسار</button>
                            </form>
                        </div>
                    </div> --}}
                        <form class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                aria-labelledby="v-pills-settings-tab" tabindex="0"
                                action="{{ LaravelLocalization::localizeUrl('update/accountSetting') }}" method="post">
                            <div>
                                <div class="shipping-address-billing-address-account">
                                    @csrf
                                    <div class="half">
                                        <h2 class="title">@lang('home.invoice address')</h2>
                                        <textarea class="address bg-light" name="invoice_address" id="" cols="30" rows="10"> {{auth()->user()->invoice_address}}</textarea>
                                        {{-- <a href="#"><button class="rts-btn btn-primary">تعديل </button></a> --}}
                                    </div>
                                    <div class="half">
                                        <h2 class="title">@lang('home.shipping_addresses')</h2>
                                        <textarea class="address bg-light" name="shipping_address" id="" cols="30" rows="10">{{auth()->user()->shipping_address}}</textarea>
                                        {{-- <a href="#"><button class="rts-btn btn-primary">تعديل </button> --}}
                                        </a>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button class="rts-btn btn-primary">@lang('home.edit') </button>
                                </div>
                            </div>
                        </form>
                        <div class="tab-pane fade" id="v-pills-settingsa" role="tabpanel"
                            aria-labelledby="v-pills-settingsa-tab" tabindex="0">
                            <form action="{{ LaravelLocalization::localizeUrl('update/accountSetting') }}"
                                class="account-details-area" method="post">
                                @csrf
                                <h2 class="title">@lang('home.account_information')</h2>
                                <div class="input-half-area">
                                    <div class="single-input">
                                        <input type="text" name="f_name" value="{{ auth()->user()->f_name }}"
                                            placeholder="@lang('home.f_name')">
                                    </div>
                                    <div class="single-input">
                                        <input type="text" name="l_name"value="{{ auth()->user()->l_name }}"
                                            placeholder="@lang('home.l_name')">
                                    </div>
                                </div>

                                <input type="email" name="email" placeholder="@lang('home.email')*"
                                    value="{{ auth()->user()->email }}" required>
                                <input type="password" name="cur_password" placeholder="@lang('home.Current Password') *" required>
                                <input type="password" name="new_password" placeholder="@lang('home.New Password') *">
                                <input type="password" name="conf_password" placeholder="@lang('home.Confirm Password') *">
                                <button type="submit" class="rts-btn btn-primary">@lang('home.Save Changes')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
