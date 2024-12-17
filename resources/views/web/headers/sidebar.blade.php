<div class="offcanvas dz-offcanvas offcanvas offcanvas-end " tabindex="-1" id="offcanvasRight">
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
        &times;
    </button>
    <div class="offcanvas-body">
        <div class="product-description">
            <div class="dz-tabs">
                <ul class="nav nav-tabs center" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="shopping-cart" data-bs-toggle="tab"
                            data-bs-target="#shopping-cart-pane" type="button" role="tab"
                            aria-controls="shopping-cart-pane" aria-selected="true">Shopping Cart
                            <span class="badge badge-light">5</span>
                        </button>
                    </li>
                    
                    
                </ul>
                <div class="tab-content pt-4" id="dz-shopcart-sidebar">
                    <div class="tab-pane fade show active" id="shopping-cart-pane" role="tabpanel"
                        aria-labelledby="shopping-cart" tabindex="0">
                        <div class="shop-sidebar-cart">
                            <ul class="sidebar-cart-list">
                                @foreach ($cart->items as $item)
                                <li>
                                    <div class="cart-widget">
                                        <div class="dz-media me-3">
                                            <img src="{{$item->product_main_image}}" alt="">
                                        </div>
                                        <div class="cart-content">
                                            <h6 class="title"><a href="{{LaravelLocalization::localizeUrl('product/'.$item->product_link)}}">{{$item->product_name}}</a></h6>
                                            <div class="d-flex align-items-center">
                                                <div class="btn-quantity light quantity-sm me-3">
                                                    <input type="text" value="1" name="demo_vertical2">
                                                </div>
                                                <h6 class="dz-price text-primary mb-0">{{$item->product_net_price}}</h6>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="dz-close">
                                            <i class="ti-close"></i>
                                        </a>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <div class="cart-total">
                                <h5 class="mb-0">@lang('home.total')</h5>
                                <h5 class="mb-0">{{$cart->net_total_price}}</h5>
                            </div>
                            <div class="mt-auto">
                                <div class="shipping-time">
                                    <div class="dz-icon">
                                        <i class="flaticon flaticon-ship"></i>
                                    </div>
                                    <div class="shipping-content">
                                        <h6 class="title pe-4">Congratulations , you've got free shipping!
                                        </h6>
                                        {{-- <div class="progress">
                                            <div class="progress-bar progress-animated border-0"
                                                style="width: 75%;" role="progressbar">
                                                <span class="sr-only">75% Complete</span>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <a href="shop-checkout.html"
                                    class="btn btn-light btn-block m-b20">@lang('home.checkout')</a>
                                <a href="shop-cart.html" class="btn btn-secondary btn-block">@lang('cart')</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>