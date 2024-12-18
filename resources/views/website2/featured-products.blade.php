@extends('layouts.app') 
@section('meta')
    @php echo $metatags @endphp
    @php echo $schema @endphp
@endsection
@section('content')  


<div class="breadcrumb-wrap">
    <div class="banner">
      <img class="bg-img bg-top" src="{{Helper::uploadedImagesPath('aboutStrucs',$about->banner)}}" alt="banner" />

      <div class="container-lg">
        <div class="breadcrumb-box">
          <div class="heading-box">
            <h1>{{__('home.our products')}}</h1>
          </div>
          <ol class="breadcrumb">
            <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{__('home.home')}}</a></li>
            <li>
              <a href="javascript:void(0)"><i data-feather="chevron-right"></i></a>
            </li>
            <li class="current"><a >{{__('home.products')}}</a></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumb End -->
<!-- Products Section Start -->
<section class="shop-page">
    <div class="container-lg">
        <div class="row gy-4 g-lg-3 g-xxl-4">
        <form id="sortForm">
            <div class="col-12">
            <div class="row gy-4 gy-lg-5 gx-0">
                <!-- filter sidebar  -->
                <div class="col-4 col-xl-3 sidebar-controll sidebar-hidden">
                <div class="sidebar-inner sticky">
                    <div class="back-box d-flex">
                        <span>عودة</span>
                        <span><i data-feather="x"></i></span>
                    </div>
                    @if (isset($_GET['sort_by']))    
                        <a href="{{ url('/products')}}">
                            <div class=" d-flex btn btn-outline-danger justify-content-between mb-3">
                                <span>ازالة الفلاتر</span>
                                <span><i data-feather="x"></i></span>
                            </div>
                        </a>
                    @endif
                    <button type="submit">
                        <div class="d-flex back-box justify-content-center px-5">
                            <span> بحث</span>
                            <span class="mx-2"><i data-feather="search"></i></span>
                        </div>
                    </button>
                    <div class="row gy-3 gx-0 g-lg-4">

                        <div class="col-lg-12">
                            <div class="sidebar-box">
                                <div class="title-box4">
                                    <h4 class="heading">الفلتر <span class="bg-theme-blue"></span></h4>
                                </div>
                                    <!--Prices-->
                                <div class="range-slider">
                                    <div class="price-input">
                                    <div class="field">
                                        <input class="form-control input-min" type="number" name="from" id="min_price" value="{{$products->min('price')}}" />
                                    </div>
                                    <div class="separator">-</div>
                                        <div class="field">
                                            <input class="form-control input-max" type="number" name="to" id="max_price" value="{{$products->max('price')}}" />
                                        </div>
                                    </div>

                                    <div class="slider">
                                    <div class="progress"></div>
                                    </div>

                                    <div class="range-input">
                                        <input type="range" class="range-min" min="0" max="{{$to ?? $products->max('price')}}" value="{{$from ?? $products->min('price')}}" step="1" />
                                        <input type="range" class="range-max" min="0" max="{{$to ?? $products->max('price')}}" value="{{$to ?? $products->max('price')}}" step="1" />
                                        {{-- <input type="range" class="range-max" min="0" max="{{$max}}" value="{{$max}}" step="100" /> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="col-12">
                            <div class="sidebar-box">
                            <div class="title-box4">
                                <h4 class="heading">الماركه <span class="bg-theme-blue"></span></h4>
                            </div>
                            <ul class="catagories-side">
                                @foreach ($all_brands as $brand)
                                    @if(count($brand->products())>0)
                                        <li data-value="{{$brand->id}}" onclick="setBrandValue({{$brand->id}})">
                                            <a href="#">
                                                <span>
                                                    <i data-feather="arrow-right"></i>
                                                    {{$brand->{'name_'.$lang} }}
                                                    </span>
                                                <span class="notification">{{ count($brand->products()) }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            </div>
                        </div>
                    </div>

                        <div class="col-12">
                            <div class="sidebar-box">
                            <div class="title-box4">
                                <h4 class="heading">القوة <span class="bg-theme-blue"></span></h4>
                            </div>
                            <ul class="catagories-side">
                                @foreach ($attribute->value_relation as $attribute_value)
                                    <li data-value="{{$attribute_value->id}}" onclick="setAttributeValue({{$attribute_value->id}})">
                                    <a href="#">
                                        <span>
                                            <i data-feather="arrow-right"></i>
                                            {{$attribute_value->{'value_'.$lang} }}
                                            </span>
                                        <span class="notification">{{ $attribute_value->product_count($attribute_value->id)->count }}</span>
                                    </a>
                                    </li>
                                @endforeach
                                <input type="hidden" id="attribute_input" name="attribute_value" value="">
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <!-- filter sidebar  -->

                <div class="col-12 order-1 order-lg-2">
                <div class="shop-product">
                    <div class="top-header-wrap">
                        <a href="javascript:void(0)" class="filter-btn btn-solid btn-sm mb-line me-4">فلتر <i class="arrow"></i></a>
                            <!--Brands &&& Sorting-->
                        <div class="grid-option-wrap">
                            <div class="select-options">
                                <div class="select-menu">
                                        <!--Sorting-->
                                    <div class="dropdown select-dropdown">
                                        <button class="select-showval" id="sortProduct">ترتيب بواسطة <i data-feather="chevron-down"></i></button>
                                        <ul name="sort_by" id="sorting" class="onhover-show-div select-vallist">
                                            <li class="select-list" data-value="" onclick="setSortValue('', '{{__('home.selectall')}}')">{{__('home.selectall')}}</li>
                                            <li class="select-list" data-value="latest" onclick="setSortValue('latest', '{{trans('home.latest')}}')">{{trans('home.latest')}}</li>
                                            <li class="select-list" data-value="price-low" onclick="setSortValue('price-low', '{{trans('home.pric: low to high')}}')">{{trans('home.pric: low to high')}}</li>
                                            <li class="select-list" data-value="price-high" onclick="setSortValue('price-high', '{{trans('home.price: high to low')}}')">{{trans('home.price: high to low')}}</li>
                                        </ul>
                                        <input type="hidden" name="sort_by" id="sort_by_input" value="{{ isset($_GET['sort_by']) ? $_GET['sort_by'] : '' }}">

                                    </div>

                                    <!--Brands-->
                                    <div class="dropdown select-dropdown small-dropdown">
                                        <button class="select-showval" id="featureProduct"><span>الماركة</span> <i
                                            data-feather="chevron-down"></i></button>
                                        <ul class="onhover-show-div select-vallist">
                                            @foreach ($all_brands as $brand)
                                            <li class="select-list" data-value="{{$brand->id}}" onclick="setBrandValue({{$brand->id}})">{{$brand->{'name_'.$lang} }}</li>
                                            @endforeach
                                        </ul>
                                        <input type="hidden" name="brand_id" id="brand_input" value="{{ isset($_GET['brand_id']) ?  $_GET['brand_id'] : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product-tab-content">
                    <div class="view-option row g-3 g-xl-4 ratio_asos row-cols-2 row-cols-sm-3 row-cols-xl-4 grid-section">
                        @foreach($products as $index=>$product)
                            <div class="col {{$index>=3?' wow fadeInUp':''}}" {{$index>=3?'data-wow-delay="0.3s"':''}}>
                            <div class="product-card4 option-bottom">
                                <div class="img-box">
                                <a href="{{LaravelLocalization::localizeUrl('product/'.$product->{'link_'.$lang})}}">
                                    <img class="bg-img" src="{{Helper::uploadedImagesPath('products',$product->firstImage()->image)}}" alt="product" />
                                </a>
                                <!-- brand  -->
                                <div class="brand">
                                    <img src="{{Helper::uploadedImagesPath('brands',$product->brand->logo)}}" alt="{{$product->{'name_'.$lang} }}">
                                </div>
                                <!-- Option -->
                                <ul class="option-wrap">
                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                    <a href="javascript:void(0)" class="wishlist-btn btn-wishlist" data-product_id="{{$product->id}}">
                                        <i data-feather="heart"></i>
                                    </a>
                                    </li>
                                    <input type="hidden" id="data-attribute_value_{{$product->id}}" value="0">

                                    <li  title="View">
                                    <a href="javascript:void(0)" class="btn-showCart"   data-product_id="{{$product->id}}">
                                        <i data-feather="eye"></i>
                                    </a>
                                    </li>
                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Cart">
                                    <a href="javascript:void(0)" class="addtocart-btn  btn-cart" data-product_id="{{$product->id}}"> <i data-feather="shopping-bag"></i> </a>
                                    </li>
                                    <li  title="{{__('home.add-to-comparelist')}}">
                                        <a href="javascript:void(0)" class="btn-quickview"   data-product_id="{{$product->id}}">
                                            <i data-feather="layers"></i>
                                        </a>
                                    </li>
                                </ul>
                                </div>

                                <a href="{{LaravelLocalization::localizeUrl('product/'.$product->{'link_'.$lang})}}" class="content-box">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>{{$product->{'name_'.$lang}.((isset($_GET['attribute_value']) && !empty($_GET['attribute_value']))?": ".$product->attribute_value($_GET['attribute_value'])->{'value_'.$lang}:'' ) }}</h5>

                                    <div class="d-flex gap-1">
                                    <img width="24" height="24"
                                        src="https://img.icons8.com/external-ddara-lineal-ddara/64/external-horse-wild-horse-wild-west-cowboy-western-animal-equine-the-wild-west-ddara-lineal-ddara.png"
                                        alt="external-horse-wild-horse-wild-west-cowboy-western-animal-equine-the-wild-west-ddara-lineal-ddara" />
                                        <?php $rate = intval($product->rate); ?>
                                        <h5>{{$rate }}</h5>
                                    </div>
                                </div>

                                <div class="price-box">
                                @if (isset($_GET['attribute_value']) && !empty($_GET['attribute_value']))
                                    @if($product->discount()>0)
                                        <div class="price">
                                            <span>{{$product->condition_discount_product_page($_GET['attribute_value'])}} </span>
                                                <del>{{$product->old_price_product_with_attribute($_GET['attribute_value'])}}</del>
                                        </div>
                                    @else
                                        <div class="price"><span>{{$product->old_price_product_with_attribute($_GET['attribute_value'])}} </span></div>
                                    @endif
                                @else
                                    @if($product->discount()>0)
                                        <div class="price"><span>{{$product->condition_discount()}} </span><del>{{$product->price}}</del></div>
                                    @else
                                        <div class="price"><span>{{$product->price}} </span></div>
                                    @endif
                                @endif
                                    <ul class="rating p-0 mb">
                                    @for($i = 1; $i <= $rate; $i++)
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    </li>
                                    @endfor
                                    @for($i = 1; $i <= 5-$rate; $i++)
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="ffba00" class="bi bi-star fill" viewBox="0 0 16 16">
                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"></path>
                                        </svg>
                                    </li>
                                    @endfor
                                    </ul>
                                </div>
                                </a>
                            </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination Start -->
                    <div class="pagination-wrap justify-content-center">
                        <ul class="pagination ">
                            @if($products->onFirstPage())
                                <li class="disabled"><span class="page-link">«</span></li>
                            @else
                                <li ><a class="prev" href="{{ $products->previousPageUrl(). '&' . http_build_query(request()->except('page')) }}">«</a></li>
                            @endif

                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @php
                                    $urlWithParams = $url . '&' . http_build_query(request()->except('page'));
                                @endphp
                                @if($page == $products->currentPage())
                                    <li ><a class="active">{{ $page }}</a></li>
                                @else
                                    <li ><a  href="{{ $urlWithParams }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            @if($products->hasMorePages())
                                <li ><a class="page-link" href="{{ $products->nextPageUrl(). '&' . http_build_query(request()->except('page')) }}">»</a></li>
                            @else
                                <li class="disabled"><span class="page-link">»</span></li>
                            @endif
                        </ul>
                    </div>
                    <!-- Pagination End -->
                    </div>
                </div>
                </div>
            </div>
            </div>
        </form>
        </div>
    </div>
</section>
<!-- Products Section End -->
@endsection

@section('script')
   {{-- onchange on brand / sortBy / attribute Power --}}
<script>
    function setSortValue(value) {
        document.getElementById('sort_by_input').value = value;
        document.getElementById('sortForm').submit();
    }
    function setBrandValue(brand_id) {
        document.getElementById('brand_input').value = brand_id;
        var brand =document.getElementById('brand_input');
        document.getElementById('sortForm').submit();
    }
    function setAttributeValue(attribute_id) {
        document.getElementById('attribute_input').value = attribute_id;
        var attribute_input =document.getElementById('attribute_input');
        document.getElementById('sortForm').submit();
    }

</script>


{{-- price-range --}}
<script>
    const rangeInput = document.querySelectorAll(".range-input input"),
          priceInput = document.querySelectorAll(".price-input input"),
          priceInput_max = document.getElementById("f_max_price"),
          priceInput_min = document.getElementById("f_min_price"),
          range = document.querySelector(".slider .progress");

    let priceGap = 10;

    // Function to update the range slider appearance
    function updateRangeSlider() {
        let minVal = parseInt(rangeInput[0].value),
            maxVal = parseInt(rangeInput[1].value);

        if ((maxVal - minVal) < priceGap) {
            rangeInput[0].value = maxVal - priceGap;
        } else {
            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;
            range.style.left = ((minVal / rangeInput[0].max) * 100) + "%";
            range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
        }
    }

    // Trigger the input event after setting initial values
    document.addEventListener("DOMContentLoaded", function() {
        updateRangeSlider();

        // Dispatch input event to trigger the event listener
        rangeInput[0].dispatchEvent(new Event('input'));
        rangeInput[1].dispatchEvent(new Event('input'));
    });

    // Event listener for input events
    rangeInput.forEach(input => {
        input.addEventListener("input", e => {
            updateRangeSlider();
        });
    });
</script>
@endsection