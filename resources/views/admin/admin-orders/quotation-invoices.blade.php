@extends('admin.layouts.app')

@section('style')
<style>
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
                    <li class="active">Quotations</li>
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
                                    <select name="user_id" id="customer_user_id" class="form-control select2 " value="">
                                        <option value="0">Select Customer</option>
                                        @foreach($customers as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
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
                                <button type="text"  id="btnFiterSubmitSearch" class="btn btn-info btn-sm" style="margin-top: 35px;">Search</button>
                            </div>
                        </div>
                    </header>
                    <div class="panel-body">
                        <div class="adm-table">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> Date </th>
                                        <th> Amount </th>
                                        <th> Quotation </th>
                                        <th> Invoice </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd"><td valign="top" colspan="4" class="dataTables_empty">No data available in table</td></tr>
                                </tbody>
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
<script>
    var table;
    start = moment().subtract(6, 'days');
    end = moment();
    var upload_url = '{{ asset("uploads") }}';
    var  $reload_datatable={};
    var url = window.location.href;

    function cb(start, end) {
        $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }
    
    cb(start, end);
    
    $("document").ready(function () {

        loadDatatable(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'))
       
        var reload_datatable = $("#datatable").dataTable( { bRetrieve : true } );


        /*child*/
         $reload_datatable = $("#datatable").dataTable( { bRetrieve : true } );

        $("#btnFiterSubmitSearch").click(function(){
            $('#datatable').DataTable().destroy();
            loadDatatable(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
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
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    },cb);
    
    $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        $('#reportrange').val('');
        $reload_datatable.fnDraw();
    });

    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        start = picker.startDate.format('YYYY-MM-DD');
        end = picker.endDate.format('YYYY-MM-DD');


        $('#datatable').DataTable().destroy();
        loadDatatable(start,end);

    });

    function loadDatatable(start_date='',end_date=''){
        //if (user_id>0) {
            table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                responsive: true,
                pageLength: -1,
                ajax: {
                    url:url,
                    data:{from_date:start_date,to_date:end_date,user_id:$("#customer_user_id").val()}
                },
                columns: [
                    {data: 'date'},
                    {data: 'amount'},
                    {data: 'quotation_row', orderable: false, searchable: false},
                    {data: 'invoice', orderable: false, searchable: false},
                ],
                order: []
            });
        //}
        
    }

</script>
@endsection
