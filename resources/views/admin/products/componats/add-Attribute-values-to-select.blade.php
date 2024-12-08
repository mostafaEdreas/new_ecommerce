<label for="helperText">{{ trans('home.attributes_values') }}</label>
<select id="attributeValues" class="form-control role select2" name="values[]" multiple>
    @foreach($attributes as $attribute)
        <optgroup label="{{ $attribute->name }}">
            @foreach($attribute->values as $value)
            <option
            @selected(old('values') && in_array(json_encode(['id' => $value->id, 'label' => $attribute->id]), old('values', [])))
            value="{{ json_encode(['id' => $value->id, 'label' => $attribute->id]) }}">
            {{ $value->value }}
        </option>
                    @endforeach
        </optgroup>
    @endforeach
</select>