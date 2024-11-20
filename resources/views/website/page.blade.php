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
              <h1>{{$page->{'title_'.$lang} }}</h1>
            </div>
            <ol class="breadcrumb">
              <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{trans('home.home')}}</a></li>
              <li>
                <a href="javascript:void(0)"><i data-feather="chevron-right"></i></a>
              </li>
              <li class="current"><a >{{$page->{'title_'.$lang} }}</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
<div class="container">
    <div class="row m-5">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 box">	
        	<div class="mb-4">
                {!! ($lang == 'en')?$page->text_en:$page->text_ar !!}
            </div>
       	</div>
	</div>
</div>
@endsection
