@extends('layouts.app')
@section('meta')
    <title>{{trans('home.account_settings')}}</title>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <div class="banner">
        <img class="bg-img bg-top" src="{{Helper::uploadedImagesPath('aboutStrucs',$about->banner)}}" alt="banner" />

        <div class="container-lg">
        <div class="breadcrumb-box">
            <div class="heading-box">
            <h1>{{trans('home.account_settings')}}</h1>
            </div>
            <ol class="breadcrumb">
            <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{__('home.home')}}</a></li>
            <li>
                <a href="javascript:void(0)"><i data-feather="chevron-right"></i></a>
            </li>
            <li class="current"><a >{{trans('home.account_settings')}}</a></li>
            </ol>
        </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->
 <!-- Dashboard Start -->
 <section class="user-dashboard">
    <div class="container-lg">
      <div class="row g-3 g-xl-4 tab-wrap">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="col-lg-4 col-xl-3 sticky">
          <button class="setting-menu btn-solid btn-sm d-lg-none">{{__('home.account_setting')}} <i class="arrow"></i></button>
          <div class="side-bar">
            <span class="back-side d-lg-none"> <i data-feather="x"></i></span>
            <div class="profile-box">
              <div class="img-box">
                @if ($user->image)
                    <img class="img-fluid" src="{{url('uploads/users/source/'.$user->image)}}" alt="user" />
                @else
                    <img class="img-fluid" src="{{Helper::imageFilesPath('profile.webp') }}" alt="user" />
                @endif
                {{-- update profile image --}}
                <form id="updateProfileImage" action="{{url('update/accountSetting')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="edit-btn">
                        <i data-feather="edit"></i>
                        <input id="imageInput" class="updateimg" type="file" name="image" />
                    </div>
                </form>
              </div>

              <div class="user-name">
                <h5> {{auth()->user()->name()}}</h5>
                <h6>{{auth()->user()->email}}</h6>
              </div>
            </div>

            <ul class="nav nav-tabs nav-tabs2" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard"
                  type="button" role="tab" aria-controls="dashboard" aria-selected="true">
                  {{__('home.dashboard')}}
                  <span><i data-feather="chevron-right"></i></span>
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button"
                  role="tab" aria-controls="orders" aria-selected="false">
                  {{__('home.my_orders')}}
                  <span><i data-feather="chevron-right"></i></span>
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="savedAddress-tab" data-bs-toggle="tab" data-bs-target="#savedAddress"
                  type="button" role="tab" aria-controls="savedAddress" aria-selected="false">
                  {{__('home.addresses')}}
                  <span><i data-feather="chevron-right"></i></span>
                </button>
              </li>

              <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                  role="tab" aria-controls="profile" aria-selected="false">
                   {{__('home.edit_profile')}}
                  <span><i data-feather="chevron-right"></i></span>
                </button>
              </li>

            </ul>
          </div>
        </div>

        <div class="col-lg-8 col-xl-9">
          <div class="right-content tab-content" id="myTabContent">
            <!-- User Dashboard Start -->
            <div class="tab-pane show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
              <div class="dashboard-tab">
                <div class="title-box3">
                  <h3>{{__('home.Welcome To Dashboard')}} </h3>
                </div>

                <div class="row g-0 option-wrap">
                  <div class="col-sm-6 col-xl-4">
                    <a href="javascript:void(0)" data-class="orders" class="tab-box">
                      <img src="{{Helper::imageFilesPath('icons/svg/1.svg') }}" alt="shopping bag" />
                      <h5>{{trans('home.orders')}}</h5>
                      <p>{{__('home.you have')}} {{ count(auth()->user()->orders) }} {{__('home.orders')}}</p>
                    </a>
                  </div>

                  <div class="col-sm-6 col-xl-4">
                    <a href="{{url('user/wish-list')}}" data-class="orders" class="tab-box">
                      <img src="{{Helper::imageFilesPath('icons/svg/cold.svg') }}" alt="shopping bag" />
                      <h5> {{__('home.wishlist')}}</h5>
                      <p>{{__('home.you have')}} {{ count(auth()->user()->wishlist) }}   فى المضلة</p>
                    </a>
                  </div>



                  <div class="col-sm-6 col-xl-4">
                    <a href="javascript:void(0)" data-class="savedAddress" class="tab-box">
                      <img src="{{Helper::imageFilesPath('icons/svg/3.svg') }}" alt="address" />
                      <h5>{{__('home.addresses')}} </h5>
                      <p>{{__('home.you have')}} {{ count(auth()->user()->adresses) }} </p>
                    </a>
                  </div>


                </div>
              </div>
            </div>
            <!-- User Dashboard End -->

            <!-- Order Tabs Start -->
            <div class="tab-pane" id="orders" role="tabpanel" aria-labelledby="orders-tab">
              <div class="cart-wrap order-content">
                <div class="title-box3">
                  <h3>{{__('home.orders')}}</h3>
                </div>

                <div class="order-wraper">
                    @foreach($user->orders as $order)
                        <div class="order-box">
                            <div class="order-header">
                            <span><i data-feather="box"></i></span>
                            <div class="order-content">
                                <h5 class="order-status success">{{$order->status}}</h5>
                                <p>{{__('home.order_date')}}  {{ \Carbon\Carbon::parse($order->created_at)->locale($lang)->isoFormat('Do MMMM YYYY') }} </p>
                                @if ($order->delivery_date)
                                 <p> {{__('home.arrive_date')}}  {{ \Carbon\Carbon::parse($order->delivery_date)->locale($lang)->isoFormat('Do MMMM YYYY') }} </p>
                                 <p>{{__('home.by')}} {{ $order->delivery->name.'  :  '.$order->delivery->phone1  }}</p>
                                @endif
                            </div>
                            </div>
                            <div class="order-info">
                                @foreach($order->products() as $order_product)
                                <a href="{{LaravelLocalization::localizeUrl('product/'.$order_product->product->{'link_'.$lang})}}" target="_blank">
                                    <div class="product-details" data-productDetail="product-detail">
                                        <div class="img-box"><img src="{{Helper::uploadedImagesPath('products',$order_product->product->firstImage()->image)}}" alt="product" />
                                        </div>
                                        <div class="product-content">
                                            <h5>{{$order_product->product->{'name_'.$lang} }}  </h5>
                                            <p class="truncate-3">{{$order_product->product->{'short_desc_'.$lang} }}
                                            </p>
                                            <span>{{__('home.quantity')}} : <span>{{$order_product->quantity}}</span></span>
                                            <span>{{__('home.price')}} : <span>{{$order_product->price}}</span></span>
                                            <span>{{__('home.power')}} : <span>{{ $order_product->values()->{'value_'.$lang} }}</span></span>
                                            <span> {{__('home.barcode')}} : <span>{{$order_product->product->barcode}}</span></span>
                                        </div>
                                    </div>
                                </a>

                                <div class="rating-box">
                                    <span>{{__('home.rate')}}  : </span>
                                    <?php $rate = intval($order_product->product->rate); ?>
                                    <ul class="rating p-0 mb">
                                        @for($i = 1; $i <= $rate; $i++)
                                        <li>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill fill" viewBox="0 0 16 16">
                                          <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                        </svg>
                                        </li>
                                        @endfor
                                        @for($i = 1; $i <= 5-$rate; $i++)
                                        <li>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="ffba00" class="bi bi-star fill" viewBox="0 0 16 16">
                                            <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"></path>
                                          </svg>
                                        </li>
                                        @endfor
                                      </ul>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
              </div>
            </div>
            <!-- Order Tabs End -->

            <!-- Saved Address Tabs Start -->
            <div class="tab-pane" id="savedAddress" role="tabpanel" aria-labelledby="savedAddress-tab">
              <div class="address-tab">
                <div class="title-box3">
                  <h3>Your Saved Address</h3>
                </div>

                <div class="row g-3 g-md-4">
                    @foreach ($user->adresses as $address_index=>$user_address)
                         <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="address-box checked">
                                <div class="radio-box">
                                    <div>
                                        <input class="radio-input" type="radio" {{$user_address->is_primary?'checked':''}} id="radio_{{$address_index}}" name="radio1"  data-address-id="{{$user_address->id}}" />
                                        <label class="radio-label" for="radio_{{$address_index}}">{{$user_address->region->{'name_'.$lang} }}</label>
                                        </div>
                                        <span class="badges badges-pill badges-theme">{{$user_address->land_mark}}</span>
                                        <div class="option-wrap">
                                        <span class="edit" data-bs-toggle="modal" data-bs-target="#edditAddress_{{$user_address->id}}"> <i data-feather="edit"></i>
                                        </span>
                                        <form action="{{url('delete/userAddress/'.$user_address->id)}}"
                                            method="POST">
                                            @csrf
                                            <span class="delet ms-0 delete_address" >
                                                <i data-feather="trash"></i>
                                            </span>
                                        </form>
                                    </div>
                                </div>
                                <div class="address-detail">
                                    <p class="content-color font-default">{{$user_address->address}}</p>
                                    <p class="content-color font-default">{{$user_address->country->{'name_'.$lang} }}</p>
                                    <span class="content-color font-default">رقم الهاتف:
                                        <span class="title-color font-default fw-500">
                                            {{$user_address->phone1}} </span>
                                        <span class="title-color font-default fw-500">
                                            {{$user_address->phone2?' - '.$user_address->phone2:''}} </span>
                                    </span>

                                </div>
                            </div>
                        </div>
                    @endforeach

                  <div class="col-md-6 col-lg-12 col-xl-6">
                    <div
                      class="address-box add-new d-flex flex-column gap-2 align-items-center justify-content-center"
                      data-bs-toggle="modal" data-bs-target="#addNewAddress">
                      <span class="plus-icon"><i data-feather="plus"></i></span>
                      <h4 class="theme-color font-xl fw-500"> {{__('home.CreateNewAddress')}} </h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Saved Address Tabs End -->
            <!-- Profile Tabs Start -->
            <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <div class="profile">
                <div class="title-box3">
                  <h3> {{__('home.profile')}}</h3>
                </div>

                <form class="custom-form form-pill" action="{{url('update/accountSetting')}}" method="post" enctype="multipart/form-data">
                    @csrf
                  <div class="row g-3 g-xl-4">
                    <div class="col-sm-6">
                      <div class="input-box">
                        <label for="f_name"> {{__('home.f_name')}}</label>
                        <input class="form-control" id="f_name" name="f_name" type="text"
                          value="{{$user->f_name}}" />
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="input-box">
                        <label for="l_name">{{__('home.l_name')}} </label>
                        <input class="form-control" id="l_name" name="l_name" type="text"
                          value="{{$user->l_name}}" />
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="input-box">
                        <label for="email">{{__('home.email')}} </label>
                        <input class="form-control" id="email" name="email" type="email"
                          value="{{$user->email}}" />
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="input-box">
                        <label for="phone">{{__('home.phone')}} </label>
                        <input  class="form-control" id="phone" name="phone" type="number"
                          value="{{$user->phone}}" />
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="input-box">
                        <label for="image"> {{__('home.profile_image')}}</label>
                        <input class="form-control" id="image" name="image" accept="application/pdf" type="file" />
                      </div>
                    </div>
                  </div>

                  <div class="btn-box">
                    <button class="btn-outline btn-sm">إلغاء</button>
                    <button type="submit" class="btn-solid btn-sm">{{__('home.save')}}  <i class="arrow"></i></button>
                  </div>
                </form>
              </div>
            </div>
            <!-- Profile Tabs End -->
          </div>
        </div>
      </div>
    </div>


    <!-- Add New Address Modal Start -->
    <div class="modal fade addnew-address" id="addNewAddress" tabindex="-1" aria-labelledby="addNewAddressLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewAddressLabel">  {{__('home.CreateNewAddress')}}</h5>
                <span class="close-modal" data-bs-dismiss="modal"><i data-feather="x"></i></span>
            </div>

            <div class="modal-body full-grid-mobile">
                <form class="custom-form form-pill" method="post" action="{{url('store/shipping-address')}}">
                @csrf
                <div class="row g-3 g-md-4">
                    <div class="col-12">
                        <div class="input-box">
                            <label for="address">{{__('home.address')}}</label>
                            <input class="form-control" type="text" required name="address" id="address" />
                        </div>
                        </div>

                        <div class="col-12">
                        <div class="input-box">
                            <label for="land_mark">  {{__('home.landmark')}}</label>
                            <input class="form-control" type="test" required name="land_mark" id="land_mark" />
                        </div>
                        </div>

                        <div class="col-6">
                            <div class="input-box">
                                <label for="mobile"> {{__('home.phone')}} :</label>
                                <input class="form-control"  type="number" required name="phone1" maxlength="10"
                                id="mobile" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-box">
                                <label for="mobile">2 {{__('home.phone')}}  :</label>
                                <input class="form-control"  type="number"  name="phone2" maxlength="10"
                                id="mobile" />
                            </div>
                        </div>

                        <div class="col-6 col-sm-6">
                        <div class="input-box">
                            <label for="country">{{__('home.country')}}</label>
                            <select class="form-select form-control country select2" id="countrySelect" name="country_id">
                            <option selected disabled value="">{{__('home.choose')}}...</option>
                                @foreach($countries as $country)
                                    <option
                                        value="{{$country->id}}" data-name-en="{{$country->name_en}}" data-name-ar="{{$country->name_ar}}">
                                        {{$country->{'name_'.$lang} }}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>

                        <div class="col-6 col-sm-6">
                            <div class="input-box">
                            <label for="shippingAddress">{{__('home.region')}}</label>
                            <select class="form-select form-control  region select2" id="region_id"  name="region_id" required>
                                <option selected disabled value="">{{__('home.choose')}}...</option>
                            </select>
                            </div>
                        </div>

                        <div class="col-6 col-sm-6">
                            <div class="input-box">
                            <label for="shippingAddress">{{__('home.area')}}</label>
                            <select class="form-select form-control  area select2" id="area_id"  name="area_id" required>
                                <option selected disabled value="">{{__('home.choose')}}...</option>
                            </select>
                            </div>
                        </div>

                        <div class="col-6 col-sm-6">
                            <div class="input-box">
                            <label for="country">  {{__('home.shippingAddress')}}</label>
                            <select class="form-select form-control" name="is_primary" id="is_primary" required>
                                <option value="0">{{__('home.no')}}</option>
                                <option value="1">{{__('home.yes')}}</option>
                            </select>
                            </div>
                        </div>


                </div>
                <div class="modal-footer">
                    <div class="btn-box">
                        <button type="button" class="btn btn-outline rounded-pill" data-bs-dismiss="modal"
                            aria-label="Close">{{__('home.cancel')}}</button>
                        <button type="submit" class="btn btn-solid line-none rounded-pill">{{__('home.save')}}  <i
                            class="arrow"></i></button>
                    </div>
                </div>
                </form>
            </div>

            </div>
        </div>
    </div>

    <!-- Add New Address Modal End -->
    @foreach ($user->adresses as $user_address_modal)
        <!-- Edit Address Modal Start -->
        <div class="modal fade addnew-address" id="edditAddress_{{$user_address_modal->id}}" tabindex="-1" aria-labelledby="edditAddressLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edditAddressLabel"> {{__('home.Edit shipping address')}}</h5>
                    <span class="close-modal" data-bs-dismiss="modal"><i data-feather="x"></i></span>
                </div>

                <div class="modal-body full-grid-mobile">
                    <form class="custom-form form-pill" method="post" action="{{url('update/userAddress/'.$user_address_modal->id)}}">
                        @csrf

                        <div class="row g-3 g-md-4">
                            <div class="col-12">
                                <div class="input-box">
                                    <label for="address">{{__('home.address')}}</label>
                                    <input class="form-control" type="text" required name="address" id="address" value="{{$user_address_modal->address}}" />
                                </div>
                                </div>

                                <div class="col-12">
                                <div class="input-box">
                                    <label for="land_mark">  {{__('home.landmark')}}</label>
                                    <input class="form-control" type="test" required name="land_mark" id="land_mark" value="{{$user_address_modal->land_mark}}"/>
                                </div>
                                </div>

                                <div class="col-6">
                                    <div class="input-box">
                                        <label for="mobile"> {{__('home.phone')}}:</label>
                                        <input class="form-control"  type="number" required name="phone1" value="{{$user_address_modal->phone1}}"
                                        id="mobile" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-box">
                                        <label for="mobile">2  {{__('home.phone')}} :</label>
                                        <input class="form-control"  type="number"  name="phone2" value="{{$user_address_modal->phone2}}"
                                        id="mobile" />
                                    </div>
                                </div>

                                <div class="col-6 col-sm-6">
                                <div class="input-box">
                                    <label for="country"> {{__('home.country')}}</label>
                                    <select class="form-select form-control country select2" id="countrySelect" name="country_id">
                                    <option selected disabled value="">إ {{__('home.choose')}}...</option>
                                        @foreach($countries as $country)
                                            <option {{$country->id==$user_address_modal->country_id?'selected':''}}
                                                value="{{$country->id}}" data-name-en="{{$country->name_en}}" data-name-ar="{{$country->name_ar}}">
                                                {{$country->{'name_'.$lang} }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>

                                <div class="col-6 col-sm-6">
                                    <div class="input-box">
                                    <label for="shippingAddress">{{__('home.region')}}</label>
                                    <select class="form-select form-control  region select2" id="region_id"  name="region_id" required>
                                        @foreach($regions as $region)
                                            <option {{$region->id==$user_address_modal->region_id?'selected':''}}
                                                value="{{$region->id}}" data-name-en="{{$region->name_en}}" data-name-ar="{{$region->name_ar}}">
                                                {{$region->{'name_'.$lang} }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-6">
                                    <div class="input-box">
                                    <label for="shippingAddress">{{__('home.area')}}</label>
                                    <select class="form-select form-control  area select2" id="area_id"  name="area_id" required>
                                        @foreach($areas as $area)
                                            <option {{$area->id==$user_address_modal->area_id?'selected':''}}
                                                value="{{$area->id}}" data-name-en="{{$area->name_en}}" data-name-ar="{{$area->name_ar}}">
                                                {{$area->{'name_'.$lang} }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>

                                <!--<div class="col-6 col-sm-6">-->
                                <!--    <div class="input-box">-->
                                <!--        <label for="country">عنوان الشحن الاساسى</label>-->
                                <!--        <select class="form-select form-control" name="is_primary" id="is_primary" required>-->
                                <!--            <option value="0" {{$user_address_modal->is_primary==0?'selected':''}}>لا</option>-->
                                <!--            <option value="1" {{$user_address_modal->is_primary==1?'selected':''}}>نعم</option>-->
                                <!--        </select>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <div class="col-6 col-sm-6">
                                    <div class="input-box">
                                    <label for="country">  {{__('home.shippingAddress')}}</label>
                                    <select class="form-select form-control" name="is_primary" id="is_primary" required>
                                         <option value="0" {{$user_address_modal->is_primary==0?'selected':''}}>{{__('home.no')}}</option>
                                        <option value="1" {{$user_address_modal->is_primary==1?'selected':''}}>{{__('home.yes')}}</option>
                                    </select>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-box">
                            <button type="button" class="btn btn-outline rounded-pill" data-bs-dismiss="modal"
                                aria-label="Close">{{__('home.cancel')}}</button>
                            <button type="submit" class="btn btn-solid line-none rounded-pill">{{__('home.save')}}  <i
                                class="arrow"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <!-- Edit Address Modal End -->
    @endforeach


    <!-- Action Conformation Start -->
    <div class="modal fade action-conform" id="conformation" tabindex="-1" aria-labelledby="conformationLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="conformationLabel">{{__('home.are you sure?')}}</h5>
            <span class="close-modal" data-bs-dismiss="modal"><i data-feather="x"></i></span>
        </div>
        <div class="modal-body">
            <p class="font-md">  {{__('home.Are you sure you want to delete that address ?')}}</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline btn-sm" data-bs-dismiss="modal">{{__('home.cancel')}}</button>
            <button type="button" class="btn btn-solid btn-sm line-none confirm-delete" data-bs-dismiss="modal">{{__('home.delete')}} <i
                    class="arrow"></i></button>
        </div>
        </div>
    </div>
    </div>
    <!-- Action Conformation End -->
</section>
  <!-- Dashboard End -->
@endsection



@section('script')

{{-- make primary address --}}
<script>
    $(document).ready(function () {
        $('.radio-input').on('change', function () {
            var isChecked = $(this).prop('checked');
            if (isChecked) {
                var address_id = $(this).attr('data-address-id');
                var url = "{{url('make/userAddress/primary')}}";

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{route('makeAddressPrimary')}}',
                    method: 'POST',
                    data: {
                        address_id: address_id,
                    }
                });
            }
        });
    });
</script>

{{-- delete address --}}
<script>
    $(document).ready(function () {
        $('.delete_address').on('click', function () {
            btn = $(this);
            $('#conformation').modal('show');
        });

        $('.confirm-delete').on('click', function () {
            btn.closest("form").submit();
            $('#conformation').modal('hide');
        });
    });
</script>
{{--countries--}}
<script>

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
            success: function (data) {
                var html = '';
                html += '<option></option>'
                for (var i = 0; i < data.length; i++) {
                    html += '<option  value="' + data[i].id + '">@if(\App::getLocale() == 'en')' + data[i].name_en + ' @else ' + data[i].name_ar + ' @endif</option>';
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
            success: function (data) {
                var html = '';
                html += '<option></option>'
                for (var i = 0; i < data.length; i++) {
                    html += '<option  value="' + data[i].id + '">@if(\App::getLocale() == 'en')' + data[i].name_en + ' @else ' + data[i].name_ar + ' @endif</option>';
                }
                area.html(html);
            }
        });
    });

</script>

{{-- edit address --}}
<script>
    $('.editAddress').click(function () {
        var address_id = $(this).data('address_id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{route('editAddress.show')}}',
            method: 'POST',
            data: {
                address_id: address_id,
            },
            success: function (response) {
                $('#addEditModal ').empty();
                $('.index-demo1 ').append(response.view);
                $('#addEditModal_' + address_id).modal('show');
            }
        });
    });
</script>





<!-- update profile image-->
<script>
    // Get the form and file input element
    const form = document.getElementById('updateProfileImage');
    const imageInput = document.getElementById('imageInput');

    // Add event listener for changes in the file input
    imageInput.addEventListener('change', function() {
        // Submit the form when the file input changes
        form.submit();
    });
</script>

@endsection
