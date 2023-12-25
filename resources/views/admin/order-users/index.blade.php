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
                    <li class="active">Order Users</li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Order Users
                    </header>
                    <div class="panel-body">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th> Business Name </th>
                                    <th> Contact Person </th>
                                    <th> Contact Number </th>
                                    <th> Address </th>
                                    <th> Postal Code </th>
                                    <th> Remarks </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No data available in table</td></tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th> Business Name </th>
                                    <th> Contact Person </th>
                                    <th> Contact No </th>
                                    <th> Address </th>
                                    <th> Postal Code </th>
                                    <th> Remarks </th>
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
<script>
    $("document").ready(function () {
    var datatable_url = "{{url('admin/order-users')}}";
    var datatable_columns = [
        {data: 'shop_name'},
        {data: 'owner_name'},   
        {data: 'contact_no'},   
        {data: 'address'},   
        {data: 'postal_code'},   
        {data: 'notes'},   
        ];
        
        create_datatables(datatable_url,datatable_columns);
      }); 
</script>
@endsection
