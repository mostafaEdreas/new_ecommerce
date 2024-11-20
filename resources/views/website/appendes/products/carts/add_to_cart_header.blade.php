<i class="fa-sharp fa-regular fa-cart-shopping"></i>
@if (count($cartsPub))
    <span class="abs-number">{{ count($cartsPub) }}</span>
@endif
<div class="category-sub-menu card-number-show">
    <h5 class="shopping-cart-number">@lang('home.my_card')</h5>
    @foreach ($cartsPub as $cartProduct)
        <div class="cart-item-1 border-top">
            <div class="img-name">
                <div class="thumbanil">
                    <img src="{{ Helper::uploadedImagesPath('products', $cartProduct->group->image->image) }}"
                        alt="">
                </div>
                <div class="details">
                    <a href="{{ LaravelLocalization::localizeUrl('product/' . $cartProduct->group->product->{'link_' . $lang}) }}?group={{ $cartProduct->group->product->id }}">
                        <h5 class="title">
                            {{ $cartProduct->group->product->{'name_' . $lang} }}</h5>
                    </a>
                    <div class="number">
                        {{ $cartProduct->quantity }}
                        <i class="fa-regular fa-x"></i>
                        <span>{{ $cartProduct->group->price_details->new_price }} @lang('home.EGY')</span>
                    </div>
                </div>
            </div>
            {{-- <div class="close-c1">
                <i class="fa-regular fa-x"></i>
            </div> --}}
        </div>
    @endforeach
    <div class="sub-total-cart-balance">
        <div class="bottom-content-deals mt--10">
            <div class="top">
                <span> @lang('home.total') :</span>
                <span class="number-c">{{count( $cartsPub)? $cartsPub->sum(function ($cartProduct) {  ;return $cartProduct->total_product ;}):0 }}</span>
            </div>
            <div class="single-progress-area-incard">
                <div class="progress">
                    <div class="progress-bar wow fadeInLeft" role="progressbar"
                        style="width: 80%" aria-valuenow="25" aria-valuemin="0"
                        aria-valuemax="100"></div>
                </div>
            </div>
            <p>
                {{ $configration->text_top }}
            </p>
        </div>
        <div class="button-wrapper d-flex align-items-center justify-content-between">
            <a href="{{ LaravelLocalization::localizeUrl('carts') }}"
                class="rts-btn btn-primary "> @lang('home.my_card') </a>
            <a
                href="{{ LaravelLocalization::localizeUrl('order-checkOut') }}"class="rts-btn btn-primary border-only">@lang('home.checkout')</a>
        </div>
    </div>
</div>
<a href="javascript::void(0)"
    class="over_link"></a>
