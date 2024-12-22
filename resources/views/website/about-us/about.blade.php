@if($about)
    <section class="content-inner">
        <div class="container">
            <div class="row about-style2 align-items-xl-center align-items-start">
                <div class="col-lg-6 col-lg-5 col-sm-5 m-b30 sticky-top">
                    <div class="about-thumb">
                        <img src="{{$about->image_source}}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-7 col-sm-7">
                    <div class="about-content">
                        <div class="section-head style-1">
                            <h3 class="title">{{$about->title}}</h3>
                            <p> {!! $about->text !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif