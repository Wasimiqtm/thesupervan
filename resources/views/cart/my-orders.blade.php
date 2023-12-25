@extends('layouts.app')

@section('content')
<!-- CONTENT + SIDEBAR -->
<div class="main-wrapper clearfix">
    <div class="site-pagetitle jumbotron">
        <div class="container  theme-container text-center">
            <h3>Goshop My Account</h3>

            <!-- Breadcrumbs -->
            <div class="breadcrumbs">
                <div class="breadcrumbs text-center">
                    <i class="fa fa-home"></i>
                    <span><a href="index.html">Home</a></span>
                    <i class="fa fa-arrow-circle-right"></i>
                    <span class="current"> Subscribe/Unsubscribe </span>
                </div>
            </div>
        </div>
    </div>

    <div class="theme-container container">
        <div class="spc-60 row">
            <main class="col-sm-12">
                <article class="woocommerce-cart">
                    <div class="account-details-wrap">
                        <div class="heading-2">
                            <h3 class="title-3 fsz-18">Your Order History</h3>
                        </div>

                        <div id="partial_records"></div>
                    </div>

                </article>
            </main>
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

            <p><strong>Lorem ipsum dolor sit amet</strong>, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut<br /> laoreet dolore magna aliquam erat volutpat.</p>

            <div class="gst-empty-space clearfix"></div>

            <form>
                <div class="col-md-2"> <h4> <strong class="fsz-20"> <span class="thm-clr">Subscribe</span> to us </strong> </h4> </div>
                <div class="gst-empty-space visible-sm clearfix"></div>
                <div class="col-md-4 col-sm-4">
                    <input type="text" class="dblock" placeholder="Enter your name" />
                </div>

                <div class="col-md-4 col-sm-4">
                    <input type="text" class="dblock" placeholder="Enter your email address" />
                </div>

                <div class="col-md-2 col-sm-4">
                    <input type="submit" class="dblock fancy-button" value="Submit" />
                </div>
            </form>
        </div>
    </div>
</section>

<div class="modal fade bs-example-modal-lg">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2>Transaction Details</h2>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="model_row_head"><h3>Payer Info:</h3> </div>

                    <table class="table table-responsive-md">
                        <thead>
                        <tr>
                            <th class="product-thumbnail"> Payer Name </th>
                            <th class="product-name">Payer Email</th>
                            <th class="product-price">Shippping Address</th>
                            <th class="product-quantity">Payment Via</th>
                            <th class="product-ordid">Status </th>
                            <th class="product-dil">Amount</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><span id="payer_name"></span></td>
                            <td><span id="payer_email"></span></td>
                            <td><span id="shipping_address"></span></td>
                            <td><span id="pay_via"></span></td>
                            <td><span id="payment_status"></span></td>
                            <td><span id="amount"></span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection

@section('scripts')
  <script type="text/javascript">

        $(document).ready(function() {

            var url = "{{ url('get-my-orders') }}";
            getMyOrders(url, 500);
        });

        function transactionDetails(id){


            show_loader();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ url('get-transaction-details') }}',
                method: "post",
                data: {id: id},
                success: function (response) {
                    console.log(response.data);
                    if(response.status){
                        $('#payer_name').text(response.data.payer_name);
                        $('#payer_email').text(response.data.payee);
                        $('#shipping_address').text(response.data.shipping_address);
                        $('.trans_number').text(response.data.trans_id);
                        $('#amount').text(response.data.amount + ' ' + response.data.currency);
                        $('#pay_via').text(response.data.payer);
                        $('#payment_status').text('Verified');
                        hide_loader();
                    }
                }
            });
            $(".modal").modal('show');
        }

    </script>
@endsection
