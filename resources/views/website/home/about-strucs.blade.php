@if (!empty($about_strucs))
    <section class="content-inner overlay-white-middle">
        <div class="container">
            <div class="row justify-content-center gx-sm-1">
                @foreach ($about_strucs as $index => $struc )
                    <div class="col-lg-4 col-md-4 col-sm-4 p-b30 wow fadeInUp" data-wow-delay="0.{{ $index ? $index + 1 :  $index + 2}}s">
                        <div class="icon-bx-wraper style-1 text-center">
                            <div class="icon-bx">
                            <img src="{{$struc->image_source}}" alt="image">
                            </div>
                            <div class="icon-content">
                                <h3 class="dz-title m-b0">{{$struc->title}}</h3>
                                <div class="square"></div>
                                <p class="font-20">{{$struc->text}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
