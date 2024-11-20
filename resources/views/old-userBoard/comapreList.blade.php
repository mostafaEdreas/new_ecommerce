@extends('layouts.app')
@section('title')
    <title>{{trans('home.comapreList')}}</title>
@endsection    
@section('content')
      <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="banner">
        <img class="bg-img bg-top" src="{{Helper::uploadedImagesPath('aboutStrucs',$about->banner)}}" alt="banner" />

        <div class="container-lg">
            <div class="breadcrumb-box">
            <div class="heading-box">
                <h1>{{trans('home.comapreList')}}</h1>
            </div>
            <ol class="breadcrumb">
                <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{__('home.home')}}</a></li>
                <li>
                <a href="javascript:void(0)"><i data-feather="chevron-right"></i></a>
                </li>
                <li class="current"><a href="{{LaravelLocalization::localizeUrl('/products')}}">{{__('home.products')}}</a></li>
                <li>
                <a href="javascript:void(0)"><i data-feather="chevron-right"></i></a>
                </li>
                <li class="current"><a >{{trans('home.comapreList')}}</a></li>
            </ol>
            </div>
        </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
      <!-- Compare Section Start -->
    <section>
      <div class="container-lg">
        <div class="row">
          <div class="col-12">
            <div class="comparemodal-body">
              <div class="table-wrapper table-responsive ratio_asos">
                <table class="table table-compare">
                  <thead>
                    <tr>
                      <th>مقارنة</th>
                            @foreach($comapreListProducts as $product)
                                <th>
                                    <form action="{{url('remove/compareList/'.$product->id)}}" method="post">
                                        @csrf
                                        <button type="button" class="btn close-btn delete_compareList" data-bs-toggle="tooltip" data-bs-placement="top" title="{{trans('home.delete')}}">{{trans('home.delete')}}</button>
                                    </form>
                                </th>
                            @endforeach
                      
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="table-product-details">
                      <td></td>
                        @foreach($comapreListProducts as $product)
                          <td>
                            <div class="product-box">
                              <div class="product-image">
                                <a class="w-100" href="javascript:void(0)">
                                  <img src="{{url('uploads/products/source/'.$product->firstImage()->image)}}" class="img-fluid bg-img" alt="" />
                                </a>
                              </div>
    
                              <div class="product-details">
                                <div class="product-title">
                                  <a href="javascript:void(0)">
                                    <h6 class="truncate"> {{$product->{'name_'.$lang} }}</h6>
                                  </a>
                                </div>
                                 @if($product->discount()>0)
                                    <span class="font-light">{{$product->condition_discount()}} </span><del  class="theme-color">{{$product->price}}</del>
                                @else
                                    <span class="font-light">{{$product->price}} </span></div>
                                @endif
                                <p class="content-color truncate-2">
                                    @php
                                    $text = strip_tags($product->{'short_desc_'.$lang});
                                    $text = mb_substr($text, 0, 100);
                                    $text = preg_replace('/<br>/', '', $text);
                                    echo $text . " ... ";
                                    @endphp     
                                </p>
                                <a class="theme-color" href="url('product/'.$product->id.'/'.$product->{'name_'.$lang})">{{__('home.See More')}}...</a>
    
                                @if($product->stock > 0)
                                    <a href="javascript:void(0);" class="addtocart-btn btn-solid btn-sm addtocart-btn btn-cart" data-product_id="{{$product->id}}}">{{trans('home.Add to Cart')}} <i class="fa fa-cart-plus"></i></a>
                                @endif
                              </div>
                            </div>
                          </td>
                        @endforeach
                    </tr>

                    <tr>
                      <td>{{__('home.brand')}}</td>
                    @foreach($comapreListProducts as $product)
                        <td> {{$product->brand->{'name_'.$lang} }}</td>
                    @endforeach  
                    </tr>
                    <tr>
                      <td>{{__('home.power')}}</td>
                      @foreach($comapreListProducts as $product)
                        <td>{{$product->attribute_value($product->price_options->first()->attribute_value_id)->{'value_'.$lang} }} </td>
                      @endforeach
                    </tr>


                    <tr>
                      <td> {{__('home.colors')}}</td>
                      @foreach($comapreListProducts as $product)
                        <td>
                            @foreach ($product->colors() as $color)
                                <span class="rounded text-white px-2 py-1 mx-2"  style="background-color: {{$color->hex_code=="#ffffff"?'#000000':$color->hex_code}}">{{$color->{'name_'.$lang} }}</span>
                            @endforeach
                        </td>
                      @endforeach
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Compare Section End -->
@endsection

@section('script')
    <script>
        $('.delete_compareList').on('click', function(){
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

                    