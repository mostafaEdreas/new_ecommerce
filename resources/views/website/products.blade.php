@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp
    @php echo $schema @endphp
@endsection
@section('content')
    <!-- rts navigation bar area start -->
    <div class="rts-navigation-area-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="navigator-breadcrumb-wrapper">
                        <a href="{{LaravelLocalization::localizeUrl('/')}}"> @lang('home.home') </a>
                        <i class="fa-regular fa-chevron-right"></i>
                        <a class="current" href="">  @lang('home.products') </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts navigation bar area end -->
    <div class="section-seperator">
        <div class="container">
            <hr class="section-seperator">
        </div>
    </div>

    <!-- shop[ grid sidebar wrapper -->
    <div class="shop-grid-sidebar-area rts-section-gap">
        <div class="container">
            <div class="row g-0">
                <div class="col-xl-3 col-lg-12 pr--70 pr_lg--10 pr_sm--10 pr_md--5 rts-sticky-column-item">
                    <div class="sidebar-filter-main theiaStickySidebar">
                        <div class="single-filter-box">
                            <h5 class="title">@lang('home.filter price')</h5>
                            <div class="filterbox-body">
                                 <div  class="price-input-area" >
                                    <div class="half-input-wrapper">
                                        <div class="single">
                                            <label for="min">@lang('home.min')</label>
                                            <input id="min" name="min" type="text" value="{{request('min')??0}}">
                                        </div>
                                        <div class="single">
                                            <label for="max">@lang('home.max')</label>
                                            <input id="max" type="text" name="max" value="{{request('max')??100000}}">
                                        </div>
                                    </div>
                                    <div class="filter-value-min-max">
                                        <span>@lang('home.price') {{request('min')??0}} — {{request('max')??100000}}</span>
                                        <button type="button" id="filter-price" class="rts-btn btn-primary">@lang('home.filter')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single-filter-box">
                            <h5 class="title">@lang('home.categories')</h5>
                            <div class="filterbox-body">
                                <div class="category-wrapper">
                                    <!-- single category -->
                                    @foreach ($MainCategories as $category )
                                    <div class="single-category">
                                        <input id="cat{{$category->id}}" name="category_id[]" value="{{$category->id}}" @checked(request('category_ids')&& in_array($category->id,request('category_ids'))) type="checkbox">
                                        <label for="cat{{$category->id}}">{{$category->{'name_'.$lang} }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="single-filter-box">
                            <h5 class="title">@lang('home.stock')</h5>
                            <div class="filterbox-body">
                                <div class="category-wrapper">
                                    <!-- single category -->
                                    <div class="single-category">
                                        <input id="has_stock" name="has_stock" @checked(request('has_stock')) type="checkbox">
                                        <label for="has_stock">@lang('home.has stock')</label>
                                    </div>
                                    <!-- single category end -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9 col-lg-12">
                    <div class="filter-select-area">
                        <div class="top-filter">
                            <span>@lang('home.view') <span>{{$MainProducts->firstItem()}}-{{$MainProducts->lastItem()}}</span> @lang('home.from') {{$MainProducts->total()}} @lang('home.items')</span>
                            <div class="right-end">
                                <span>@lang('home.terms')</span>
                            </div>
                        </div>
                        <div class="nice-select-area-wrapper-and-button">
                            <div class="nice-select-wrapper-1">
                                {{-- @if (count($all_brands))
                                    <div class="single-select">
                                        <select class="select-filter" id="brand_id">
                                            <option data-display="@lang('home.brands')" value="">@lang('home.brands')</option>
                                            @foreach ($all_brands as $brand)
                                                <option @selected($brand->id==request('brand_id')) value="{{$brand->id}}">{{$brand->{'name_'.$lang} }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif --}}
                                @if (count($sizes))
                                <div class="single-select">
                                    <select class="select-filter" id="size_id">
                                        <option  value="">@lang('home.sizes')</option>
                                        @foreach ($sizes as $size )
                                            <option value="{{$size->id}}" @selected($size->id==request('size_id'))>{{$size->{'value_'.$lang} }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                            </div>
                            {{-- <div class="button-area">
                                <button class="rts-btn">تصفية</button>
                                <button class="rts-btn" onclick="resetSelectFilter()">@lang('home.reset')</button>
                            </div> --}}
                        </div>

                    </div>

                    <div class="product-area-wrapper-shopgrid-list mt--20 tab-pane fade show active" id="home-tab-pane"
                        role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <div id="product-container" class="row g-4">
                            @include('website.appendes.products.add_product_cart')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- shop[ grid sidebar wrapper end -->
@endsection
@section('script')


<script>
    var data = getQueryParam();
    let loade = false;
    let hasMore = true;
    data.page = 1; 
    var segUrl = '{{Request::segment(3)}}'?'category/{{Request::segment(3)}}':'products'
    $(function () {
        $('input[name="category_id[]"]').change(function (e) {
            let checkedCategories = Array.from(document.querySelectorAll('input[name="category_id[]"]:checked')).map(function(input) {
                return input.value;
            });
            if (checkedCategories.lenght) {
                data.category_ids = checkedCategories;
            }else{
                delete  data.category_ids;
            }
            data.category_ids = checkedCategories;
            proSearch (data) ;
        });

        $('#has_stock').change(function (e) {
           let has_stock = Array.from(document.querySelectorAll('input[name="has_stock"]:checked')).map(function(input) {
                return input.value;
            })[0];

            if (has_stock) {
                data.has_stock = has_stock;
            } else {
                delete data.has_stock;
            }
            proSearch (data) ;
        });

        $('#brand_id').change(function (e) {
           let brand_id = $(this).val();

            if (brand_id) {
                data.brand_id = brand_id;
            } else {
                delete data.brand_id;
            }
            proSearch (data) ;
        });

        $('#size_id').change(function (e) {
           let size_id = $(this).val();

            if (size_id) {
                data.size_id = size_id;
            } else {
                delete data.size_id;
            }
            proSearch (data) ;
        });
        $('#filter-price').click(function (e) {
            let min = document.getElementById('min').value;
            let max = document.getElementById('max').value;
            if (min) {
                data.min = min;
            } else {
                delete data.min;
            }
            if (max) {
                data.max = max;
            } else {
                delete data.max;
            }
            proSearch (data) ;
        })
    });
    function getQueryParam() {
        @if (count(request()->all()))
            return data = @json(request()->all())
        @else
            return   data = {} ;
        @endif
    }
    function proSearch (data){
        if (window.scrollY >= 800) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth' // This will make the scroll smooth
            });
        }
        data.page = 1;
        hasMore = true;
        let queryString = $.param(data);
        $.ajax({
            url: '{{LaravelLocalization::localizeUrl("/")}}/'+segUrl,
            method: 'get',
            data:data,
            success: function(response) {
                replaceUrlWithoutReload('{{LaravelLocalization::localizeUrl("/")}}/'+segUrl+'?' + queryString);
                if(!response.product_html){
                    response.product_html ='<div class="text-center">@lang("home.doesn\'t have paroducts")'
                }
                document.getElementById('product-container').innerHTML= response.product_html
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
            }
        });
    }

    // function addToCart (ele){
    //     let group_id = ele.getAttribute('group_id');
    //     let quantity_input = ele.getAttribute('quan-input');
    //     let quantity = document.getElementById(quantity_input).value;
    //     let header_cart = document.getElementById('header-cart');
    //     let data ={'group_id':group_id,'quantity':quantity}
    //     if(group_id){
    //         $.ajax({
    //             url: '{{LaravelLocalization::localizeUrl("carts")}}',
    //             method: 'post',
    //             data:data,
    //             success: function(response) {
    //                 if (response.status) {
    //                     header_cart.innerHTML =response.html_cart ;
    //                     toastr.success(response.message);
    //                 } else {
    //                     toastr.warning(response.message);
    //                 }

    //             },
    //             error: function(error) {
    //                 toastr.error(error.responseJSON.message);
    //                 console.log('Error:', error);
    //             }
    //         });
    //     }
    // }

    function replaceUrlWithoutReload(newUrl) {
        window.history.replaceState(null, '', newUrl);
    }

// Usage example:
</script>
<script>
    let scroll = document.getElementById('product-container');
    $(document).ready(function() {
        $(window).scroll(function() {
            console.log(data.page)
            if (($(window).scrollTop() + $(window).height()) >= $(document).height() - $('#footer-size').outerHeight() - 30 && !loade && hasMore) {
                // $('#load-icon').show();
                data.page = data.page + 1;
                loade = true;
                $.ajax({
                    url: '{{LaravelLocalization::localizeUrl("/")}}/'+segUrl,
                    method: 'GET',
                    data: data,
                    success: function(response) {
                        if(response.status){
                            if (!response.product_html) {
                            hasMore = false;
                            data.page = data.page - 1
                            
                        }
                        $(scroll).append(response.product_html);
                        loade = false
                        // $('#load-icon').hide();
                        }else{
                            toastr.error(response.message);
                        }

                    },
                    error: function(xhr) {
                        console.log('An error occurred:', xhr);
                    }
                });
            }

        });
    });
</script>

<script type="text/javascript">
    // Product details popup
    $(document).on('click',".product-details-popup-btn", function () {
      $("."+this.getAttribute('product')).addClass("popup")
      $("#anywhere-home").addClass("bgshow");
    });
</script>
@endsection
