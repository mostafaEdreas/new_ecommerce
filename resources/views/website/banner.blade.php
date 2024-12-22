<div class="dz-bnr-inr style-1" style="background-image:url('{{$bannerImage ?? $about->banner}}');">
    <div class="container">
        <div class="dz-bnr-inr-entry">
            <h1>{{$bannerTitle ?? ''}}</h1>
            <nav aria-label="breadcrumb" class="breadcrumb-row">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{LaravelLocalization::localizeUrl('/')}}"> @lang('home.home')</a></li>
                    <li class="breadcrumb-item">{{$bannerTitle ?? ''}}</li>
                </ul>
            </nav>
        </div>
    </div>
</div>