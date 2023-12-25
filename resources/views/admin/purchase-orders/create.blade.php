@extends('admin.layouts.app')

@section('style')
<style>
    td.invoice ul li span{float: right;}
    label.error{color: #950606;font-weight: 500 !important;}
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
                     <li><a href="{{ url('admin/purchase-orders') }}"> Purchase Orders</a></li>
                    <li class="active">Purchase Order</li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>

                  <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body invoice" id="printData">
                            
                        <form id="applicationForm" action="{{ route('admin.purchase-orders.store') }}" method="post">
                        @csrf
                        
                        {{-- <input type="hidden" name="supplier_id" value="{{$supplier->id}}" /> --}}
                        <div class="row invoice-to">
                            <div class="col-md-6 col-sm-6 pull-left">

                                <h4>Supplier Details:</h4>
                                <p>
                                    <select name="supplier_id" class="form-control" style="width: 250px;">
                                        <option value="0"> Select Supplier</option>
                                        @foreach($suppliers as $supplierr)
                                        <option value="{{  $supplierr->id }}" {{  ($supplierr->id == @$supplier->id) ? 'selected': '' }}>{{  $supplierr->name }}</option>
                                        @endforeach
                                        
                                    </select>
                                    
                                    
                                    {{-- <b>Supplier Code:</b> {{$supplier->code}}<br>
                                    <b>Supplier Name:</b> {{$supplier->name}}<br> --}}
                                </p>
                            </div>
                            <div class="col-md-4 col-sm-5 pull-right">
                                <div class="row">
                                    <div class="col-md-4 col-sm-5 inv-label">Date #</div>
                                    <div class="col-md-8 col-sm-7">{{ date('d-m-Y') }}</div>
                                </div>
                            </div>
                        </div>
                        

                        <table class="table table-invoice" >
                            <thead>
                            <tr>
                                <th>Item Description</th>
                                <th class="text-center">Total Quantity</th>
                                <th class="text-center">Unit Cost</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total</th>
                                <th class="text-center"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $key => $product)
                                <?php
                                    $quantity = 0;
                                    if (@$product->store_products[0]) {
                                        $quantity = $product->store_products[0]->quantity;
                                    }
                                    $productId = $product->id;
                                    $unitCost = $sUnitCost = 0;
                                    // if ($supplier->id == $product->supplier_id) {
                                    //     $sUnitCost = $product->supplier_cost_1;
                                    // } else if ($supplier->id == $product->supplier_id_2) {
                                    //     $sUnitCost = $product->supplier_cost_2;
                                    // } else if ($supplier->id == $product->supplier_id_3) {
                                    //     $sUnitCost = $product->supplier_cost_3;
                                    // } else if ($supplier->id == $product->supplier_id_4) {
                                    //     $sUnitCost = $product->supplier_cost_4;
                                    // }
                                    if ($unitCost == 0) {
                                        $unitCost = $product->cost;
                                    }
                                    
                                    // if ($quantity>0) {
                                ?>
                                <tr class='product_row'>
                                    <td class="invoice">
                                        <h4>{{ $product->name }}  ({{ number_format($sUnitCost, 2) }})</h4>
                                    </td>
                                    <td class="text-center">{{ $quantity }}</td>
                                    <td class="text-center product_unit_price" >
                                        <input required type='number' style='width:60px' name='products[{{$productId}}][price]' class='product_price' value="{{ $unitCost }}" step="any" min="0" />
                                        <label id="products[{{$productId}}][price]-error" class="error" for="products[{{$productId}}][price]"></label>
                                    </td>
                                    <td class="text-center product_quantity_tr">
                                        <input required type='number' style='width:50px' name='products[{{$productId}}][quantity]' class='product_quantity' value="0" step="1" min="0" />
                                        <label id="products[{{$productId}}][quantity]-error" class="error" for="products[{{$productId}}][quantity]"></label>
                                    </td>
                                    <td class="text-center product_total">0</td>
                                    <td class="text-center"><i class="btn btn-sm fa fa-close removeRow text-danger"></td>
                                </tr>
                                <?php //} ?>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div class="row">
                            <div class="col-md-4 col-xs-5 invoice-block pull-right">
                                <ul class="unstyled amounts">
                                    <li style="display: none;">Gross Total: <span class="gross_total">0</span></li>
                                    <li style="display: none;">Discount :   <span class="total_discount">0</span></li>
                                    <li style="display: none;">Vat :   <span class="total_vat">0</span></li>
                                    <li class="grand-total">Total :  <span class="total_amount">0</span></li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-6">
                                {!! Form::submit('Create Purchase Order', ['class' => 'btn btn-info pull-right admin-order-btn']) !!}
                            </div>
                        </div>    
                            
                        </form>
                    </div>
                </section>
            </div>
        </div>



    </section>
</section>

@endsection

@section('scripts')
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/lodash.min.js') }}"></script>
<script type="text/javascript">
    
    var i = 1;
    var products = [];
    var taxRate = {{ getVatCharges() }};
    $(document).ready(function () {
        $("#applicationForm").validate({
            rules : {},
            submitHandler: function(form) {
                
                let _form = $(form);
                let _loader = $("body");
                let formData = _form.serialize();
                loadingOverlay(_loader);
                $.ajax({
                    type: _form.attr('method'),
                    url: _form.attr('action'),
                    processData: false,
                    //contentType: false,
                    //dataType: 'json',
                    data: formData,
                    success:function (res) {
                        //return false;
                        successMessage(res.message);
                        stopOverlay(_loader);
                        setTimeout(function() {
                            window.location = "{{ route('admin.purchase-orders.index') }}";
                        }, 2000);
                    },
                    error: function (request, status, error) {
                        stopOverlay(_loader);
                        showAjaxErrorMessage(request, true);
                    },complete: function() {
                        $(".admin-order-btn").prop('disabled', false);
                    }
                }); 
            }
    });
        
        calculateAmount();
        
        $(document).on('change', '.product_quantity', function (e) {
            // var val = parseInt(this.value);
            // var max = parseInt($(this).attr('max'));
            
            // if (val > max) {
            //     $(this).val(max);
            // }
            
            calculateAmount();
        });
        
        $(document).on('change', '.product_price', function (e) {
            calculateAmount();
        });
        
        $(document).on('click', '.removeRow', function() {
            var _parent = $(this).parents('.product_row');
            var productId = _parent.find(".products").val();
            _.remove(products, function(n) {
                return n == productId;
            });
            _parent.remove();
            calculateAmount();
        });
    });
    
    function calculateAmount() {
        
        var grossTotal = 0;
        var totalDiscount = 0;
        var totalVat = 0;
        var totalAmount = 0;
        
        $('.table-invoice tbody tr.product_row').each(function() {
            let _product = $(this);

            //var productUnitPrice = _product.find('.product_unit_price').attr('data-value');
            var productUnitPrice = _product.find('.product_price').val();
            var quantity = parseInt(_product.find('.product_quantity').val());

            if (productUnitPrice > 0 && quantity > 0) {
                var productTotal = productUnitPrice*quantity;
                _product.find(".product_total").text(productTotal);

                grossTotal = grossTotal + productTotal;
                totalDiscount = totalDiscount + (productUnitPrice * quantity);
                if (taxRate > 0) {
                    totalVat = totalVat + (((taxRate / 100) * productUnitPrice) * quantity);
                }
            }
        });
        //totalAmount = (grossTotal - totalDiscount) + totalVat;
        totalAmount = grossTotal;
        $(".gross_total").text((grossTotal>0) ? grossTotal.toFixed(2) : 0);
        $(".total_discount").text((totalDiscount>0) ? totalDiscount.toFixed(2) : 0);
        $(".total_vat").text((totalVat>0) ? totalVat.toFixed(2) : 0);
        $(".total_amount").text((totalAmount>0) ? totalAmount.toFixed(2) : 0);
    }
    
</script>

@endsection



