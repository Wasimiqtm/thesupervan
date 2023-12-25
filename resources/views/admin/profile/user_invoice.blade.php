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
    <section id="main-content">
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

                        </span>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <h5>User <span class="text-danger"></span></h5>
                                    <div class="controls">
                                        <select name="user_id" id="user_id" class="form-control select2 " value="">
                                            <option value="">Select user</option>
                                            @foreach($data as $val)
                                                <option value="{{$val->id}}">{{$val->email}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <h5>Start Date <span class="text-danger"></span></h5>
                                    <div class="controls">
                                        <input type="date" name="start_date" id="start_date"
                                               class="form-control datepicker-autoclose"
                                               placeholder="Please select start date" value="">
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <h5>End Date <span class="text-danger"></span></h5>
                                    <div class="controls">
                                        <input type="date" name="end_date" id="end_date"
                                               class="form-control datepicker-autoclose"
                                               placeholder="Please select end date" value="">
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="text-left" style="
margin-left: 15px;
">
                                    <button type="text"  id="btnFiterSubmitSearch"
                                            class="btn btn-info">Submit
                                    </button>
                                </div>
                            </div>
                        </header>
                        <div class="panel-body">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                <tr>


                                    <th> Email</th>
                                    <th> Total Sale</th>
                                    <th>Wallet Amount</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr class="odd">
                                    <td valign="top" colspan="6" class="dataTables_empty">No data available in table
                                    </td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>

                                    <th> Email</th>
                                    <th> Total Sale</th>
                                    <th>Wallet Amount</th>

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

        var upload_url = '{{ asset("uploads") }}';

        var url = window.location.href;

        var table;


        $(document).ready(function () {

            $('#btnFiterSubmitSearch').click(function(){
                $('#datatable').DataTable().draw(true);
            });
            table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                responsive: true,
                ajax: {
                    url: url,
                    data: function (d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.user_id = $('#user_id option:selected').val()
                    }
                },

                columns: [

                    {data: 'email', width: "20%"},
                    {data: 'sum_amount', width: "10%"},
                    {data: 'wallet_amount', width: "10%"}

                ],
                order: []
            });
        })

        /*child*/


    </script>
@endsection
