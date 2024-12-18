 <div class="side-list">
    <div>
    <a href="javascript:void(0)" class="cart-button"><i data-feather="shopping-bag"></i> <span
        class="notification-label cart-count">{{$cartCount}}</span></a>
    <a href="javascript:void(0)" class="overlay-cart overlay-common"></a>
    <div class="onhover-cart-dropdown">
        <div class="onhover-show-div">
        <div class="dropdown-header">
            <div class="control">
            <a href="{{LaravelLocalization::localizeUrl('/shopping-cart')}}">{{ __('home.cart') }}</a>
            <button class="back-cart"><i data-feather="arrow-right"></i></button>
            </div>
        </div>
        <div class="card-wrap custom-scroll">
            @foreach($cartProds as $cartProd)
                <!-- Cart Item Start -->
                <div class="cart-card media">
                    <a href="{{LaravelLocalization::localizeUrl('product/'.$cartProd->product->{'link_'.$lang} )}}">
                    <img src="{{Helper::uploadedImagesPath('products',$cartProd->product->images()[0])}}"
                        class="img-fluid" alt="{{$cartProd->product->{'name_'.$lang} }}" /> </a>
                    <div class="media-body">
                    <a href="{{LaravelLocalization::localizeUrl('product/'.$cartProd->product->{'link_'.$lang} )}}">
                        <h6>{{$cartProd->product->{'name_'.$lang} }}</h6>
                    </a>
                    @if($cartProd->product->discount()>0)
                        <span>{{$cartProd->product->condition_discount_product_page($cartProd->productAttributeValues()->id).' '.__('home.EGP')  }}</span>
                    @else
                        <span>{{$cartProd->product->condition_discount_product_page($cartProd->productAttributeValues()->id).' '.__('home.EGP')  }}</span>
                    @endif

                    <div class="plus-minus product_{{$cartProd->product->id}}">
                            <a class="qtyBtn minus minus-button sub " href="javascript:void(0);" data-product_id="{{$cartProd->product->id}}" data-cart_id="{{$cartProd->id}}" data-product_price="{{$cartProd->prod_price}}" data-n_stock="{{$cartProd->product->stockCount()}}" >
                              <i class="sub" data-feather="minus"></i>
                      </a>
                      <input type="number" id="quantity_{{$cartProd->product->id}}" name="quantity" value="{{$cartProd->quantity}}" class="qty" disabled>
                      <a class="qtyBtn plus plus-button add {{$cartProd->quantity>=$cartProd->product->stockCount()?'disabled':''}}"   href="javascript:void(0);" data-cart_id="{{$cartProd->id}}" data-product_id="{{$cartProd->product->id}}" data-product_price="{{$cartProd->prod_price}}" data-n_stock="{{$cartProd->product->stockCount()}}" >
                          <i class="add" data-feather="plus"></i>
                      </a>
                    </div>
                    </div>
                    <form method="POST" action="{{url('removeCartProduct')}}">
                        @csrf
                        <input type="hidden" name="CartProductId" value="{{$cartProd->id}}">
                        <a  href="javascript:void(0);"  class="remove-cart delete_product">
                        <i data-feather="x"></i></a>
                    </form>
                </div>
                <!-- Cart Item End -->
            @endforeach
        </div>
        @if($setting->free_shipping_status==1 && $setting->free_shipping>0)
            <?php $amount_money = $setting->free_shipping-$totalPrice;
                    $progress = 100-(($setting->free_shipping-$totalPrice)/$setting->free_shipping *100)  ?>
            <div>
                <div>
                    <p>{{__('home.Free_shipping_and_maintenance')}} 
                    <strong>{{ $setting->free_shipping }}</strong>
                    </p>
                    <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{$progress>=100?100:$progress+10}}%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100">{{ substr($progress, 0,  4) }}%</div>
                    </div>
                </div>

            <div class="btn-group block-group">
                <a href="{{ url('shopping-cart') }}" class="btn-solid">{{__('home.cart')}} </a>
                <a href="{{ url('order-checkOut') }}" class="btn-outline">{{__('home.checkout')}}</a>
            </div>
            </div>
        @endif
        </div>
    </div>
    </div>
    <div class="side-box">
    <span>{{__('home.cart')}}:</span>
    <a href="jabvascript:void(0)" id="sideCart_totalPrice">{{ $totalPrice.' '.__('home.EGP') }}</a>
    </div>

</div>
<!-- Load Feather Icon -->
<script src="{{ Helper::jsFilesPath('feather/feather.min.js') }}"></script>
<script>
    function delete_product() {
            $('.delete_product').on('click', function () {
                btn = $(this);
                $.confirm({
                    title: '{{trans("home.delete product")}}',
                    content: '{{trans("home.Are you sure you want to delete that product ?")}}',
                    rtl: true,
    
                    buttons: {
                        confirm: function () {
                            text: "{{trans('home.OK')}}";
                            btnClass: "btn main-btn";
                            btn.closest("form").submit();
                        },
                        cancel: function () {
                            text: "{{trans('home.cancel')}}";
                        }
                    },
                });
            });
        }
    
    delete_product();
    ////reinizialize addminus from script.js/////
    function initializePlusMinus() {
        const plusMinus = document.querySelectorAll(".plus-minus ");
        feather.replace();
        for (var i = 0; i < plusMinus.length; ++i) {
            const addButton = plusMinus[i].querySelector(".add")
            const subButton = plusMinus[i].querySelector(".sub")
            addButton?.addEventListener('click', function () {
                const inputEl = this.parentNode.querySelector("input[type='number']");
                if (inputEl.value < 10) {
                    inputEl.value = Number(inputEl.value) + 1;
                }
            })
            subButton?.addEventListener('click', function () {
                const inputEl = this.parentNode.querySelector("input[type='number']");
                if (inputEl.value > 1) {
                    inputEl.value = Number(inputEl.value) - 1;
                }
            })
        };
    }
    initializePlusMinus()
         function changeAddQuantity() {
        $('.plus-button').click(function () {
            var cart_id = $(this).data('cart_id');
            var n_stock = $(this).data('n_stock');
            var product_id = $(this).data('product_id');
            var quantity = $('#quantity_'+product_id).val();
            if(quantity>=n_stock){
                   $(this).addClass('disabled');
            }
            let updateDone = false;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{LaravelLocalization::localizeUrl('changeCartProductQuantity')}}",
                method: 'POST',
                data: {
                    cart_id: cart_id,
                    sign: 'plus'
                },
               success: function (data) {
                    $('#sideCart_totalPrice').html(data.total_price+'{{ ' '.__('home.EGP')}}');
                    $('#sub_totalPrice').html(data.total_price);
                },

            });
        });
    }
    changeAddQuantity();
    function changeMinusQuantity() {
        $('.minus-button').click(function () {
            var cart_id = $(this).data('cart_id');
            var product_id = $(this).data('product_id');
            console.log(product_id);
            $('.product_' + product_id + ' a').removeClass('disabled');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{LaravelLocalization::localizeUrl('changeCartProductQuantity')}}",
                method: 'POST',
                data: {
                    cart_id: cart_id,
                    sign: 'minus'
                },
                success: function (data) {
                    $('#sideCart_totalPrice').html(data.total_price+'{{' '. __('home.EGP')}}');
                    $('#sub_totalPrice').html(data.total_price);

                },
            });
        });
    }
    changeMinusQuantity()


</script>
