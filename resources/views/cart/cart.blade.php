<div class="cart-wrap">
    <div class="woocommerce">
        <form action="https://jthemes.net/themes/f-html/goshophtml/default/checkout.html" method="post">
            <table class="shop_table cart">
                <thead>
                <tr>
                    <th class="product-thumbnail">&nbsp;</th>
                    <th class="product-name">Product</th>
                    <th class="product-price">Price</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-subtotal">Total</th>
                </tr>
                </thead>
                <tbody>
                @forelse($cartContents as $product)
                <?php 
                $productDetails = getProductDetails($product->id);
                if($productDetails) {
                $slug = (!empty($product->slug)) ? $product->slug : Hashids::encode($product->id); ?>
                
                    <tr class="cart_item">
                        <td class="product-thumbnail">
                            <a href="javascript:void(0)">
                                <img src="{{ getProductDefaultImage($product->id) }}" alt="poster_2_up">
                            </a>
                        </td>
                        <td class="product-name">
                            <div class="rating">
                                <span class="star active"></span>
                                <span class="star active"></span>
                                <span class="star active"></span>
                                <span class="star active"></span>
                                <span class="star half"></span>
                            </div>
                            <div class="cart-product-title">
                                <a href="{{ url('products/'.$slug) }}">{{$product->name}} <span
                                        class="thm-clr"> {{$product->code}} </span> </a>
                            </div>

                            <!--                                        <p class="fsz-20 funky-font-2">Women Collection</p>-->
                        </td>

                        <td class="product-price">
                            <p class="font-3 fsz-18 no-mrgn"><b
                                    class="amount blk-clr">{{$product->quantity . ' x £' . $product->price." "}}
                                    @if(@$product->cprice > $product->price)
                                        <s>{{"(".$product->cprice.")"}}</s>
                                    @endif</b><!-- <del>$299.00</del>--> </p>
                            <!--                                        <p class="fsz-14 no-mrgn"> <b class="gray-clr">Special Offers: </b> <b class="blk-clr">Discount 50%</b> </p>-->
                        </td>

                        <td class="product-quantity">
                            <div class="quantity input-group">
                                                        <span class="input-group-btn ">
                                                            <button type="button" class="btn-number btn-up"
                                                                    data-id="product{{$product->id}}"
                                                                    data-product="{{$product->id}}">
                                                                <i class="fa fa-chevron-up"></i>
                                                            </button>
                                                        </span>
                                <input type="text" name="" data-product="{{$product->id}}"
                                       data-quantity="{{getProductQuantity($product->id)}}"
                                       value="{{$product->quantity}}" min="1" max="{{getProductQuantity($product->id)}}"
                                       placeholder="Quantity" onkeyup="checkToUpdateCart(this)" title="Qty"
                                       class="input-text qty input-qty product{{$product->id}}">
                                <span class="input-group-btn ">
                                                            <button type="button" class="btn-number btn-down"
                                                                    data-id="product{{$product->id}}"
                                                                    data-product="{{$product->id}}" data-type="minus"
                                                                    data-field="cart[b3e3e393c77e35a4a3f3cbd1e429b5dc][qty]">
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                        </span>
                            </div>
                        </td>

                        <td class="product-subtotal">
                            <p class="font-3 fsz-18 no-mrgn"><b class="amount blk-clr"><i
                                        class="fa fa-gbp">{{($product->price * $product->quantity)}}</i></b></p>
                            <a href="javascript:void(0)" class="remove remove-from-cart" title="Remove this item"
                               data-id="{{$product->id}}"> <i class="fa-times fa"></i> </a>
                        </td>
                    </tr>
                <?php } ?>
                @empty
                    <tr>
                        <td colspan="4">No Record Found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </form>

        <div class="cart-extra-info clearfix">
            <!--                            <div class="col-lg-4 col-sm-4 cart-shipping-calculator">
                                            <h4 class="cart-title-highlight title-3">Calculate Shipping</h4>
                                            <form class="woocommerce-shipping-calculator" action="#">
                                                <section class="shipping-calculator-form">
                                                    <div class="form-group selectpicker-wrapper">
                                                        <div class="btn-group bootstrap-select input-price" style="width: 100%;"><button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" title="Country"><span class="filter-option pull-left">Country</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button><div class="dropdown-menu open"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off"></div><ul class="dropdown-menu inner" role="menu"><li data-original-index="1"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Åland Islands</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="2"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Afghanistan</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="3"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Albania</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul></div><select class="selectpicker input-price" data-live-search="true" data-width="100%" data-toggle="tooltip" title="Country" tabindex="-98"><option class="bs-title-option" value="">Country</option>
                                                                <option>Åland Islands</option>
                                                                <option>Afghanistan</option>
                                                                <option>Albania</option>
                                                            </select></div>
                                                    </div>
                                                    <div class="form-group selectpicker-wrapper">
                                                        <div class="btn-group bootstrap-select input-price" style="width: 100%;"><button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" title="State / Province"><span class="filter-option pull-left">State / Province</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button><div class="dropdown-menu open"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off"></div><ul class="dropdown-menu inner" role="menu"><li data-original-index="1"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Tirana</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="2"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Durres</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="3"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Vlore</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul></div><select class="selectpicker input-price" data-live-search="true" data-width="100%" data-toggle="tooltip" title="State / Province" tabindex="-98"><option class="bs-title-option" value="">State / Province</option>
                                                                <option>Tirana</option>
                                                                <option>Durres</option>
                                                                <option>Vlore</option>
                                                            </select></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" placeholder="ZIP / Portal Code">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="submit" value="Update" class="button">
                                                    </div>
                                                </section>
                                            </form>
                                        </div>-->

            <div class="col-lg-4 col-sm-4 cart-collaterals">
                <div class="cart_totals font-2">
                    <h4 class="cart-title-highlight title-3">Cart Total</h4>
                    <table>
                        <tbody>
                        @if(Auth::user()->type == 'dropshipper')
                            <tr>
                                <td>Product Vat</td>

                                <td class="subtotal">£{{number_format(($originalPrice*$vatCharges)/100,2)}}</td>
                                @php $subTotal=number_format($subTotal+(($subTotal)*$vatCharges)/100,2) @endphp

                            </tr>
                        @endif

                        <tr>

                            @if(Auth::user()->type == 'dropshipper')
                                <td>Shipping Charges</td>


                                <td >£{{number_format(@$total_shipment_charges,2) }}</td>

                            @elseif(Auth::user()->type == 'wholesaler')

                                <td>Shipping Charges</td>
                                <td class="subtotal">£0</td>
                            @else
                                <td>Shipping Charges</td>
                                <td class="subtotal">£{{number_format(($subTotal - $cartSum) ,2)}}</td>
                            @endif
                        </tr>

                        @if(Auth::user()->type == 'dropshipper')
                            <tr>
                                <td>Shipping Tax</td>
                                <td class="subtotal">£{{number_format(($total_shipment_charges*$vatCharges)/100,2)}}</td>
                                @php $total_shipment_charges=number_format($total_shipment_charges+(($total_shipment_charges)*$vatCharges)/100,2) @endphp


                            </tr>
                        @endif
                        @if(Auth::user()->type != 'dropshipper')
                            <tr>

                                <td>Discount</td>

                                <td class="subtotal">£{{number_format($originalPrice - $subTotal,2)}}</td>

                            </tr>
                        @endif
                        @if( Auth::user()->type == 'wholesaler')

                            <tr>

                                <td>Vat</td>

                                <td>£{{number_format(($subTotal*$vatCharges)/100,2)}}</td>
                                @php $subTotal=number_format($subTotal+($subTotal*$vatCharges)/100,2) @endphp

                            </tr>
                        @endif
                        <?php
                        $subTotal = numberFormatToFloat($subTotal);
                        ?>
                        <tr class="cart-subtotal">
                            <th>Sub Total:</th>
                            <td><span class="drk-gry"><i class="fa fa-gbp">
                                {{number_format($subTotal+($subTotal*$vatCharges)/100,2)}}</i></span>
                            </td>
                        </tr>

                        <tr class="order-total">
                            <th>Order Total</th>
                            <td><strong><span class="amount"><i
                                            class="fa fa-gbp">{{number_format($subTotal+($subTotal*$vatCharges)/100,2)}}</i></span></strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!--                            <div class="col-lg-4 col-sm-4 cart-coupons">
                                            <h4 class="cart-title-highlight title-3"> Apply Coupon Code </h4>
                                            <p class="title-3 fsz-15 no-mrgn">  ASIN: <span class="thm-clr"> B00IL3TMFW </span> </p>
                                            <p class="font-4 fsz-15">  Shipping Weight: 1.8 pounds </p>
                                            <form>
                                                <div class="form-group">
                                                    <input type="text" placeholder="ENTER CODE" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" class="button" value="Apply">
                                                </div>
                                            </form>
                                        </div>-->
        </div>

        <div class="wc-proceed-to-checkout text-center">
            <a  href="{{url('make-payment')}}" class="checkout-button button alt wc-forward">
                <i class="fa fa-check-circle"></i>Proceed to Checkout
            </a>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $(".btn-down").click(function () {
            var productId = $(this).attr('data-id');
            var input = $(".quantity").find("input." + productId);
            var id = $(this).attr('data-product');
            if (parseInt(input.val()) > 1) {
                input.val(parseInt(input.val()) - 1);
                if (parseInt(input.val()) < parseInt(input.attr("max"))) {
                    updateCartItems(id, input.val());
                } else {
                    error_message("You have added maximum " + input.attr("max") + " quantity");
                }
            }


        });
        $(".btn-up").click(function () {
            var productId = $(this).attr('data-id');
            var input = $(".quantity").find("input." + productId);
            var id = $(this).attr('data-product');
            if (parseInt(input.val()) < parseInt(input.attr("max"))) {
                input.val(parseInt(input.val()) + 1);
                updateCartItems(id, input.val());
            } else {
                error_message("You have added maximum " + input.attr("max") + " quantity");
            }
        });
        $(".update-cart").click(function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var qty = $('.product' + id).val();
            var totalAvailable = $('.product' + id).attr('data-quantity');
            if (qty > totalAvailable) {
                toastr.error('Quantity is greater than available stock');
            } else {
                updateCartItems(id, qty);
            }


        });
        // remove cart item
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            if (confirm("Are you sure you want to delete this item ?")) {
                var id = $(this).attr('data-id');
                show_loader();
                $.ajax({
                    url: '{{ url('cart-remove') }}',
                    method: "DELETE",
                    data: {id: id},
                    success: function (response) {
                        // if(response.status) {
                        //     $('#cartTotal').text(response.cartTotal);
                        //     $('#cartPrice').text("£" + response.cartPrice);
                        //     success_message("Item removed from cart successfully");
                        //     hide_loader();
                        //     getCartDetails();
                        // }
                        // else
                        // {
                        //     success_message("Item removed from cart successfully");
                        // }


                        if (response.status) {
                            $('#cartTotal').text(response.cartTotal);
                            $('#cartPrice').text("£" + response.cartPrice);
                            success_message("Item removed from cart successfully");
                            hide_loader();
                            getCartDetails();
                        } else {
                            $('#cartTotal').text(response.cartTotal);
                            $('#cartPrice').text("£" + response.cartPrice);
                            getCartDetails();
                            hide_loader();
                            toastr.error(response.message);
                        }
                    }
                });
            }
        });

    });

    function checkToUpdateCart(event) {
        var currentValue = $(event).val();
        var totalAvailableProducts = $(event).attr('data-quantity');
        var id = $(event).attr('data-product');
        if (currentValue > parseInt(totalAvailableProducts)) {
            var va = 0;
            $(event).val(va);
            toastr.error('Quantity is greater than available stock');

        } else {
            updateCartItems(id, currentValue);
        }

    }

    function updateCartShip(event) {
        var product_id = $(event).attr('data-product-id');
        var shipment_id = $(event).val();
        show_loader();
        $.ajax({
            url: '{{ url('update-shipment') }}',
            method: "post",
            data: {product_id: product_id, shipment_id: shipment_id},
            success: function (response) {
                if (response.status) {

                    success_message("Cart updated successfully");
                    hide_loader();
                    getCartDetails();
                } else {
                    hide_loader();
                    toastr.error("Sorry You Previous Request Already In Process");
                }
            }
        });
    }

    function updateCartItems(id, qty) {
        show_loader();
        $.ajax({
            url: '{{ url('cart-update') }}',
            method: "patch",
            data: {id: id, quantity: qty},
            success: function (response) {
                if (response.status) {
                    $('#cartTotal').text(response.cartTotal);
                    $('#cartPrice').text("£" + response.cartPrice);
                    success_message("Cart updated successfully");
                    hide_loader();
                    getCartDetails();
                    getCartHistory()
                } else {
                    hide_loader();
                    getCartDetails();
                    getCartHistory()
                    toastr.error("Sorry You Previous Request Already In Process");
                }
            }
        });
    }


</script>

