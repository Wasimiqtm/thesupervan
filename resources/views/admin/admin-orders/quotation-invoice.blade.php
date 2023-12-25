@extends('admin.layouts.app')

@section('style')
    <style>
        td.invoice ul li span {
            float: right;
        }
    </style>
@endsection

@section('content')
    @php

        $cart = @$order->cart;
        $user = @$cart->user_details;
        $cart_details = @$cart->cart_details;
        $trans_details = @$order->trans_details;
        $updateData = collect([]);
        if ($order->updated_columns) {
            $updateData = collect(json_decode($order->updated_columns, true));
        }

        $total_text = 'Due';
        if ($cart->payment_status == 'complete') {
            $total_text = 'Paid';
        }

        $currency = getDefaultCurrency();
        $currency_code = @$currency->code;
        $subtotal = 0;
        $courier = 0;
        $courierAmout = 0;
    @endphp

    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                        <li><a href="{{ url('admin/admin-orders') }}"> Admin Orders</a></li>
                        <li class="active">Invoice</li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <!--<a id='printMe'  onclick="printDiv('printData');" style="padding: 10px;float: right;font-size: large;cursor: pointer">-->
                        <a href="{{ url('admin/admin-order-quotation-print/' . Hashids::encode($order->id)) }}"
                            target="_blank" style="padding: 10px;float: right;font-size: large;cursor: pointer" title="Print Invoice">
                            <i class="fa fa-print"></i>
                        </a>
                        <a href="{{ url('admin/admin-order-quotation-print/' . Hashids::encode($order->id)). '/view' }}"
                           target="_blank" style="padding: 10px;float: right;font-size: large;cursor: pointer" title="View Invoice">
                            <i class="fa fa-print"></i>
                        </a>
                        <div class="panel-body invoice" id="printData">
                            <form action="{{ url('admin/admin-orders/update-quotation') }}" method="post">
                                <div class="row invoice-to">
                                    <div class="col-md-6 col-sm-6 pull-left">

                                        {!! adminDetails() !!}

                                        <h4>Customer Details:</h4>
                                        <p>
                                            <b>Account No:</b> {{ @$user->customer_id }}<br>
                                            <b>Business Name:</b> {{ @$user->company_name }}<br>
                                            <b>Phone:</b> {{ @$user->contact_no ? $user->contact_no : @$user->phone }}<br>
                                            <b>Email:</b> {{ @$user->email }}<br>
                                            <b>Address:</b> {{ @$user->address }}
                                        </p>
                                    </div>
                                    <div class="col-md-4 col-sm-5 pull-right">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-5 inv-label">Invoice #:</div>
                                            <div class="col-md-8 col-sm-7">
                                                @if ($getNextInvoiceNumber != null)
                                                    <input type="text" name="invoice_no" required
                                                        value="{{ $getNextInvoiceNumber }}" readonly />
                                                @else
                                                    <input type="text" name="invoice_no" required
                                                        placeholder="{{ $getNextInvoiceNumber }}" />
                                                @endif
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-5 inv-label">Date #</div>
                                            @if (is_null($order->order_date))
                                                <div class="col-md-8 col-sm-7">
                                                    {{ date('d-m-Y h:i a', strtotime($order->created_at)) }}</div>
                                            @else
                                                <div class="col-md-8 col-sm-7">
                                                    {{ date('d-m-Y', strtotime($order->order_date)) }}</div>
                                            @endif
                                        </div>


                                    </div>
                                </div>

                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">

                                <table class="table table-invoice">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item Description</th>
                                             <th>Price Option</th>
                                            <th class="text-center">Unit Cost</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @foreach ($cart_details as $single_item)
                                            @php
                                                $single_item = (array) $single_item;

                                                $unit_price = $single_item['price'];

                                                $item_sub_total = $unit_price * $single_item['quantity'];
                                                $subtotal = $subtotal + $item_sub_total;
                                                $item_discount = @$single_item['item_discount'] ? $single_item['item_discount'] : 0;
                                                $item_sub_total = $item_sub_total - $item_discount;
                                                $item_sub_total = $item_sub_total + $courier;
                                                $productName = $single_item['name'];
                                                $price = number_format($unit_price, 2);
                                                if ($updateData->contains('id', $single_item['id'])) {
                                                    $dataRecieve = $updateData->firstWhere('id', $single_item['id']);
                                                    $productName = $dataRecieve['name'];
                                                    $price = $dataRecieve['price'];
                                                }
                                                $pId = $single_item['id'];
                                                $price = numberFormatToFloat($price);
                                                 $price_options = $single_item['price_options']??'';

                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="invoice">
                                                    <input type="text" name="products[{{ $pId }}][name]"
                                                        value="{{ ucwords(strtolower($productName)) }}"
                                                        style="width: 150px;margin-right: -200px;">
                                                </td>
                                                   <td class="invoice">
                                                       <select class="form-control price_option"  name="products[{{ $pId }}][price_options]">
                                                           @foreach(['Standard Price'=> 'Standard Price' ,
 'Price Matched On Request' =>'Price Matched On Request',
  'Reduced To Clear Price'=>'Reduced To Clear Price',
	'Promotional Offer Price' => 'Promotional Offer Price'] as $value)
	                                    <option value="{{$value}}" {{$price_options=== $value?'selected':''}}>{{$value}}</option>
	                                @endforeach

                                                       </select>

                                                </td>
                                                <td class="text-center">{{ $currency_code }}
                                                    <input type="number" step="any" min="0"
                                                        name="products[{{ $pId }}][price]"
                                                        value="{{ $price }}" style="width: 60px;">
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" step="1" min="1"
                                                        name="products[{{ $pId }}][quantity]"
                                                        value="{{ $single_item['quantity'] }}" style="width: 40px;">
                                                </td>
                                                <td class="text-center">{{ $currency_code }}
                                                    <input type="number" step="any" min="0"
                                                        name="products[{{ $pId }}][total]"
                                                        value="{{ $item_sub_total }}" style="width: 60px;">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="row">
                                    <div class="col-md-8 col-xs-7 payment-method">
                                        <h4>Payment</h4>
                                        @php
                                            $payment_method = @$trans_details['payer'];
                                            $payment_status = 'Pending';
                                            $payment_class = 'label-danger';

                                            if ($cart->payment_status == 'complete') {
                                                $payment_status = 'Paid';
                                                $payment_class = 'label-success';
                                            }

                                            $tax = $order->tax;
                                        @endphp

                                        @if ($order->payment_method == '2pay')
                                            <p>Payment Method : Wallet</p>
                                        @endif

                                        @if ($order->payment_method != 'none')
                                            <p>Payment Mode :
                                                {{ ucwords(str_replace('2', 'To ', $order->payment_method)) }}</p>
                                        @endif

                                    </div>

                                    <?php
                                    $amount = $order->amount;
                                    if (!is_numeric($order->amount)) {
                                        $amount = str_replace(',', '', $order->amount);
                                    }
                                    ?>

                                    <div class="col-md-4 col-xs-5 invoice-block pull-right">
                                        <ul class="unstyled amounts">
                                            {{-- <li style="display:none;">Product amount : {{$currency_code}}
                                        <input type="number" name="subtotal" step="any" min="0" value="{{ $subtotal }}" style="width: 80px;">
                                    </li>
                                    <li style="display:none;">Discount : {{$currency_code}}
                                        <input type="number" name="discount" step="any" min="0" value="{{ $order->discount }}" style="width: 80px;">
                                    </li>
                                    <li style="display:none;">Vat : {{$currency_code}}
                                        <input type="number" name="tax" step="any" min="0" value="{{ $tax }}" style="width: 80px;">
                                    </li> --}}
                                            <li class="grand-total">Total : {{ $currency_code }}
                                                <input type="number" name="amount" step="any" min="0"
                                                    value="{{ $amount }}" style="width: 80px;color: black;">
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-6">
                                        {!! Form::submit('Update Invoice', ['class' => 'btn btn-info pull-right admin-order-btn']) !!}
                                    </div>
                                </div>
                            </form>

                            <div class="row">
                                <h3 style="margin-left:20px;font-size:16px;">VAT Summary</h3>
                                <table class="table table-invoice">
                                    <thead>
                                        <tr>
                                            <th class="text-center">RATE</th>
                                            <th class="text-center">VAT</th>
                                            <th class="text-center">NET</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php
                                            $vat = $tax;

                                            $price = $amount - $vat;
                                            $vatRate = 0;
                                            if ($amount > 0) {
                                                $vatRate = ($vat / $amount) * 100;
                                            }

                                        @endphp
                                        <tr>
                                            <td class="text-center"> {{ getVatName() }} </td>
                                            <td class="text-center">{{ $currency_code }}{{ number_format($vat, 2) }}</td>
                                            <td class="text-center">{{ $currency_code }}{{ number_format($price, 2) }}
                                            </td>
                                        </tr>
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
    <script type="text/javascript"></script>
@endsection
