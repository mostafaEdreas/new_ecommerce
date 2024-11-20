@if($attributes->count()>0)

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card custom-card">
            <div class="card-body">
                <div>
                    <h6 class="card-title mb-1">{{trans('home.product_attributes')}}</h6>
                </div>
                <div class="row">
                    @foreach($attributes as $attribute)
                        <div class="form-group col-md-6">
                            <label for="attribute">{{(app()->getLocale() == 'en')? $attribute->name_en: $attribute->name_ar }}</label>
                            <select class="form-control select2" name="attribute[]" required multiple>
                                @foreach($attribute->values() as $value)
                                    <option value="{{$attribute->id}}-{{$value->id}}">@if(\App::getLocale() == 'en') {{ $value->value_en }} @else {{ $value->value_ar }} @endif</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card custom-card">
            <div class="card-body">
                <div>
                    <h6 class="card-title mb-1">{{trans('home.product_attributes')}}</h6>
                </div>

                <div class="form-group col-md-6 text-center">
                    <h2>{{trans('home.no_attributes_found')}}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
