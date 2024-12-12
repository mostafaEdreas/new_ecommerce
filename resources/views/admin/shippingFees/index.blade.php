@extends('layouts.admin')
    <title>{{ trans('home.shipping_fees') }}</title>
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{ trans('home.shipping_fees') }}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">{{ trans('home.admin') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('home.shipping_fees') }}</li>
                </ol>
            </div>
            {{-- <div class="btn btn-list">
                <a href="{{url('admin/shipping-methods/create')}}"><button class="btn ripple btn-primary"><i class="fas fa-plus-circle"></i> {{trans('home.add')}}</button></a>
                <a id="btn_active"><button class="btn ripple btn-dark"><i class="fas fa-eye"></i> {{trans('home.publish/unpublish')}}</button></a>
                <a id="btn_delete" ><button class="btn ripple btn-danger"><i class="fas fa-trash"></i> {{trans('home.delete')}}</button></a>
            </div> --}}
        </div>
        <!-- End Page Header -->
        <!-- Row-->
        <form accept="{{url()->current()}}">
            <div class="row bg-info p-2 pt-5">
                <div class="col-md-3 mb-3">
                    <select id="inputState" class="form-control select2" name="country_id">
                        <option value="null" selected> @lang('home.regions') </option>
                        @foreach ($countries as  $country)
                            <option value="{{$country->id}}" selected> {{$country->name}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <select id="inputState" class="form-control select2" name="region_id">
                        <option value="null" selected> @lang('home.regions') </option>
                        @foreach ($regions as  $region)
                            <option value="{{$region->id}}" selected> {{$region->name}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <input class="btn btn-primary" type="submit" class="form-control" value="@lang('home.search')">
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">{{ trans('home.shippingFeess') }}</h6>
                            <p class="text-muted card-sub-title">  {{ trans('home.table_contain_all_data_shortly_you_can_view_more_details') }} </p>
                        </div>

                        <div class="table-responsive">
                            <table class="table" id="exportexample">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">{{ trans('home.area_name') }}</th>
                                        <th class="wd-20p">{{ trans('home.fees') }}</th>
                                        <th class="wd-20p">{{ trans('home.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shippingFeeses as $shippingFees)
                                        <tr id="{{ $shippingFees->id }}">
                                            <td>{{ $shippingFees->area_name }}</td>
                                            <td>
                                                <input type="text" name="feeses[]" value="{{ $shippingFees->fees }}" data-id="{{ $shippingFees->id }}" class="fees-input">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info update-fees" data-id="{{ $shippingFees->id }}">
                                                    @lang('home.update')
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>
@endsection
@section('script')
    <script>
        $(document).on('click', '.update-fees', function () {
            const rowId = $(this).data('id');
            const fees = $(`input[name="feeses[]"][data-id="${rowId}"]`).val();

            $.ajax({
                url: '{{ route("admin.shipping.fees.update") }}',
                method: 'PATCH',
                data: {
                    ids: [rowId],
                    feeses: [fees]
                },
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "@lang('home.Success')",
                        text: response.message,
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: 'An error occurred: ' + xhr.responsejSON.message,
                    });
                }
            });
        });
    </script>
@endsection
