@extends('admin.layouts.app')

@section('content')
<section id="main-content" >
    <section class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li class="active">Purchase Orders</li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Purchase Orders

                        <span class="tools pull-right">
                            <a href="{{ url('admin/purchase-orders/create') }}" class="btn btn-info btn-sm" title="Create Purchase Order">
                                <i class="fa fa-plus" aria-hidden="true"></i> Create Purchase Order
                            </a>
                         </span>
                    </header>
                    <div class="panel-body">
                        <div class="adm-table">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th> Date </th>
                                    <th> Supplier Name </th>
                                    <th> Total Quanitty </th>
                                    <th> Total Price </th>
                                    <th> Action </th>
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
    $("document").ready(function () {
    var datatable_url = "{{url('admin/purchase-orders/supplier/'.$id)}}";
    var datatable_columns = [
        {data: 'date', width: '15%'},
        {data: 'supplier_name'},
        {data: 'total_quantity'},
        {data: 'total_price'},
        {data: 'action', width: '10%', className: "text-center", orderable: false, searchable: false}
        ];
        
        create_datatables(datatable_url,datatable_columns);
        
      });

</script>
@endsection
