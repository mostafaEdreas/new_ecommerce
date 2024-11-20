@foreach ($vals as $value)
    <div class="d-flex flex-column m-2" style="border: solid 1px black">

        <div class="d-flex flex-wrap p-0 align-items-center">
            <div class= "bg-light d-flex justify-content-center align-items-center"
                style="height: 100%; width: 30px">
                <input type="checkbox" class="add-val" parentVal="{{ $value->attribute->id }}" value="{{ $value->id }}" id="defaultCheck1">
            </div>
            <label class="bg-primary text-white mb-0 p-2" style="width:150px">{{ $value->{'value_' . $lang} }}</label>
        </div>
    </div>
@endforeach
