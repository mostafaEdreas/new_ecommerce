@extends('layouts.app')
@section('meta')
    @php echo $metatags @endphp
    @php echo $schema @endphp
@endsection
@section('content')
    <div class="page-content">
        @include('website.carts.banner')
        
        		<!-- contact area -->
		<section class="content-inner shop-account">
			<!-- Product -->
			<div class="container">
				<div class="row">
					<div class="col-lg-8">
						<div class="table-responsive">
							<table class="table check-tbl">
								<thead>
									<tr>
										<th>@lang('home.product')</th>
										<th></th>
										<th>@lang('home.price')</th>
										<th>@lang('home.quantity')</th>
										<th>@lang('home.subtotal')</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
                                    @foreach ($carts as $cart)
                                    <tr>
										<td class="product-item-img"><img src="{{$cart->product_main_image}}" alt="/"></td>
										<td class="product-item-name">{{$cart->product_name}}</td>
										<td class="product-item-price">{{$cart->product_price}}</td>
										<td class="product-item-quantity">
											<div class="quantity btn-quantity style-1 me-3">
												<input  type="text" value="{{$cart->quantity}}" name="quantity">
											</div>
										</td>
										<td class="product-item-totle">{{$cart->product_net_price}}</td>
										<td class="product-item-close"><a href="javascript:void(0);"><i class="ti-close"></i></a></td>
									</tr>
                                    @endforeach
									
									
								</tbody>
							</table>
						</div>
						
					</div>
					<div class="col-lg-4">
						<h4 class="title mb15">Cart Total</h4>
						<div class="cart-detail">
						    
						    
							<table>
								<tbody>
									<tr class="total">
										<td>
											<h6 class="mb-0">Total</h6>
										</td>
										<td class="price">
											125.75 LE
										</td>
									</tr>
								</tbody>
							</table>
							<a href="shop-checkout.html" class="btn btn-secondary w-100">PLACE ORDER</a>
						</div>
					</div>
				</div>
			</div>
			<!-- Product END -->
		</section>
		<!-- contact area End--> 
    </div>
@endsection
@section('script')
@endsection