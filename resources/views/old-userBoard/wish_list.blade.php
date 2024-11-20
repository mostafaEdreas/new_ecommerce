@extends('layouts.app')
@section('meta')
    <title>{{trans('home.wish_list')}}</title>
@endsection
@section('content')

<div class="rts-navigation-area-breadcrumb bg_light-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="navigator-breadcrumb-wrapper">
                    <a href="{{LaravelLocalization::localizeUrl('/')}}">@lang('home.home')</a>
                    <i class="fa-regular fa-chevron-right"></i>
                    <a class="current" href="index.html">@lang('home.wish_list')</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-seperator bg_light-1">
    <div class="container">
        <hr class="section-seperator">
    </div>
</div>



    <!-- rts cart area start -->
    <div class="rts-cart-area rts-section-gap bg_light-1">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-12">
                    <div class="rts-cart-list-area wishlist">
                        <div class="single-cart-area-list head">
                            <div class="product-main">
                                <P>@lang('home.products')</P>
                            </div>
                            <div class="price">
                                <p>@lang('home.price')</p>
                            </div>
                            <div class="quantity">
                               <p>@lang('home.quantity')</p>
                            </div>
                            <div class="subtotal">
                                <p>@lang('home.total')</p>
                            </div>
                            <div class="button-area">

                            </div>
                        </div>
                        @forelse ($wishes as $wish)
                        <div class="single-cart-area-list main  item-parent">
                            <div class="product-main-cart">
                                <div in-wish="true" class="close section-activation"  url="{{ LaravelLocalization::localizeUrl('wishes') }}/{{ $wish->id }}">
                                    <i class="fa-regular fa-x"></i>
                                </div>
                                <div class="thumbnail">

                                    @if ($wish->group->image->image)
                                    <img src="{{ Helper::uploadedImagesPath('products', $wish->group->image->image) }}" alt="shop">
                                    @else
                                    <img src="{{url('resources/assets/back/img/noimage.png')}}"
                                    alt="shop">
                                    @endif
                                </div>
                                <div class="information">
                                    <h6 class="title">{{$wish->group->product->{'name_'.$lang} }}</h6>
                                    {{-- <span>رمز المنتج:BG-1001</span> --}}
                                </div>
                            </div>
                            <div class="price">
                                <p>{{$wish->group->price_details->new_price }}  </p>
                            </div>
                            <div class="quantity">
                                <div class="quantity-edit">
                                    <input type="text" stock="{{$wish->group->stock}}" sub-total-id="subtotal{{$wish->id}}" price="{{$wish->group->price_details->new_price}}"  id="quan-inp-{{$wish->id}}" class="input" value="{{ $wish->group->stock > 0?1:0 }}">

                                    <div class="button-wrapper-action">
                                        <button class="button"><i class="fa-regular fa-chevron-down"></i></button>
                                        <button class="button plus">+<i class="fa-regular fa-chevron-up"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="subtotal" >
                                <p> <span id="subtotal{{$wish->id}}">{{$wish->total_product}}</span>  @lang('home.EGP')</p>
                            </div>
                            <div class="button-area">
                                <button  quan-input="quan-inp-{{$wish->id}}"  group_id="{{$wish->group->id}}" onclick="addToCart(this)" class="rts-btn btn-primary radious-sm with-icon">
                                    <div class="btn-text">
                                        @lang('home.Add to Cart')
                                    </div>

                                    <div class="arrow-icon">
                                        <i class="fa-regular fa-cart-shopping"></i>
                                    </div>
                                    <div class="arrow-icon">
                                        <i class="fa-regular fa-cart-shopping"></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="p-3 text-center">
                            @lang('home.doesn\'t have paroducts')
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts cart area end -->
    <script>
        function updateSubtotal(value, id, price) {
            const subtotalElement = document.getElementById('subtotal' + id);
            if (subtotalElement) {
                subtotalElement.innerText = value * price;
            }
        }
        </script>

<script>
    function deleteWish(ele) {
        let url = ele.getAttribute('url');
        let header_cart = document.getElementById('wish-cunter-id');
        if (url) {
            let itemParent = $(ele).parents('.item-parent'); // Store reference to the parent item
            $.ajax({
                url: url,
                method: 'DELETE',
                // data: data, // Uncomment if you need to send data
                success: function(response) {
                    if (response.status) {
                        // Update the cart HTML
                        return  location.reload();
                        $(header_cart).text(response.count);
                        // Remove the parent item
                        itemParent.remove();
                        // Show success notification
                        toastr.success(response.message);
                    } else {
                        toastr.warning(response.message);
                    }
                },
                error: function(error) {
                    toastr.error(error.responseJSON.message);
                }
            });
        }
    }

    function setTotal() {
        $('#total-without-shipping-costs').text(sum($('.sub-totat-product')))
        let total = $('#total-without-shipping-costs').text();
        $('#total-with-shipping-costs').text(total)
    }

    function sum(elements) {

        let total = 0;
        elements.each(function() {
            let value = parseFloat($(this).val()) || parseFloat($(this).text()) || 0;
            total += value;
        });
        return total;
    }
</script>
    @endsection


