@extends('admin.layouts.app')


@section('style')
<style>
    .dataTables_length{float: left;}
    .dt-buttons{float: right; margin: 14px 0 0 0px;}
     div.dataTables_processing{top:55%;}
    .mini-stat{background: #f7f7f7;}
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
                        <li class="active">Invoice Amount</li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <div class="row">
                                
                                <div class="form-group col-md-3">
                                    <h5>Select Date Range<span class="text-danger"></span></h5>
                                    <div class="controls">
                                        <div id="reportrange" class="pull-right report-range" style="margin-top: 0px;">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                            <span></span> <b class="caret"></b>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </header>
                        <div class="panel-body">
                            <div class="adm-table">
                                <table id="datatable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th> Date </th>
                                            <th>Amount</th>
                                            <th>Name</th>
                                           
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
                                            <th>Amount</th>
                                            <th>Name</th>
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
        start = moment().subtract(1, 'months');
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
                lengthMenu: [
[ 10, 25, 50, -1 ],
[ '10 rows', '25 rows', '50 rows', 'Show all' ]
],
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
                        data: 'date'
                    },
                    {
                        data:'amount'
                    },
                    {
                        data:'user_name'
                    }
                     
                ],
                order: [],
                
            });
            //}

        }
    </script>
@endsection