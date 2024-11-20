@extends('layouts.admin')
<title>{{trans('home.order_invoice')}}</title>

@section('content')

<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{trans('home.order_invoice')}}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{trans('home.admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('home.order_invoice')}}</li>
                </ol>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Row -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div id="elementToPrint" class="card custom-card print">
                    <div class="card-body">
                        <div id="topinv" class="d-lg-flex" style="justify-content: space-around;align-items: center;">
                            @if($configration->app_logo)
                                <img id="invlogo" src="{{url('\uploads\settings\source')}}\{{$configration->app_logo}}" alt="logo" >
                            @endif
                            <h2 class="card-title mb-1"><span class="font-weight-bold">{{trans('home.invoice_no.')}} :</span> #NSWEB{{$invoice->number}}</h2>
                            <div>
                                <p class="mb-1"><span class="font-weight-bold">{{trans('home.invoice_date')}} :</span> {{date('Y/m/d', strtotime($invoice->created_at ))}}</p>
                            </div>
                        </div>
                        <hr class="mg-b-40">

                        <div class="order_details">
                            <div class="row">
                                <div class="col-sm-12 col-md-6"><p><span>{{trans('home.order_id')}} :</span>  {{$invoice->order->id}}</p></div>
                                <div class="col-sm-12 col-md-6"><p><span>{{trans('home.order_date')}} :</span> {{date('m/d/Y', strtotime($invoice->order->created_at ))}}</p></div>
                                <div class="col-sm-12 col-md-6"><p><span>{{trans('home.deliverd_to')}} :</span>  {{$invoice->order->user->name()}}</p></div>
                                <div class="col-sm-12 col-md-6"><p><span>{{trans('home.address')}} :</span>@if($invoice->order->address) {{$invoice->order->address->address}} @endif</p></div>
                                <div class="col-sm-12 col-md-6"><p><span>{{trans('home.order_phone_numbers')}} :</span>  {{($invoice->order->address)?$invoice->order->address->phone1:trans('home.unknown_phone')}}</p></div>
                                <div class="col-sm-12 col-md-3"><p><span>{{trans('home.payment_method')}} :</span> {{(app()->getLocale() == 'en')?$invoice->order->paymentmethod->name_en:$invoice->order->paymentmethod->name_ar}}</p></div>
                                <div class="col-sm-12 col-md-3"><p><span>{{trans('home.shipping_method')}} :</span> {{(app()->getLocale() == 'en')?$invoice->order->shippingmethod->name_en:$invoice->order->shippingmethod->name_ar}}</p></div>
                            </div>
                        </div>
                        
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice table-bordered">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">{{trans('home.product')}}</th>
                                        <th class="wd-40p">{{trans('home.quantity')}}</th>
                                        <th class="tx-center">{{trans('home.price')}}</th>
                                        <th class="tx-right">{{trans('home.attributes')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($orderProducts as $key=>$orderProduct)
                                    @if($orderProduct->product)
                                        <tr>
                                            <td>{{(app()->getLocale() == 'en')? $orderProduct->product->name_en : $orderProduct->product->name_ar}}</td>
                                            <td class="tx-center">{{$orderProduct->quantity}}</td>
                                            <td class="tx-right">{{$orderProduct->price}}</td>
                                            <td class="tx-right">
                                                @if($orderProduct->group->productGroups->count() > 0)
                                                    @foreach($orderProduct->group->productGroups as $value)
                                                        {{$value->attributeValue->value_en}} 
                                                        @if(! $loop->last) , @endif
                                                    @endforeach
                                                @else
                                                    {{trans('home.no_attributes_found')}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                    <tr>
                                        <td class="tx-right">{{trans('home.products_price')}}</td>
                                        <td class="tx-right" colspan="2">{{$invoice->order->products_price}} {{trans("home.EGP")}}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-center" colspan="3">{{trans('home.product prices includes vat')}}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">{{trans('home.tax_fees')}}</td>
                                        <td class="tx-right" colspan="2"><!--{{$invoice->order->tax_fees}}--> 0 {{trans("home.EGP")}}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right tx-uppercase tx-bold tx-inverse">{{trans('home.total_price')}}</td>
                                        <td class="tx-right" colspan="2">
                                            <h4 class="tx-bold">{{$invoice->order->total_price}} {{trans("home.EGP")}}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" class="btn ripple btn-info mb-1" onclick="printElement();"><i class="fe fe-printer mr-1"></i> {{trans("home.Print Invoice")}}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->

    </div>

@endsection

@section('script')
    <script>
    function printElement() {
      // Temporarily apply the CSS style to hide other elements and show the target element
      const style = document.createElement('style');
      //style.innerHTML = '@media print { body * { display: none; } #elementToPrint { display: block !important; } }';
      style.innerHTML ='@media print {div.page-header,.main-sidebar.side-menu,.side-header{display: none !important;} #topinv{display: flex !important;flex-direction: row;flex-wrap: nowrap;justify-content: space-evenly;align-items: center;} #invlogo{max-width:250px !important}  }';
      document.head.appendChild(style);

      // Trigger the print dialog
      window.print();

      // Remove the temporary CSS style to restore the original page layout
      document.head.removeChild(style);
    }
    </script>
@endsection

