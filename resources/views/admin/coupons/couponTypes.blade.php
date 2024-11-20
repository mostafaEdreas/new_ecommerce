
@if($type == 'category')
    <hr>
    <div class="form-group col-md-12">
        <label for="categories">{{trans('home.category')}}</label>
        <select class="form-control multiple" name="category_id[]" multiple>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">@if(app()->getLocale() == 'en'){{ $category->name_en }}@else{{$category->name_ar}}@endif</option>
            @endforeach
        </select>
        <input type="checkbox" class="checkbox" >  {{trans('home.selectall')}}
    </div>
@elseif($type == 'brand')
    <hr>
    <div class="form-group col-md-12">
        <label for="brands">{{trans('home.brand')}}</label>
        <select class="form-control multiple" name="brand_id[]" multiple>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}">@if(app()->getLocale() == 'en'){{ $brand->name_en }}@else{{$brand->name_ar}}@endif</option>
            @endforeach
        </select>
        <input type="checkbox" class="checkbox" >  {{trans('home.selectall')}}
    </div>
@elseif($type == 'product')
    <hr>
    <div class="form-group col-md-12">
        <label for="products">{{trans('home.product')}}</label>
        <select class="form-control multiple" name="product_id[]" multiple>
            @foreach($products as $product)
                <option value="{{ $product->id }}">@if(app()->getLocale() == 'en'){{ $product->name_en }}@else{{$product->name_ar}}@endif</option>
            @endforeach
        </select>
        <input type="checkbox" class="checkbox" >  {{trans('home.selectall')}}
    </div>
@elseif($type == 'user')
    <hr>
    <div class="form-group col-md-12">
        <label for="users">{{trans('home.user')}}</label>
        <select class="form-control multiple" name="user_id[]" multiple>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        <input type="checkbox" class="checkbox" >  {{trans('home.selectall')}}
    </div>
@elseif($type == 'region')
    <hr>
    <div class="form-group col-md-12">
        <label for="regions">{{trans('home.region')}}</label>
        <select class="form-control multiple" name="region_id[]" multiple>
            @foreach($regions as $region)
                <option value="{{ $region->id }}">@if(app()->getLocale() == 'en'){{ $region->name_en }}@else{{$region->name_ar}}@endif</option>
            @endforeach
        </select>
        <input type="checkbox" class="checkbox" >  {{trans('home.selectall')}}
    </div>
@elseif($type == 'free_shipping')
    <hr>
    <div class="form-group col-md-12">
        <label for="regions">{{trans('home.region')}}</label>
        <select class="form-control multiple" name="region_id[]" multiple>
            @foreach($regions as $region)
                <option value="{{ $region->id }}">@if(app()->getLocale() == 'en'){{ $region->name_en }}@else{{$region->name_ar}}@endif</option>
            @endforeach
        </select>
        <input type="checkbox" class="checkbox" >  {{trans('home.selectall')}}
    </div>
@endif


<script>
    
    $(document).ready(function() {
        $('.multiple').select2();
    });

    $(".checkbox").click(function(){
        if($(".checkbox").is(':checked') ){
            $(".multiple > option").prop("selected",true);
            $(".multiple").trigger("change");
        }else{
            $('.multiple option:selected').prop("selected", false);
            $(".multiple").trigger("change");
        }
    });
    
</script>
