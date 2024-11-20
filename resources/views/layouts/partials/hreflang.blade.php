@if(Request::segment(2) == 'product')
    <link rel="alternate" hreflang="en-eg" href="{{ LaravelLocalization::getLocalizedURL('en', 'product/'.$product->link_en, [], true) }}" />
@elseif(Request::segment(2) == 'category')
    <link rel="alternate" hreflang="en-eg" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}"/>
@elseif(Request::segment(2) == 'brand')
    <link rel="alternate" hreflang="en-eg" href="{{ LaravelLocalization::getLocalizedURL('en', null , [], true) }}"/>
@elseif(Request::segment(2) == 'page')
    <link rel="alternate" hreflang="en-eg" href="{{ LaravelLocalization::getLocalizedURL('en', 'page/'.$page->link_en, [], true) }}"/>
@elseif(Request::segment(2) == 'trending')
    <link rel="alternate" hreflang="en-eg" href="{{ LaravelLocalization::getLocalizedURL('en', 'trending/'.$blog->link_en, [], true) }}" />
@else
    <link rel="alternate" hreflang="en-eg" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}"/>
@endif

@if(Request::segment(2) == 'product')
   <link rel="alternate" hreflang="ar-eg" href="{{ LaravelLocalization::getLocalizedURL('ar', 'product/'.$product->link_ar, [], true) }}" />
@elseif(Request::segment(2) == 'category')
    <link rel="alternate" hreflang="ar-eg" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" />
@elseif(Request::segment(2) == 'brand')
    <link rel="alternate" hreflang="ar-eg" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" />
@elseif(Request::segment(2) == 'page')
    <link rel="alternate" hreflang="ar-eg" href="{{ LaravelLocalization::getLocalizedURL('ar', 'page/'.$page->link_ar, [], true) }}" />
@elseif(Request::segment(2) == 'trending')
    <link rel="alternate" hreflang="ar-eg" href="{{ LaravelLocalization::getLocalizedURL('ar', 'trending/'.$blog->link_ar, [], true) }}" />
@else
    <link rel="alternate" hreflang="ar-eg" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" />
@endif

@if(Request::segment(2) == 'product')
   <link rel="alternate" hreflang="x-default" href="{{ LaravelLocalization::getLocalizedURL('ar', 'product/'.$product->link_ar, [], true) }}" />
@elseif(Request::segment(2) == 'category')
    <link rel="alternate" hreflang="x-default" href="{{ LaravelLocalization::getLocalizedURL('ar', null , [], true) }}" />
@elseif(Request::segment(2) == 'brand')
    <link rel="alternate" hreflang="x-default" href="{{ LaravelLocalization::getLocalizedURL('ar', null , [], true) }}" />
@elseif(Request::segment(2) == 'page')
    <link rel="alternate" hreflang="x-default" href="{{ LaravelLocalization::getLocalizedURL('ar', 'page/'.$page->link_ar, [], true) }}" />
@elseif(Request::segment(2) == 'trending')
    <link rel="alternate" hreflang="x-default" href="{{ LaravelLocalization::getLocalizedURL('ar', 'trending/'.$blog->link_ar, [], true) }}" />
@else
    <link rel="alternate" hreflang="x-default" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" />
@endif