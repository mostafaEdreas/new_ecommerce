@if (!empty($sliders))
    @foreach ($sliders->take(1) as $slider)
        <!--Swiper Banner Start -->
			<div class="main-slider style-1">
				<div class="main-swiper">
					<div class="bg-light">
						<div class="">
							 <div class="banner-content">
								<div class="banner-media">
									<div class="img-preview">
										<img src="{{$slider->image_source}}" alt="banner-media">
									</div>
										
								</div>
							</div>
						</div>


					</div>
				
				</div>
			</div>
			<!--Swiper Banner End-->
    @endforeach
@endif
