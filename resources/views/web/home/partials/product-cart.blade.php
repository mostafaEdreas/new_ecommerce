@foreach ($array as $index => $object)
<div class="swiper-slide">
    <div class="shop-card wow fadeInUp" data-wow-delay="0.{{ $index ? $index + 1 :  $index + 2}}s">
        <div class="dz-media">
            <img src="{{$object->main_image_source}}" alt="image">
            <div class="shop-meta">
                <button  class="btn btn-secondary btn-icon add-to-cart">
                    <i class="fa-solid fa-eye d-md-none d-block"></i>
                    <span class="d-md-block d-none">@lang('home.Add to Cart')</span>
                </button>
            </div>
        </div>
        <div class="dz-content">
            <h5 class="title"><a href="{{LaravelLocalization::localizeUrl('product/'.$object->link)}}">{{$object->name}}</a></h5>
            <h6 class="price">
                {{$object->net_price}}
            </h6>
        </div>
    </div>
</div>
@endforeach