@extends('admin.layouts.print')

@section('style')
    <style>
        .billTo {
            margin-top: 110px;
        }

        @media print {
            /* .billTo {
                                                                                                                                                                                                    margin-top: 130px;
                                                                                                                                                                                                } */

            .col-sm-1,
            .col-sm-2,
            .col-sm-3,
            .col-sm-4,
            .col-sm-5,
            .col-sm-6,
            .col-sm-7,
            .col-sm-8,
            .col-sm-9,
            .col-sm-10,
            .col-sm-11,
            .col-sm-12 {
                float: left;
            }

            .col-sm-12 {
                width: 100%;
            }

            .col-sm-11 {
                width: 91.66666667%;
            }

            .col-sm-10 {
                width: 83.33333333%;
            }

            .col-sm-9 {
                width: 75%;
            }

            .col-sm-8 {
                width: 66.66666667%;
            }

            .col-sm-7 {
                width: 58.33333333%;
            }

            .col-sm-6 {
                width: 50%;
            }

            .col-sm-5 {
                width: 41.66666667%;
            }

            .col-sm-4 {
                width: 33.33333333%;
            }

            .col-sm-3 {
                width: 25%;
            }

            .col-sm-2 {
                width: 16.66666667%;
            }

            .col-sm-1 {
                width: 8.33333333%;
            }
        }

        td.invoice ul li span {
            float: right;
        }

        .border-rounded {
            border: 1px solid;
            border-radius: 12px;
            width: 100%;
        }

        .border-rounded h1 {
            padding-right: 20px;
        }

        .border-rounded p {
            padding-right: 20px;
            padding-bottom: 10px;
        }

        .border-rounded hr {
            border-color: #767676;
        }

        .table tbody>tr>td {
            padding: 5px;
            border-top: none;
        }

        .paymentTable tr {
            border: 1px solid black;
        }

        .paymentTable tr th {
            color: black;
            font-weight: 800;
        }

        .paymentTable>thead>tr>th {
            border: 1px solid black;
        }

        .clearfix {
            overflow: auto;
        }

        .watermark {
            position: relative;
        }

        .watermark__inner {
            align-items: center;
            display: flex;
            justify-content: center;
            left: 0px;
            position: absolute;
            top: 0px;
            height: 100%;
            width: 100%;
        }

        .watermark__body {
            color: rgba(142, 138, 138, 0.2);
            font-size: 15rem;
            font-weight: bold;
            text-transform: uppercase;
            transform: rotate(-40deg);
            user-select: none;
        }
    </style>
@endsection

@section('content')
    @php
        $cart = @$order->cart;
        $user = @$cart->user_details;
        //dd($user);
        $cart_details = @$cart->cart_details;
        $trans_details = @$order->trans_details;
        
        $total_text = 'Due';
        if ($cart->payment_status == 'complete') {
            $total_text = 'Paid';
        }
        $updateData = collect([]);
        if ($order->updated_columns) {
            $updateData = collect(json_decode($order->updated_columns, true));
        }
        $currency = getDefaultCurrency();
        $currency_code = @$currency->code;
        $subtotal = 0;
        $courier = 0;
        $courierAmout = 0;
        $subTotatExVat = 0;
        $subTotatIncVat = 0;
    @endphp


    <?php
    foreach ($cart_details as $single_item) {
        $single_item = (array) $single_item;
        $unit_price = $single_item['price'];
    
        $item_discount = @$single_item['item_discount'] ? $single_item['item_discount'] : 0;
        //$item_sub_total = $item_sub_total - $item_discount;
        $productName = $single_item['name'];
        $price = number_format($unit_price, 2);
        if ($updateData->contains('id', $single_item['id'])) {
            $dataRecieve = $updateData->firstWhere('id', $single_item['id']);
            $productName = $dataRecieve['name'];
            $price = $dataRecieve['price'];
        }
    
        $vatRate = 20;
        if (@$single_item['exclude_include_vat'] == 'ex') {
            $add = 1.2;
    
            $exVatPrice = $price;
    
            $unit_price = $price = $single_item['price'] * $add;
            $vat = $unit_price * (20 / 120);
        } else {
            $exVatPrice = $price - ($price * $vatRate) / 120;
            $price = number_format($unit_price, 2);
        }
    
        $item_sub_total = $unit_price * $single_item['quantity'];
        $subtotal = $subtotal + $item_sub_total;
        $netTotal = $item_sub_total - ($item_sub_total * $vatRate) / 120;
    
        $subTotatExVat = $subTotatExVat + $netTotal;
        $subTotatIncVat = $subTotatIncVat + $item_sub_total;
        $totalVat = $subTotatIncVat - $subTotatExVat;
    }
    
    ?>


    <section id="main-content1">
        <section class="wrapper1">


            <div class="row">
                <div class="col-md-12">
                    <section class="panel">

                        <div class="panel-body invoice" id="printData">


                            <div class="row ">
                                <div class="col-md-6 pull-left">
                                    <div id="logo" class="logo">
                                        <img src="{{ asset('uploads/settings/site_logo.jpg') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 pull-right">
                                    <div class="border-rounded pull-right" style="text-align: right;width:200px;">
                                        <h1>INVOICE</h1>
                                        <hr>
                                        <p style="font-size: 19px; font-weight: 700;">#
                                            @if ($quotation->invoice_no != null)
                                            {{ sixDigitInvoiceNumber($order->id, $quotation->invoice_no) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row invoice-to" style="margin-top:10px;">
                                <div class="col-md-6 col-sm-6 pull-left">
                                    <div class="border-rounded pull-right">
                                        <div style="padding-top: 6px;padding-left: 10px">
                                            <p style="padding-bottom:0;">
                                                <b>Company Name: VAPEOSONIC LTD</b><br>
                                                Company Reg: SC737008<br>
                                                VAT No: 416 9547 70<br>
                                                Tel: 075 63 63 57 57<br>
                                                Email: info@vapeosonic.com<br>
                                                Web: http://www.vapeosonic.com<br>
                                                Address: Unit B, 15 Edison Street, Hillington Park, Glasgow. G52 4JW
                                            </p>
                                        </div>
                                        <hr style="margin-top: 10px;margin-bottom: 10px;">
                                        <div style="margin-left: 10px;">
                                            <p>
                                                <b>Bank Account Name:</b> VAPEOSONIC LTD<br>
                                                <b>Bank Account No:</b> 19277217<br>
                                                <b>Bank Sort Code:</b> 04-06-05<br>
                                             <!--   <b>Payment Reference:</b>
                                                {{ sixDigitInvoiceNumber($order->id, $quotation->invoice_no) }}
                                                -->
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 pull-right">

                                    <div class="border-rounded pull-right" style="text-align: right;">
                                        <div style="padding-bottom: 13px;padding-top: 10px;">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="pull-right">
                                                    <h2>Date:</h2>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6" style="font-size: 19px;">
                                                @if (is_null($order->order_date))
                                                    {{ date('M d Y', strtotime($order->created_at)) }}
                                                @else
                                                    {{ date('M d Y', strtotime($order->order_date)) }}
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                        <div style="padding-bottom: 35px;margin-top: -5px;">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="pull-right">
                                                    <h4>Total To-Pay:</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <h2>
                                                    {{-- {{ $currency_code }}{{ number_format($subTotatIncVat, 2) }} --}}
                                                    {{ getWalletAndOrderAmount($order->user_id, 0) }}
                                                </h2>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-rounded billTo">
                                        <div style="padding-top: 6px;padding-left: 15px;">
                                            <h4>Bill To:</h4>
                                            <p>
                                                <b>Business Name: {{ @$user->company_name }}</b><br>
                                                Account No: {{ @$user->customer_id }}<br>
                                                Address: {{ @$user->address }}
                                                <br> Tel: {{ @$user->contact_no ? $user->contact_no : @$user->phone }}<br>
                                                Email: {{ @$user->email }}<br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <hr />
                            <div class="row invoice-to">
                                <div class="col-md-6 col-sm-6 pull-left">
                                    <h4>Bill To</h4>
                                    <p>
                                        <b>Account No:</b> {{ @$user->customer_id }}<br>
                                        <b>Business Name:</b> {{ @$user->company_name }}<br>
                                        <b>Phone:</b> {{ @$user->contact_no ? $user->contact_no : @$user->phone }}<br>
                                        <b>Email:</b> {{ @$user->email }}<br>
                                        <b>Address:</b> {{ @$user->address }}
                                    </p>
                                </div>

                                <div class="col-md-4 col-sm-5 pull-right">
                                    <h4>Ship To</h4>
                                    <p>{{ $user->company_name }}</p>
                                    <p>{{ $user->address }}</p>
                                    <p>FONOLOGY LTD</p>
                                    <p>61c Mian Street, Thiornliebank,</p>
                                    <p>Glasgow, G46 7RX </p>
                        </div>
                </div> --}}

                            <div class="adm-table">

                                @if ($quotation->is_canceled)
                                    <div class="watermark">
                                        <!-- Watermark container -->
                                        <div class="watermark__inner">
                                            <!-- The watermark -->
                                            <div class="watermark__body">CANCELLED</div>
                                        </div>
                                        <!-- Other content -->
                                    </div>
                                @endif

                                <table class="table table-invoice1" style="margin-top: 10px">
                                    <thead>
                                        <tr style="background: black;color: white;">
                                            <th>Item No</th>
                                            <th>Item Description</th>
                                              
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Unit Cost <br /> Ex-VAT</th>
                                            <th class="text-center">VAT <br /> Rate</th>
                                            <th class="text-center">Unit Cost <br /> Inc-VAT</th>
                                            <th class="text-center">Net <br /> Total</th>
                                            <th class="text-center">Gross <br /> Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $subtotal = 0;
                                        $courier = 0;
                                        $courierAmout = 0;
                                        $subTotatExVat = 0;
                                        $subTotatIncVat = 0;
                                        ?>
                                        @foreach ($cart_details as $single_item)
                                            @php
                                                $single_item = (array) $single_item;
                                                $unit_price = $single_item['price'];
                                                
                                                $item_discount = @$single_item['item_discount'] ? $single_item['item_discount'] : 0;
                                                //$item_sub_total = $item_sub_total - $item_discount;
                                                $productName = $single_item['name'];
                                                $price = number_format($unit_price, 2);
                                                if ($updateData->contains('id', $single_item['id'])) {
                                                    $dataRecieve = $updateData->firstWhere('id', $single_item['id']);
                                                    $productName = $dataRecieve['name'];
                                                    $price = $dataRecieve['price'];
                                                }
                                                
                                                $vatRate = 20;
                                                if (@$single_item['exclude_include_vat'] == 'ex') {
                                                    $add = 1.2;
                                                
                                                    $exVatPrice = $price;
                                                
                                                    $unit_price = $price = $single_item['price'] * $add;
                                                    $vat = $unit_price * (20 / 120);
                                                } else {
                                                    $exVatPrice = $price - ($price * $vatRate) / 120;
                                                    $price = number_format($unit_price, 2);
                                                }
                                                
                                                $item_sub_total = $unit_price * $single_item['quantity'];
                                                $subtotal = $subtotal + $item_sub_total;
                                                $netTotal = $item_sub_total - ($item_sub_total * $vatRate) / 120;
                                                
                                                $subTotatExVat = $subTotatExVat + $netTotal;
                                                $subTotatIncVat = $subTotatIncVat + $item_sub_total;
                                                $totalVat = $subTotatIncVat - $subTotatExVat;
                                                $productPrice = (isset($single_item['price_options']) and $single_item['price_options'] !=='Standard Price')?'('.$single_item['price_options'].')':'';
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="invoice">
                                                    <h5>{{ ucwords(strtolower($productName)) }}<strong>{{ $productPrice}}</strong></h5>
                                                </td>
                                          
                                                <td class="text-center">{{ $single_item['quantity'] }}</td>
                                                <td class="text-center">
                                                    {{ $currency_code }}{{ number_format($exVatPrice, 2) }}</td>
                                                <td class="text-center">{{ $vatRate }}%</td>

                                                <td class="text-center">{{ $currency_code }}{{ $price }}</td>

                                                <td class="text-center">
                                                    {{ $currency_code }}{{ number_format($netTotal, 2) }}</td>
                                                <td class="text-center">
                                                    {{ $currency_code }}{{ number_format($item_sub_total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>



                                <div class="row invoice-to" style="margin-top:10px;">
                                    <div class="col-md-8 col-sm-8">
                                        <div class="border-rounded pull-right">
                                            <div style="padding-top: 6px;padding-left: 10px">
                                                <u><b>Declaration:</b></u>
                                                <p> The goods delivered remain the property of VAPEOSONIC Ltd until
                                                    paid in full. Risk passes to buyer upon acceptance of delivery.
                                                    Overdue
                                                    accounts
                                                    would be subject to interest of 3% per month. All shortages or
                                                    damages
                                                    must be
                                                    reported with 24 hours of delivery. Goods are supplied subject to
                                                    our
                                                    term and
                                                    conditions (copy available upon request).</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-4">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-8">
                                                <h5 style="text-align: right;"><b>SubTotal Ex-VAT:</b></h5>
                                                <h5 style="text-align: right;"><b>Total VAT:</b></h5>
                                                <h5 style="text-align: right;"><b>SubTotal Inc-VAT:</b></h5>
                                            </div>
                                            <div class="col-md-6 col-sm-4">
                                                <h5 style="text-align: right;">
                                                    <b>{{ $currency_code }}{{ number_format($subTotatExVat, 2) }}</b>
                                                </h5>
                                                <h5 style="text-align: right;">
                                                    <b>{{ $currency_code }}{{ number_format($totalVat, 2) }}</b>
                                                </h5>
                                                <h5 style="text-align: right;">
                                                    <b>{{ $currency_code }}{{ number_format($subTotatIncVat, 2) }}</b>
                                                </h5>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- @if ($order->payment_method != 'none')
                                            <tr>
                                                <td colspan="7" align="right"><b>
                                                        @if ($order->payment_method == '2pay')
                                                            Payment Method
                                                        @else
                                                            Payment Mode
                                                        @endif
                                                    </b></td>
                                                <td align="center">
                                                    @if ($order->payment_method == '2pay')
                                                        Wallet
                                                    @else
                                                        {{ ucwords(str_replace('2', 'To ', $order->payment_method)) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif --}}

                                </tbody>
                                </table>
                            </div>

                            <div class="row col-md-12">
                                <table class="table paymentTable" style="margin-top: 10px">
                                    <thead>
                                        <tr>
                                            <th colspan="4" class="text-center">PAYMENT MODE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="text-start">CASH</th>
                                            <th class="text-center">TO-PAY</th>
                                            <th class="text-center">BANK</th>
                                            <th class="text-center">CARD</th>
                                        </tr>
                                    </tbody>
                                </table>
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
    <script type="text/javascript"></script>
@endsection
