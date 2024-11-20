@extends('layouts.app')
@section('meta')
    <title>{{$configration->app_name}}|{{trans('home.wish_list')}}</title>
@endsection    
@section('content')

<!--Page Title-->
<div class="page section-header text-center">
    <div class="page-title">
        <div class="wrapper"><h1 class="page-width">{{trans('home.wish_list')}}</h1></div>
    </div>
</div>
<!--End Page Title-->

<div class="container">
    <!-- Grid Product -->
    <div class="grid-products grid--view-items wishlist-grid mt-4 mb-5 mb-3">
        <div class="row">
            @foreach($wishProducts as $product)
                <div class="col-12 col-sm-4 col-md-3 col-lg-3 item">
                    <div class="product-image">
                        <form action="{{url('remove/wishlist/'.$product->id)}}" method="post">
                            @csrf
                            <input class="productId" type="hidden" name="CartProductId" value="26">
                            <button type="button" class="btn close-btn delete_wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="{{trans('home.delete')}}"><i class="icon an an-times"></i></button>
                        </form>

                        <a href="{{($lang == 'en')?LaravelLocalization::localizeUrl('product/'.$product->link_en):LaravelLocalization::localizeUrl('product/'.$product->link_ar)}}">
                            @if($product->firstImage())
                                <img class="primary blur-up lazyload" data-src="{{url('uploads/products/source/'.$product->firstImage()->image)}}" src="{{url('uploads/products/resize200/'.$product->firstImage()->image)}}" alt="{{$product->name_en}} product-image" title="{{$product->name_en}}">
                            @else
                                <img class="primary blur-up lazyload" data-src="{{url('resources/assets/front/images/noimage.png')}}" src="{{url('resources/assets/front/images/noimage.png')}}" alt="{{$product->name_en}} product-image" title="{{$product->name_en}}">
                            @endif
                             
                            @if($product->scoundImage())
                                <img class="hover blur-up lazyload" data-src="{{url('uploads/products/source/'.$product->scoundImage()->image)}}" src="{{url('uploads/products/resize200/'.$product->scoundImage()->image)}}" alt="" title="">
                            @elseif($product->firstImage())
                                <img class="hover blur-up lazyload" data-src="{{url('uploads/products/source/'.$product->firstImage()->image)}}" src="{{url('uploads/products/resize200/'.$product->firstImage()->image)}}" alt="{{$product->name_en}} product-image" title="{{$product->name_en}}">
                            @else
                                <img class="hover blur-up lazyload" data-src="{{url('resources/assets/front/images/noimage.png')}}" src="{{url('resources/assets/front/images/noimage.png')}}" alt="product-image" title="{{$product->name_en}}">
                            @endif
                            
                            @if($product->discount())
                                <div class="product-labels rectangular">
                                    <span class="lbl on-sale">{{$product->discountPercentage()}} %</span>
                                    <span class="lbl pr-label1">{{trans('sale')}}</span>
                                </div>
                            @endif
                        </a>
                        @if($product->stock > 0)
                            <!-- Product Button -->
                            <div class="button-set">
                                <div class="quickview-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="{{trans('home.Quick View')}}">
                                    <a href="#open-quickview-popup-product-{{$product->id}}" class="btn quick-view-popup quick-view"><i class="icon an an-search"></i></a>
                                </div>
                                
                                {{--<div class="variants add" data-bs-toggle="tooltip" data-bs-placement="top" title="{{trans('home.Add to Cart')}}">
                                    <a href="#open-addtocart-popup" class="btn cartIcon btn-addto-cart open-addtocart-popup" data-product_id="{{$product->id}}"><i class="icon an an-shopping-bag"></i></a>
                                </div>--}}
                                
                                <div class="wishlist-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="{{trans('home.Add To Wishlist')}}">
                                    <a href="#open-wishlist-popup" class="open-wishlist-popup wishlist add-to-wishlist" data-product_id="{{$product->id}}"><i class="icon an an-heart"></i></a>
                                </div>
                            </div>
                            <!-- End Product Button -->
                        @else
                            <div class="product-labels rectangular"><span class="lbl on-sale">{{trans('home.out of stock')}}</span></div>
                        @endif
                        
                        <div class="cagtegory-name">
                            <a class="category-href" href="{{($lang == 'en')?LaravelLocalization::localizeUrl('category/'.$product->category->link_en):LaravelLocalization::localizeUrl('category/'.$product->category->link_ar)}}">{{(app()->getLocale() == 'en')?$product->category->name_en:$product->category->name_ar}}</a>
                        </div>
                                                
                    </div>

                    <div class="product-details text-center">
                        <div class="product-name text-truncate">
                            <a href="{{($lang == 'en')?LaravelLocalization::localizeUrl('product/'.$product->link_en):LaravelLocalization::localizeUrl('product/'.$product->link_ar)}}">{{(app()->getLocale() == 'en')?$product->name_en:$product->name_ar}}</a>
                        </div>
                        <div class="product-price">
                            @if($product->discount())
                                <span class="price">{{$product->price - $product->discount()}} <small>{{trans('home.SAR')}}</small></span>
                                <span class="old-price">{{$product->price}} <small>{{trans('home.SAR')}}</small></span>
                            @else
                                <span class="price">{{$product->price}} <small>{{trans('home.SAR')}}</small></span>
                            @endif
                        </div>
                        <div class="product-rate" data-rating="{{$product->rate()}}"></div>
                        
                        @if($product->stock > 0)
                            <div class="btn-addto-cart new-cart-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="{{trans('home.Add to Cart')}}">
                                <a href="#open-addtocart-popup" class="btn cartIcon btn-addto-cart open-addtocart-popup" data-product_id="{{$product->id}}">{{trans('home.Add to Cart')}} <i class="icon an an-shopping-bag"></i></a>
                            </div>
                        @endif
                       
                    </div>
                </div>
            @endforeach
        </div>
        @foreach($wishProducts as $key=>$product)
            <!-- quick view modal -->                                                
            <div id="open-quickview-popup-product-{{$product->id}}" class="quickview-popup magnific-popup mfp-hide">
                <div id="ProductSection-product-template" class="product-template__container prstyle1">
                    <div class="product-singles">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-12 col-12">
                                <div class="quickview-details mb-3 mb-md-0">
                                    <!-- Thumbnails Single -->
                                    <div class="quickview-details-img quickview-thumbnails-single">
                                        @if($product->firstImage())
                                            <div class="item">
                                                <img src="{{url('uploads/products/source/'.$product->firstImage()->image)}}" data-src="{{url('uploads/products/source/'.$product->firstImage()->image)}}" alt="product main image" />
                                            </div>
                                        @else
                                            <div class="item">
                                                <img src="{{url('resources/assets/front/images/noimage.png')}}" data-src="{{url('resources/assets/front/images/noimage.png')}}" alt="product main image" />
                                            </div>
                                        @endif
                                        
                                        @foreach($product->images() as $key=>$image)
                                            <div class="item">
                                                <img src="{{url('uploads/products/source/'.$image)}}" data-src="{{url('uploads/products/source/'.$image)}}" alt="producuct-images" />
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- End Thumbnails Single -->
                                    <!-- Thumbnail Lists -->
                                    <div class="product-thumb-lists quickview-thumbnail-items">
                                        @if($product->firstImage())
                                            <div class="item">
                                                <img class="blur-up lazyload" src="{{url('uploads/products/source/'.$product->firstImage()->image)}}" data-src="{{url('uploads/products/source/'.$product->firstImage()->image)}}" alt="product main image" />
                                            </div>
                                        @else
                                            <div class="item">
                                                <img class="blur-up lazyload" src="{{url('resources/assets/front/images/noimage.png')}}" data-src="{{url('resources/assets/front/images/noimage.png')}}" alt="product main image" />
                                            </div>
                                        @endif
                                        @foreach($product->images() as $key=>$image)
                                            <div class="item">
                                                <img class="blur-up lazyload" src="{{url('uploads/products/source/'.$image)}}" data-src="{{url('uploads/products/source/'.$image)}}" alt="producuct-images" />
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- End Thumbnail Lists -->
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                                <div class="product-single__meta">
                                    <h2 class="product-single__title">{{(app()->getLocale() == 'en')?$product->name_en:$product->name_ar}}</h2>
                                    <div class="prInfoRow">
                                        <div class="product-stock"> <span class="instock ">{{trans('home.availability')}}</span> @if($product->stock > 0)<span class="instock">{{trans('home.in_stock')}}</span> @else <span class="outstock hide">{{trans('home.unavailable')}}</span>@endif </div>
                                        @if($product->sku_code)<div class="product-sku">{{trans('home.SKU')}}: <span class="variant-sku">{{$product->sku_code}}</span></div>@endif
                                    </div>
                                    
                                    <p class="product-single__price product-single__price-product-template">
                                        @if($product->discount())
                                            <s id="ComparePrice-product-template"><span class="money">{{$product->price}} {{trans('home.SAR')}}</span></s>
                                            <span class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
                                                <span id="ProductPrice-product-template"><span class="money">{{$product->price - $product->discount()}} {{trans('home.SAR')}}</span></span>
                                            </span>
                                        @else
                                        <span class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
                                            <span id="ProductPrice-product-template"><span class="money">{{$product->price}} {{trans('home.SAR')}}</span></span>
                                        </span>
                                        @endif
                                    </p>
                                    
                                    <div class="product-single__description rte"> {{($lang == 'en')?$product->short_desc_en:$product->short_desc_ar}} </div>
                                    
                                    <div class="product-form product-form-product-template product-form-border hidedropdown pb-3">
            
                                        @if(count($product->colors() ) > 0)
                                            <div class="swatch clearfix swatch-0 option1">
                                                <div class="product-form__item">
                                                    <label class="label">{{trans('home.colors')}} :</label>
                                                    @foreach($product->colors() as $key=>$color)
                                                        <div class="swatch-element color">
                                                            <input class="swatchInput color" id="color-{{$color->id}}" type="radio" name="color_id" value="{{$color->id}}" {{($key == 0)?'checked':''}}>
                                                            <label class="swatchLbl small {{$color->name_en}}" for="color-{{$color->id}}" title="{{($lang == 'en')?$color->name_en:$color->name_ar}}">{{($lang == 'en')?$color->name_en:$color->name_ar}}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if(count($product->attributes()) > 0)
                                            @foreach($product->attributes() as $key=>$attribute)
                                                <div class="swatch clearfix swatch-{{$key+1}} option{{$key+2}}">
                                                    <div class="product-form__item">
                                                        <label class="label">{{($lang =='en')?$attribute->name_en:$attribute->name_ar}} :</label>
                                                        @foreach($attribute->productAttributeValues($product->id) as $key=> $value)
                                                            <div class="swatch-element color">
                                                                <input class="swatchInput attributeValue" id="{{$attribute->name_en}}-{{$value->id}}" type="radio" name="{{$attribute->name_en}}_value_id" value="{{$value->id}}" {{($key == 0)?'checked':''}}>
                                                                <label class="swatchLbl small" for="{{$attribute->name_en}}-{{$value->id}}" title="{{($lang == 'en')?$value->value_en:$value->value_ar}}">{{($lang == 'en')?$value->value_en:$value->value_ar}}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
            
                                        <div class="product-action clearfix">
                                            @if($product->stock > 0)
                                                <div class="product-form__item--quantity">
                                                    <div class="wrapQtyBtn">
                                                        <div class="qtyField">
                                                            <a class="qtyBtn minus" href="javascript:void(0);"><i class="icon an an-minus" aria-hidden="true"></i></a>
                                                            <input type="number" readonly name="quantity" value="1" min="1" max="{{($product->stock)}}" class="product-form__input qty" />
                                                            <a class="qtyBtn plus" href="javascript:void(0);"><i class="icon an an-plus" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                </div>                                
                                                <div class="product-form__item--submit">
                                                    <button type="button" class="btn product-form__cart-submit cart-btn" data-product_id="{{$product->id}}"><span>{{trans('home.Add to cart')}}</span></button>
                                                </div>
                                            @else
                                                <div class="product-labels rectangular"><span class="lbl on-sale">{{trans('home.out of stock')}}</span></div>
                                            @endif
                                            <div class="payment-button">
                                                <button type="button" class="payment-button__button payment-button__button--unbranded add-to-wishlist" data-product_id="{{$product->id}}"><i class="icon an an-heart me-1"></i> <span>{{trans('home.Add to Wishlist')}}</span></button>
                                            </div>
                                        </div>
            
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End-product-single-->
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- End Grid Product-->
</div>
@endsection

@section('script')
    <script>
        $('.delete_wishlist').on('click', function(){
            btn= $(this);
            $.confirm({
                title: '{{trans("home.delete product")}}',
                content: '{{trans("home.Are you sure you want to delete that product ?")}}',


                buttons: {
                    confirm: function(){
                        text: "{{trans('home.OK')}}";
                        btnClass: "btn main-btn";
                        btn.closest("form").submit();
                    },
                    cancel: function(){
                        text: "{{trans('home.cancel')}}";
                    }
                },
            });
        });
    </script>
@endsection

                    