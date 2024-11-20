@if(isset($regions))
<option value="">@lang('home.regions')</option>
    @foreach ($regions as $region )
        <option value="{{$region->id }}" @selected($region->id == auth()->user()->region->id)>{{$region->{'name_'.$lang} }}</option>
    @endforeach
@elseif (isset($area) )
<option value="">@lang('home.areas')</option>
    @foreach ($areas as $area )
        <option value="{{$area->id }}" @selected($area->id == auth()->user()->area->id)>{{$area->{'name_'.$lang} }}</option>
    @endforeach
@endif