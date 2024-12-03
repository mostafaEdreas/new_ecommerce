@extends('layouts.admin')
@section('meta')
    <title>{{trans('home.admin_panel')}}</title>
@endsection
@section('content')

<div class="container-fluid">

	<!-- Page Header -->
	<div class="page-header">
		<div>
			<h2 class="main-content-title tx-24 mg-b-5">{{trans('home.Welcome To Dashboard')}}</h2>
		</div>
	</div>
	<!-- End Page Header -->

	<!-- Row -->
	<div class="row row-sm">
		@foreach ($reports as $key => $value )
		<div class="col-sm-6 col-xl-2 col-lg-6">
			<div class="card custom-card">
				<div class="card-body dash1">
					<div class="d-flex">
						<p class="mb-1 tx-inverse">{{trans("home.$key")}}</p>
						{{-- <div class="ml-auto">
							<i class="fas fa-chart-line fs-20 text-primary"></i>
						</div> --}}
					</div>
					<div>
						<h3 class="dash-25">{{$value}}</h3>
					</div>
					<div class="progress mb-1">
						@php
							$bg = [
									'bg-primary',
									'bg-secondary',
									'bg-success',
									'bg-danger',
									'bg-warning',
									'bg-info',
									
									'bg-dark',
								
									
								];

						@endphp
						<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" class="progress-bar {{$bg[array_rand($bg)]}} progress-bar-xs wd-70p" role="progressbar"></div>
					</div>
					<div class="expansion-label d-flex">
						<span class="text-muted">{{trans("home.$key")}}</span>
						<span class="ml-auto">{{$value}}</span>
					</div>
				</div>
			</div>
		</div>
		@endforeach
		

		{{-- <div class="col-sm-6 col-xl-2 col-lg-6">
			<div class="card custom-card">
				<div class="card-body dash1">
					<div class="d-flex">
						<p class="mb-1 tx-inverse">{{trans('home.pending_orders')}}</p>
						<div class="ml-auto">
							<i class="fab fa-rev fs-20 text-secondary"></i>
						</div>
					</div>
					<div>
						<h3 class="dash-25">{{$pendingOrders}}</h3>
					</div>
					<div class="progress mb-1">
						<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" class="progress-bar progress-bar-xs wd-60p bg-secondary" role="progressbar"></div>
					</div>
					<div class="expansion-label d-flex">
						<span class="text-muted">{{trans('home.pending_orders_cost')}}</span>
						<span class="ml-auto">{{$pendingOrdersCost}} {{trans('home.SAR')}}</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-xl-2 col-lg-6">
			<div class="card custom-card">
				<div class="card-body dash1">
					<div class="d-flex">
						<p class="mb-1 tx-inverse">{{trans('home.products_price')}}</p>
						<div class="ml-auto">
							<i class="fas fa-dollar-sign fs-20 text-success"></i>
						</div>
					</div>
					<div>
						<h3 class="dash-25">{{$productsPrice}}  {{trans('home.SAR')}}</h3>
					</div>
					<div class="progress mb-1">
						<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" class="progress-bar progress-bar-xs wd-50p bg-success" role="progressbar"></div>
					</div>
					<div class="expansion-label d-flex text-muted">
						<span class="text-muted">{{trans('home.orderedProductsCost')}}</span>
						<span class="ml-auto">{{$orderedProductsCost}}  {{trans('home.SAR')}}</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-xl-2 col-lg-6">
			<div class="card custom-card">
				<div class="card-body dash1">
					<div class="d-flex">
						<p class="mb-1 tx-inverse">{{trans('home.productsCount')}}</p>
						<div class="ml-auto">
							<i class="fas fa-signal fs-20 text-info"></i>
						</div>
					</div>
					<div>
						<h3 class="dash-25">{{$productsCount}}</h3>
					</div>
					<div class="progress mb-1">
						<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" class="progress-bar progress-bar-xs wd-40p bg-info" role="progressbar"></div>
					</div>
					<div class="expansion-label d-flex text-muted">
						<span class="text-muted">{{trans('home.orderdProductCount')}}</span>
						<span class="ml-auto">{{$orderdProductCount}}</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-xl-2 col-lg-6">
			<div class="card custom-card">
				<div class="card-body dash1">
					<div class="d-flex">
						<p class="mb-1 tx-inverse">{{trans('home.total_registerd_users')}}</p>
						<div class="ml-auto">
							<i class="fab fa-rev fs-20 text-secondary"></i>
						</div>
					</div>
					<div>
						<h3 class="dash-25">{{$totalUsers}}</h3>
					</div>
					<div class="progress mb-1">
						<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" class="progress-bar progress-bar-xs wd-60p bg-secondary" role="progressbar"></div>
					</div>
					<div class="expansion-label d-flex">
						<span class="text-muted">{{trans('home.currentMonthUsers')}}</span>
						<span class="ml-auto">{{$currentMonthUsers}}</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-xl-2 col-lg-6">
		    <div class="card custom-card">
				<div class="card-body">
					<div>
						<h6 class="card-title mb-1">{{trans('home.Monthly Profits')}}</h6>
					</div>
					<h3 class="dash-25">{{$totalOrdersCost}} {{trans('home.SAR')}}</h3>
					<div class="clearfix mb-3">
						<div class="clearfix">
							<span class="float-left text-muted">{{trans('home.This Month')}}</span>
							<span class="float-right">{{$currentMonthOrdersCost}} {{trans('home.SAR')}}</span>
						</div>

						<div class="progress mt-1">
							<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" class="progress-bar progress-bar-xs wd-70p bg-primary" role="progressbar"></div>
						</div>
					</div>
					{{--
					<div class="clearfix">
						<div class="clearfix">
							<span class="float-left text-muted">{{trans('home.Last Monthes')}}</span>
							<span class="float-right">{{$lastMonthOrdersCost}} {{trans('home.SAR')}}</span>
						</div>
						<div class="progress mt-1">
							<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" class="progress-bar progress-bar-xs wd-50p bg-success" role="progressbar"></div>
						</div>
					</div>
					--}}
				</div>
			</div>
		</div> --}}
	</div>
	<!--End  Row -->

	<!-- Row -->
	{{--
	<div class="row row-sm">
		<div class="col-sm-12 col-xl-12 col-lg-12">
			<div class="card custom-card overflow-hidden">
				<div class="card-body">
					<div class="card-option d-flex">
						<div>
							<h6 class="card-title mb-1">Overview of Sales Win/Lost</h6>
							<p class="text-muted card-sub-title">Comapred to last month sales.</p>
						</div>
						<div class="card-option-title ml-auto">
							<div class="btn-group p-0">
								<button class="btn btn-light btn-sm" type="button">Month</button>
								<button class="btn btn-outline-light btn-sm" type="button">Year</button>
							</div>
						</div>
					</div>
					<div>
						<canvas id="sales"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Row -->
	--}}

	<!-- Row-->
	<div class="row">
		<div class="col-sm-12 col-xl-12 col-lg-12">
			<div class="card custom-card">
				<div class="card-body">
					<div>
						<h6 class="card-title mb-1">{{trans('home.Orders Summary')}}</h6>
						<p class="text-muted card-sub-title">{{trans('home.list of recent 10 orders')}}</p>
					</div>
					<div class="table-responsive">
						<table class="table table-bordered text-nowrap mb-0">
							<thead>
								<tr>
									<th>#No</th>
									<th>{{trans('home.order_number')}}</th>
									<th>{{trans('home.order_date')}}</th>
									<th>{{trans('home.order_user')}}</th>
									<th>{{trans('home.order_address')}}</th>
									<th>{{trans('home.order_note')}}</th>
									<th>{{trans('home.order_phone_numbers')}}</th>
									<th>{{trans('home.order_status')}}</th>
								</tr>
							</thead>
							<tbody>

								@foreach($orders as $key=>$order)
									<tr>
										<td>{{$key}}</td>
										<td>{{$order->id}}</td>
										<td>{{date('Y-m-d', strtotime($order->created_at ))}}</td>
										<td>@if($order->user){{$order->user->name()}}@endif</td>
										<td>@if($order->address){{$order->address->address}} @endif</td>
										<td>@if($order->address){{$order->order_note}} @endif</td>
										<td>@if($order->address){{$order->address->phone1}} @if($order->address->phone1) - {{$order->address->phone1}} @endif @endif</td>

										<td>
											@if($order->status == 'pending')
												<span class="badge badge-primary">{{trans('home.pending')}}</span>
											@elseif($order->status == 'accept')
												<span class="badge badge-secondary">{{trans('home.accept')}}</span>
											@elseif($order->status == 'process')
												<span class="badge badge-info">{{trans('home.process')}}</span>
											@elseif($order->status == 'shipping')
												<span class="badge badge-default">{{trans('home.shipping')}}</span>
											@elseif($order->status == 'delivered')
												<span class="badge badge-success">{{trans('home.delivered')}}</span>
											@elseif($order->status == 'canceled')
												<span class="badge badge-danger">{{trans('home.canceled')}}</span>
											@endif
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
