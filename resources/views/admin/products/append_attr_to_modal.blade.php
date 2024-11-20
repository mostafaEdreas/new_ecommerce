@foreach ( $attrs as $attr)
    @if (count($attr->values))
        <div class="card col-md-4 mb-3">
            <div class="card-header text-light bg-primary" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#{{ $attr->{'name_' . $lang} }}" aria-expanded="true" aria-controls="collapseOne">
                    {{ $attr->{'name_' . $lang} }}
                    </button>
                </h5>
            </div>

            <div id="{{ $attr->{'name_' . $lang} }}{{ $attr->id }}" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body" style="height:250px; overflow: auto;">
                    @foreach ($attr->values??[] as $value)
                        <div class="d-flex  align-items-center bg-light border border-light">
                            <input class="add-val-attr p-3  m-2" style="border: 1px solid black" type="checkbox" parentVal="{{ $attr->id }}" value="{{ $value->id }}" id="{{ $value->id }}">
                            <label class="m-0 bg-white p-2" style="width: 100%" for="{{ $value->id }}"> {{ $value->{'value_' . $lang} }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endforeach
{{-- {{App\Models\Attribute::whereNotIn('id', $product->attributes->pluck('id'))->get()}} --}}
