<div class="dashboard-upper-info">
	<div class="row align-items-center no-gutters">
        <div class="col-xl-3 col-lg-3 col-md-12">
            <div class="d-single-info">
                <p class="user-name">{{trans('home.hello')}} <span class="font-weight-600"> {{$user->name()}}</span></p>
                <p>({{$user->email}}) <a class="font-weight-600" href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{trans('home.logout')}}</a></p>
                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-12">
            <div class="d-single-info">
                <p>{{trans('home.Need Assistance? Customer service at.')}}</p>
                <p>{{$setting->contact_email}}</p>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-12">
            <div class="d-single-info">
                <p>{{trans('home.E-mail them at')}}</p>
                <p>{{$setting->email}}</p>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-12">
            <div class="d-single-info text-lg-center">
                <i class="icon an an-shopping-bag me-1"></i>
                <a class="view-cart" href="{{LaravelLocalization::localizeUrl('carts')}}"><i class="icon anm anm-bag-l"></i>{{trans('home.View Cart')}}</a>
            </div>
        </div>
    </div>
</div>

@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->pull('success') }}</strong> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif