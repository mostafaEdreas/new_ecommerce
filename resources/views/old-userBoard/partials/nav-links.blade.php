<ul class="nav nav-tabs mb-6" role="tablist">
    <li class="nav-item {{(Request::segment(3) == 'account-settings')? 'active' : ''}}">
        <a href="{{url('user/account-settings')}}">{{trans('home.profile')}}</a>
    </li>
    
    <li class="nav-item {{(Request::segment(3) == 'wish-list')? 'active' : ''}}">
        <a href="{{url('user/wish-list')}}">{{trans('home.wish_list')}}</a>
    </li>
    
    <li class="nav-item {{(Request::segment(3) == 'orders' || Request::segment(1) =='track-order')? 'active' : ''}}">
        <a href="{{url('user/orders')}}">{{trans('home.orders')}}</a>
    </li>
    
    <li class="nav-item {{(Request::segment(3) == 'shipping-addresses' || Request::segment(3) =='shipping-address')? 'active' : ''}}">
        <a href="{{url('user/shipping-addresses')}}">{{trans('home.addresses')}}</a>
    </li>
    
    <li class="nav-item">
        <a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{trans('home.logout')}}</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>
</ul>
