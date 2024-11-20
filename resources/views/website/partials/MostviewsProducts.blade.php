@if(count($mostViwedProducts)>0)
  <!-- Top Rated Section Start -->
  <section class="pt-0 ratio_asos">
      <div class="container-lg">
        <div class="title-box">
          <h2 class="unique-heading"> {{__('home.featured_products')}}</h2>
          <span class="title-divider2">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 67.41"
              style="enable-background:new 0 0 122.88 67.41" xml:space="preserve">
              <g>
                <path
                  d="M79.93,51.37c-0.53-0.51-0.32-1.2,0.48-1.54c0.8-0.34,1.87-0.2,2.41,0.3c3.78,3.6,1.96,6.52,0.21,9.32 c-1.32,2.12-2.59,4.15-0.25,6.19c0.57,0.5,0.4,1.19-0.37,1.55c-0.77,0.36-1.86,0.26-2.43-0.24c-3.47-3.03-1.86-5.62-0.17-8.32 C81.22,56.36,82.7,54,79.93,51.37L79.93,51.37z M14.57,28.11h73.65c0.96,0,1.74,0.78,1.74,1.74v12.26h24.13 c1.46,0,2.79-0.6,3.75-1.56c0.96-0.96,1.56-2.29,1.56-3.75V8.8c0-1.46-0.6-2.79-1.56-3.75c-0.96-0.96-2.29-1.56-3.75-1.56H8.8 c-1.46,0-2.79,0.6-3.75,1.56C4.08,6.01,3.48,7.34,3.48,8.8V36.8c0,1.46,0.6,2.79,1.56,3.75c0.96,0.96,2.29,1.56,3.75,1.56h4.03 V29.85C12.83,28.89,13.61,28.11,14.57,28.11L14.57,28.11z M86.48,31.59H16.31v10.09h70.17V31.59L86.48,31.59z M15.21,13.64 c-0.96,0-1.74-0.78-1.74-1.74c0-0.96,0.78-1.74,1.74-1.74h93.74c0.96,0,1.74,0.78,1.74,1.74c0,0.96-0.78,1.74-1.74,1.74H15.21 L15.21,13.64z M98.58,31.99c1.36,0,2.46,1.1,2.46,2.46s-1.1,2.46-2.46,2.46s-2.46-1.1-2.46-2.46S97.23,31.99,98.58,31.99 L98.58,31.99z M108.85,31.99c1.36,0,2.46,1.1,2.46,2.46s-1.1,2.46-2.46,2.46c-1.36,0-2.46-1.1-2.46-2.46S107.49,31.99,108.85,31.99 L108.85,31.99z M8.8,0h105.29c2.42,0,4.62,0.99,6.21,2.58c1.59,1.59,2.58,3.79,2.58,6.21V36.8c0,2.42-0.99,4.62-2.58,6.21 c-1.59,1.59-3.79,2.58-6.21,2.58H8.8c-2.42,0-4.62-0.99-6.21-2.58C0.99,41.42,0,39.22,0,36.8V8.8c0-2.42,0.99-4.62,2.58-6.21 C4.18,0.99,6.38,0,8.8,0L8.8,0z M15.21,21.76c-0.96,0-1.74-0.78-1.74-1.74c0-0.96,0.78-1.74,1.74-1.74h93.74 c0.96,0,1.74,0.78,1.74,1.74c0,0.96-0.78,1.74-1.74,1.74H15.21L15.21,21.76z M21.37,51.37c-0.53-0.51-0.32-1.2,0.48-1.54 c0.8-0.34,1.87-0.2,2.41,0.3c3.78,3.6,1.96,6.52,0.21,9.32c-1.32,2.12-2.59,4.15-0.25,6.19c0.57,0.5,0.4,1.19-0.37,1.55 c-0.77,0.36-1.86,0.26-2.43-0.24c-3.47-3.03-1.86-5.62-0.17-8.32C22.66,56.36,24.13,54,21.37,51.37L21.37,51.37z M36.01,51.37 c-0.53-0.51-0.32-1.2,0.48-1.54c0.8-0.34,1.87-0.2,2.41,0.3c3.78,3.6,1.96,6.52,0.21,9.32c-1.32,2.12-2.59,4.15-0.25,6.19 c0.57,0.5,0.4,1.19-0.37,1.55c-0.77,0.36-1.86,0.26-2.43-0.24c-3.47-3.03-1.86-5.62-0.17-8.32C37.3,56.36,38.77,54,36.01,51.37 L36.01,51.37z M50.65,51.37c-0.53-0.51-0.32-1.2,0.48-1.54c0.8-0.34,1.87-0.2,2.41,0.3c3.78,3.6,1.96,6.52,0.21,9.32 c-1.32,2.12-2.59,4.15-0.25,6.19c0.57,0.5,0.4,1.19-0.37,1.55c-0.77,0.36-1.86,0.26-2.43-0.24c-3.47-3.03-1.86-5.62-0.17-8.32 C51.94,56.36,53.42,54,50.65,51.37L50.65,51.37z M65.29,51.37c-0.53-0.51-0.32-1.2,0.48-1.54c0.8-0.34,1.87-0.2,2.41,0.3 c3.78,3.6,1.96,6.52,0.21,9.32c-1.32,2.12-2.59,4.15-0.25,6.19c0.57,0.5,0.4,1.19-0.37,1.55c-0.77,0.36-1.86,0.26-2.43-0.24 c-3.47-3.03-1.85-5.62-0.17-8.32C66.58,56.36,68.06,54,65.29,51.37L65.29,51.37z" />
              </g>
            </svg>
          </span>
        </div>
        <div class="swiper product-slider">
          <div class="swiper-wrapper">
            @foreach($mostViwedProducts as $mostViwedProduct)
            <div class="swiper-slide">
              <div class="product-card4 option-bottom">
                <div class="img-box">
                  <a href="{{LaravelLocalization::localizeUrl('product/'.$mostViwedProduct->{'link_'.$lang})}}">
                    <img class="bg-img" src="{{Helper::uploadedImagesPath('products',$mostViwedProduct->images()[0])}}" alt="{{$mostViwedProduct->{'name_'.$lang} }}" />
                  </a>
                  <!-- brand  -->
                  <div class="brand">
                    <img src="{{Helper::uploadedImagesPath('brands',$mostViwedProduct->brand->logo)}}" alt="{{$mostViwedProduct->{'name_'.$lang} }}">
                  </div>
                  <!-- Option -->
                  <ul class="option-wrap">
                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                      <a href="javascript:void(0)" class="wishlist-btn btn-wishlist" data-product_id="{{$mostViwedProduct->id}}">
                        <i data-feather="heart"></i>
                      </a>
                    </li>

                    <li  title="View">
                      <a href="javascript:void(0)" class="btn-showCart"   data-product_id="{{$mostViwedProduct->id}}">
                        <i data-feather="eye"></i>
                      </a>
                    </li>
                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Cart">
                      <a href="javascript:void(0)" class="addtocart-btn  btn-cart"  data-product_id="{{$mostViwedProduct->id}}"> <i data-feather="shopping-bag"></i> </a>
                    </li>
                     <li  title="{{__('home.add-to-comparelist')}}">
                        <a href="javascript:void(0)" class="btn-quickview"   data-product_id="{{$mostViwedProduct->id}}">
                            <i data-feather="layers"></i>
                        </a>
                    </li>
                    <input type="hidden" id="data-attribute_value_{{$mostViwedProduct->id}}" value="0">
                  </ul>
                </div>

                <a href="{{LaravelLocalization::localizeUrl('product/'.$mostViwedProduct->{'link_'.$lang})}}" class="content-box">
                  <div class="d-flex justify-content-between align-items-center">
                    <h5>{{$mostViwedProduct->{'name_'.$lang} }}</h5>
                    <div class="d-flex gap-1">
                      <img width="24" height="24"
                        src="https://img.icons8.com/external-ddara-lineal-ddara/64/external-horse-wild-horse-wild-west-cowboy-western-animal-equine-the-wild-west-ddara-lineal-ddara.png"
                        alt="external-horse-wild-horse-wild-west-cowboy-western-animal-equine-the-wild-west-ddara-lineal-ddara" />
                        <?php $rate = intval($mostViwedProduct->rate); ?>
                        <h5>{{$rate }}</h5>
                    </div>
                  </div>

                  <div class="price-box">
                    @if($mostViwedProduct->discount()>0)
                        <div class="price"><span>{{$mostViwedProduct->condition_discount()}} </span><del>{{$mostViwedProduct->price}}</del></div>
                    @else
                        <div class="price"><span>{{$mostViwedProduct->price}} </span></div>
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
        </div>
      </div>
    </section>
    <!-- Top Rated Section End -->
@endif
