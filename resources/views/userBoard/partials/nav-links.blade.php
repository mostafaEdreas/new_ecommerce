<div class="col-xl-2 col-lg-2 col-md-12 md-margin-20px-bottom">
    <!-- Nav tabs -->
    <ul class="nav flex-column dashboard-list" role="tablist">
        <li><a class="nav-link {{(Request::segment(2) == 'account-settings')? 'active' : ''}}" href="{{LaravelLocalization::localizeUrl('user/account-settings')}}">{{trans('home.profile')}}</a></li>
        <li><a class="nav-link {{(Request::segment(2) == 'edit-account')? 'active' : ''}}" href="{{LaravelLocalization::localizeUrl('user/edit-account')}}">{{trans('home.edit_profile')}}</a></li>
        <li><a class="nav-link {{(Request::segment(2) == 'shipping-addresses' || Request::segment(3) =='shipping-address' || Request::segment(2) == 'shipping-address')? 'active' : ''}}" href="{{LaravelLocalization::localizeUrl('user/shipping-addresses')}}">{{trans('home.addresses')}}</a></li>
        <li><a class="nav-link {{(Request::segment(2) == 'wish-list')? 'active' : ''}}" href="{{LaravelLocalization::localizeUrl('user/wish-list')}}">{{trans('home.wish_list')}}</a></li>
        <li><a class="nav-link {{(Request::segment(2) == 'orders' || Request::segment(1) =='track-order')? 'active' : ''}}" href="{{LaravelLocalization::localizeUrl('user/orders')}}">{{trans('home.orders')}}</a></li>
    </ul>
    <!-- End Nav tabs -->
</div>
