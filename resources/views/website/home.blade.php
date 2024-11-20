@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp
    @php echo $schema @endphp
@endsection
@section('content')

    @include('website.partials.Home-Slideshow')
    @include('website.partials.seasonal_products')
    @include('website.partials.BestSelling')
    @include('website.partials.featured_products')

        <!-- rts top tranding product area -->
        <div class="top-tranding-product rts-section-gap">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="title-area-between">
                            <h2 class="title-left mb--10">
                                @lang('home.finally arrived')
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cover-card-main-over">
                            <div class="row g-4">
                                @foreach ($new_products as $product )
                                <div class="col-xl-3 col-md-6 col-sm-12 col-12">
                                    <div class="single-shopping-card-one tranding-product">
                                        <a href="{{ LaravelLocalization::localizeUrl('product/' . $product->{'link_' . $lang}) }}" class="thumbnail-preview">
                                            @if ($product->discount)
                                                <div class="badge">
                                                    <span>{{ $product->lessPriceByGroub()->price_details->percentage }}% <br>
                                                        @lang('home.off')
                                                    </span>
                                                    <i class="fa-solid fa-bookmark"></i>
                                                </div>
                                            @endif
                                            <img src="{{ Helper::uploadedImagesPath('products', $product->lessPriceByGroub()->image->image) }}" alt="">
                                        </a>
                                        <div class="body-content">

                                            <a href="{{ LaravelLocalization::localizeUrl('product/' . $product->{'link_' . $lang}) }}">
                                                <h4 class="title">{{ $product->{'name_' . $lang} }}</h4>
                                            </a>
                                            <span class="availability"> {{ $product->{'short_desc_' . $lang} }} </span>
                                            <div class="price-area">
                                                @if ($product->discount)
                                                    <span class="current">{{ $product->lessPriceByGroub()->price_details->new_price }}</span>
                                                    <div class="previous">{{ $product->lessPriceByGroub()->price_details->old_price }}</div>
                                                @else
                                                    <span class="current">{{ $product->lessPriceByGroub()->price_details->new_price }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- rts top tranding product area end -->
        @include('website.partials.blogs')
   {{--
    @include('website.partials.banner')
    @include('website.partials.BestSelling')
    @include('website.partials.banner_2')
    @include('website.partials.MostviewsProducts')  <!-- most views products --> --}}

@endsection
@section('script')
<script type="text/javascript">
    $(function () {
        $(document).on('click',".product-details-popup-btn", function () {
      $("."+this.getAttribute('product')).addClass("popup")
      $("#anywhere-home").addClass("bgshow");
    });
    })
    
</script>
@endsection