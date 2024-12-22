@if (!empty($about_strucs))
    <section class="content-inner py-0">
        <div class="container-fluid px-0">
            <div class="row gx-0">
                @foreach ($about_strucs as $index => $struc )
                    <div class="col-xl-3 col-lg-3 col-sm-6">
                        <div class="icon-bx-wraper style-2 bg-light">
                            <div class="icon-bx">
                                <img src="{{$struc->image_source}}" alt="">
                            </div>
                            <div class="icon-content">
                                <h5 class="dz-title">{{$struc->title}}</h5>
                                <p>{{$struc->text}}</p>
                            </div>
                            <div class="data-text">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif