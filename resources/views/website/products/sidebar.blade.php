<div class="col-xl-3 col-lg-12">
    <div class="sticky-xl-top">
        <a href="javascript:void(0);" class="panel-close-btn">
            <svg width="35" height="35" viewBox="0 0 51 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M37.748 12.5L12.748 37.5" stroke="white" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12.748 12.5L37.748 37.5" stroke="white" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <div class="shop-filter mt-xl-2 mt-0">
            <aside>
                <div class="d-flex align-items-center justify-content-between m-b30">
                    <h6 class="title mb-0 fw-normal">
                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25" width="20" height="20"><g id="Layer_29" data-name="Layer 29"><path d="M2.54,5H15v.5A1.5,1.5,0,0,0,16.5,7h2A1.5,1.5,0,0,0,20,5.5V5h2.33a.5.5,0,0,0,0-1H20V3.5A1.5,1.5,0,0,0,18.5,2h-2A1.5,1.5,0,0,0,15,3.5V4H2.54a.5.5,0,0,0,0,1ZM16,3.5a.5.5,0,0,1,.5-.5h2a.5.5,0,0,1,.5.5v2a.5.5,0,0,1-.5.5h-2a.5.5,0,0,1-.5-.5Z"></path><path d="M22.4,20H18v-.5A1.5,1.5,0,0,0,16.5,18h-2A1.5,1.5,0,0,0,13,19.5V20H2.55a.5.5,0,0,0,0,1H13v.5A1.5,1.5,0,0,0,14.5,23h2A1.5,1.5,0,0,0,18,21.5V21h4.4a.5.5,0,0,0,0-1ZM17,21.5a.5.5,0,0,1-.5.5h-2a.5.5,0,0,1-.5-.5v-2a.5.5,0,0,1,.5-.5h2a.5.5,0,0,1,.5.5Z"></path><path d="M8.5,15h2A1.5,1.5,0,0,0,12,13.5V13H22.45a.5.5,0,1,0,0-1H12v-.5A1.5,1.5,0,0,0,10.5,10h-2A1.5,1.5,0,0,0,7,11.5V12H2.6a.5.5,0,1,0,0,1H7v.5A1.5,1.5,0,0,0,8.5,15ZM8,11.5a.5.5,0,0,1,.5-.5h2a.5.5,0,0,1,.5.5v2a.5.5,0,0,1-.5.5h-2a.5.5,0,0,1-.5-.5Z"></path></g></svg>
                        @lang('home.filter')
                    </h6>
                </div>


                <div class="widget">
                    <h6 class="widget-title">@lang('home.price')</h6>
                    <div class="price-slide range-slider">
                        <div class="price">
                            <div class="range-slider style-1">
                                <div id="slider-tooltips" class="mb-3"></div>
                                <span class="example-val" id="slider-margin-value-min"></span>
                                <span class="example-val" id="slider-margin-value-max"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <h6 class="widget-title">@lang('home.color')</h6>
                    <div class="d-flex align-items-center flex-wrap color-filter ps-2">
                        @foreach ($color->values as $value )
                        <a href="{{ url()->current() . (request()->query('color') ? '?color=' . $value->id . '&' . http_build_query(request()->except('color')) : '?' . http_build_query(array_merge(request()->all(), ['color' => $value->id]))) }}">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="color" id="radioNoLabel1" value="{{ $value->value}}" aria-label="...">
                                <span> </span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="widget widget_categories">
                    <h6 class="widget-title">@lang('home.categories')</h6>
                    <ul>
                        @foreach ($categories as $category)
                            <li class="cat-item cat-item-26"><a href="{{LaravelLocalization::LocalizeUrl('category/'.$category->link)}}">{{$category->name}}</a> ({{$category->productsCount}})</li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</div>