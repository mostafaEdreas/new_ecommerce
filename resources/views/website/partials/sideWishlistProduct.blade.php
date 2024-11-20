<div class="card-wrap custom-scroll">
    @if(count($wishProds)>0)
        @foreach($wishProds as $wishProd)
            <!-- Cart Item Start -->
            <div class="cart-card media">
                <a href="{{LaravelLocalization::localizeUrl('product/'.$wishProd->{'link_'.$lang} )}}?{{}}">
                <img src="{{Helper::uploadedImagesPath('products',$wishProd->firstImage()->image)}}"
                    class="img-fluid" alt="{{$wishProd->{'name_'.$lang} }}" /> </a>
                <div class="media-body">
                <a href="{{LaravelLocalization::localizeUrl('product/'.$wishProd->{'link_'.$lang} )}}">
                    <h6>{{$wishProd->{'name_'.$lang} }}</h6>
                </a>
                </div>
                <form action="{{url('remove/wishlist/'.$wishProd->id) }}" method="post">
                    @csrf
                    <input class="productId" type="hidden" name="CartProductId" value="{{$wishProd->id}}">
                    <button type="submit" class="btn remove-icon  position-static me-3  delete_wishlist" title="Remove">  <i data-feather="x"></i></button>
                </form>
            </div>
            <!-- Cart Item End -->
        @endforeach
    @else
        <a href="{{LaravelLocalization::localizeUrl('/products')}}"> <img src="{{Helper::imageFilesPath('icons/svg/box.svg')}}" class="img-fluid" alt="box" /> </a>
        <div class="content">
          <a href="{{LaravelLocalization::localizeUrl('/products')}}">
            <h6>{{__('home.emptyWishlist')}}    !!</h6>
            <p>{{__('home.discover our products')}}</p>
          </a>
        </div>
    @endif
</div>



<script src="{{ Helper::jsFilesPath('feather/feather.min.js') }}"></script>

