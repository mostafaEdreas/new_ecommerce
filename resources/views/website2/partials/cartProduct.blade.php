<div class="modal view-product fade" id="addtocart_modal_{{$cartProduct->id}}" tabindex="-1"
        aria-labelledby="viewModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                <span class="close-modal d-md-block" data-bs-toggle="modal" data-bs-target="#addtocart_modal_{{$cartProduct->id}}"          aria-label="Close"><i
                    data-feather="x"></i></span>
                    <div class="row gy-4 g-md-0">
                        <div class="col-md-7">
                        <div class="slider-box">
                            <div class="row g-2">
                                    <div class="col-2">
                                        <div class="thumbnail-box">
                                        <div class="swiper thumbnail-img-box thumbnailSlider">
                                            <div class="swiper-wrapper">
                                             @foreach($cartProduct->images() as $index=>$cartProductImage)
                                                 <div class="swiper-slide @if($index==0) @endif">
                                                    <img src="{{Helper::uploadedImagesPath('products',$cartProductImage)}}" alt="img" />
                                                </div>
                                             @endforeach
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-10 ratio_square">
                                        <div class="swiper mainslider">
                                        <div class="swiper-wrapper">
                                            @foreach($cartProduct->images() as $index=>$cartProductImage)

                                                <div class="swiper-slide @if($index==0) @endif">
                                                    <img src="{{Helper::uploadedImagesPath('products',$cartProductImage)}}" alt="img" />
                                                </div>
                                            @endforeach

                                        </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-5">
                        <div class="product-detail-box grocery">
                            <div class="product-option">
                            <h4>{{ $cartProduct->{'name_'.$lang} }}</h4>
                            <div class="option price">
                                <h5>{{ __('home.price') }}</h5>
                                <?php count($cartProduct->price_options)>0?$price=$cartProduct->price_options[0]->price:$price=$cartProduct->price ?>
                                @if($cartProduct->discount()>0)
                                    <div  class="price"><span id="product_price_{{$cartProduct->id}}">{{$cartProduct->condition_discount_product_page()}} </span><del id="old_price_{{$cartProduct->id}}" class="mx-2">{{$price}}</del></div>
                                @else
                                    <div  class="price"><span id="product_price_{{$cartProduct->id}}">{{$price}} </span></div>
                                @endif
                            </div>
                            <div class="option">
                                <h5>{{__('home.description')}} </h5>
                                <p class="content-color">{{$cartProduct->{'short_desc_'.$lang} }}</p>
                            </div>

                            <div class="option">
                            @foreach ($cartProduct->attributes() as $attribute)
                                <h5>{{ $attribute->{'name_'.$lang} }}:</h5>
                                <ul class="size-list">
                                @foreach ($attribute->productAttributeValues($cartProduct->id) as $index=>$value)
                                    @if ($index==0)
                                        <input type="hidden" id="data-attribute_value_cart_product{{$cartProduct->id}}" value="{{$value->id}}">
                                    @endif
                                    <li class="size_option {{ $index==0?'active':'' }}" data-value_id={{$value->id}} data-product_id={{$cartProduct->id}}>{{ $value->{'value_'.$lang} }}</li>
                                @endforeach
                                </ul>
                            @endforeach
                            </div>

                            <div class="btn-group">
                                <a href="javascript:void(0)"
                                class="btn-solid btn-sm addtocart-btn btn-cart-modal"  data-product_id="{{$cartProduct->id}}"> {{__('home.Add to Cart')}} </a>
                                <a href="{{LaravelLocalization::localizeUrl('product/'.$cartProduct->{'link_'.$lang})}}" class="btn-outline btn-sm">{{__('home.product_review')}}  </a>
                            </div>
                           
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<!-- Load Feather Icon -->
<script src="{{ Helper::jsFilesPath('feather/feather.min.js') }}"></script>

{{-- <!-- Load Active Class js -->
<script src="{{ Helper::jsFilesPath('active-class.js') }}"></script> --}}

<script>
///////// function card add to cart/////

    function cardAddToCart() {
        $('.btn-cart-modal').click(function () {
            var productId = $(this).data('product_id');
            var attribute_value_id = $('#data-attribute_value_cart_product' + productId).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{LaravelLocalization::localizeUrl('cardAddToCart')}}",
                method: 'POST',
                data: {productId: productId,attribute_value_id:attribute_value_id},
                success: function (data) {
                    toastr['success'](data.text);
                    $('.shopingbag-cart').html(data.html);
                    $('.cart-count').html(data.cartCount);
                    $('.side-cart-count').html(data.cartCount);
                    $('#sideCart_totalPrice').html(data.totalPrice);
                    $('#addtocart_modal_' + productId).modal('hide');
                },
            });
        });
    }

    cardAddToCart();
</script>
{{-- change price according to power --}}
<script>
    $('.size_option').click(function () {
        var value_id = $(this).data('value_id');
        var product_id = $(this).data('product_id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{LaravelLocalization::localizeUrl('get_option_price')}}",
            method: 'POST',
            data: {
            value_id: value_id,
            product_id: product_id,
            },
            success: function (data) {
                $('#product_price_'+product_id).html(data.price);
                $('#data-attribute_value_cart_product' + product_id).val(value_id);
                if(data.price != data.old_price){
                    $('#old_price_'+product_id).html(data.old_price);
                }
            },

        });
    });
</script>
