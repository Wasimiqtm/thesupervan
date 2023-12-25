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
<section id="main-content" >
    <section class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li class="active">Van Store</li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Van Store
                        
                        <span class="tools pull-right quote-btn" style="margin-right: 12px;">
                            <a href="{{ url('admin/van-store/create') }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Create Quotation">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add Products
                            </a>
                         </span>
                    </header>
                    <div class="panel-body">
                        <div class="adm-table">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th> Product Name </th>
                                    <th> Quantity </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd"><td valign="top" colspan="3" class="dataTables_empty">No data available in table</td></tr>
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
       
        var reload_datatable = $("#datatable").dataTable( { bRetrieve : true } );


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
                {data: 'product.name'},
                {data: 'quantity'},
                {data: 'action', width: "8%", orderable: false, searchable: false}
            ],
          order: []
        });
            }

        /*child*/

      

</script>
@endsection
