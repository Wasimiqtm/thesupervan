@extends('admin.layouts.app')

@section('content')
    <section id="main-content" >
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                        <li class="active">Drop Shippers</li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Drop Shippers
                            @can('add drop_shipper')
                                <span class="tools pull-right">
<!--                                <a href="{{ url('/admin/wholesaler/create') }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Add New Wholesaler">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add New
                                </a>-->
                             </span>
                            @endcan
                        </header>
                        <div class="panel-body">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Company Name</th>
                                    <th>Contact #</th>
                                    <th>Address</th>
                                    <th>Cost Percentage</th>
                                    <th>Wallet Amount</th>
                                    <th>Status</th>
                                    @can('edit drop_shipper')
                                        <th>Action</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">No data available in table</td></tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Company Name</th>
                                    <th>Contact #</th>
                                    <th>Address</th>
                                    <th>Cost Percentage</th>
                                    <th>Wallet Amount</th>
                                    <th>Status</th>
                                    @can('edit drop_shipper')
                                        <th>Action</th>
                                    @endcan
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </section>
                </div>
            </div>

        </section>
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="attribute_model" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Add Variant</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group is_main_price">
                                    {!! Form::label('amount', 'Wallet Amount', ['class' => 'control-label col-lg-4 required-input ']) !!}
                                    <div class="col-lg-7">
                                        {!! Form::number('amount', null, ['class' => 'form-control walletInput','min' => '0']) !!}
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
    </section>

@endsection


@section('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
        var id= '';
        $("document").ready(function () {
            var datatable_url = "{{url('admin/drop-shipper')}}";
            var datatable_columns = [
                {data: 'name'},
                {data: 'email'},
                {data: 'company_name'},
                {data: 'phone'},
                 {data: 'address'},
                {data: 'percentage_1'},
                {data: 'wallet_amount'},
                {data: 'is_active', orderable: false, searchable: false,width: "10%"},
                    @can('edit drop_shipper')
                {data: 'action', orderable: false, searchable: false,width: "10%"}
                @endcan
            ];

            create_datatables(datatable_url,datatable_columns);
        });

        $("body").on("click",'.walletAdd',function () {
            id = $(this).attr('data-id');
            $('#attribute_model').modal('show');
        })

        $('.submitData').on('click', function (e) {

            if(e.isDefaultPrevented()) {

            }else{

                e.preventDefault();
                if($(".walletInput").val() == ''){
                    toastr.error("Please Enter Amount!");
                    return false;
                }
                var attribute_id = $("#attribute").val();

                $.ajax({
                    url :'{{route('admin.add.wallet.amount')}}',
                    type: 'post',
                    data: {'_token': token,'id':id,amount:$(".walletInput").val()},
                    success: function (result) {
                        $('#attribute_model').modal('hide');
                        $(".walletInput").val('');
                        $('#datatable').DataTable().ajax.reload();
                        toastr.success("Amount Added to user wallet!");
                    }

                });
            }
        });
    </script>
@endsection
