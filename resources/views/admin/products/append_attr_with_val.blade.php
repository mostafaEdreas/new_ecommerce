    <div class="col-md-6 bg-white rounded p-3" style="width: max-content; display: inline-block">
        <div class="bg-light p-1 d-flex  align-items-center">
            <button type="button" class="btn" data-toggle="modal" onclick="getDoesntHaveVal('{{$attribute->id}}')" data-target="#add-value-to-attribute">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                </svg>
            </button>
            <h5 class="p-0 m-0">
                {{ $attribute->{'name_' . $lang} }}
            </h5>
        </div>
        @include('admin.products.add_values_to_attribute_modal')
        <div class="d-flex flex-wrap" id="{{ $attribute->{'name_' . $lang}.  $attribute->id }}">
            @foreach ($attribute->productAttributeValues($product_id??$product->id) as $value)
                {{-- <div class="d-flex flex-column m-2" style="border: solid 1px black;width:10rem">
                    <label class="val-title bg-primary text-white mb-0">{{ $value->attributeValue->{'value_' . $lang} }}</label>
                    <div class="d-flex p-0 align-items-center">
                        <div class= "bg-light d-flex justify-content-center align-items-center" style="height: 100%; width: 100%">
                            <input type="checkbox" class="remveValue{{ $attribute->id }}" value="{{ $value->id }}" checked>
                        </div>
                         <input type="number" step="0.01" pro_attr_id ="{{$value->id}}" onkeydown="changPrice(this,event)" onchange="changPrice(this,event)" class="change-price" value="{{$value->price}}"  placeholder="@lang('home.price')">
                    </div>
                </div> --}}

                {{-- <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <input type="checkbox"   class="remveValue{{ $attribute->id }}" value="{{ $value->id }}" checked aria-label="Checkbox for following text input">
                      </div>
                    </div>
                    <input type="text" value="{{ $value->attributeValue->{'value_' . $lang} }}" readonly class="form-control" aria-label="Text input with checkbox">
                </div> --}}

                <div class="d-flex flex-column m-2" style="border: solid 1px black">

                    <div class="d-flex flex-wrap p-0 align-items-center">
                        <div class= "bg-light d-flex justify-content-center align-items-center"
                            style="height: 100%; width: 30px">
                            <input type="checkbox"  class="remveValue{{ $attribute->id }}" value="{{ $value->id }}"checked >
                        </div>
                        <label class="bg-primary text-white mb-0 p-2" style="width:150px">{{ $value->attributeValue->{'value_' . $lang} }}</label>
                    </div>
                </div>
            @endforeach
        </div>
        <div  style="display: inline-block; border:solid #ff473d 1px !important; cursor: pointer;" onclick="removeValues('remveValue{{ $attribute->id }}')" class="unchecked-val btn btn-white">@lang('home.remove unchecked values')</div>
    </div>
