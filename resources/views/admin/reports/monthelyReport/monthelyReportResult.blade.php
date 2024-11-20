<div id="DivIdToPrint" class="row">
	<div class="col-lg-12">
		<div class="card custom-card">
			<div class="card-body">
				<div>
					<h6 class="card-title mb-1">{{trans('home.report_results')}}</h6>
					<p class="text-muted card-sub-title">{{trans('home.month')}} {{$month}}</p>
				</div>
				<div class="table-responsive">
                    @if(count($orders)>0)
                        <table class="table table-hover mg-b-0">
                            <thead>
                                <tr>
                                    
                                    <th>#</th>
                                    <th>{{trans('home.name')}}</th>
                                    <th>{{trans('home.products_price')}}</th>
                                    <th>{{trans('home.total_price')}}</th>
                                    <th>{{trans('home.payment_fees')}}</th>
                                    <th>{{trans('home.shipping_fees')}}</th>
                                    <th>{{trans('home.coupon_discount')}}</th>
                                    <th>{{trans('home.shippimg_method')}}</th>
                                    <th>{{trans('home.payment_method')}}</th>
                                    <th>{{trans('home.status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $key=>$order)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$order->user->name()}}</td>
                                        <td>{{$order->products_price}}</td>
                                        <td>{{$order->total_price}}</td>
                                        <td>{{$order->payment_fees}}</td>
                                        <td>{{$order->shipping_fees}}</td>
                                        <td>{{$order->coupon_discount}}</td>
                                        <td>@if($order->shippingmethod){{(app()->getLocale() == 'en')?$order->shippingmethod->name_en:$order->shippingmethod->name_ar}}@endif</td>
                                        <td>@if($order->shippingmethod){{(app()->getLocale() == 'en')?$order->paymentmethod->name_en:$order->paymentmethod->name_ar}}@endif</td>
                                        <td>{{$order->status}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <h3>{{trans('home.no_data_found')}}</h3>
                        </div>
                    @endif

				</div>
			</div>
		</div>
	</div>
</div>
