@extends('admin.layouts.print')

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

    <section id="main-content1">
        <section class="wrapper1">


            <div class="row">
                <div class="col-md-12">
                    <section class="panel">

                        <div class="panel-body invoice" id="printData">


                            <div id="logo" class="logo">

                                <img src="{{ asset('uploads/settings/site_logo.jpg') }}">

                            </div>
                            {{-- <center><h1><u>Invoice</u></h1></center> --}}

                            <div class="row invoice-to">
                                <div class="col-md-6 col-sm-6 pull-left">
                                    <h1>INVOICE</h1>

                                    <p><b>Invoice Date:</b>
                                        @if (is_null($order->order_date))
                                            {{ date('d/m/Y', strtotime($order->created_at)) }}
                                        @else
                                            {{ date('d/m/Y', strtotime($order->order_date)) }}
                                        @endif
                                    </p>
                                    <p><b>Invoice No:</b> {{ sixDigitInvoiceNumber($order->id) }}<br></p>
                                </div>

                                <div class="col-md-4 col-sm-5 pull-right">
                                    <p>VAPEOSONIC LTD</p>
                                    <p>62 High Street, Johnstone, Paisley</p>
                                    <p>Scotland, UK. PA5 8SG</p>
                                    <p>T: 075 63 63 57 57</p>
                                    <p>E: info@thesupervan.co.uk</p>
                                    <p>w: http://www.thesupervan.co.uk</p>
                                </div>
                            </div>
                            <hr />
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
                                    {{-- <p>FONOLOGY LTD</p>
                                    <p>61c Mian Street, Thiornliebank,</p>
                                    <p>Glasgow, G46 7RX </p> --}}
                                </div>
                            </div>

                            <div class="adm-table">
                                <table class="table table-invoice1 table-bordered  " style="margin-top: 10px">
                                    <thead>
                                        <tr>
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
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="invoice">
                                                    <h5>{{ ucwords(strtolower($productName)) }}</h5>
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

                                        <tr>
                                            <td colspan="7" align="right"><b>SubTotal Ex-VAT</b></td>
                                            <td align="center"> {{ $currency_code }}{{ number_format($subTotatExVat, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" align="right"><b>Total VAT</b></td>
                                            <td align="center"> {{ $currency_code }}{{ number_format($totalVat, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" align="right"><b>SubTotal Inc-VAT</b></td>
                                            <td align="center">
                                                {{ $currency_code }}{{ number_format($subTotatIncVat, 2) }}
                                            </td>
                                        </tr>

                                        <tr style="display:none;">
                                            <td colspan="7" align="right"><b>SubTotal Inc-VAT</b></td>
                                            <td align="center"> {{ $currency_code }}
                                                <?php
                                                if (is_numeric($order->amount)) {
                                                    echo number_format($order->amount, 2);
                                                } else {
                                                    echo $order->amount;
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        @if ($order->payment_method != 'none')
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
                                        @endif

                                    </tbody>
                                </table>




                            </div>

                            <div class="row hide">
                                {{-- <h3 style="margin-left:20px;font-size:16px;">VAT Summary</h3> --}}
                                <table class="table table-invoice1 table-bordered  " style="margin-top: 10px">
                                    <thead>
                                        <tr>
                                            <th class="text-center">RATE</th>
                                            <th class="text-center">VAT</th>
                                            <th class="text-center">NET</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            {{-- <td class="text-center">VAT @ {{ number_format($vatRate, 2) }}%</td> --}}
                                            <td class="text-center">{{ getVatName() }}</td>
                                            <td class="text-center">{{ $currency_code }}{{ number_format($totalVat, 2) }}
                                            </td>
                                            <td class="text-center">
                                                {{ $currency_code }}{{ number_format($subTotatExVat, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p><b>Declaration:</b> The goods delivered remain the property of VAPEOSONIC Ltd until
                                        paid in full. Risk passes to buyer upon acceptance of delivery. Overdue accounts
                                        would be subject to interest of 3% per month. All shortages or damages must be
                                        reported with 24 hours of delivery. Goods are supplied subject to our term and
                                        conditions (copy available upon request).</p>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-12">
                                    <p><b>Account Name:</b> VAPEOSONIC LTD</p>
                                    <p><b>Bank Name:</b> Cash Plus</p>
                                    <p><b>Account Currency:</b> GBP</p>
                                    <p><b>A/C No:</b> 08766758</p>
                                    <p><b>Sort Code:</b> 08-71-99</p>
                                    <p><b>Reference:</b> Please Put Your Invoice No as Reference</p>
                                    <p><b>VAT No:</b> 416 9547 70</p>
                                    <p><b>Company REG No:</b> SC737008</p>
                                </div>
                            </div>
                            
                            <br><br>
                            <table style="border: 1px solid black;
  border-collapse: collapse; height: 40px;">
  <tr>
    <th style="border: 1px solid black;
  border-collapse: collapse; height: 40px;">Payment</th>
<th style="border: 1px solid black;
  border-collapse: collapse;">Status</th>
    
  </tr>
  <tr>
    <td style="border: 1px solid black;
  border-collapse: collapse; height: 40px;">Paid by Card</td>
  </tr>
  
  <tr>
  <td style="border: 1px solid black;
  border-collapse: collapse; height: 40px;">Cash Paid</td>
  
  <td style="border: 1px solid black;
  border-collapse: collapse; width : 70px"></td>
  </tr>
  <tr><td style="border: 1px solid black;
  border-collapse: collapse; height: 40px;">Paid in Bank</td>
  <td style="border: 1px solid black;
  border-collapse: collapse;"></td>
  </tr>
  <tr><td style="border: 1px solid black;
  border-collapse: collapse; height: 40px;">To-Pay</td>
  <td style="border: 1px solid black;
  border-collapse: collapse;"></td>
  </tr>
  <tr></tr>
    
  </tr>

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
