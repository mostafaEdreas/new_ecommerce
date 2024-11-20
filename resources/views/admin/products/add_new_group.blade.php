@if (isset($stock)&&$stock )
    <div class="card  mt-2 mb-2" style="width: 18rem">
        <div class="card-body">
            <div class="card-text d-flex flex-wrap align-items-center" style="height:7rem;overflow: auto ; border: solid 1px #e1e6f1;background-color: #e1e6f1;borde" id="stockGroupVal{{$stock->id}}">
                @foreach ( $stock->product_groups as $product_attribute )
                    <span class="badge badge-primary d-flex m-1 justify-content-center align-items-center">
                        <span class="badge badge-pill" style="cursor: pointer;font-size: large" onclick="removeStock({{$stock->id}},{{$product_attribute->id}},'{{$stock->id}}')"> x </span>
                    {{$product_attribute->attributeValue->{'value_'.$lang} }}
                    </span>
                @endforeach
            </div>

            {{-- <div class="form-group ">
                <label class="">{{ trans('home.choose_image') }}</label>

                <select stock_id="{{$stock->id}}" id="stockImg{{$stock->id}}" multiple  class="form-control" onchange="saveToStockId(this,'image','{{$stock->id}}')" data-dynamic-select>
                    <option value="">@lang('home.choose')</option>

                    @foreach ($imagesStoc as $index => $image )
                        <option data-img-height='30px' data-img-width='30px'  @selected($image->id == $stock->image_id) value="{{ $image->id }}" data-img="{{ url("uploads/products/source/" . $image->image) }}" @selected($stock->image_id == $image->id)></option>
                    @endforeach
                </select>
            </div> --}}

            <div class="form-group " id="stockAvilableVal{{$stock->id}}" >
                <label class="">{{ trans('home.values') }}</label>
                <select stock_id="{{$stock->id}}" id="stockAvilableVal{{$stock->id}}" class="form-control select2" onchange="saveToStockId(this,'product_attribute_id','{{$stock->id}}')" >
                    <option value="">@lang('home.choose')</option>
                    @foreach ( $stock->avilableValuesForGroup as $avilableValues)
                        <option value="{{$avilableValues->id}}" > {{ $avilableValues->attributeValue->{'value_'.$lang} }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group d-flex justify-content-center">
                <div class="">
                    <label class="">{{ trans('home.price') }}</label>
                    <input stock_id="{{$stock->id}}" id="stockPrice{{$stock->id}}" class="form-control" value="{{$stock->price}}"  type="number" step="0.01" placeholder="{{ trans('home.price') }}"  onchange="saveToStockId(this,'price','{{$stock->id}}')"  >
                </div>
                <div>
                    <label class="">{{ trans('home.stock') }}</label>
                    <input stock_id="{{$stock->id}}" id="stockStock{{$stock->id}}" class="form-control" value="{{$stock->stock}}"  type="number" placeholder="{{ trans('home.stock') }}"  onchange="saveToStockId(this,'stock','{{$stock->id}}')"  >
                </div>
            </div>
        </div>
    </div>
@elseif (isset($avilable_values))
    <select stock_id="{{$stock_id}}" class="form-control select2" onchange="saveToStockId(this,'product_attribute_id','{{$stock_id}}')" >
        <option value="">@lang('home.choose')</option>
        @foreach ( $avilable_values as $avilableValues)
            <option value="{{$avilableValues->id}}" > {{ $avilableValues->attributeValue->{'value_'.$lang} }}</option>
        @endforeach
    </select>

@elseif (isset($group_values)&& count($group_values))
    @foreach ( $group_values as $product_attribute )
        <span class="badge badge-primary d-flex m-1 justify-content-center align-items-center">
            <span class="badge badge-pill" style="cursor: pointer;font-size: large" onclick="removeStock({{$stock_id}},{{$product_attribute->id}},'{{$stock_id}}')">x</span>
            {{ $product_attribute->attributeValue->{'value_'.$lang} }}
        </span>
    @endforeach
@endif


