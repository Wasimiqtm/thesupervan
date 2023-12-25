<tr class='product_row'>
    <td class="invoice">
        {!! Form::select('product_name[{0}]', $products, null, ['class' => 'form-control select2 products', 'style' => 'width:250px', 'required' => 'required']) !!}
        <label id="product_name[{0}]-error" class="error" for="product_name[{0}]"></label>
        <input type="hidden" name="product_id[{0}]" value="0" class="product_id" />
    </td>
    <td class="exclude_include_vat_tr">
        {!! Form::select('exclude_include_vat[{0}]', ['none' => 'None','ex' => 'Ex VAT','inc' => 'Inc VAT'], null, ['class' => 'form-control exclude_include_vat', 'required' => 'required']) !!}
        <label id="exclude_include_vat[{0}]-error" class="error" for="exclude_include_vat[{0}]"></label>
    </td>
        <td class="exclude_include_vat_tr">
                                        {!! Form::select('price_option[{0}]',  ['Standard Price'=> 'Standard Price' ,
 'Price Matched On Request' =>'Price Matched On Request' ,
  'Reduced To Clear Price'=>'Reduced To Clear Price', 
	'Promotional Offer Price' => 'Promotional Offer Price'], null, ['class' => 'form-control price_option', 'required' => 'required']) !!}
                                        <label id="price_option[{0}]-error" class="error" for="price_option[{0}]"></label>
                                    </td>
    <td class="text-center product_unit_price" data-value="0" data-discounted_price="0" data-tax_rate="0" >
        <input required type='number' style='width:60px' name='product_price[{0}]' class='product_price' value="0" step="any" min="0" />
        <label id="product_price[{0}]-error" class="error" for="product_price[{0}]"></label>
    </td>
    <td class="text-center product_unit_vat">0</td>
    <td class="text-center product_quantity_tr">
        <input required type='number' style='width:50px' name='product_quantity[{0}]' class='product_quantity' value="1" step="1" min="1" />
        <label id="product_quantity[{0}]-error" class="error" for="product_quantity[{0}]"></label>
    </td>
    <td class="text-center quantity_total">0</td>
    <td class="text-center product_total">0</td>
    <td class="text-center"><i class="btn btn-sm fa fa-close removeRow text-danger"></i></td>
</tr>