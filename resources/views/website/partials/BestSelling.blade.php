@if (count($home_categories) > 0 && count($first_category) > 0)
    <div class="weekly-best-selling-area rts-section-gap bg_light-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area-between">
                        <h2 class="title-left">
                           {{$home_categories[0]->{'name_'.$lang} }}
                        </h2>

                    </div>
                </div>
            </div>
            <div class="row g-4">
                @include('website.appendes.products.add_product_cart',
                ['MainProducts'=>$first_category

                ])
            </div>
        </div>
    </div>
    <!-- best selling groceris end -->

@endif
@if (count($home_categories) > 1&& count($second_category) > 0)
    <div class="weekly-best-selling-area rts-section-gap bg_light-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area-between">
                        <h2 class="title-left">
                           {{$home_categories[1]->{'name_'.$lang} }}
                        </h2>

                    </div>
                </div>
            </div>
            <div class="row g-4">
                @include('website.appendes.products.add_product_cart',
                ['MainProducts'=>$second_category

                ])
            </div>
        </div>
    </div>
    <!-- best selling groceris end -->

@endif
@if (count($home_categories) > 2&& count($theerd_category) > 0)
    <div class="weekly-best-selling-area rts-section-gap bg_light-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area-between">
                        <h2 class="title-left">
                           {{$home_categories[2]->{'name_'.$lang} }}
                        </h2>

                    </div>
                </div>
            </div>
            <div class="row g-4">
                @include('website.appendes.products.add_product_cart',
                ['MainProducts'=>$theerd_category

                ])
            </div>
        </div>
    </div>
    <!-- best selling groceris end -->

@endif
