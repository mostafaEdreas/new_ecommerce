@if($type == 'category')
    <fieldset class="form-group">
        <label for="categories">{{trans('home.category')}}</label>
        <select class="form-control type_value" name="type_value" id="type_value" >
            @foreach($categories as $category)
                <option value="{{ $category->id }}">@if(app()->getLocale() == 'en'){{ $category->name_en }}@else{{$category->name_ar}}@endif</option>
            @endforeach
        </select>
    </fieldset>

@elseif($type == 'product')
    <fieldset class="form-group">
        <label for="products">{{trans('home.product')}}</label>
        <select class="form-control type_value" name="type_value" id="type_value" >
            @foreach($products as $product)
                <option value="{{ $product->id }}">@if(app()->getLocale() == 'en'){{ $product->name_en }}@else{{$product->name_ar}}@endif</option>
            @endforeach
        </select>
    </fieldset>

@elseif($type == 'brand')
    <fieldset class="form-group">
        <label for="brands">{{trans('home.brand')}}</label>
        <select class="form-control type_value" name="type_value" id="type_value" >
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}">@if(app()->getLocale() == 'en'){{ $brand->name_en }}@else{{$brand->name_ar}}@endif</option>
            @endforeach
        </select>
    </fieldset>
@elseif($type == 'compatible')
    <fieldset class="form-group">
        <label for="users">{{trans('home.compatibles')}}</label>
        <select class="form-control type_value" name="type_value" id="type_value" >
            @foreach($compatibles as $compatible)
                <option value="{{$compatible -> id}}">{{$compatible -> brand}} - {{$compatible -> model}}</option>
            @endforeach
        </select>
    </fieldset>
@elseif($type == 'attribute')
    <fieldset class="form-group">
        <label for="attributes">{{trans('home.attributes')}}</label>
            <select class="form-control type_value" name="type_value" id="type_value" >
                @foreach($attributes as $attribute)
                    <option value="{{$attribute -> id}}">@if(app()->getLocale() == 'en') {{$attribute ->attribute-> name_en}} - {{$attribute -> value_en}} @else {{$attribute ->attribute-> name_ar}} - {{$attribute -> value_ar}} @endif</option>
                @endforeach
            </select>    
    </fieldset>
@elseif($type == 'pages')
    <fieldset class="form-group">
        <label for="regions">{{trans('home.pages')}}</label>
        <select class="form-control select2 type_value" name="type_value"  id="type_value">
            @foreach($pages as $page)
                <option value="{{$page -> id}}">@if(app()->getLocale() == 'en') {{$page -> title_en}} @else {{$page -> title_ar}}@endif</option>
            @endforeach
        </select>
    </fieldset>
@elseif($type == 'link')
    <fieldset class="form-group">
        <label for="regions">{{trans('home.link')}}</label>
        <input type="text" class="form-control type_value" placeholder="{{trans('home.link')}}" name="type_value">
    </fieldset>

@elseif($type == 'blog-item')
    <fieldset class="form-group">
        <label for="blog_items">{{trans('home.blog_items')}}</label>
        <select class="form-control select2 type_value" name="type_value"  id="type_value">
            @foreach($blogItems as $blogItem)
                <option value="{{$blogItem -> id}}">@if(app()->getLocale() == 'en') {{$blogItem -> title_en}} @else {{$blogItem -> title_ar}}@endif</option>
            @endforeach
        </select>
    </fieldset>
    
@elseif($type == 'blog-category')
    <fieldset class="form-group">
        <label for="blog_categories">{{trans('home.blog_categories')}}</label>
        <select class="form-control select2 type_value" name="type_value"  id="type_value">
            @foreach($blogCategories as $blogCategory)
                <option value="{{$blogCategory -> id}}">@if(app()->getLocale() == 'en') {{$blogCategory -> title_en}} @else {{$blogCategory -> title_ar}}@endif</option>
            @endforeach
        </select>
    </fieldset>

@elseif($type == 'about-us')
    <fieldset class="form-group">
    </fieldset>
@elseif($type == 'contact-us')
    <fieldset class="form-group">
    </fieldset>
@elseif($type == 'deals')
    <fieldset class="form-group">
    </fieldset>
@elseif($type == 'featured')
    <fieldset class="form-group">
    </fieldset>  
    
@elseif($type == 'blogs')
<fieldset class="form-group">
</fieldset>

@elseif($type == 'home')
    <fieldset class="form-group">
    </fieldset>   
    
@elseif($type == 'main-item')
    <fieldset class="form-group">
    </fieldset>   
    
@elseif($type == 'galleryVideos')
    <fieldset class="form-group">
    </fieldset> 
    
    
@elseif($type == 'galleryImages')
    <fieldset class="form-group">
    </fieldset> 
    
@elseif($type == 'winners')
    <fieldset class="form-group">
    </fieldset> 
@endif





<script>
    
    $(document).ready(function() {
        $('.type_value').select2();
    });
</script>
