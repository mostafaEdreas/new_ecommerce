<div class="modal fade" id="addEditModal_{{$address->id}}" tabindex="-1" aria-labelledby="addEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="addEditModalLabel">{{__('home.Edit shipping address')}}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="edit-address-from" method="post" action="{{url('update/userAddress/'.$address->id)}}">
                    @csrf
                    <div class="form-row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 row-cols-1">
                        <div class="form-group">
                            <input name="address" placeholder="{{__('home.address')}}" value="{{$address->address}}" id="edit-address" type="text" />
                        </div>
                        <div class="form-group">
                            <input name="phone1" placeholder="{{__('home.phone').' 1'}}" value="{{$address->phone1}}" id="edit-name" type="text" />
                        </div>
                        <div class="form-group">
                            <input name="phone2" placeholder="{{__('home.phone').' 2'}}" value="{{$address->phone2}}" id="edit-name" type="text" />
                        </div>
                        <div class="form-group col-12 mb-md-0">
                            <label for="shippingAddress" class="mb-0">{{__('home.country')}}</label>
                            <select class="form-control country select2" name="country_id" required>

                                @foreach($countries as $country)
                                    <option selected>{{__('home.country')}}</option>
                                    <option
                                        value="{{$country->id}}">{{(app()->getLocale() == 'en')?$country->name_en:$country->name_ar}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 mb-md-0">
                            <label for="shippingAddress" class="mb-0">{{__('home.region')}}</label>
                            <select class="form-control region select2" name="region_id"  required>
{{--                                    <option selected>{{__('home.region')}}</option>--}}
                            </select>
                        </div>
                        <div class="form-group col-12 mb-md-0">
                            <label for="shippingAddress" class="mb-0">{{__('home.area')}}</label>
                            <select class="form-control area select2" name="area_id"  required>
{{--                                    <option selected>{{__('home.area')}}</option>--}}
                            </select>
                        </div>
                    </div>
                    <div class="form-row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 row-cols-1 mt-4">
                        <div class="customCheckbox clearfix mb-2">
                            <div class="form-group col-12 mb-md-0">
                                <select class="form-control select2" name="landmark"  required>
                                    <option value="Home" {{$address->land_mark=='Home'?'selected':''}}>{{__('home.Home_address')}}</option>
                                    <option value="Office"{{$address->land_mark=='Office'?'selected':''}}>{{__('home.Office_address')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 row-cols-1 mt-4">
                        <div class="customCheckbox clearfix mb-2">
                            <input name="is_primary" id="shippingAddress" value="1" type="checkbox" @if($address->is_primary==1)checked @endif />
                            <label for="shippingAddress" class="mb-0">{{__('home.shippingAddress')}}</label>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-primary m-0"><span>{{__('home.update')}}</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    $('.country').change(function () {
        var id = $(this).val();
        var region = $('.region');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{url('getRegions')  }}',
            data: {id: id},
            success: function( data ) {
                var html = '';
                html += '<option></option>'
                for(var i=0;i<data.length;i++){
                    html += '<option  value="'+ data[i].id +'">@if(\App::getLocale() == 'en')'+ data[i].name_en +' @else '+ data[i].name_ar +' @endif</option>';
                }
                region.html(html);
            }
        });
    });

    $('.region').change(function () {
        var id = $(this).val();
        var area = $('.area');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{url('getAreas')  }}',
            data: {id: id},
            success: function( data ) {
                var html = '';
                html += '<option></option>'
                for(var i=0;i<data.length;i++){
                    html += '<option  value="'+ data[i].id +'">@if(\App::getLocale() == 'en')'+ data[i].name_en +' @else '+ data[i].name_ar +' @endif</option>';
                }
                area.html(html);
            }
        });
    });

</script>
