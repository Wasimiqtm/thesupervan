@section('style')
    <link href="{{ asset('css/dropzone.css') }}" rel="stylesheet">
    <link href="{{ asset('css/gijgo.min.css') }}" rel="stylesheet">
    <style>

    </style>
@endsection

@php($current_tab = app('request')->input('tab'))
@switch($current_tab)
    @case(1)
        @php($tab1 = 'active')
        @php($tab2 = '')
        @php($tab3 = '')
    @break

    @case(2)
        @php($tab1 = '')
        @php($tab2 = 'active')
        @php($tab3 = '')
    @break

    @case(3)
        @php($tab1 = '')
        @php($tab2 = '')
        @php($tab3 = 'active')
    @break

    @default
        @php($tab1 = 'active')
        @php($tab2 = '')
        @php($tab3 = '')
@endswitch

<ul class="nav nav-tabs">
    @if (!isset($submitButtonText))
        <li class="{{ $tab1 }}"><a href="{{ url('admin/products/create') }}">Product Information</a></li>
    @else
        <li class="{{ $tab1 }}"><a
                href="{{ url('admin/products/' . Hashids::encode($product->id) . '/edit?tab=1') }}">Product
                Information</a>
        </li>
        <!--<li class="{{ $tab2 }}"><a href="{{ url('admin/products/' . Hashids::encode($product->id) . '/edit?tab=2') }}">Store & Categories</a></li>-->

        @if ($product->is_variants == 1)
            <li><a href="{{ url('admin/products/' . Hashids::encode($product->id) . '/edit?tab=2') }}">Variants</a></li>
        @endif
    @endif
</ul>

<div class="tab-content">
    @if (!empty($tab1))
        <div id="home" class="tab-pane fade in {{ $tab1 }}">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <div class="panel-body">

                            <div class="row">
                                <div class="form-group col-md-2 {{ $errors->has('code') ? 'has-error' : '' }}">
                                    {!! Form::label('code', 'Product Bar Code', ['class' => 'control-label required-input']) !!}
                                    <div class="input-group">
                                        {!! Form::text('code', null, [
                                            'class' => 'form-control',
                                            'placeholder' => 'Product Code',
                                            'required' => 'required',
                                        ]) !!}
                                        <span class="input-group-addon pointer" id="genrate_random_number"><i
                                                class="fa fa-random"></i></span>
                                    </div>
                                    <!--                            <span class="help-block">You can scan your barcode and select the correct symbology below.</span>-->
                                    {!! $errors->first('code', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-2 {{ $errors->has('item_code') ? 'has-error' : '' }}">
                                    {!! Form::label('item_code', 'Item Code', ['class' => 'control-label']) !!}
                                    {!! Form::text('item_code', null, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Item Code',
                                    ]) !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-md-3 {{ $errors->has('name') ? 'has-error' : '' }}">
                                    {!! Form::label('name', 'Product Name', ['class' => 'control-label required-input']) !!}
                                    {!! Form::text('name', null, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Product Name',
                                        'required' => 'required',
                                    ]) !!}
                                    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-md-3 {{ $errors->has('slug') ? 'has-error' : '' }}">
                                    {!! Form::label('slug', 'Slug', ['class' => 'col-md-3 control-label']) !!}
                                    {!! Form::text('slug', null, ['class' => 'form-control', 'rows' => '3', 'placeholder' => 'Slug']) !!}
                                    {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-md-2 {{ $errors->has('brand_id') ? 'has-error' : '' }}">
                                    {!! Form::label('brand_id', 'Brand Name', ['class' => 'control-label']) !!}
                                    {!! Form::select('brand_id', $brands, null, ['class' => 'form-control select2']) !!}
                                    {!! $errors->first('brand_id', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>

                                {{-- <div class="form-group col-md-3 {{ $errors->has('barcode_symbology') ? 'has-error' : ''}}">
                                    {!! Form::label('barcode_symbology', 'Barcode Symbology', ['class' => 'control-label required-input']) !!}
                                    {!! Form::select('barcode_symbology', ['code25'=>'Code25','code39'=>'Code39','code128'=>'Code128','ean8'=>'EAN8','ean13'=>'EAN13','upca'=>'UPC-A','upce'=>'UPC-E'],null, ['class' => 'form-control select2','required' => 'required']) !!}
                                    {!! $errors->first('barcode_symbology', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div> --}}
                            </div>

                            <div class="row modifier_select">
                                <div class="form-group col-md-3" style="margin-left: 18px;" id="is_variants_text">
                                    <input id="is_variants" name="is_variants" type="checkbox" value="1"
                                        {{ @$product->is_variants == 1 ? 'checked' : '' }}> <b>This product has
                                        variants</b>
                                </div>
                            </div>


                            <?php
                            $suppliers = getSuppliersDropdown();
                            ?>
                            @for ($i = 1; $i <= 4; $i++)
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        {!! Form::label('supplier_id', 'Supplier Name ' . $i, ['class' => 'control-label']) !!}
                                        {!! Form::select('supplier_id_' . $i, $suppliers, null, ['class' => 'form-control select2 supplier_ids']) !!}
                                    </div>
                                    <div class="form-group col-md-3">
                                        {!! Form::label('quantity', 'Quantity ' . $i, ['class' => 'control-label']) !!}
                                        {!! Form::number('supplier_quantity_' . $i, null, [
                                            'class' => 'form-control supplier_quantities supplier_quantity_' . $i,
                                            'placeholder' => 'Quantity ' . $i,
                                            'min' => 0,
                                            'step' => 1,
                                        ]) !!}
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-md-2 hide">
                                        {!! Form::label('cost', 'Product Cost Ex VAT ' . $i, ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">£</button>
                                            </span>
                                            {!! Form::number('supplier_cost_ex_vat_' . $i, null, [
                                                'class' => 'form-control supplier_ex_vat_costs supplier_ex_vat_cost_' . $i,
                                                'placeholder' => 'Product Cost Ex VAT ' . $i,
                                                'step' => 'any',
                                            ]) !!}
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        {!! Form::label('cost', 'Product Cost ' . $i, ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">£</button>
                                            </span>
                                            {!! Form::number('supplier_cost_' . $i, null, [
                                                'class' => 'form-control supplier_costs supplier_cost_' . $i,
                                                'placeholder' => 'Product Cost ' . $i,
                                                'step' => 'any',
                                            ]) !!}
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-md-2 hide">
                                        {!! Form::label('total_cost', 'Total Cost EX VAT ' . $i, ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">£</button>
                                            </span>
                                            {!! Form::number('total_cost_ex_vat_' . $i, null, [
                                                'class' => 'form-control total_ex_vat_costs total_ex_vat_cost_' . $i,
                                                'placeholder' => 'Total Cost Ex VAT ' . $i,
                                                'step' => 'any',
                                            ]) !!}
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        {!! Form::label('total_cost', 'Total Cost ' . $i, ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">£</button>
                                            </span>
                                            {!! Form::number('total_cost_' . $i, null, [
                                                'class' => 'form-control total_costs total_cost_' . $i,
                                                'placeholder' => 'Total Cost ' . $i,
                                                'step' => 'any',
                                            ]) !!}
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            @endfor

                            <div class="row modifier_select">



                                <div class="form-group col-md-3 {{ $errors->has('quantity') ? 'has-error' : '' }}">
                                    {!! Form::label('quantity', 'Quantity', ['class' => 'control-label required-input']) !!}
                                    {!! Form::number('quantity', null, [
                                        'class' => 'form-control',
                                        'min' => 0,
                                        'step' => 1,
                                        'placeholder' => 'Quantity',
                                    ]) !!}
                                    {!! $errors->first('quantity', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div
                                    class="form-group col-md-3 hide hide_cost {{ $errors->has('cost') ? 'has-error' : '' }}">
                                    {!! Form::label('excluded_vat_cost', 'Product Cost EX VAT', ['class' => 'control-label required-input']) !!}
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">£</button>
                                        </span>
                                        {!! Form::number('excluded_vat_cost', null, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'placeholder' => 'Product Cost EX VAT',
                                            'step' => 'any',
                                        ]) !!}
                                    </div>
                                    {!! $errors->first('cost', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-3 {{ $errors->has('vat_type') ? 'has-error' : '' }}">
                                    {!! Form::label('vat_type', 'VAT Type', ['class' => 'control-label required-input']) !!}
                                    {!! Form::select('vat_type', ['' => 'Select VAT Type', '1' => 'EX-VAT', '2' => 'INC-VAT'], null, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ]) !!}
                                    {!! $errors->first('vat_type', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div
                                    class="form-group col-md-3 hide_cost {{ $errors->has('cost') ? 'has-error' : '' }}">
                                    {!! Form::label('cost', 'Product Cost', ['class' => 'control-label required-input']) !!}
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">£</button>
                                        </span>
                                        {!! Form::number('cost', null, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'placeholder' => 'Product Cost',
                                            'step' => 'any',
                                        ]) !!}
                                    </div>
                                    {!! $errors->first('cost', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div
                                    class="form-group col-md-3 hide hide_price {{ $errors->has('price') ? 'has-error' : '' }}">
                                    {!! Form::label('excluded_vat_price', 'Selling Price EX VAT', ['class' => 'control-label required-input']) !!}
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">£</button>
                                        </span>
                                        {!! Form::number('excluded_vat_price', null, [
                                            'class' => 'form-control',
                                            'placeholder' => 'Selling Price EX VAT',
                                            'min' => 0,
                                            'step' => 'any',
                                            'required' => 'required',
                                        ]) !!}
                                    </div>
                                    {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div
                                    class="form-group col-md-3 hide_price {{ $errors->has('price') ? 'has-error' : '' }}">
                                    {!! Form::label('price', 'Selling Price', ['class' => 'control-label required-input']) !!}
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

                            <div class="row">
                                <div class="form-group col-md-3 {{ $errors->has('tax_rate_id') ? 'has-error' : '' }}">
                                    {!! Form::label('tax_rate_id', 'Product Tax', ['class' => 'control-label required-input']) !!}
                                    @if (isset($product))
                                        {!! Form::select('tax_rate_id', getTaxRatesDropdown(), null, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                        ]) !!}
                                    @else
                                        {!! Form::select('tax_rate_id', getTaxRatesDropdown(), null, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                        ]) !!}
                                    @endif
                                    {!! $errors->first('tax_rate_id', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>


                                <div
                                    class="form-group col-md-3 {{ $errors->has('discount_type') ? 'has-error' : '' }}">
                                    {!! Form::label('discount_type', 'Discount Type', ['class' => 'control-label']) !!}
                                    {!! Form::select('discount_type', ['0' => 'Select Discount Type', '1' => 'Percentage', '2' => 'Fixed'], null, [
                                        'class' => 'form-control',
                                    ]) !!}
                                    {!! $errors->first('discount_type', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-3 {{ $errors->has('discount') ? 'has-error' : '' }}">
                                    {!! Form::label('discount', 'Max Discount', ['class' => 'control-label']) !!}
                                    {!! Form::number('discount', null, ['class' => 'form-control', 'placeholder' => 'Max Discount', 'min' => '0']) !!}
                                    {!! $errors->first('discount', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-3 {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                    {!! Form::label('category_id', 'Category', ['class' => 'control-label required-input']) !!}
                                    {!! Form::select('category_id', getParentCategories()->prepend('Select Category', 0), null, [
                                        'class' => 'form-control select2 changescategory',
                                    ]) !!}
                                    {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div
                                    class="form-group col-md-3 {{ $errors->has('sub_category_id') ? 'has-error' : '' }}">
                                    {!! Form::label('sub_category_id', 'Sub Category', ['class' => 'control-label required-input']) !!}
                                    {!! Form::select('sub_category_id', [], null, ['class' => 'form-control select2 subcategory']) !!}
                                    {!! $errors->first('sub_category_id', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-3 {{ $errors->has('shipping_id') ? 'has-error' : '' }}">
                                    {!! Form::label('shipping_id', 'Shipping Charges', ['class' => 'control-label required-input']) !!}
                                    {!! Form::select('shipping_id', $shippings, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
                                    {!! $errors->first('shipping_id', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>


                                <div
                                    class="form-group col-md-2 {{ $errors->has('new_arrivals') ? 'has-error' : '' }}">
                                    {!! Form::label('new_arrivals', 'New Arrivals', ['class' => 'control-label required-input']) !!}
                                    {!! Form::select('new_arrivals', ['1' => 'Yes', '0' => 'No'], null, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ]) !!}
                                    {!! $errors->first('new_arrivals', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-2 {{ $errors->has('is_featured') ? 'has-error' : '' }}">
                                    {!! Form::label('is_featured', 'Is Featured', ['class' => 'control-label required-input']) !!}
                                    {!! Form::select('is_featured', ['1' => 'Yes', '0' => 'No'], null, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ]) !!}
                                    {!! $errors->first('is_featured', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-2 {{ $errors->has('is_hot') ? 'has-error' : '' }}">
                                    {!! Form::label('is_hot', 'Is Hot', ['class' => 'control-label required-input']) !!}
                                    {!! Form::select('is_hot', ['1' => 'Yes', '0' => 'No'], null, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ]) !!}
                                    {!! $errors->first('is_hot', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div
                                    class="form-group col-md-4 modifier_select {{ $errors->has('tags') ? 'has-error' : '' }}">
                                    {!! Form::label('tags', 'Tags', ['class' => 'control-label ']) !!}
                                    {!! Form::textarea('tags', isset($product) ? $product->product_tags->pluck('name')->implode(',') : '', [
                                        'class' => 'form-control',
                                    ]) !!}
                                    {!! $errors->first('tags', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-4 {{ $errors->has('meta_title') ? 'has-error' : '' }}">
                                    {!! Form::label('meta_title', 'Meta Title', ['class' => 'col-md-3 control-label']) !!}
                                    {!! Form::textarea('meta_title', null, ['class' => 'form-control', 'rows' => '3']) !!}
                                    {!! $errors->first('meta_title', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div
                                    class="form-group col-md-4 {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                                    {!! Form::label('meta_description', 'Meta Description', ['class' => 'col-md-5 control-label']) !!}
                                    {!! Form::textarea('meta_description', null, ['class' => 'form-control', 'rows' => '3']) !!}
                                    {!! $errors->first('meta_description', '<p class="help-block">:message</p>') !!}
                                    <div class="help-block with-errors"></div>
                                </div>


                                <div class="row modifier_select">
                                    <div class="form-group col-md-12">
                                        {!! Form::label('images', 'Product Images', ['class' => 'control-label']) !!}
                                        <div class="dropzone {{ isset($product) ? 'dz-started' : '' }}"
                                            id="my-awesome-dropzone">
                                            @include('admin.products.imagelist')
                                        </div>
                                        <input id="total_images" name="product_images"
                                            value="{{ isset($product) ? $product->product_images->count() : '' }}"
                                            style="display:none;" type="text">
                                        <div class="help-block with-errors"style="margin-left: 10px;"></div>
                                    </div>
                                </div>

                                <div class="row modifier_select">
                                    <div class="form-group col-md-12 {{ $errors->has('detail') ? 'has-error' : '' }}">
                                        {!! Form::label('detail', 'Product Details', ['class' => 'control-label']) !!}
                                        {!! Form::textarea('detail', null, ['class' => 'form-control']) !!}
                                        {!! $errors->first('detail', '<p class="help-block">:message</p>') !!}
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <!--                                  <div class="form-group col-md-6 {{ $errors->has('invoice_detail') ? 'has-error' : '' }}">
                                    {!! Form::label('invoice_detail', 'Product Details for Invoice', ['class' => 'control-label']) !!}
                                        {!! Form::textarea('invoice_detail', null, ['class' => 'form-control']) !!}
                                        {!! $errors->first('invoice_detail', '<p class="help-block">:message</p>') !!}
                                        <div class="help-block with-errors"></div>
                                  </div> -->
                                </div>

                                <div class="row modifier_select">
                                    <div
                                        class="form-group col-md-6 {{ $errors->has('full_detail') ? 'has-error' : '' }}">
                                        {!! Form::label('full_detail', 'Product Full Details', ['class' => 'control-label']) !!}
                                        {!! Form::textarea('full_detail', null, ['class' => 'form-control']) !!}
                                        {!! $errors->first('full_detail', '<p class="help-block">:message</p>') !!}
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div
                                        class="form-group col-md-6 {{ $errors->has('tecnical_specs') ? 'has-error' : '' }}">
                                        {!! Form::label('tecnical_specs', 'Technical Specification', ['class' => 'control-label']) !!}
                                        {!! Form::textarea('tecnical_specs', null, ['class' => 'form-control']) !!}
                                        {!! $errors->first('tecnical_specs', '<p class="help-block">:message</p>') !!}
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        {!! Form::submit('Save', ['class' => 'btn btn-info pull-right']) !!}
                                    </div>
                                </div>
                            </div>
                    </section>
                </div>
            </div>
        </div>
    @endif
</div>

@section('scripts')
    <!--<script type="text/javascript" src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>-->
    <script src="//cdn.ckeditor.com/3.8.0/full/ckeditor.js"></script>
    @if (!empty($tab1))
        <script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>
    @endif
    <script type="text/javascript" src="{{ asset('js/gijgo.min.js') }}"></script>
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
        var baseUrl = "{{ url('admin/products') }}";
        var category_select = $('#category_id');
        var category_id = "{{ $product->category_id ?? '' }}";
        var sub_category_id = "{{ $product->sub_category_id ?? '' }}";
        var add = 1.2;
        var less = 0.833333333;

        function calculateSupplierCost(el) {
            var _el = el[0];
            var classes = _el.classList;

            var c, q, sc1, sc2, sc3, sc4, sq1, sq2, sq3, sq4, tc1, tc2, tc3, tc4, tevc1, tevc2, tevc3, tevc4;
            c = q = sc1 = sc2 = sc3 = sc4 = sq1 = sq2 = sq3 = sq4 = tc1 = tc2 = tc3 = tc4 = tevc1 = tevc2 = tevc3 = tevc4 =
                0;
            var sevc1 = $('.supplier_ex_vat_cost_1').val();
            var sc1 = $('.supplier_cost_1').val();
            var sevc2 = $('.supplier_ex_vat_cost_2').val();
            var sc2 = $('.supplier_cost_2').val();
            var sevc3 = $('.supplier_ex_vat_cost_3').val();
            var sc3 = $('.supplier_cost_3').val();
            var sevc4 = $('.supplier_ex_vat_cost_4').val();
            var sc4 = $('.supplier_cost_4').val();
            var sq1 = $('.supplier_quantity_1').val();
            var sq2 = $('.supplier_quantity_2').val();
            var sq3 = $('.supplier_quantity_3').val();
            var sq4 = $('.supplier_quantity_4').val();

            if (sc1 > 0 || sc2 > 0 || sc3 > 0 || sc4 > 0) {
                c++;
            }
            if (sq1 > 0 || sq2 > 0 || sq3 > 0 || sq4 > 0) {
                q++;
            }

            if (sq1 > 0) {
                sq1 = parseInt(sq1);

                var sq1F = jQuery.inArray("supplier_quantity_1", classes) != -1;
                var sevc1F = jQuery.inArray("supplier_ex_vat_cost_1", classes) != -1;
                var sc1F = jQuery.inArray("supplier_cost_1", classes) != -1;

                if ((sq1F || sevc1F) && sevc1 > 0) {
                    sc1 = parseFloat(sevc1) * add;
                    $('.supplier_cost_1').val(sc1.toFixed(2));
                }


                if ((sq1F || sc1F) && sc1 > 0) {
                    sevc1 = parseFloat(sc1 * less);
                    $('.supplier_ex_vat_cost_1').val(sevc1.toFixed(2));
                }

                tevc1 = parseFloat(sevc1) * sq1;
                tc1 = parseFloat(sc1) * sq1;
            } else {
                sq1 = 0;
            }

            $('.total_cost_1').val(tc1.toFixed(2));
            $('.total_ex_vat_cost_1').val(tevc1.toFixed(2));

            if (sq2 > 0) {
                sq2 = parseInt(sq2);

                var sq2F = jQuery.inArray("supplier_quantity_2", classes) != -1;
                var sevc2F = jQuery.inArray("supplier_ex_vat_cost_2", classes) != -1;
                var sc2F = jQuery.inArray("supplier_cost_2", classes) != -1;

                if ((sq2F || sevc2F) && sevc2 > 0) {
                    sc2 = parseFloat(sevc2) * add;
                    $('.supplier_cost_2').val(sc2.toFixed(2));
                }
                if ((sq2F || sc2F) && sc2 > 0) {
                    sevc2 = parseFloat(sc2 * less);
                    $('.supplier_ex_vat_cost_2').val(sevc2.toFixed(2));
                }

                tevc2 = parseFloat(sevc2) * sq2;
                tc2 = parseFloat(sc2) * sq2;
            } else {
                sq2 = 0;
            }

            $('.total_cost_2').val(tc2.toFixed(2));
            $('.total_ex_vat_cost_2').val(tevc2.toFixed(2));

            if (sq3 > 0) {
                sq3 = parseInt(sq3);

                var sq3F = jQuery.inArray("supplier_quantity_3", classes) != -1;
                var sevc3F = jQuery.inArray("supplier_ex_vat_cost_3", classes) != -1;
                var sc3F = jQuery.inArray("supplier_cost_3", classes) != -1;

                if ((sq3F || sevc3F) && sevc3 > 0) {
                    sc3 = parseFloat(sevc3) * add;
                    $('.supplier_cost_3').val(sc3.toFixed(2));
                }
                if ((sq3F || sc3F) && sc3 > 0) {
                    sevc3 = parseFloat(sc3 * less);
                    $('.supplier_ex_vat_cost_3').val(sevc3.toFixed(2));
                }

                tevc3 = parseFloat(sevc3) * sq3;
                tc3 = parseFloat(sc3) * sq3;
            } else {
                sq3 = 0;
            }

            $('.total_cost_3').val(tc3.toFixed(2));
            $('.total_ex_vat_cost_3').val(tevc3.toFixed(2));

            if (sq4 > 0) {
                sq4 = parseInt(sq4);

                var sq4F = jQuery.inArray("supplier_quantity_4", classes) != -1;
                var sevc4F = jQuery.inArray("supplier_ex_vat_cost_4", classes) != -1;
                var sc4F = jQuery.inArray("supplier_cost_4", classes) != -1;

                if ((sq4F || sevc4F) && sevc4 > 0) {
                    sc4 = parseFloat(sevc4) * add;
                    $('.supplier_cost_4').val(sc4.toFixed(2));
                }
                if ((sq4F || sc4F) && sc4 > 0) {
                    sevc4 = parseFloat(sc4 * less);
                    $('.supplier_ex_vat_cost_4').val(sevc4.toFixed(2));
                }

                tevc4 = parseFloat(sevc4) * sq4;
                tc4 = parseFloat(sc4) * sq4;
            } else {
                sq4 = 0;
            }

            $('.total_cost_4').val(tc4.toFixed(2));
            $('.total_ex_vat_cost_4').val(tevc4.toFixed(2));

            var tevc = tevc1 + tevc2 + tevc3 + tevc4;
            var tc = tc1 + tc2 + tc3 + tc4;
            var sq = parseInt(sq1) + parseInt(sq2) + parseInt(sq3) + parseInt(sq4);
            if (tc > 0 && c > 0 && sq > 0 && q > 0) {

                var pTotalExVatCost = (tevc / sq);
                var pTotalCost = (tc / sq);

                $("#excluded_vat_cost").val(pTotalExVatCost.toFixed(2));
                $("#cost").val(pTotalCost.toFixed(2));
                $("#quantity").val(sq);
            }
        }

        $(document).ready(function() {

            $('.supplier_costs, .supplier_ex_vat_costs, .supplier_quantities').on("change", function(e) {
                var el = $(this);
                calculateSupplierCost(el);
            });

            $('#excluded_vat_cost').on("change", function(e) {
                var el = $(this);
                var val = el.val();

                if (val > 0) {
                    $('#cost').val((parseFloat(val) * add).toFixed(2));
                } else {
                    $('#cost').val(0);
                }
            });

            $('#cost').on("change", function(e) {
                var el = $(this);
                var val = el.val();

                if (val > 0) {
                    $('#excluded_vat_cost').val((parseFloat(val) * less).toFixed(2));
                } else {
                    $('#excluded_vat_cost').val(0);
                }
            });

            $('#excluded_vat_price').on("change", function(e) {
                var el = $(this);
                var val = el.val();

                if (val > 0) {
                    $('#price').val((parseFloat(val) * add).toFixed(2));
                } else {
                    $('#price').val(0);
                }
            });

            $('#price').on("change", function(e) {
                var el = $(this);
                var val = el.val();

                if (val > 0) {
                    $('#excluded_vat_price').val((parseFloat(val) * less).toFixed(2));
                } else {
                    $('#excluded_vat_price').val(0);
                }
            });

            $('#name').on("change", function(e) {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/ /g, '-');
                Text = Text.replace(/[^\w-]+/g, '');
                $("#slug").val(Text);
            });

            $('#code').on("keypress", function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    return false;
                }
            });

            $('#discount_type').change();

            if (category_id != '') {
                loadCategoryDate(category_id);
            }

            $(".changescategory").on('change', function() {
                loadCategoryDate($(this).val())

            })

            @if (@$product)
                var url = "{{ url('admin/get-all-store-categories') }}" + '/' + {{ $product->id }}
            @else
                var url = "{{ url('admin/get-all-store-categories') }}";
            @endif

            @if (@$product && !empty($tab1))
                show_hide_fields(1);
            @else
                show_hide_fields(1);
            @endif

            @if (@$product && !empty($tab2))
                var tree = $('#store_category_tree').tree({
                    primaryKey: 'data_id',
                    uiLibrary: 'bootstrap',
                    dataSource: url,
                    icons: {
                        expand: '<i class="glyphicon glyphicon-circle-arrow-right"></i>',
                        collapse: '<i class="glyphicon glyphicon-circle-arrow-down"></i>'
                    },
                    checkboxes: true,
                    border: true,
                    showIcon: true,
                });

                tree.on('checkboxChange', function(e, $node, record, state) {

                    var checkedIds = tree.getCheckedNodes();

                    $("#checkedIds").val(checkedIds);
                    $("#store_quantity").html('');

                    $.each(checkedIds, function(index, value) {

                        var id_type = value.split('-');
                        if (id_type[0] == 'store') {
                            var data = tree.getDataById(value);

                            if (data.name) {
                                $("#store_quantity").append(
                                    '<div class="form-group">\
                                                                                            <label class="control-label required-input">' +
                                    data
                                    .text +
                                    '</label>\
                                                                                            <input type="number" name="store_quantity_' +
                                    data
                                    .data_id + '" class="form-control" min="0" required />\
                                                                                            <div class="help-block with-errors"></div>\
                                                                                           </div>');

                                set_store_products(tree, 50);
                                $('#product_form').validator('update');
                            }

                        }
                    });

                });

                set_store_products(tree, 2000);
            @endif


            $('#tags').tagsInput({
                width: 'auto'
            });

            $("#genrate_random_number").click(function() {
                var random_number = generateRandomNumber(13);
                $("#code").val(random_number);
                $("#code").blur();
                return false;
            });

            $("#genrate_random_number_sku").click(function() {
                var random_number = generateRandomNumber(3);
                var prefix = $("#prefix option:selected").val();

                var sku = $('#sku');
                if (sku.val() == "") {
                    if (prefix != "") {
                        sku.val(prefix + '-' + random_number);
                    } else {
                        sku.val(random_number);
                    }
                } else {
                    var skus = sku.val().split('-');
                    if (skus.length == 1) {
                        if (prefix != "") {
                            sku.val(prefix + '-' + random_number);
                        } else {
                            sku.val(random_number);
                        }

                    } else {

                        sku.val(skus[0] + '-' + random_number);

                    }
                }

                //$("#sku").val(random_number);
                $("#sku").blur();
                return false;
            });


            $('#discount_type').change(function() {
                var text = "Max Discount";
                if (this.value == 1) {
                    text = "Max Discount (%)";
                } else if (this.value == 2) {
                    text = "Max Discount (Fixed)";
                }

                $("#discount").parent(".form-group").find("label").text(text);
                $("#discount").attr("placeholder", text);
            });

            $('#prefix').change(function() {
                var prefix = this.value;

                var sku = $('#sku');
                if (sku.val() == "") {
                    sku.val(prefix + '-');
                } else {
                    var skus = sku.val().split('-');
                    if (prefix == "") {
                        if (skus.length == 1) {
                            sku.val(skus[0]);
                        } else {
                            sku.val(skus[1]);
                        }
                    } else {
                        if (skus.length == 1) {
                            sku.val(prefix + '-' + skus[0]);
                        } else {
                            sku.val(prefix + '-' + skus[1]);
                        }
                    }

                }

                sku.focus();
            });







            @if (!empty($tab1))
                Dropzone.autoDiscover = false;
                $(document).ready(function() {
                    var myDropzone = new Dropzone("div#my-awesome-dropzone", {
                        url: baseUrl + "/store-image",
                        paramName: "file",
                        maxFilesize: 2,
                        init: function() {
                            var self = this;
                            // config
                            self.options.addRemoveLinks = true;
                            self.options.dictRemoveFile = "Remove";
                            // bind events

                            /*
                             * Success file upload
                             */
                            self.on("success", function(file, response) {
                                console.log(response);
                                if (response) {
                                    $('#my-awesome-dropzone').append(
                                        '<input type="hidden" name="image_ids[]" class="image_ids" id="img_' +
                                        response.id + '" value="' + response.id +
                                        '"/>');
                                    file.previewElement.classList.add("dz-" + response
                                        .id);

                                    $('.dz-' + response.id).append(
                                        '<span class="default-image"><input class="default_image" id="default_image_' +
                                        response.id + '" data-id="' + response.id +
                                        '" type="checkbox" data-toggle="tooltip" title="Set image as default"></span>'
                                    );
                                    $('.dz-' + response.id).find('.dz-image img').attr(
                                        'src', response.image_url);
                                }


                                file.serverId = response.id;

                                var total_images = $("#total_images").val();

                                if (total_images == "")
                                    $("#total_images").val(1);
                                else
                                    $("#total_images").val(parseInt(total_images) + 1);
                            });

                            self.on("error", function(file, message) {
                                console.log(message);
                                $(file.previewElement).addClass("dz-error").find(
                                    '.dz-error-message').text(message.message);
                            });

                            /*
                             * On delete file
                             */
                            self.on("removedfile", function(file) {
                                $.ajax({
                                    url: baseUrl + '/delete-image/' + file
                                        .serverId,
                                    type: 'get',
                                    data: {
                                        '_token': token
                                    },
                                    success: function(result) {
                                        var total_images = $(
                                            "#total_images").val();
                                        if (total_images == 1)
                                            $("#total_images").val("");
                                        else
                                            $("#total_images").val(parseInt(
                                                total_images) - 1);
                                    }
                                });
                            });
                        },
                        params: {
                            _token: token
                        }
                    });

                });


                $(document).on('click', '.default_image', function() {

                    var image_id = $(this).data('id');
                    var image_ids = [];

                    $("#my-awesome-dropzone .dz-preview").each(function() {
                        image_ids.push($(this).find('.default-image input').data('id'));
                    });

                    if ($(this).is(':checked')) {
                        $('.default_image').prop('checked', false);
                        $(this).prop('checked', true);
                        var checked = 1;
                    } else {
                        $('.default_image').prop('checked', false);
                        var checked = 0;
                    }

                    $.ajax({
                        url: baseUrl + '/set-default-image',
                        type: 'post',
                        data: {
                            '_token': token,
                            'image_id': image_id,
                            'image_ids': image_ids,
                            'checked': checked
                        },
                        success: function(result) {

                        }

                    });

                });
            @endif

        });

        function loadCategoryDate(id) {
            var uri = "{{ route('admin.load.subcategory') }}";
            $.ajax({
                url: uri,
                data: {
                    format: 'json',
                    Id: id
                },
                type: "POST",
                success: function(data) {
                    $(".subcategory").html('');
                    $(".subcategory").select2({
                        data: data.data,
                        placeholder: "Select a Sub Category"
                    });
                },
                error: function() {
                    console.log("Error")
                }
            });

            if (sub_category_id != '') {
                console.log('sdfsdf', sub_category_id);
                setTimeout(function() {
                    $('.subcategory').val(sub_category_id).trigger("change");
                }, 2000)
            }
        }

        function show_hide_fields(type) {
            if (type == 1) { // Show
                $(".modifier_select").show();
                // if($("#is_variants").is(':checked')){
                //     $(".variant_checked").hide();
                //     $("#sku").removeAttr("required","required");
                // }else{
                //     $(".variant_checked").show();
                //     $("#sku").attr("required","required");
                // }

                $("#cost").attr("required", "required");
                $("#price").attr("required", "required");
                $("#cost").parent('.hide_cost').show();
                $("#price").parent('.hide_price').show();


            } else if (type == 2) { // Hide
                $(".modifier_select").show();
                $(".variant_checked").hide();
                $("#sku").removeAttr("required", "required");
                $("#cost").removeAttr("required", "required");
                $("#price").removeAttr("required", "required");
            }
        }

        @if (@$product && !empty($tab2))
            function set_store_products(tree, timeout) {
                setTimeout(function() {
                    @foreach ($product->store_products as $store)
                        @if ($store->quantity > 0)
                            tree.expand(tree.getNodeById('store-{{ $store->store_id }}'));
                            $("input[name=store_quantity_store-{{ $store->store_id }}]").val(
                                {{ $store->quantity }});
                        @endif
                    @endforeach

                    @foreach ($product->category_products as $category)
                        @if ($category->category->parent_id == 0)
                            tree.expand(tree.getNodeById('category-{{ $category->category_id }}'));
                        @else
                            tree.expand(tree.getNodeById('subcategory-{{ $category->category_id }}'));
                        @endif
                    @endforeach

                }, timeout);
            }
        @endif

        function remove_uploaded_file(imageId) {
            $.ajax({
                url: baseUrl + '/delete-image/' + imageId,
                type: 'get',
                success: function(result) {
                    $('.dz-' + imageId).remove();

                    var total_images = $("#total_images").val();
                    if (total_images == 1)
                        $("#total_images").val("");
                    else
                        $("#total_images").val(parseInt(total_images) - 1);
                }
            });
        }

        @if (!empty($tab1))
            $(document).ready(function() {
                CKEDITOR.replace('detail', {
                    removePlugins: 'elementspath,magicline',
                    resize_enabled: false,
                    allowedContent: true,
                    enterMode: CKEDITOR.ENTER_BR,
                    shiftEnterMode: CKEDITOR.ENTER_BR,
                    // toolbar: [
                    //     [ 'Bold','-','Italic','-','Underline'],
                    // ],
                });


                CKEDITOR.replace('full_detail', {
                    removePlugins: 'elementspath,magicline',
                    resize_enabled: false,
                    allowedContent: true,
                    enterMode: CKEDITOR.ENTER_BR,
                    shiftEnterMode: CKEDITOR.ENTER_BR,
                    // toolbar: [
                    //     [ 'Source','-','Image','-','Bold','-','Italic','-','Underline'],
                    // ],
                });
                CKEDITOR.replace('tecnical_specs', {
                    removePlugins: 'elementspath,magicline',
                    resize_enabled: false,
                    allowedContent: true,
                    enterMode: CKEDITOR.ENTER_BR,
                    shiftEnterMode: CKEDITOR.ENTER_BR,
                    // toolbar: [
                    //     [ 'Source','-','Image','-','Bold','-','Italic','-','Underline'],
                    // ],
                });
            });
        @endif
    </script>
@endsection
