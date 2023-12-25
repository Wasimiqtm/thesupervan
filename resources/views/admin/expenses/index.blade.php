@extends('admin.layouts.app')

@section('content')
<section id="main-content" >
    <section class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li class="active">Expenses</li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>                
        
         <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Expenses
                        
                        <span class="pull-right">
                            <div id="reportrange" class="pull-right report-range">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                <span></span> <b class="caret"></b>
                            </div>
                        </span>
                        
                        @can('add expenses')
                        <span class="tools pull-right quote-btn" style="margin-right: 12px;margin-top: -6px;">
                            <a href="{{ url('admin/expenses/create') }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Add New Expense">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add New
                            </a>
                         </span>
                         @endcan
                    </header>
                    <div class="panel-body">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Expense By</th>
                                @if(auth()->user()->can('edit expenses') || auth()->user()->can('delete expenses'))
                                <th>Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                                <tr class="odd"><td valign="top" colspan="4" class="dataTables_empty">No data available in table</td></tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Expense By</th>
                                @if(auth()->user()->can('edit expenses') || auth()->user()->can('delete expenses'))
                                <th>Action</th>
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
      
@endsection


@section('scripts')
<script type="text/javascript">
    
    var table;
    var start = moment().subtract(6, 'days');
    var end = moment();
    var  $reload_datatable={};
     var url = window.location.href;
    function cb(start, end) {
      $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }
    
    cb(start, end);
    
    $("document").ready(function () {

        loadDatatable(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'))
       
        var reload_datatable = $("#datatable").dataTable( { bRetrieve : true } );
        $reload_datatable = $("#datatable").dataTable( { bRetrieve : true } );
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
        startdate = picker.startDate.format('YYYY-MM-DD');
        enddate = picker.endDate.format('YYYY-MM-DD');


         $('#datatable').DataTable().destroy();
        loadDatatable(startdate,enddate)

    });
    
    function loadDatatable(start_date='',end_date=''){
        table = $('#datatable').DataTable({
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
                {data: 'date'},   
                {data: 'name'},   
                {data: 'amount'},   
                {data: 'admin.name'},   
                @if(auth()->user()->can('edit expenses') || auth()->user()->can('delete expenses'))
                {data: 'action', name: 'action', width: '10%',orderable: false, searchable: false}
                @endif
            ],
          order: []
        });
    }         
</script>
@endsection                            
