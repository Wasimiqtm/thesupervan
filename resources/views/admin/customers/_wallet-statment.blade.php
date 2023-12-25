@extends('admin.layouts.app')

@section('style')
<style>
    .dataTables_length{float: left;}
    .dt-buttons{float: right; margin: 14px 0 0 0px;}
    div.dataTables_processing{top:55%;}
    .dt-buttons .dt-button{    background-color: #57c8f1;
    border-color: #57c8f1;
    color: #FFFFFF;
    border-radius: 13px;
    padding: 5px 10px 5px 10px;}
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
                    <li class="active">Wallet Statment</li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>                
        
         <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">Wallet Statment

                        <div class="row">
                            <form method="get">
                                <div class="form-group col-md-4">
                                    <h5>Start Date <span class="text-danger"></span></h5>
                                    <div class="controls">
                                        <input type="date" name="start_date" id="start_date"
                                            class="form-control datepicker-autoclose"
                                            placeholder="Please select start date" value="{{ (request()->filled('start_date')) ? date('Y-m-d', strtotime(request()->start_date)) : '' }}">
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <h5>End Date <span class="text-danger"></span></h5>
                                    <div class="controls">
                                        <input type="date" name="end_date" id="end_date"
                                            class="form-control datepicker-autoclose"
                                            placeholder="Please select end date" value="{{ (request()->filled('end_date')) ? date('Y-m-d', strtotime(request()->end_date)) : '' }}">
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2" style="margin-top: 35px;">
                                    <button type="submit"  id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>
                                </div>
                            </form>
                        </div>
                    </header>
                    <div class="panel-body">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="10%">Date</th>
                                <th style="text-align: center;" width="20%">Sale/To Pay Amount</th>
                                <th style="text-align: center;" width="15%">Amount Receive</th>
                                <th>Note</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $debit = 0;    
                                    $credit = 0;   
                                ?>
                                @forelse($wallets as $wallet)
                                <?php
                                    $debit += $wallet->debit;    
                                    $credit += $wallet->credit;
                                ?>
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($wallet->date)) }}</td>
                                    <td align="center" style="color:{{ ($wallet->type=='2pay')?'red':'green' }};">{{ $wallet->debit }}</td>
                                    <td align="center">{{ $wallet->credit }}</td>
                                    <td>{{ $wallet->note }}</td>
                                    <td>
                                    @if($wallet->order_id > 0 && $wallet->type == '2pay')
                                        <a target="_blank" class="text-primary"  href="{{ url('admin/admin-orders/' . Hashids::encode($wallet->order_id)) }}" > View Quotation</a>
                                    @endif
                                    <a href="{{ url('admin/delete-wallet-statement/' . $wallet->id) }}" ><i class="fa fa-trash text-danger"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">No data available in table</td></tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Date</th>
                                    <th>Total: ({{ $debit }})</th>
                                    <th>Total: ({{ $credit }})</th>
                                    <th>Balance: ({{ number_format($credit-$debit, 2) }} )</th>
                                    <th></th>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
<script>
$(document).ready(function() {
    $('#datatable').DataTable( {
        dom: 'Bfrtip',
        paging: false,
        ordering: false,
        pageLength: -1,
        buttons: [
            {
                text: '<span data-toggle="tooltip" title="Print"><i class="fa fa-lg fa-print"></i> Print</span>',
                extend: 'print',
                className: 'btn btn-sm btn-round btn-info',
                footer: true,
                exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                }
            }
        ]
    } );
} );
</script>

@endsection