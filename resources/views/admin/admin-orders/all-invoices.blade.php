@extends('admin.layouts.app')

@section('style')
    <style>
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
                        <li class="active">Invoices</li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <h5>Customer <span class="text-danger"></span></h5>
                                    <div class="controls">
                                        <select name="user_id" id="customer_user_id" class="form-control select2 "
                                            value="">
                                            <option value="0">Select Customer</option>
                                            @foreach ($customers as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <h5>Select Date Range<span class="text-danger"></span></h5>
                                    <div class="controls">
                                        <div id="reportrange" class="pull-right report-range" style="margin-top: 0px;">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                            <span></span> <b class="caret"></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-left" style="margin-left: 15px;">
                                    <button type="text" id="btnFiterSubmitSearch" class="btn btn-info btn-sm"
                                        style="margin-top: 35px;">Search</button>
                                </div>
                            </div>
                        </header>
                        <div class="panel-body">
                            <div class="adm-table">
                                <table id="datatable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th> Date </th>
                                            <th>Inovice #</th>
                                            <th> Amount </th>
                                            {{-- <th> Quotation </th> --}}
                                            <th> Customer ID </th>
                                            <th> Note </th>
                                            <th> Created By </th>
                                            <th> Invoice </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd">
                                            <td valign="top" colspan="4" class="dataTables_empty">No data available in
                                                table</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th> Date </th>
                                         <th>Inovice #</th>
                                            <th> Amount </th>
                                            {{-- <th> Quotation </th> --}}
                                            <th> Customer ID </th>
                                            <th> Note </th>
                                            <th> Created By </th>
                                            <th> Invoice </th>
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

    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="attribute_model"
        class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Cancel Invoice</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group is_main_price">
                                {!! Form::label('note', 'Note', ['class' => 'control-label col-lg-4']) !!}
                                <div class="col-lg-7">
                                    {!! Form::textarea('note', null, ['class' => 'form-control cancelNote', 'rows' => '2']) !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <button type="button" class="btn btn-info pull-right submitData">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js" ></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js" ></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js" ></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" ></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" ></script>
    <script>
        var table;
        start = moment().subtract(1, 'weeks');
  
        end = moment();
        var upload_url = '{{ asset('uploads') }}';
        var $reload_datatable = {};
        var url = window.location.href;
        var id = '';
        var token = $('meta[name="csrf-token"]').attr('content');

        function cb(start, end) {
            $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        }

        cb(start, end);

        $("document").ready(function() {

            $("body").on("click", '.btn-cancel-invoice', function() {
                id = $(this).attr('data-id');
                $(".cancelNote").val('');
                $('#attribute_model').modal('show');
            });

            $("body").on("click", '.btn-undo-invoice', function() {
                id = $(this).attr('data-id');

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure! You want to undo invoice',
                    type: 'green',
                    typeAnimated: true,
                    closeIcon: true,
                    buttons: {
                        confirm: function() {
                            $.ajax({
                                url: '{{ url('admin/admin-orders/undo-quotation') }}',
                                type: 'post',
                                data: {
                                    '_token': token,
                                    'id': id,
                                },
                                success: function(result) {
                                    $('#datatable').DataTable().ajax.reload();
                                    toastr.success("Invoice successfully restored");
                                }

                            });
                        },
                        cancel: function() {},
                    }
                });
            });

            $('.submitData').on('click', function(e) {

                if (e.isDefaultPrevented()) {

                } else {

                    e.preventDefault();
                    if ($(".cancelNote").val() == '') {
                        toastr.error("Please Enter Note!");
                        return false;
                    }

                    $.ajax({
                        url: '{{ url('admin/admin-orders/cancel-quotation') }}',
                        type: 'post',
                        data: {
                            '_token': token,
                            'id': id,
                            'note': $(".cancelNote").val()
                        },
                        success: function(result) {
                            $('#attribute_model').modal('hide');
                            $('#datatable').DataTable().ajax.reload();
                            toastr.success("Invoice successfully canceled");
                        }

                    });
                }
            });

            loadDatatable(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'))

            var reload_datatable = $("#datatable").dataTable({
                bRetrieve: true
            });


            /*child*/
            $reload_datatable = $("#datatable").dataTable({
                bRetrieve: true
            });

            $("#btnFiterSubmitSearch").click(function() {
                $('#datatable').DataTable().destroy();
                loadDatatable(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            });
        });



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
            start = picker.startDate.format('YYYY-MM-DD');
            end = picker.endDate.format('YYYY-MM-DD');


            $('#datatable').DataTable().destroy();
            loadDatatable(start, end);

        });

        function loadDatatable(start_date = '', end_date = '') {
            //if (user_id>0) {
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
                title: 'All Invoices',
                extension: '.csv'
            }],
                ajax: {
                    url: url,
                    data: {
                        from_date: start_date,
                        to_date: end_date,
                        user_id: $("#customer_user_id").val()
                    }
                },
                columns: [{
                        data: 'date',
                        width: '8%'
                    },
                    {
                        data: 'invoice_no',
                        width: '8%'
                    },
                 
                    {
                        data: 'amount'
                    },
                    {
                        data: 'user.customer_id'
                    },
                    {
                        data: 'note'
                    },
                    {
                        data: 'admin.name',
                    },
                    // {data: 'quotation_row', orderable: false, searchable: false},
                    {
                        data: 'invoice',
                        orderable: false,
                        searchable: false,
                        width: '30%'
                    },
                ],
                order: [],
                createdRow: function(row, data, index) {
                    if (data['is_canceled'] == 1) {
                        $('td', row).addClass('danger');
                    }

                },
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    var total = 0;
                    $.each(data, function(key, value) {
                        console.log(value);
                        if (value.is_canceled == '0') {
                            total = total + parseFloat(value.amount);
                        }
                    });

                    $(api.column(2).footer()).html('<b>Total: ' + total.toFixed(2) + '</b>');
                }
            });
            //}

        }
    </script>
@endsection
