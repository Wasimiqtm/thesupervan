@extends('admin.layouts.app')

@section('style')
<style>
    td.invoice ul li span{float: right;}
</style>
@endsection
 
@section('content')
@php

    $cart = @$order->cart;
    $user = unserialize(@$cart->user_details);
    //dd($user);
    $cart_details = unserialize(@$cart->cart_details);



    $trans_details = unserialize(@$order->trans_details);
    $updateData = collect([]);
    if($order->updated_columns){
          $updateData = collect(json_decode($order->updated_columns,true));

    }

    $total_text = 'Due';
    if($cart->payment_status == 'complete'){
        $total_text = 'Paid';
    }

    $currency = getDefaultCurrency();
    $currency_code = @$currency->code;
    $subtotal = 0;
    $courier=0;
    $courierAmout =0;
@endphp

<section id="main-content" >
    <section class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                     <li><a href="{{ url('admin/admin-orders') }}"> Quotations</a></li>
                    <li class="active">Quotation</li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>

                  <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <!--<a id='printMe'  onclick="printDiv('printData');" style="padding: 10px;float: right;font-size: large;cursor: pointer">-->
                    <a   href="{{ url('admin/admin-order-print/'. Hashids::encode($order->id)) }}" target="_blank" style="padding: 10px;float: right;font-size: large;cursor: pointer">
                       <i class="fa fa-print"></i>
                    </a>
                    <div class="panel-body invoice" id="printData">

                        <div class="row invoice-to">
                            <div class="col-md-6 col-sm-6 pull-left">

                                {!! adminDetails() !!}

                                <h4>Customer Details:</h4>
                                <p>
                                    <b>Account No:</b> {{ @$user['customer_id'] }}<br>
                                    <b>Business Name:</b> {{ @$user['company_name'] }}<br>
                                    <b>Phone:</b> {{ (@$user['contact_no']) ? $user['contact_no'] : @$user['phone'] }}<br>
                                    @if(@$user['email'])
                                    <b>Email:</b> {{$user['email'] }}<br>
                                    @endif
                                    <b>Address:</b> {{ @$user['address'] }}
                                </p>
                            </div>
                            <div class="col-md-4 col-sm-5 pull-right">
                                <div class="row">
                                    <div class="col-md-4 col-sm-5 inv-label">Performa Invoice #:</div>
                                    <div class="col-md-8 col-sm-7">{{ sixDigitQuotationNumber($order->id) }}</div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-sm-5 inv-label">Date #:</div>
                                    @if (is_null($order->order_date))
                                    <div class="col-md-8 col-sm-7">{{ date('d-m-Y h:i a', strtotime($order->created_at)) }}</div>
                                    @else
                                    <div class="col-md-8 col-sm-7">{{ date('d-m-Y', strtotime($order->order_date)) }}</div>
                                    @endif
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 inv-label">
                                        <h3>Total {{$total_text}}</h3>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <h1 class="amnt-value">{{ $currency_code }}
                                            <?php
                                            if (is_numeric($order->amount)) {
                                                echo number_format($order->amount,2);
                                            } else {
                                                echo $order->amount;
                                            }
                                            ?>
                                        </h1>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <form action="{{route('admin.update.invoice')}}" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="{{$order->id}}">
  <div class="adm-table">
                        <table class="table table-invoice" >
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


                            @foreach($cart_details as $single_item)

                            @php
                                $single_item = (array)$single_item;
                                $unit_price = $single_item['price'];
                                
                                if(@$single_item['exclude_include_vat'] == 'ex') {
                                    $add = 1.2;
                                    $unit_price = $single_item['price'] * $add;
                                }
                                
                                $item_sub_total = $unit_price * $single_item['quantity'];
                                $subtotal = ($subtotal + $item_sub_total);
                                $item_discount = (@$single_item['item_discount'])?$single_item['item_discount']:0;
                                $item_sub_total = $item_sub_total - $item_discount;
                                $item_sub_total = $item_sub_total + $courier;
                                $priceOptions = isset($single_item['price_options'])?$single_item['price_options']:'';
                                  $productName = $single_item['name'];
                                  $price = number_format($unit_price,2);
                                if($updateData->contains('id',$single_item['id'])){
                                   $dataRecieve = $updateData->firstWhere('id',$single_item['id']);
                                   $productName = $dataRecieve['name'];
                                   $price = $dataRecieve['price'];
                                }
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="invoice"><h4>{{ ucwords(strtolower($productName)) }}</h4></td>
                                <input type="hidden" name="product_id[]" value="{{$single_item['id']}}">
                                <td class="text-center">{{$priceOptions}}</td>
                                 <td class="text-center">{{$currency_code}} {{$price}}</td>
                                <td class="text-center">{{$single_item['quantity']}}</td>
                                <td class="text-center">{{$currency_code}}{{number_format($item_sub_total,2)}}</td>
                            </tr>


                            @endforeach


                            </tbody>
                        </table>
                    </div>    
                        </form>
                        <div class="row">
                            <div class="col-md-8 col-xs-7 payment-method">
                                <h4>Payment</h4>
                                @php
                                    $payment_method = @$trans_details['payer'];
                                    $payment_status = 'Pending';
                                    $payment_class = 'label-danger';

                                    if($cart->payment_status == 'complete'){
                                        $payment_status = 'Paid';
                                        $payment_class = 'label-success';
                                    }
                                    
                                    $tax = $order['tax'];
                                    if (!is_string($tax)) {
                                        $tax = number_format($tax,2);
                                    }
                                @endphp
                                @if($order->payment_method == '2pay')
                                <p>Payment Method : Wallet</p> 
                                <p>Payment Mode : To Pay</p>
                                @elseif($order->payment_method != 'none')
                                <p>Payment Mode : {{ ucwords($order->payment_method) }}</p>
                                @endif


                                <h4>Profit</h4>
                                <p>{{$currency_code}}{{ ($order->amount - $order->cost_of_goods) }}</p>
                            </div>
                            <div class="col-md-4 col-xs-5 invoice-block pull-right">
                                <ul class="unstyled amounts">
                                    <li style="display:none;">Gross Total : {{$currency_code}}{{number_format($subtotal,2)}}</li>
                                    <li style="display:none;">Discount : {{$currency_code}}{{number_format($order['discount'],2)}} </li>
                                    <li style="display:none;">Vat : {{$currency_code}}{{ $tax }} </li>
                                    <li class="grand-total">Total : {{$currency_code}}
                                        <?php
                                            if (is_numeric($order->amount)) {
                                                echo number_format($order->amount,2);
                                            } else {
                                                echo $order->amount;
                                            }
                                            ?>
                                        </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-6">
                                <a href="{{ url('admin/admin-orders/quotation/' . Hashids::encode($order->id)) }}" class="btn btn-info pull-right admin-order-btn" >Generate Invoice</a>
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
    $(document).on('change', '.couriers', function (e)
   {
        e.preventDefault();
        var cart_id = {{@$order->cart_id}};
        var courier_id = $(this).val();
        var product_id = $(this).attr('data-product_id');

        console.log('cart_id '+cart_id+' courier_id '+courier_id+' product_id '+product_id);

        $.ajax({
            url:"{{url('admin/invoice/update-product-courier')}}",
            type:"post",
            data:{cart_id:cart_id, courier_id:courier_id, product_id:product_id},
            success:function (res) {
                if (res == 'true') {
                    success_message("Courier sucessfully updated");
                }
            },
            error: function (request, status, error) {
                error_message(request.responseText);
            }
        });

    });


</script>

@endsection



