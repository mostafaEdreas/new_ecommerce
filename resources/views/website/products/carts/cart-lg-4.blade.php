@foreach ($products  as $product )
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="shop-card wow fadeInUp" data-wow-delay="0.2s">
            <div class="dz-media">
                <img src="{{$product->main_image_source}}" alt="image">
                <div class="shop-meta">
                    <a href="{{LaravelLocalization::localizeUrl('product/'.$product->link)}}" class="btn btn-secondary btn-icon">
                        <i class="fa-solid fa-eye d-md-none d-block"></i>
                        <span class="d-md-block d-none">@lang('home.add home.Add to Cart')</span>
                    </a>
                </div>
            </div>
            <div class="dz-content">
                <h5 class="title"><a href="{{LaravelLocalization::localizeUrl('product/'.$product->link)}}">{{ $product->name }}</a></h5>

                <h6 class="price">
                    {{$product->net_price}}
                </h6>
            </div>
        </div>
    </div>
@endforeach
