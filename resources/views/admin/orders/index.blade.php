@extends('admin.layouts.app')

@section('style')
<style>
    td span.details-control {
        background: url(../images/details_open.png) no-repeat center center;
        cursor: pointer;
        width: 18px;
        padding: 12px;
    }
    tr.shown td span.details-control {
        background: url(../images/details_close.png) no-repeat center center;
    }
</style>
@endsection

@section('content')
<section id="main-content" >
    <section class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li class="active">Orders</li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Orders
                         <span class="pull-right">
                            <div id="reportrange" class="pull-right report-range">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                <span></span> <b class="caret"></b>
                            </div>
                        </span>
                    </header>
                    <div class="panel-body">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th> Order Id </th>
                                    <th> Email </th>
                                    <th> Amount </th>
                                    <th> Label Image </th>
                             
                                    @if(auth()->user()->can('change order status'))
                                    <th> Status </th>
                                    @endif
                                    @if(auth()->user()->can('change order status'))
                                        <th> Courier </th>
                                    @endif
                                    @if(auth()->user()->can('view order invoice'))
                                    <th> Action </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No data available in table</td></tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th> Order Id </th>
                                    <th> Email </th>
                                    <th> Amount </th>
                                    <th> Label Image </th>
                          
                                    @if(auth()->user()->can('change order status'))
                                    <th> Status </th>
                                    @endif
                                    @if(auth()->user()->can('change order status'))
                                        <th> Courier </th>
                                    @endif
                                    @if(auth()->user()->can('view order invoice'))
                                    <th> Action </th>
                                    @endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="transaction_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Transaction Details</h4>
            </div>
            <div class="modal-body">

                <form role="form" class="form-horizontal" data-toggle="validator" data-disable = 'false' id="ss">
                    <div class="row">

                        <div id="variant_fields"></div>

                        <h5 class="col-lg-12"><b>Payer Infor:</b></h5>
                        <div class="form-group">
                            <div class="col-lg-offset-1 col-lg-5">
                                <b>Payer Name:</b>
                            </div>
                            <div class="col-lg-offset-1 col-lg-5">
                                <span class="payer_name"></span>
                            </div>
                            <div class="col-lg-offset-1 col-lg-5">
                                <b>Payer Email:</b>
                            </div>
                            <div class="col-lg-offset-1 col-lg-5">
                                <span class="payer_email"></span>
                            </div>
                            <div class="col-lg-offset-1 col-lg-5">
                                <b>Shipping Address:</b>
                            </div>
                            <div class="col-lg-offset-1 col-lg-5">
                                <span class="shipping_address"></span>
                            </div>
                        </div>
                        <h5 class="col-lg-12"><b>Payment Info:</b></h5>
                        <div class="form-group">
                            <div class="col-lg-offset-1 col-lg-5">
                                <b>Transaction No:</b>
                            </div>
                            <div class="col-lg-offset-1 col-lg-5">
                                <span class="trans_number"></span>
                            </div>
                            <div class="col-lg-offset-1 col-lg-5">
                                <b>Total Deposit:</b>
                            </div>
                            <div class="col-lg-offset-1 col-lg-5">
                                <span class="amount"></span>
                            </div>
                            <div class="col-lg-offset-1 col-lg-5">
                                <b>Payment via:</b>
                            </div>
                            <div class="col-lg-offset-1 col-lg-5">
                                <span class="pay_via"></span>
                            </div>
                            <div class="col-lg-offset-1 col-lg-5">
                                <b>Status:</b>
                            </div>
                            <div class="col-lg-offset-1 col-lg-5">
                                <span class="payment_status"></span>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    var start = moment().subtract(6, 'days');
    var end = moment();
    var upload_url = '{{ asset("uploads") }}';
    var  $reload_datatable={};
     var url = window.location.href;
    function cb(start, end) {
      $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }
    
       cb(start, end);
    $("document").ready(function () {

loadDatatable(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'))
       

              $('#datatable tbody').on('click', 'td span.details-control', function ()
        {
            var tr = $(this).closest('tr');console.log(tr);
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
        } );
        var reload_datatable = $("#datatable").dataTable( { bRetrieve : true } );

        $(document).on('click', '.refresh_products', function (e) {
            reload_datatable.fnDraw();
        });

        /*child*/


         $reload_datatable = $("#datatable").dataTable( { bRetrieve : true } );
        /*change shipping status*/
        $(document.body).on('change',".change_status",function (e) {

            var status= $(this).val();
            var id = $(this).attr("data-id");
            var cart_id = $(this).attr("data-cart-id");
            var url= "{{url('admin/orders/change-status')}}"+'/'+id+'/'+cart_id;
            var data_object = {status:status, id:id};
            // change_status(url, data_object, $reload_datatable);
            $.ajax({
                url:url,
                type:"put",
                data:data_object,
                success:function (res) {
                    if (res == 'true') {
                        $reload_datatable.fnDraw();
                        success_message("Delivery status updated successfully");
                    }
                },
                error: function (request, status, error) {
                    error_message(request.responseText);
                }
            });//..... end of ajax() .....//
        });
        $("body").on("click",'.bt-download',function () {
            var url = $(this).attr('image-url');
            printImg(url);
        });

        $("body").on('change','.courier_send' ,function () {
            var status= $(this).val();
            var id = $(this).attr("data-id");
            var cart_id = $(this).attr("data-cart-id");
            var url= "{{url('admin/orders/change-courier')}}"+'/'+id+'/'+cart_id;
            var data_object = {status:status, id:id};
            // change_status(url, data_object, $reload_datatable);
            $.ajax({
                url:url,
                type:"put",
                data:data_object,
                success:function (res) {
                    if (res == 'true') {
                        $reload_datatable.fnDraw();
                        success_message("Delivery status updated successfully");
                    }
                },
                error: function (request, status, error) {
                    error_message(request.responseText);
                }
            });//..... end of ajax() .....//
        })
        
             $("body").on('change','.status_update' ,function () {
            var status= $(this).val();
            var cart_id = $(this).attr("data-id");
            var transaction_id = $(this).attr('data-transaction-id');
            var url= "{{url('admin/orders/update-order-status')}}"+'/'+cart_id;
            var data_object = {status:status,transaction_id:transaction_id};
            // change_status(url, data_object, $reload_datatable);
            $.ajax({
                url:url,
                type:"put",
                data:data_object,
                success:function (res) {
                    if (res == 'true') {
                        $reload_datatable.fnDraw();
                        success_message("Delivery status updated successfully");
                    }
                },
                error: function (request, status, error) {
                    error_message(request.responseText);
                }
            });//..... end of ajax() .....//
        })
    });
    function printImg(url) {

        var win = window.open('');
        win.document.write('<img src="' + url + '" onload="window.print();window.close()" />');
        win.focus();
    }
    function format ( rowData ) {
        var div = $('<div/>').addClass( 'loading' ).text( 'Loading...' );
        var products = rowData.purchased_items;

        var product_html = '<table class="table table-bordered table-striped">\
                            <thead><tr>\
                                <th>Image</th>\
                                <th>Name</th>\
                                <th>Code</th>\
                                <th>Amount/Item</th>\
                                <th>Discount Type</th>\
                                <th>Discount</th>\
                                <th>Discounted Price</th>\
                                <th>Quantity</th>\
                            </tr></thead><tbody>';

        if(products.length>0){
            console.log(products);

            $.each(products,function(index, item){

                var image = '<img width="30" src="'+ upload_url +'/no-image.png" />';
                if(item.product.product_images.length>0){
                    image = '<img width="30" src="' + upload_url +'/products/thumbs/'+ item.product.product_images[0].name +'" />'
                }
                var discount_type = 'No';
                if(item.product.discount_type == 1){
                    discount_type = 'Percentage';
                }else{
                    discount_type = 'Fixed';
                }

                product_html += '<tr>\
                                    <td align="left" width="10%">'+ image +'</td>\
                                    <td align="left" width="20%">'+ item.product.name +'</td>\
                                    <td align="left" width="10%">'+ item.product.code +'</td>\
                                    <td align="left" width="10%">'+ item.product.price +'</td>\
                                    <td align="left" width="15%">'+ discount_type +'</td>\
                                    <td align="left" width="10%">'+ item.product.discount +'</td>\
                                    <td align="left" width="15%">£'+ item.product.discountedPrice +'</td>\
                                    <td align="left" width="10%">'+ item.quantity +'</td>\
                                </tr>';

            });
        }else{

            product_html += '<tr><td colspan="7">Record not found</td></tr> ';
        }

        product_html += '</tbody></table>';

        div.html( product_html ).removeClass( 'loading' );

        return div;
    }

    function load_model(id){

        /*$.ajax({
            url: '{{ url('get-transaction-details') }}',
            method: "post",
            data: {_token: '{{ csrf_token() }}', id: id},
            success: function (response) {
                console.log(response.data);
                if(response.status){
                    $('.payer_name').text(response.data.payer_name.full_name);
                    $('.payer_email').text(response.data.payer);
                    $('.shipping_address').text(response.data.shipping_address);
                    $('.trans_number').text(response.data.trans_id);
                    $('.amount').text(response.data.amount + ' ' + response.data.currency);
                    $('.pay_via').text('PayPal');
                    $('.status').text('Approved');
                    hide_loader();
                }
            }
        });*/

        // $('#transaction_model').modal('show');return false;

        var url = "{{url('get-transaction-details')}}";
        $.ajax({
            url:url,
            type:"post",
            data: {id: id},
            success: function (response) {
                console.log(response.data);
                if(response.status){
                    $('.payer_name').text(response.data.payer_name.full_name);
                    $('.payer_email').text(response.data.payer);
                    $('.shipping_address').text(response.data.shipping_address);
                    $('.trans_number').text(response.data.trans_id);
                    $('.amount').text(response.data.amount + ' ' + response.data.currency);
                    $('.pay_via').text('PayPal');
                    $('.payment_status').text('Approved');
                    $('#transaction_model').modal('show');
                }
            }
        });//..... end of ajax() .....//
    }
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    },cb);
    
     $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
    $('#reportrange').val('');
    $reload_datatable.fnDraw();
    });

  $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
   startdate = picker.startDate.format('YYYY-MM-DD');
   enddate = picker.endDate.format('YYYY-MM-DD');
 
   
    $('#datatable').DataTable().destroy();
   loadDatatable(startdate,enddate)
 
    });
    function loadDatatable(start_date='',end_date=''){
                 var table = $('#datatable').DataTable({
          processing: true,
          serverSide: true,
          ordering: true,
          responsive: true,
          pageLength: -1,
          ajax: {
              url:url,
                data:{from_date:start_date,to_date:end_date}
          },
          
          columns: [
                {data: 'orders_details', width: "2%", orderable:false, searchable: false},
                {data: 'orderId', width: "10%"},
                {data: 'email', width: "20%"},
                {data: 'amount', width: "10%"},
                {data: 'barcode_image', width: "10%"},
             
                @if(auth()->user()->can('change order status'))
                {data: 'status', width: "10%", orderable: false, searchable: false},
                @endif
                  @if(auth()->user()->can('change order status'))
              {data: 'courier_service', width: "10%", orderable: false, searchable: false},
                  @endif
                @if(auth()->user()->can('view order invoice'))
                {data: 'action', width: "5%", orderable: false, searchable: false}
                @endif
            ],
          order: []
        });
            }

        /*child*/

      

</script>
@endsection
