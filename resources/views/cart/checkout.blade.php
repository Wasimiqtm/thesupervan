@extends('layouts.app')

@section('content')
    <!-- CONTENT + SIDEBAR -->
    <div class="main-wrapper clearfix">
        <div class="site-pagetitle jumbotron">
            <div class="container text-center">
                <h3>Goshop Products</h3>

                <!-- Breadcrumbs -->
                <div class="breadcrumbs">
                    <div class="breadcrumbs text-center">
                        <i class="fa fa-home"></i>
                        <span><a href="index.html">Home</a></span>
                        <i class="fa fa-arrow-circle-right"></i>
                        <span class="current">Checkout</span>
                    </div>
                </div>
            </div>
        </div>
        @php
            $subData = ["company_name" => "","address" => "","address_2" => "","town_city" => "","state_country" => "","post_code" => "","phone" => ""];
            if(isset($userData) and isset($userData['type']) and $userData['type'] !=='main_address'){
                $subData =$userData;
            }

        @endphp

        <div class="container theme-container">
            <main id="main-content" class="main-container" itemprop="mainContentOfPage" itemscope="itemscope"
                  itemtype="http://schema.org/Blog">
                <article itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

                    <!-- Main Content of the Post -->
                    <div class="entry-content" itemprop="articleBody">
                        <div class="woocommerce checkout">

                            <div class="col2-set clearfix" id="customer_details">
                                <div class="col-1 col-lg-6 col-sm-6 border">
                                    <h4 class="cart-title-highlight title-3">Billing Details</h4>
                                    <form name="checkout" id="myForm"
                                    >
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group"><input class="form-control" type="text"
                                                                               id="first-name" name="first_name"
                                                                               placeholder="First Name"
                                                                               value="{{ (Auth::user()->type != 'dropshipper') ? Auth::user()->first_name : '' }}"
                                                                               required></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group"><input class="form-control" type="text"
                                                                               id="last-name" name="last_name"
                                                                               placeholder="Last Name"
                                                                               value="{{ (Auth::user()->type != 'dropshipper') ? Auth::user()->last_name : '' }}"
                                                                               required></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group"><input class="form-control" type="text"
                                                                               id="company-name" name="company_name"
                                                                               placeholder="Company Name"
                                                                               value="{{$userData['company_name']??''}}" {{ (Auth::user()->type == 'wholesaler')?'required':'' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input class="form-control" type="text"
                                                           id="email-address" name="email_address"
                                                           placeholder="Email" value="{{Auth::user()->email}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group"><input type="text" id="address" name="address"
                                                                               placeholder="Street address"
                                                                               class="form-control"
                                                                               value="{{$userData['address']??''}}"
                                                                               required>
                                                    <input type="text" id="address-2" name="address_2"
                                                           placeholder="Apartment, suite, unit etc. (optional)"
                                                           class="form-control"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text"
                                                           id="town-city"
                                                           name="town_city"
                                                           class="form-control"
                                                           placeholder="Town / City *"
                                                           value="{{$userData['town_city']??''}}"
                                                           required>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" id="state-country" placeholder="State / County*"
                                                           name="state_country" class="form-control"
                                                           value="{{$userData['state_country']??''}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" id="post-code"
                                                           name="post_code" type="text"
                                                           placeholder="Post Code*"
                                                           value="{{$userData['post_code']??''}}"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" id="phone" name="phone"
                                                           placeholder="Phone Number" value="{{Auth::user()->phone}}"
                                                           required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="wc-proceed-to-checkout text-center">
                                            <button class="checkout-button button alt wc-forward" type="submit">
                                                <i class="fa fa-check-circle"></i>Proceed to Checkout
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-2 col-lg-6 col-sm-6 border">
                                    <div class="woocommerce-shipping-fields">
                                        <h4 class="cart-title-highlight title-3">Ship to a different address?</h4>
                                        <form action="" id="myForm1">
                                            <input type="hidden" name="address_type" value="different">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"><input class="form-control" type="text"
                                                                                   id="first-name" name="first_name"
                                                                                   placeholder="First Name"
                                                                                   value="{{ (Auth::user()->type != 'dropshipper') ? Auth::user()->first_name : '' }}"
                                                                                   required></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"><input class="form-control" type="text"
                                                                                   id="last-name" name="last_name"
                                                                                   placeholder="Last Name"
                                                                                   value="{{ (Auth::user()->type != 'dropshipper') ? Auth::user()->last_name : '' }}"
                                                                                   required></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group"><input class="form-control" type="text"
                                                                                   id="company-name" name="company_name"
                                                                                   placeholder="Company Name"
                                                                                   value="{{$subData['company_name']??''}}" {{ (Auth::user()->type == 'wholesaler')?'required':'' }}>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text"
                                                               id="email-address" name="email_address"
                                                               placeholder="Email" value="{{Auth::user()->email}}"
                                                               readonly></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group"><input type="text" id="address"
                                                                                   name="address"
                                                                                   placeholder="Street address"
                                                                                   class="form-control"
                                                                                   value="{{$subData['address']??''}}"
                                                                                   required>
                                                        <input type="text" id="address-2" name="address_2"
                                                               placeholder="Apartment, suite, unit etc. (optional)"
                                                               class="form-control"></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text"
                                                               id="town-city"
                                                               name="town_city"
                                                               class="form-control"
                                                               placeholder="Town / City *"
                                                               value="{{$subData['town_city']??''}}"
                                                               required>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" id="state-country"
                                                               placeholder="State / County*"
                                                               name="state_country" class="form-control"
                                                               value="{{$subData['state_country']??''}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input class="form-control" id="post-code"
                                                               name="post_code" type="text"
                                                               placeholder="Post Code*"
                                                               value="{{$subData['post_code']??''}}"
                                                               required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" id="phone" name="phone"
                                                               placeholder="Phone Number"
                                                               value="{{Auth::user()->phone}}" required>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="wc-proceed-to-checkout text-center">
                                                <button class="checkout-button button alt wc-forward" type="submit">
                                                    <i class="fa fa-check-circle"></i>Proceed to Checkout
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div id="order_review" class="woocommerce-checkout-review-order ">
                                <div class="col-lg-6 col-sm-6 border">
                                    <div class="chck-ttl">
                                        <h4 id="order_review_heading" class="cart-title-highlight title-3">Your
                                            order</h4>
                                        <table class="shop_table woocommerce-checkout-review-order-table">
                                            <thead>
                                            <tr>
                                                <th class="product-name">Product</th>
                                                <th class="product-total">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($cartContents as $key =>$product)
                                                <tr class="cart_item">
                                                    <td class="product-name">{{@$product->name}} <strong
                                                            class="product-quantity">&times; {{$product->quantity}}</strong>
                                                    </td>

                                                    {{-- @if(Auth::user()->type == 'wholesaler') --}}
                                                        <td class="product-total"><b
                                                                class="amount fa fa-gbp">{{$product->price.' * '.$product->quantity.' = '.$product->price * $product->quantity}}</b></td>
                                                    {{-- @else
                                                        <td class="product-total"><b
                                                                class="amount fa fa-gbp">{{ number_format(getProductDetails($product->id)->price,2).' * '.$product->quantity.' = '. number_format(getProductDetails($product->id)->price * $product->quantity,2)}}</b></td>
                                                    @endif --}}


                                                </tr>
                                            @empty
                                                <td colspan="2">Cart is empty</td>

                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Sub Total:</th>
                                                <td><span
                                                        class="drk-gry fa fa-gbp"> {{ number_format($originalPrice, 2) }}</span>
                                                </td>
                                            </tr>
                                            @if(Auth::user()->type == 'dropshipper')
                                                <tr>
                                                    <td>Subtotal Vat</td>
                                                    @php $vatAmount = number_format(($originalPrice*$vatCharges)/100,2);@endphp
                                                    <td class="subtotal">£{{number_format(($originalPrice*$vatCharges)/100,2)}}</td>
                                                    @php $subTotal=number_format($subTotal+(($subTotal)*$vatCharges)/100,2) @endphp
                                                </tr>
                                            @endif

                                            <tr>
                                                @if(Auth::user()->type == 'dropshipper')
                                                    <td>Shipping</td>
                                                    <td >£{{number_format(@$total_shipment_charges,2)}}</td>
                                                @else
                                                    <td>Shipping </td>
                                                    <td class="subtotal">£{{number_format(($subTotal - $cartSum) ,2)}}</td>
                                                @endif
                                            </tr>

                                            @if(Auth::user()->type == 'dropshipper')
                                                <tr>
                                                    <td>Shipping Vat</td>
                                                    <td class="subtotal">£{{number_format(($total_shipment_charges*$vatCharges)/100,2)}}</td>
                                                    @php $total_shipment_charges=number_format($total_shipment_charges+(($total_shipment_charges)*$vatCharges)/100,2) @endphp
                                                </tr>
                                            @endif

                                            @if(Auth::user()->type != 'dropshipper')
                                                <tr>

                                                    <td>Discount</td>
                                                    @php $discountAmount = number_format(($originalPrice - $cartSum),2);@endphp
                                                    <td>£{{$discountAmount}}</td>
                                                </tr>
                                            @endif

                                            @if( Auth::user()->type == 'wholesaler')
                                                <tr>

                                                    <td>Vat</td>

                                                    @php $vatAmount = number_format(($subTotal*$vatCharges)/100,2);@endphp
                                                    <td>£{{number_format(($subTotal*$vatCharges)/100,2)}}</td>

                                                    @php $subTotal=number_format($subTotal+($subTotal*$vatCharges)/100,2) @endphp

                                                </tr>
                                            @endif


                                            <tr class="order-total">
                                                <th>Order Total</th>
                                                <td><b class="amount fa fa-gbp">{{$subTotal  }}</b></td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <div id="payment" class="col-lg-6 col-sm-6 border woocommerce-checkout-payment">
                                    <h4 class="cart-title-highlight title-3">Your Payment</h4>
                                    <?php $totalAmountWallet = getWholsellerDataWallet(Auth::user()->id);
                                    $subtotals = $subTotal;
                                    ;?>
                                    <div class="woocommerce-checkout-payment-inner">
                                        <ul class="payment_methods methods list-unstyled">
                                            <li class="payment_method_bacs">
                                                <div id="paypal-button-container"></div>
                                            </li>
                                            @if( Auth::user()->type == 'wholesaler' || Auth::user()->type == 'dropshipper' )
                                                <li class="payment_method_cod">
                                                    <button type="button" style=" 	margin-top: 40px;
   background: darkslateblue;
    position: relative;
    display: inline-block;
    width: 100%;
    min-height: 25px;
    min-width: 150px;" class="disabled disableSection paywithwallet"
                                                            onclick="payWithWallet({{numberFormatToFloat($subtotals)}},{{$totalAmountWallet}})">
                                                        Pay From wallet({{number_format($totalAmountWallet,2,'.','')}})
                                                    </button>
                                                </li>
                                            @endif

                                        </ul>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                            </div>

                        </div>
                    </div>
                </article>
            </main>
        </div>

        <div class=" light-bg gst-row">
            <div class="fancy-heading text-center">
                <h3> RELATED PRODUCTS </h3>
                <h5 class="funky-font-2"> Customers who viewed this item also viewed </h5>
            </div>

            <!-- Portfolio items -->
            <div class="related-product nav-2 text-center">
                <div class="product">
                    <div class="rel-prod-media">
                        <img src="assets/img/products/rel-prod-1.png" alt=""/>
                    </div>
                    <div class="product-content">
                        <h3><a href="#" class="title-3 fsz-16"> CICLYSMO JACKET </a></h3>
                        <p class="font-3">Price: <span class="thm-clr"> $299.00 </span></p>
                    </div>
                </div>

                <div class="product">
                    <div class="rel-prod-media">
                        <img src="assets/img/products/rel-prod-2.png" alt=""/>
                    </div>
                    <div class="product-content">
                        <h3><a href="#" class="title-3 fsz-16"> LYCRA BITZ MEN CLOTHING </a></h3>
                        <p class="font-3">Price: <span class="thm-clr"> $299.00 </span></p>
                    </div>
                </div>

                <div class="product">
                    <div class="rel-prod-media">
                        <img src="assets/img/products/rel-prod-3.png" alt=""/>
                    </div>
                    <div class="product-content">
                        <h3><a href="#" class="title-3 fsz-16"> CICLYSMO JACKET </a></h3>
                        <p class="font-3">Price: <span class="thm-clr"> $299.00 </span></p>
                    </div>
                </div>

                <div class="product">
                    <div class="rel-prod-media">
                        <img src="assets/img/products/rel-prod-4.png" alt=""/>
                    </div>
                    <div class="product-content">
                        <h3><a href="#" class="title-3 fsz-16"> LYCRA BITZ MEN CLOTHING </a></h3>
                        <p class="font-3">Price: <span class="thm-clr"> $299.00 </span></p>
                    </div>
                </div>

                <div class="product">
                    <div class="rel-prod-media">
                        <img src="assets/img/products/rel-prod-5.png" alt=""/>
                    </div>
                    <div class="product-content">
                        <h3><a href="#" class="title-3 fsz-16"> CICLYSMO JACKET </a></h3>
                        <p class="font-3">Price: <span class="thm-clr"> $299.00 </span></p>
                    </div>
                </div>

                <div class="product">
                    <div class="rel-prod-media">
                        <img src="assets/img/products/rel-prod-6.png" alt=""/>
                    </div>
                    <div class="product-content">
                        <h3><a href="#" class="title-3 fsz-16"> LYCRA BITZ MEN CLOTHING </a></h3>
                        <p class="font-3">Price: <span class="thm-clr"> $299.00 </span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="clear"></div>
    </div>

    <!-- Subscribe News -->
    <section class="gst-row gst-color-white row-newsletter ovh">
        <div class="gst-wrapper">
            <div class="gst-column col-lg-12 no-padding text-center">
                <div class="fancy-heading text-center">
                    <h3 class="wht-clr">Subscribe Newsletter</h3>
                    <h5 class="funky-font-2 wht-clr">Sign up for <span class="thm-clr">Special Promotion</span></h5>
                </div>

                <p><strong>Lorem ipsum dolor sit amet</strong>, consectetuer adipiscing elit, sed diam nonummy nibh
                    euismod tincidunt ut<br/> laoreet dolore magna aliquam erat volutpat.</p>

                <div class="gst-empty-space clearfix"></div>

                <form>
                    <div class="col-md-2"><h4><strong class="fsz-20"> <span class="thm-clr">Subscribe</span> to us
                            </strong></h4></div>
                    <div class="gst-empty-space visible-sm clearfix"></div>
                    <div class="col-md-4 col-sm-4">
                        <input type="text" class="dblock" placeholder="Enter your name"/>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <input type="text" class="dblock" placeholder="Enter your email address"/>
                    </div>

                    <div class="col-md-2 col-sm-4">
                        <input type="submit" class="dblock fancy-button" value="Submit"/>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection
@section('scripts')
    <script
        src="https://www.paypal.com/sdk/js?client-id=AbFSkkSixS51Qe_69o4v1RVOvTeTAcFYW-d8SspuBFQWswkBsof5UsvNF6RGAFMLIoZn7Z4PEnYYhJei&currency=GBP"></script>
    <script type="text/javascript">
        var discountAmount = "{{ (isset($discountAmount))?@$discountAmount:0 }}";
        var vatAmount = "{{ (isset($vatAmount))?@$vatAmount:0 }}";
        $(document).ready(function () {
            // disable payment
            $("#paypal-button-container").addClass("disableSection");

            // save user data
            $('#myForm').validator().on('submit', function (e) {
                if (e.isDefaultPrevented()) {
                    // handle the invalid form...

                } else {

                    e.preventDefault();
                    // everything looks good!
                    var formData = $('#myForm').serialize() + '&type=main_address';

                    show_loader();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ url('save-user-info') }}',
                        method: "post",
                        data: {formData: formData},
                        success: function (response) {
                            if (response) {
                                if (response.status) {
                                    // enable payment
                                    $("#paypal-button-container").removeClass("disableSection");
                                    $(".paywithwallet").removeClass("disableSection");
                                    $("#myForm").addClass("disableSection");
                                    toastr.success(response.message);
                                    hide_loader();
                                }
                            }
                        }
                    });
                }
            })
            $('#myForm1').validator().on('submit', function (e) {
                if (e.isDefaultPrevented()) {
                    // handle the invalid form...

                } else {

                    e.preventDefault();
                    // everything looks good!
                    var formData = $('#myForm1').serialize() + '&type=other_address';

                    show_loader();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ url('save-user-info') }}',
                        method: "post",
                        data: {formData: formData},
                        success: function (response) {
                            if (response) {
                                if (response.status) {
                                    // enable payment
                                    $("#paypal-button-container").removeClass("disableSection");
                                    $(".paywithwallet").removeClass("disableSection");
                                    $("#myForm1").addClass("disableSection");
                                    toastr.success(response.message);
                                    hide_loader();
                                }
                            }
                        }
                    });
                }
            })

            // paypal starts
            if ("{{Auth::id()}}") {
                PayPalPayment();

            }
            // paypal starts

            // get cart
            getCartDetails();
        });

        function getCartDetails() {
            $.ajax({
                url: '{{ url('cart-details') }}',
                method: "post",
                dataType: "html",
                success: function (response) {
                    if (response) {
                        $('#cart_details').html(response);
                    }
                }
            });
        }

        function PayPalPayment() {
            // var amount = "{{Auth::id()?(Cart::session(Auth::id())->getSubTotal())??0:0}}";
            var amount = "{{$subTotal}}";
            paypal.Buttons({
                style: {
                    color: 'blue',
                    shape: 'pill',
                    label: 'pay',
                    height: 40
                },
                createOrder: function (data, actions) {

                    // Set up the transaction
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: amount,
                                currency: 'GBP'
                            }
                        }]
                    });
                },
                onApprove: function (data, actions) {
                    return actions.order.capture().then(function (details) {

                        var trans_id = details.id;
                        var payer = details.payer.email_address;
                        var payer_name = details.purchase_units[0].shipping.name;
                        var payee = details.purchase_units[0].payee.email_address;
                        var merchant_id = details.purchase_units[0].payee.merchant_id;
                        var amount = details.purchase_units[0].amount.value;
                        var currency = details.purchase_units[0].amount.currency_code;
                        var shipping_address = details.purchase_units[0].shipping.address.admin_area_1;

                        var allData = {
                            trans_id: trans_id,
                            payer: payer,
                            payer_name: payer_name,
                            payee: payee,
                            merchant_id: merchant_id,
                            amount: amount,
                            currency: currency,
                            shipping_address: shipping_address,
                            discount: discountAmount,
                            vat_amount: vatAmount
                        };


                        // alert('Transaction completed by ' + details.payer.name.given_name);
                        // Call your server to save the transaction
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '{{url('/paypal-transaction-complete')}}',
                            method: "post",
                            data: allData,
                            success: function (response) {
                                console.log(response);
                                if (response.status) {
                                    window.location.href = "{{url('my-orders')}}";
                                }
                            },
                            error: function (request, status, error) {
                                alert(request.responseText);
                            }
                        });
                    });
                },
                onCancel: function (data, actions) {
                    toastr.error("You have cancelled the payment");
                    return false;
                }
            }).render('#paypal-button-container');
        }

        function payWithWallet(subtotal, available) {
            if (available > subtotal) {
                $.ajax({
                    url: '{{url('/paywith-wallet')}}',
                    method: "post",
                    data: {amount: subtotal, discount: discountAmount, vat_amount: vatAmount},
                    success: function (response) {
                        if (response.status) {
                            window.location.href = "{{url('my-orders')}}";
                        }
                    },
                    error: function (request, status, error) {
                        alert(request.responseText);
                    }
                });
            } else {
                toastr.error("Your wallet amount is less than cart amount please pay with alternate payment method");
                return false;
            }
        }
    </script>
@endsection
