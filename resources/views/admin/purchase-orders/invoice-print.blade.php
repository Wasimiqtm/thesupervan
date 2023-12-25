@extends('admin.layouts.print')

@section('style')
<style>
    td.invoice ul li span{float: right;}
</style>
@endsection

@section('content')

@php
    $currency = getDefaultCurrency();
    $currency_code = @$currency->code;
@endphp

<section id="main-content1" >
    <section class="wrapper1">


                  <div class="row">
            <div class="col-md-12">
                <section class="panel">

                    <div class="panel-body invoice" id="printData">


                <div id="logo" class="logo">
                    <img src="{{ asset('uploads/settings/site_logo.jpg') }}" >
                </div>
                <center><h1><u>Purchase Order</u></h1></center>

                        <div class="row invoice-to">
                            <div class="col-md-6 col-sm-6 pull-left">

                                <h4>Supplier Details:</h4>
                                @if($supplier)
                                <p>
                                    <b>Supplier Code:</b> {{ $supplier->code }}<br>
                                </p>
                                @endif
                                <p>
                                    <b>Supplier Name:</b> {{ $order->supplier_name }}<br>
                                </p>
                            </div>
                            <div class="col-md-4 col-sm-5 pull-right">
                                <div class="row">
                                    <div class="col-md-4 col-sm-5 inv-label">Order #</div>
                                    <div class="col-md-8 col-sm-7">{{ $order->id }}</div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-sm-5 inv-label">Date #</div>
                                    <div class="col-md-8 col-sm-7">{{ date('d-m-Y h:i a', strtotime($order->created_at)) }}</div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 inv-label">
                                        <h3>Total</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <h1 class="amnt-value">{{ $currency_code }}{{number_format($order->total_price,2)}}</h1>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="adm-table">
                        <table class="table table-invoice" >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Description</th>
                                <th class="text-center">Unit Cost</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total</th>
                            </tr>
                            </thead>
                            <tbody>

                                @foreach(json_decode($order->products) as $product)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="invoice"><h4>{{ $product->product_name }}</h4></td>
                                    <td class="text-center">{{$currency_code}}{{ $product->price }}</td>
                                    <td class="text-center">{{ $product->quantity }}</td>
                                    <td class="text-center">{{$currency_code}}{{number_format(($product->quantity*$product->price),2)}}</td>
                                </tr>


                                @endforeach

                            </tbody>
                        </table>
                    </div>    
                        <div class="row">
                            <div class="col-md-8 col-xs-7 payment-method">
                                
                            </div>
                            <div class="col-md-4 col-xs-5 invoice-block pull-right">
                                <ul class="unstyled amounts">
                                    <li class="grand-total">Total : {{$currency_code}}{{number_format($order->total_price,2)}}</li>
                                </ul>
                            </div>
                        </div>



                    </div>
                </section>
            </div>
        </div>



    </section>
</section>

@endsection

@section('scripts')

<script type="text/javascript">

   
</script>

@endsection



