@extends('admin.layouts.app')

@section('content')
<section id="main-content" >
    <section class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li class="active">Wholesalers</li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>                
        
         <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Wholesalers
                        @can('add wholesaler')
                            <span class="tools pull-right">
                                <a href="{{ url('/admin/customers/create?type=wholesaler') }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Add New Wholesaler">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add New
                                </a>
                                <a href="{{ url('/admin/admin-orders/create') }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Create Quotation">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Create Quotation
                                </a>
                             </span>
                        @endcan
                    </header>
                    <div class="panel-body">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Customer ID</th>
                                <th>Name</th>
                                <th>Business Name</th>
                                <th>Email</th>
                                <th>Contact #</th>
                                <th>Address</th>
                                <th>Notes</th>
                                <th>Wallet Amount</th>
                                {{-- <th>To Pay Amount</th> --}}
                                @can('edit wholesaler')
                                <th>Action</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                                <tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">No data available in table</td></tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Customer ID</th>
                                <th>Name</th>
                                <th>Business Name</th>
                                <th>Email</th>
                                <th>Contact #</th>
                                <th>Address</th>
                                <th>Notes</th>
                                <th>Wallet Amount</th>
                                {{-- <th>To Pay Amount</th> --}}
                                @can('edit wholesaler')
                                <th>Action</th>
                                @endcan
                            </tr>
                          </tfoot>
                        </table>
                    </div>
                </section>
            </div>
        </div>

        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="add_wallet_to_pay_amount" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Add Wallet/To Pay Amount</h4>
                    </div>
                    <div class="modal-body">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group is_main_price">
                                        {!! Form::label('amount', 'Wallet/To Pay Amount', ['class' => 'control-label col-lg-4 required-input ']) !!}
                                        <div class="col-lg-7">
                                            {!! Form::number('amount', null, ['class' => 'form-control walletInput']) !!}
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="form-group is_main_price">
                                        {!! Form::label('payment_type', 'Payment Type', ['class' => 'control-label col-lg-4 required-input ']) !!}
                                        <div class="col-lg-7">
                                            {!! Form::select('payment_type', ['' => 'None', 'cash' => 'Paid', '2pay' => 'To Pay'], null, ['class' => 'form-control payment_type']) !!}
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('date') ? 'has-error' : ''}}">
                                        {!! Form::label('date', 'Date', ['class' => 'col-lg-4 col-sm-4 control-label required-input']) !!}
                                        <div class="col-lg-7">
                                            {!! Form::text('date', null, ['class' => 'form-control datepicker walletDate','required' => 'required','autocomplete' => 'off']) !!}
                                            {!! $errors->first('date', '<p class="help-block">:message</p>') !!}
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="form-group is_main_price">
                                        {!! Form::label('note', 'Note', ['class' => 'control-label col-lg-4']) !!}
                                        <div class="col-lg-7">
                                            {!! Form::textarea('note', null, ['class' => 'form-control walletNote','rows' => '2']) !!}
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

        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="attribute_model" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Add Wallet Amount</h4>
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
        
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="2pay_model" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Add To Pay Amount</h4>
                    </div>
                    <div class="modal-body">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group is_main_price">
                                        {!! Form::label('amount', 'To Pay Amount', ['class' => 'control-label col-lg-4 required-input ']) !!}
                                        <div class="col-lg-7">
                                            {!! Form::number('amount', null, ['class' => 'form-control 2payInput','min' => '0']) !!}
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                               <div class="row">
                                   <button type="button" class="btn btn-info pull-right 2PaySubmitData">Submit</button>
                               </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<style>
    .datepicker{ z-index:99999 !important; }?
  </style>
@endsection


@section('scripts')
<script type="text/javascript">
    var token = $('meta[name="csrf-token"]').attr('content');
    var id= '';
$("document").ready(function () {

    $("body").delegate(".datepicker", "focusin", function () {
        $(this).datepicker({
            format:'dd/mm/yyyy',
            autoclose: true
        });
    });

    var datatable_url = "{{url('admin/wholesalers')}}";
    var datatable_columns = [
        {data: 'customer_id'},
        {data: 'name'},
        {data: 'company_name'},
        {data: 'email'},
        {data: 'phone'},
        {data: 'address'},
        {data: 'notes'},
        {data: 'wallet_amount', orderable: false},
        // {data: '2pay_amount', orderable: false},
        @can('edit wholesaler')
        {data: 'action', orderable: false, searchable: false}
        @endcan        
        ];
        
        create_datatables(datatable_url,datatable_columns, true, [], 100);

    $("body").on("click",'.walletAdd',function () {
        id = $(this).attr('data-id');
        $(".walletNote").val('');
        $(".payment_type").val('').change();
        $("#amount").val('');
        $(".walletDate").val('');
        $('#add_wallet_to_pay_amount').modal('show');
    });
    
    $("body").on("click",'.2payAdd',function () {
        id = $(this).attr('data-id');
        $('#2pay_model').modal('show');
    });
    
    $('.submitData').on('click', function (e) {

        if(e.isDefaultPrevented()) {

        }else{

            e.preventDefault();
            if($(".walletInput").val() == ''){
                toastr.error("Please Enter Amount!");
                return false;
            } else if($(".payment_type").val() == ''){
                toastr.error("Please select payment type!");
                return false;
            } else if($(".walletDate").val() == ''){
                toastr.error("Please Enter Date!");
                return false;
            }
            var attribute_id = $("#attribute").val();
            var paymentType = $(".payment_type").val();

            $.ajax({
                url :'{{route('admin.add.wallet.amount')}}',
                type: 'post',
                data: {'_token': token,
                    'id':id,amount:$(".walletInput").val(), 
                    date:$(".walletDate").val(), 
                    note:$(".walletNote").val(),
                    payment_type: paymentType
                },
                success: function (result) {
                    $('#add_wallet_to_pay_amount').modal('hide');
                    $('#datatable').DataTable().ajax.reload();
                    toastr.success("Amount Added to user!");
                }

            });
        }
    });
    
    $('.2PaySubmitData').on('click', function (e) {

        if(e.isDefaultPrevented()) {

        }else{

            e.preventDefault();
            if($(".2PayInput").val() == ''){
                toastr.error("Please Enter 2Pay Amount!");
                return false;
            }
            var attribute_id = $("#attribute").val();

            $.ajax({
                url :'{{ route('admin.add.2pay.amount') }}',
                type: 'post',
                data: {'_token': token,'id':id,amount:$(".2payInput").val()},
                success: function (result) {
                    $('#2pay_model').modal('hide');
                    $(".2PayInput").val('');
                    $('#datatable').DataTable().ajax.reload();
                    toastr.success("Amount Added to user 2Pay!");
                }

            });
        }
    });
});
</script>
@endsection                            
