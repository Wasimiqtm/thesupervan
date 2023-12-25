@extends('admin.layouts.app')

@section('style')
    <style>
        td span.details-control {
            background: url(../images/details_open.png) no-repeat center center;
            cursor: pointer;
            width: 18px;
            padding: 12px;
        }

        tr.shown td span.details-control {
            background: url(../images/details_close.png) no-repeat center center;
        }
    </style>
@endsection
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                        <li class="active">Products</li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Products
                            <span class="pull-right" style="margin-top: -5px;">
                                @can('add products')
                                    <a href="javascript:void(0)" class="btn btn-info btn-sm csv_products" data-toggle="tooltip"
                                        title="Upload CSV Products"><i class="fa fa-file" aria-hidden="true"></i></a>
                                @endcan
                                <a href="javascript:void(0)" class="btn btn-success btn-sm refresh_products"
                                    data-toggle="tooltip" title="Refresh Products"><i class="fa fa-refresh"
                                        aria-hidden="true"></i></a>
                                @can('add products')
                                    <a href="{{ url('admin/products/create') }}" class="btn btn-info btn-sm"
                                        data-toggle="tooltip" title="Add New Product"><i class="fa fa-plus"
                                            aria-hidden="true"></i></a>
                                @endcan
                            </span>
                        </header>
                        <div class="panel-body">

                            <div class="row">
                                <div class="form-group col-md-3">
                                    {!! Form::text('barcode', null, ['class' => 'form-control', 'id' => 'barcode', 'placeholder' => 'Barcode']) !!}
                                </div>
                                <div class="form-group col-md-3">
                                    {!! Form::text('product_name', null, [
                                        'class' => 'form-control',
                                        'id' => 'product_name',
                                        'placeholder' => 'Product Name',
                                    ]) !!}
                                </div>
                                <div class="form-group col-md-3">
                                    {!! Form::select('brand_id', $brands, null, ['class' => 'form-control select2', 'id' => 'brand_id']) !!}
                                </div>
                                <div class="form-group col-md-3">
                                    <button class="btn bnt-success searchProducts">Search</button>
                                </div>
                            </div>

                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Image</th>
                                        <th>Bar Code</th>
                                        <th>Item Code</th>
                                        <th>Name</th>
                                        {{-- <th>Supplier</th> --}}
                                        {{-- <th>Brand</th> --}}
                                        <th>Quantity</th>
                                        <th>Ex-VAT<br />Cost</th>
                                        <th>Inc-VAT<br />Cost</th>
                                        <th>Total Cost<br />Ex-VAT</th>
                                        <th>Total Cost<br />Inc-VAT</th>
                                        <th>Selling Price</th>
                                        @if (auth()->user()->can('edit products') ||
                                                auth()->user()->can('view product stocks') ||
                                                auth()->user()->can('delete products'))
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd">
                                        <td valign="top" colspan="10" class="dataTables_empty">No data available in
                                            table</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Image</th>
                                        <th>Bar Code</th>
                                        <th>Item Code</th>
                                        <th>Name</th>
                                        {{-- <th>Supplier</th> --}}
                                        {{-- <th>Brand</th> --}}
                                        <th>Quantity</th>
                                        <th>Ex-VAT Cost</th>
                                        <th>Inc-VAT Cost</th>
                                        <th>Total Ex-VAT Cost</th>
                                        <th>Total Inc-VAT Cost</th>
                                        <th>Selling Price</th>
                                        @if (auth()->user()->can('edit products') ||
                                                auth()->user()->can('view product stocks') ||
                                                auth()->user()->can('delete products'))
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </section>
                </div>
            </div>

        </section>
    </section>

    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="csv_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Upload CSV Products</h4>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" action="{{ url('admin/upload-csv-products') }}" method="post"
                        role="form">
                        @csrf
                        <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">CSV File</label>
                            <div class="col-lg-10">
                                <input type="file" class="form-control" id="inputEmail4" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-10 col-lg-10">
                                <button type="submit" class="btn btn-success">Upload</button>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <style>
        .table-striped>tbody>tr:nth-child(odd)>td,
        .table-striped>tbody>tr:nth-child(odd)>th {
            background-color: transparent;
        }
    </style>
@endsection


@section('scripts')
    <script type="text/javascript">
        var upload_url = '{{ asset('uploads') }}';

        $(document).ready(function() {

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                responsive: true,
                pageLength: 100,
                ajax: {
                    url: "{{ url('admin/products') }}",
                    data: function(d) {
                        d.brand_id = $("#brand_id option:selected").val();
                        d.barcode = $("#barcode").val();
                        d.product_name = $("#product_name").val();
                    }
                },
                columns: [{
                        data: 'is_variants',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'product_image',
                        width: "8%",
                        className: 'text-center'
                    },
                    {
                        data: 'code',
                        className: 'text-center'
                    },
                    {
                        data: 'item_code',
                        className: 'text-center'
                    },
                    {
                        data: 'name'
                    },
                    // {data: 'supplier', className: 'text-center'},                
                    // {data: 'brand.name', className: 'text-center'},                
                    {
                        data: 'quantity.quantity',
                        className: 'text-center'
                    },
                    {
                        data: 'ex_cost',
                        className: 'text-center'
                    },
                    {
                        data: 'inc_cost',
                        className: 'text-center'
                    },
                    {
                        data: 'total_ex_cost',
                        className: 'text-center'
                    },
                    {
                        data: 'total_inc_cost',
                        className: 'text-center'
                    },
                    // {
                    //     data: 'total_stock_worth',
                    //     className: 'text-center'
                    // },
                    {
                        data: 'price',
                        className: 'text-center'
                    },
                    @if (auth()->user()->can('edit products') ||
                            auth()->user()->can('view product stocks') ||
                            auth()->user()->can('delete products'))
                        {
                            data: 'action',
                            width: "5%",
                            orderable: false,
                            searchable: false
                        }
                    @endif
                ],
                order: []
            });

            $('#datatable tbody').on('click', 'td span.details-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                console.log(row);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });

            var reload_datatable = $("#datatable").dataTable({
                bRetrieve: true
            });

            $(document).on('click', '.refresh_products', function(e) {
                reload_datatable.fnDraw();
            });

            $(document).on('click', '.searchProducts', function(e) {
                reload_datatable.fnDraw();
            });

            $(".csv_products").click(function() {
                $('#csv_model').modal('show');
            });

            $("#datatable_length label").after(
                '<button class="btn bnt-sm btn-danger deleteAllBtn" style="margin-left: 8px;" >Delete</button>');

            $(".deleteAllBtn").click(function() {
                var productIds = $('.multipleDelete:checked').map(function() {
                    return parseInt(this.value);
                }).get();

                if (productIds.length > 0) {
                    $.confirm({
                        title: 'Confirm!',
                        content: 'Are you sure! You want remove this records',
                        type: 'red',
                        typeAnimated: true,
                        closeIcon: true,
                        buttons: {
                            confirm: function() {
                                $("#datatable tbody").LoadingOverlay("show");
                                $.ajax({
                                    type: 'post',
                                    url: '{{ url('admin/products/delete-multi-products') }}',
                                    data: {
                                        'product_ids': productIds
                                    },
                                    complete: function(res) {
                                        $("#datatable tbody").LoadingOverlay(
                                            "hide");
                                        var j = JSON.parse(res.responseText);
                                        var result = j.result;
                                        if (res.status == 200) {
                                            if (reload_datatable != "") {
                                                reload_datatable.fnDraw();
                                            }

                                            success_message(result.message);

                                        } else {
                                            error_message(result.message);
                                        }
                                    },
                                    error: function(request, status, error) {
                                        $("#datatable tbody").LoadingOverlay(
                                            "hide");
                                        var result = request.responseJSON.result;
                                        var err = JSON.parse(request.responseText);
                                        if (status == 401) {
                                            error_message(result.message);
                                        } else {
                                            error_message(err.message);
                                        }
                                    }
                                });
                            },
                            cancel: function() {},
                        }
                    });
                } else {
                    toastr.error('Please select atleast one product');
                }
            });
        });

        function format(rowData) {
            var div = $('<div/>').addClass('loading').text('Loading...');
            var products = rowData.products;

            var product_html = '<table class="table table-bordered table-striped">\
                                                                                <thead><tr>\
                                                                                    <th>Image</th>\
                                                                                    <th>Code</th>\
                                                                                    <th>SKU</th>\
                                                                                    <th>Name</th>\
                                                                                    <th>Cost</th>\
                                                                                    <th>Price</th>';
            @if (auth()->user()->can('edit products') ||
                    auth()->user()->can('view product stocks') ||
                    auth()->user()->can('delete products'))
                product_html += '<th>Action</th>';
            @endif
            product_html += '</tr></thead><tbody>';

            if (products.length > 0) {
                console.log(products);

                $.each(products, function(index, product) {

                    var image = '<img width="30" src="' + upload_url + '/no-image.png" />';
                    if (product.product_images.length > 0) {
                        image = '<img width="30" src="' + upload_url + '/products/thumbs/' + product.product_images[
                            0].name + '" />'
                    }

                    var cost = '-';
                    var price = '-';
                    if (product.is_main_price == 0) {
                        cost = product.cost;
                        price = product.price;
                    }

                    product_html += '<tr>\
                                                                                        <td align="center" width="10%">' +
                        image + '</td>\
                                                                                        <td align="center" width="10%">' +
                        product
                        .code + '</td>\
                                                                                        <td align="center">' + product
                        .sku + '</td>\
                                                                                        <td>' + product.name + '</td>\
                                                                                        <td align="center" width="10%">' +
                        cost + '</td>\
                                                                                        <td align="center" width="10%">' +
                        price +
                        '</td>';
                    @if (auth()->user()->can('edit products') ||
                            auth()->user()->can('view product stocks') ||
                            auth()->user()->can('delete products'))
                        product_html += '<td>';
                        @if (auth()->user()->can('edit products'))
                            product_html += '<a href="products/edit/' + product.id +
                                '" class="text-primary" data-toggle="tooltip" title="Edit Product"><i class="fa fa-lg fa-edit"></i></a>';
                        @endif
                        @if (auth()->user()->can('view product stocks'))
                            product_html += '<a href="product-stocks/' + product.id +
                                '" class="text-success" data-toggle="tooltip" title="Stock History"><i class="fa fa-lg fa-history"></i></a>';
                        @endif
                        @if (auth()->user()->can('delete stocks'))
                            product_html +=
                                '<a href="javascript:void(0)" class="text-danger btn-delete" data-toggle="tooltip" title="Delete Product" id="' +
                                product.id + '"><i class="fa fa-lg fa-trash"></i></a>';
                        @endif
                        product_html += '</td>';
                    @endif
                    product_html += '</tr>';

                });
            } else {

                product_html += '<tr><td colspan="7">Record not found</td></tr> ';
            }





            product_html += '</tbody></table>';

            div.html(product_html).removeClass('loading');

            return div;
        }
    </script>
@endsection
