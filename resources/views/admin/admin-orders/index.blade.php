@extends('admin.layouts.app')

@section('style')
    <style>
        /*    td span.details-control {
                                        background: url(../images/details_open.png) no-repeat center center;
                                        cursor: pointer;
                                        width: 18px;
                                        padding: 12px;
                                    }
                                    tr.shown td span.details-control {
                                        background: url(../images/details_close.png) no-repeat center center;
                                    }*/
    </style>
@endsection

@section('content')
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                        <li class="active">Quotations</li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Performa Invoices
                            <span class="pull-right">
                                <div id="reportrange" class="pull-right report-range">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                    <span></span> <b class="caret"></b>
                                </div>
                            </span>

                            <span class="tools pull-right quote-btn" style="margin-right: 12px;margin-top: -6px;">
                                <a href="{{ url('admin/admin-orders/create') }}" class="btn btn-info btn-sm"
                                    data-toggle="tooltip" title="Create Quotation">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Create Performa Invoice
                                </a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div class="adm-table">
                                <table id="datatable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                           <!-- <th> Order Id </th>-->
                                            <th> Customer ID </th>
                                            <th> Quantity </th>
                                            <th> Amount </th>
                                            <th> Gross Total </th>
                                            <th> VAT </th>


                                            @if (auth()->user()->can('change order status'))
                                                {{-- <th> Status </th> --}}
                                            @endif
                                            <th> Created By </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd">
                                            <td valign="top" colspan="8" class="dataTables_empty">No data available in
                                                table</td>
                                        </tr>
                                    </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Date</th>
                                            <!--<th> Order Id </th>-->
                                            <th> Customer ID </th>
                                            <th> Quantity </th>
                                            <th> Amount </th>
                                            <th> Gross Total </th>
                                            <th> VAT </th>


                                            @if (auth()->user()->can('change order status'))
                                                {{-- <th> Status </th> --}}
                                            @endif
                                            <th> Created By </th>
                                            <th> Action </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>
@endsection

@section('scripts')
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js" ></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js" ></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js" ></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" ></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" ></script>
    <script>
        var table;
        var start = moment().subtract(1, 'weeks');
        console.log(start);
        var end = moment();
        var upload_url = '{{ asset('uploads') }}';
        var $reload_datatable = {};
        var url = window.location.href;

        function cb(start, end) {
            $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        }

        cb(start, end);


        $('#datatable').on('click', '.btn-generate-invoice', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure! You want to generate invoice',
                type: 'green',
                typeAnimated: true,
                closeIcon: true,
                buttons: {
                    confirm: function() {
                        window.location.href = url;
                        return false;
                    },
                    cancel: function() {},
                }
            });

            return false;
        });

        $("document").ready(function() {

            loadDatatable(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'))

            var reload_datatable = $("#datatable").dataTable({
                bRetrieve: true
            });


            /*child*/


            $reload_datatable = $("#datatable").dataTable({
                bRetrieve: true
            });
            /*change shipping status*/
            $(document.body).on('change', ".change_status", function(e) {

                var status = $(this).val();
                var id = $(this).attr("data-id");
                var cart_id = $(this).attr("data-cart-id");
                var url = "{{ url('admin/orders/change-status') }}" + '/' + id + '/' + cart_id;
                var data_object = {
                    status: status,
                    id: id
                };
                // change_status(url, data_object, $reload_datatable);
                $.ajax({
                    url: url,
                    type: "put",
                    data: data_object,
                    success: function(res) {
                        if (res == 'true') {
                            $reload_datatable.fnDraw();
                            success_message("Delivery status updated successfully");
                        }
                    },
                    error: function(request, status, error) {
                        error_message(request.responseText);
                    }
                }); //..... end of ajax() .....//
            });
            $("body").on("click", '.bt-download', function() {
                var url = $(this).attr('image-url');
                printImg(url);
            });

            $("body").on('change', '.status_update', function() {
                var status = $(this).val();
                var cart_id = $(this).attr("data-id");
                var transaction_id = $(this).attr('data-transaction-id');
                var url = "{{ url('admin/orders/update-order-status') }}" + '/' + cart_id;
                var data_object = {
                    status: status,
                    transaction_id: transaction_id
                };
                // change_status(url, data_object, $reload_datatable);
                $.ajax({
                    url: url,
                    type: "put",
                    data: data_object,
                    success: function(res) {
                        if (res == 'true') {
                            $reload_datatable.fnDraw();
                            success_message("Delivery status updated successfully");
                        }
                    },
                    error: function(request, status, error) {
                        error_message(request.responseText);
                    }
                }); //..... end of ajax() .....//
            })
        });

        function printImg(url) {

            var win = window.open('');
            win.document.write('<img src="' + url + '" onload="window.print();window.close()" />');
            win.focus();
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')]
            }
        }, cb);

        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
            $('#reportrange').val('');
            $reload_datatable.fnDraw();
        });

        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            startdate = picker.startDate.format('YYYY-MM-DD');
            enddate = picker.endDate.format('YYYY-MM-DD');


            $('#datatable').DataTable().destroy();
            loadDatatable(startdate, enddate)

        });

        function loadDatatable(start_date = '', end_date = '') {
            table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                responsive: true,
                pageLength: -1,
                  dom: 'lBfrtip',
            buttons: [{
                text: '<span data-toggle="tooltip" title="Export CSV"><i class="fa fa-lg fa-file-text-o"></i> CSV</span>',
                extend: 'csv',
                className: 'btn btn-sm btn-round btn-success',
                title: 'Sale Report',
                extension: '.csv'
            }],
                ajax: {
                    url: url,
                    data: {
                        from_date: start_date,
                        to_date: end_date
                    }
                },
                columns: [{
                        data: 'date',
                        searchable: false
                    },/*{
                        data: 'orderId',
                        searchable: false
                    },*/
                    {
                        data: 'user.customer_id',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'qty',
                        searchable: false
                    },
                    {
                        data: 'amount',
                        searchable: false
                    },
                    {
                        data: 'cost',
                        searchable: false
                    },
                    {
                        data: 'tax',
                        searchable: false
                    },
                    {
                        data: 'admin.name',
                    },
                    @if (auth()->user()->can('change order status'))
                        // {data: 'status', width: "10%", orderable: false, searchable: false},
                    @endif {
                        data: 'action',
                        width: "10%",
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    var total = 0;
                    $.each(data, function(key, value) {
                        console.log(value);
                      total = total + parseFloat(value.cost);
                    });

                    $(api.column(4).footer()).html('<b>Total: ' + total.toFixed(2) + '</b>');
                }
            });
        }

        /*child*/
    </script>
@endsection
