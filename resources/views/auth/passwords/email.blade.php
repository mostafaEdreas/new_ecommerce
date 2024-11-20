@extends('layouts.app')
@section('title')
    <title>{{trans('home.Reset Password')}}</title>
@endsection
@section('content')
<main class="main login-page">

    <!--Page Header-->
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="page-title"><h1>{{trans('home.Reset Password')}}</h1></div>
                    <!--Breadcrumbs-->
                    <div class="breadcrumbs"><a href="{{LaravelLocalization::localizeUrl('/')}}" title="Back to the home page">{{trans('home.home')}}</a><span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>{{trans('home.Reset Password')}}</span></div>
                    <!--End Breadcrumbs-->
                </div>
            </div>
        </div>
    </div>
    <!--End Page Header-->

    <div class="page-content">
        <div class="container">
            <div class="login-popup">
                <div class="tab tab-nav-boxed tab-nav-center tab-nav-underline">
                    <div class="tab-pane active" id="Reset-password">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form  method="POST" action="{{ route('password.email') }}" id="reset-form">
                                @csrf
                                <div class="form-group">
                                    <label for="email">{{trans('home.email')}} <span class="required">*</span></label>
                                    <input type="email" name="email"  class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group align-items-center justify-content-between">
                                    <label></label>
                                    <button type="submit" class="btn btn-primary">{{ trans('home.Send Password Reset Link') }}</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

