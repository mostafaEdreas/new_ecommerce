@extends('layouts.admin')
<title>{{trans('home.edit_branche')}}</title>
@section('content')

<div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.branches')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/branches')}}">{{trans('home.branches')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.edit_branche')}}</li>
                </ol>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Row-->
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
    
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{trans('home.edit_branche')}}</h6>
                        </div>
                        {!! Form::open(['method'=>'PATCH','url' => 'admin/branches/'.$branche->id, 'data-toggle'=>'validator', 'files'=>'true']) !!}
                            <div class="row">


                                <div class="form-group col-md-2">
                                    <label class="">{{trans('home.name_en')}}</label>
                                    <input class="form-control" name="name_en" type="text" placeholder="{{trans('home.name_en')}}"  value="{{$branche->name_en}}" required>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="">{{trans('home.name_ar')}}</label>
                                    <input class="form-control" name="name_ar" type="text" placeholder="{{trans('home.name_ar')}}" value="{{$branche->name_ar}}" />
                                </div>
                                
                                <div class="form-group col-md-4">
                                    <label class="">{{trans('home.address_en')}}</label>
                                    <input class="form-control" name="address_en" type="text" placeholder="{{trans('home.address_en')}}" value="{{$branche->address_en}}"/>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="">{{trans('home.address_ar')}}</label>
                                    <input class="form-control" name="address_ar" type="text" placeholder="{{trans('home.address_ar')}}" value="{{$branche->address_ar}}"/>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label for="inputName4">{{trans('home.region')}}:</label>
                                    <select class="form-control region select2" name="region_id"  required>
                                        <option></option>
                                        @foreach($regions as $region)
                                            <option value="{{$region->id}}" @if($branche->region_id == $region->id) selected @endif>{{(app()->getLocale() == 'en')?$region->name_en :$region->name_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputName4">{{trans('home.area')}}:</label>
                                    <select class="form-control area select2" name="area_id" required >
                                        @foreach($areas as $area)
                                            <option value="{{$area->id}}"@if($branche->area_id == $area->id) selected @endif>{{(app()->getLocale() == 'en')?$area->name_en :$area->name_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label>{{trans('home.logo')}}</label>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> {{trans('home.upload')}}</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="logo">
                                            <label class="custom-file-label" for="inputGroupFile01">{{trans('home.choose_logo')}}</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label class="">{{trans('home.mobile')}}</label>
                                    <input class="form-control" name="mobile" type="number" min="0" placeholder="{{trans('home.mobile')}}" value="{{$branche->mobile}}">
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label class="">{{trans('home.mobile')}} 2</label>
                                    <input class="form-control" name="mobile2" type="number" min="0" placeholder="{{trans('home.mobile')}} 2" value="{{$branche->mobile2}}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="">{{trans('home.telephone')}}</label>
                                    <input class="form-control" name="telephone" type="number" min="0" placeholder="{{trans('home.telephone')}}" value="{{$branche->telephone}}">
                                </div>
                                
                                @if($branche->logo)
                                    <div class="col-md-12">
                                        <img src="{{url('\uploads\branches\resize200')}}\{{$branche->logo}}" width="150">
                                    </div>
                                @endif
                                

                                <div class="col-md-12">
                                    <label>{{trans('home.map_url')}}</label>
                                    <textarea class="form-control" name="map_url" type="text" placeholder="{{trans('home.map_url')}}">{{$branche->map_url}}</textarea>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="ckbox">
                                        <input name="status" value="1" {{($branche->status == 1)? 'checked':''}} type="checkbox"><span class="tx-13">{{trans('home.publish')}}</span>
                                    </label>
                                </div>
                                
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} </button>
                                    <a href="{{url('/admin/branches')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i> {{trans('home.cancel')}}</button></a>
                                </div>
                                
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>

@endsection

@section('script')

    <script>
        $('.region').select2({
            'placeholder':'{{trans("home.regions")}}'
        });

        $('.area').select2({
            'placeholder':'{{trans("home.areas")}}'
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
@endsection


                    


