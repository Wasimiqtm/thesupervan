<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Add Adjustment</header>
            <div class="panel-body">
                <div class="position-center">

                    <div class="form-group {{ $errors->has('supplier_id') ? 'has-error' : '' }}">
                        {!! Form::label('supplier_id', 'Supplier', ['class' => 'col-md-3 control-label required-input']) !!}
                        <div class="col-md-9">
                            {!! Form::select('supplier_id', $suppliers, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
                            {!! $errors->first('supplier_id', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('product_id') ? 'has-error' : '' }}">
                        {!! Form::label('product_id', 'Product', ['class' => 'col-md-3 control-label required-input']) !!}
                        <div class="col-md-9">
                            {!! Form::select('product_id', $products, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
                            {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('stock_type') ? 'has-error' : '' }}">
                        {!! Form::label('stock_type', 'Type', ['class' => 'col-md-3 control-label required-input']) !!}
                        <div class="col-md-9">
                            {!! Form::select('stock_type', ['1' => 'IN', '2' => 'OUT'], null, [
                                'class' => 'form-control',
                                'required' => 'required',
                            ]) !!}
                            {!! $errors->first('stock_type', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
                        {!! Form::label('quantity', 'Quantity', ['class' => 'col-md-3 control-label required-input']) !!}
                        <div class="col-md-9">
                            {!! Form::number('quantity', 1, [
                                'class' => 'form-control changeCost',
                                'placeholder' => 'Quantity',
                                'min' => '0',
                                'required' => 'required',
                            ]) !!}
                            {!! $errors->first('quantity', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group cost-divs {{ $errors->has('cost') ? 'has-error' : '' }}">
                        {!! Form::label('cost', 'Supplier Cost Per Item', ['class' => 'col-md-3 control-label required-input supplier_cost_per_item']) !!}
                        <div class="col-md-9">
                            {!! Form::number('cost', null, [
                                'class' => 'form-control changeCost',
                                'placeholder' => 'Supplier Cost Per Item',
                                'min' => 0,
                                'step' => 'any',
                                'required' => 'required',
                            ]) !!}
                            {!! $errors->first('cost', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group cost-divs {{ $errors->has('t_cost') ? 'has-error' : '' }}">
                        {!! Form::label('t_cost', 'Supplier Total Cost', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::number('t_cost', null, [
                                'class' => 'form-control supplierTotalCost',
                                'placeholder' => 'Supplier Total Cost',
                                'min' => 0,
                                'step' => 'any',
                                'readonly',
                            ]) !!}
                            {!! $errors->first('t_cost', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group cost-divs {{ $errors->has('t_cost') ? 'has-error' : '' }}">
                        {!! Form::label('ttc', 'Total Transport/Courier', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::number('ttc', null, [
                                'class' => 'form-control totalTransportCourier changeCost',
                                'placeholder' => 'Total Transport/Courier',
                                'min' => 0,
                                'step' => 'any',
                            ]) !!}
                            {!! $errors->first('ttc', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group cost-divs {{ $errors->has('t_cost') ? 'has-error' : '' }}">
                        {!! Form::label('tme', 'Total Misc Expense', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::number('tme', null, [
                                'class' => 'form-control totalMiscExpense changeCost',
                                'placeholder' => 'Total Misc Expense',
                                'min' => 0,
                                'step' => 'any',
                            ]) !!}
                            {!! $errors->first('tme', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group cost-divs {{ $errors->has('aggregate_cost') ? 'has-error' : '' }}">
                        {!! Form::label('cost', 'Aggregate Cost', ['class' => 'col-md-3 control-label required-input']) !!}
                        <div class="col-md-9">
                            {!! Form::number('aggregate_cost', null, [
                                'class' => 'form-control aggregate_cost',
                                'placeholder' => 'Aggregate Cost',
                                'readonly',
                            ]) !!}
                            {!! $errors->first('aggregate_cost', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group cost-divs {{ $errors->has('price') ? 'has-error' : '' }}">
                        {!! Form::label('price', 'Selling Price', ['class' => 'col-md-3 control-label required-input']) !!}
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">£</button>
                                </span>
                                {!! Form::number('price', null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Selling Price',
                                    'min' => 0,
                                    'step' => 'any',
                                    'required' => 'required',
                                ]) !!}
                            </div>
                            {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
                        {!! Form::label('note', 'Note', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => 'Note', 'rows' => '3']) !!}
                            {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', [
                                'class' => 'btn btn-info pull-right',
                            ]) !!}
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>

</div>

@section('scripts')
    <script type="text/javascript">
        var product_select = $('#product_id');
        var store_id = '';
        var oldCost = 0;
        var oldQty = 0;
        var vatType = 0;
        $(document).ready(function() {

            var store_select = $('#store_id');

            $(document).on('blur', '.changeCost', function(e) {
                calculateAgregateCost();
            });

            $(document).on('change', '#product_id', function(e) {

                let _el = $(this);
                var val = this.value;
                if (val > 0) {

                    loadingOverlay(_el);

                    $.ajax({
                        type: "GET",
                        url: '{{ url('admin/get-product-details') }}' + '/' + val,
                        dataType: "json",
                        success: function(data, textStatus, jqXHR) {
                            $(".supplier_cost_per_item").text('Supplier Cost Per Item');
                            $(".supplier_cost_per_item").parent('.form-group').find('input').attr('placeholder', 'Supplier Cost Per Item');

                            if (data.success) {
                                var product = data.product;
                                oldQty = Number(product.quantity.quantity);
                                oldCost = parseFloat(product.cost);
                                vatType = product.vat_type;
                                $(".aggregate_cost").val(oldCost);
                                $("#price").val(product.price);

                                if (vatType == 1) {
                                    $(".supplier_cost_per_item").text('Supplier Cost Per Item (Ex-VAT)');
                                    $(".supplier_cost_per_item").parent('.form-group').find('input').attr('placeholder', 'Supplier Cost Per Item (Ex-VAT)');
                                } else if (vatType == 2) {
                                    $(".supplier_cost_per_item").text('Supplier Cost Per Item (Inc-VAT)');
                                    $(".supplier_cost_per_item").parent('.form-group').find('input').attr('placeholder', 'Supplier Cost Per Item (Inc-VAT)');
                                }

                            } else {
                                errorMessage(data.message);
                            }
                            stopOverlay(_el);
                        }
                    });
                } else {
                    $("#cost").val(0);
                    $("#price").val(0);
                }

            });

            $(document).on('change', '#stock_type', function(e) {
                if ($(this).val() == 1) {
                    $(".cost-divs").show();
                } else {
                    $(".cost-divs").hide();
                }
            });

            // store_select.select2();

            // product_select.select2({
            //     placeholder: "Please select store first",                                
            //   });

            store_select.change(function() {
                store_id = this.value;
                get_products(this.value);
            });

        });

        function calculateAgregateCost() {
            let newQty = Number($("#quantity").val());
            let totalQty = Number(newQty) + Number(oldQty);

            let newCost = parseFloat($("#cost").val());
            let totalCost = parseFloat(oldCost) + parseFloat(newCost);

            let oldTotalCost = oldCost * oldQty;
            let newTotalCost = newCost * newQty;
            //let newAgCost = (oldTotalCost + newTotalCost) / totalQty;

            console.log('oldQty ' + oldQty);
            console.log('newQty ' + newQty);
            console.log('totalQty ' + totalQty);
            console.log('oldCost ' + oldCost);
            console.log('newCost ' + newCost);


            let totalMiscExpense = parseFloat($(".totalMiscExpense").val());
            if (totalMiscExpense > 0) {
                totalMiscExpense = totalMiscExpense;
            } else {
                totalMiscExpense = 0;
            }

            let totalTransportCourier = parseFloat($(".totalTransportCourier").val());
            if (totalTransportCourier > 0) {
                totalTransportCourier = totalTransportCourier;
            } else {
                totalTransportCourier = 0;
            }

            let totalCostExpense = newTotalCost + totalMiscExpense + totalTransportCourier;
            let newAgCost = (oldTotalCost + totalCostExpense) / totalQty;
            console.log('newAgCost ' + newAgCost);

            $(".supplierTotalCost").val(parseFloat(newTotalCost).toFixed(2));
            $(".aggregate_cost").val(parseFloat(newAgCost).toFixed(2));
        }

        function get_products(store_id = "") {

            if (store_id == '') {
                product_select.select2('destroy').empty().select2({
                    placeholder: "Please select store first"
                });
            } else {

                product_select.select2({
                    minimumInputLength: 3,

                    placeholder: "Please select store first",
                    ajax: {
                        url: "{{ url('admin/get-store-products') }}",
                        dataType: 'json',
                        data: function(params) {
                            var query = {
                                search: params.term,
                                store_id: store_id,

                            }

                            // Query parameters will be ?search=[term]&type=public
                            return query;
                        },
                        processResults: function(result) {
                            return {
                                results: result.results
                            };
                        }
                    }
                });
            }
        }
    </script>
@endsection
