@extends('layouts.app')

@section('meta')
    <title>{{$configration->app_name}}|{{trans('home.edit_profile')}}</title>
@endsection

@section('content')

<!-- Page Title -->
<div class="page section-header text-center mb-0">
    <div class="page-title">
        <div class="wrapper"><h1 class="page-width">{{trans('home.edit_profile')}}</h1></div>
    </div>
</div>
<!-- End Page Title -->
<div class="bredcrumbWrap bredcrumbWrapPage bredcrumb-style2 text-center">
    <div class="container breadcrumbs">
        <a href="{{url('/')}}" title="Back to home page">{{trans('home.home')}}</a><span aria-hidden="true">|</span><span class="title-bold">{{trans('home.edit_profile')}}</span>
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
                    <h3>{{trans('home.edit_profile')}}</h3>
                    <p>{{trans('home.If you want to change account details and change the password')}}</p>
                    
                    
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->pull('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{url('update/accountSetting')}}" method="post" enctype="multipart/form-data">
                        <div class="account-information">
                            @csrf
                            <div class="row">
                                
                                <div class="form-group col-12 text-center">
                                    @if($user->image)
                                        <img alt="avatar" src="{{ URL::to('uploads/users/source') }}/{{ $user->image }}">
                                    @else
                                        <img alt="avatar" src="{{ URL::To('resources/assets/back/img/users/1.jpg')}}">
                                    @endif
                                </div>
                                
                                <div class="form-group col-6">
                                    <label for="f_name">{{trans('home.f_name')}}:</label>
                                    <input type="text" class="form-control" name="f_name"  placeholder="{{trans('home.f_name')}}" value="{{$user->f_name}}" required>
                                </div>
                                
                                <div class="form-group col-6">
                                    <label for="f_name">{{trans('home.l_name')}}:</label>
                                    <input type="text" class="form-control" name="l_name"  placeholder="{{trans('home.l_name')}}" value="{{$user->l_name}}" required>
                                </div>
        
                                <div class="form-group col-6">
                                    <label for="inputName4">{{trans('home.email')}}:</label>
                                    <input type="email" class="form-control" name="email"  placeholder="Email" value="{{$user->email}}"  @if($user->email) readonly @else name="email" required @endif>
                                </div>
        
                                {{--<div class="form-group col-12">
                                    <label for="inputName4">{{trans('home.country_code')}}:</label>
                                    <input type="text" class="form-control" name="country_code"  placeholder="Country Code" value="{{$user->country_code}}">
                                </div>--}}
                                
                                <div class="form-group col-6">
                                    <label for="inputName4">{{trans('home.phone')}}:</label>
                                    <input type="number" class="form-control" name="phone"  placeholder="phone" value="{{$user->phone}}" pattern="/(01)[0-9]{9}/">
                                </div>
                                
                                <div class="form-group col-12">
                                    <label for="inputName4">{{trans('home.image')}}:</label>
                                    <input type="file"  class="form-control" name="image" >
                                </div>
                                
                                <hr>
                                
                                <h5>{{trans('home.Password change')}}</h5>

                                <div class="form-group col-12 col-md-4">
                                    <label for="cur-password">{{trans('home.Current Password leave blank to leave unchanged')}}</label>
                                    <input type="password" class="form-control" id="cur-password" name="cur_password" placeholder="{{trans('home.cur_password')}}"/>
                                </div>
                                
                                <div class="form-group col-12 col-md-4">
                                    <label for="new-password">{{trans('home.New Password leave blank to leave unchanged')}}</label>
                                    <input type="password" class="form-control" id="new-password" name="new_password" placeholder="{{trans('home.new_password')}}"/>
                                </div>
                                
                                <div class="form-group col-12 col-md-4">
                                    <label for="conf-password">{{trans('home.Confirm Password')}}</label>
                                    <input type="password" class="form-control" id="conf-password" name="conf_password" placeholder="{{trans('home.conf_password')}}"/>
                                </div>
        
                            </div>
                        </div>
                        <button type="submit" class="btn main-btn">{{trans('home.save_change')}}</button>
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
