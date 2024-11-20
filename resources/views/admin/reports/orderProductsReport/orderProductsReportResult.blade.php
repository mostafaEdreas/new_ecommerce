<div id="DivIdToPrint" class="row">
	<div class="col-lg-12">
		<div class="card custom-card">
			<div class="card-body">
				<div>
					<h6 class="card-title mb-1">{{trans('home.report_results')}}</h6>
					<p class="text-muted card-sub-title">{{trans('home.date_from')}} {{$dateFrom}}   {{trans('home.date_to')}}  {{$dateTo}}</p>
				</div>
				<div class="table-responsive">
					@if(count($ordersProducts)>0)
						<table class="table table-hover mg-b-0">
							<thead>
								<tr>
									<th>#</th>
									<th>{{trans('home.name')}}</th>
									<th>{{trans('home.quantity')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($ordersProducts as $key=>$ordersProduct)
									<tr>
										<td>{{$key+1}}</td>
										<td>@if($ordersProduct->group->product){{(app()->getLocale() == 'en')?$ordersProduct->group->product->name_en:$ordersProduct->group->product->name_ar}}@endif</td>
										<td>{{$ordersProduct->productCount}}</td>
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
