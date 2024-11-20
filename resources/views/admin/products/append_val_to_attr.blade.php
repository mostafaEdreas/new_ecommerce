@foreach ($attribute->productAttributeValues($product_id) as $value)
{{-- <div class="d-flex flex-column m-2" style="border: solid 1px black">
    <label class="val-title bg-primary text-white mb-0">{{ $value->attributeValue->{'value_' . $lang} }}</label>
    <div class="d-flex p-0 align-items-center">
        <div class= "bg-light d-flex justify-content-center align-items-center" style="height: 100%; width: 30px">
            <input type="checkbox" class="remveValue{{ $attribute->id }}"  value="{{ $value->id }}" checked>
        </div>
        <input type="number" step="0.01" pro_attr_id ="{{$value->id}}" onkeydown="changPrice(this,event)" onchange="changPrice(this,event)" class="change-price"  value="{{$value->price}}" placeholder="@lang('home.price')">
    </div>
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
