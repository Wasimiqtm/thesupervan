@extends('admin.layouts.app')

@section('content')
    <section id="main-content" >
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                        <li class="active">Drop Shipper Orders</li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">Drop Shipper Orders
                        </header>

                        <div class="panel-body">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone#</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">No data available in table</td></tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone#</th>
                                    <th>Action</th>
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

        var table;
        $("document").ready(function () {

            var url = "{{ route('admin.shipper.orders') }}";
            var columns = [
                    {data: 'profile_image', width: '10%',orderable: false, searchable: false},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'mobile'},
                    {data: 'action', width: '10%', orderable: false, searchable: false}
                ];

                create_datatables(url, columns);    


        }); //..... end of ready() .....//
    </script>

@endsection
