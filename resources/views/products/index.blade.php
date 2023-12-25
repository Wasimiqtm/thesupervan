@extends('layouts.app')

@section('content')
    
    <style>
        .save-to-proceed {
            background-color: #f92400;
            color: #fff;
            font-size: 16px;
            height: 50px;
            line-height: 50px;
            padding: 0 64px;
            border-radius: 25px;
            margin-right: 30px;
            font-weight: 600;
            margin-left: -8px;
            letter-spacing: 0.5px;
            border: none;
            margin-top: 25px;
        }
    </style>
    <!-- CONTENT + SIDEBAR -->
    <div class="main-wrapper clearfix">
        <div class="site-pagetitle jumbotron">
            <div class="container text-center">
                <h3>Goshop Products</h3>

                <!-- Breadcrumbs -->
                <div class="breadcrumbs">
                    <div class="breadcrumbs text-center">
                        <i class="fa fa-home"></i>
                        <span><a href="index.html">Home</a></span>
                        <i class="fa fa-arrow-circle-right"></i>
                        <span class="current">Shop</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="theme-container container">
            <div class="main-container row">
                <aside class="col-md-3 col-sm-4">
                    <div class="main-sidebar">
                         <h3 class="sec-title fsz-25 no-mrgn blk-clr"> FILTER BY </h3>
                        <div class="widget sidebar-widget widget_categories clearfix">
                            <h6 class="widget-title">CATEGORY</h6>
                            <div class="panel-group">
                                <div class="panel panel-cate">
                                    @forelse(getCategories() as $category)
                                        <a style="cursor: pointer;" data-toggle="collapse" id="{{$category->id.'-'.$category->name}}" class="collapsed categoryType"> {{$category->name}}   </a>
                                        <div class="cate-heading">
                                            <a data-toggle="collapse"  href="#{{$category->id}}"
                                               id="{{$category->id.'-'.$category->name}}"
                                               class="collapsed"> </a>
                                        </div>
                                        @if($category->subcategories->count()>0)
                                            <div id="{{$category->id}}" class="panel-collapse collapse ">
                                                <ul>
                                                    @foreach($category->subcategories as $subcategory)
                                                        <li>
                                                            <a class="cat-item categoryType"
                                                               id="{{$subcategory->id.'-'.$subcategory->sub_name}}"
                                                               href="javascript:void(0)"
                                                               title="">{{$subcategory->sub_name}}</a>
                                                        </li>
                                                    @endforeach

                                                </ul>
                                            </div>
                                        @endif
                                    @empty
                                        <li>No Records Found</li>
                                    @endforelse
                                </div>

                            </div>
                        </div>
                         
                        <form method="get" action="{{ url('products') }}">
                        <input type="hidden" name="category" value="all" class="records">
                        <input type="hidden" name="records" value="10" class="records">
                        <input type="hidden" name="order" value="asc">
                        <input type="hidden" name="page" value="1">
                        <input type="hidden" name="filter" value="true">
                        <input id="view-type" type="hidden" name="view-type" value="grid" />
                        
                        <div class="widget sidebar-widget widget_categories clearfix">
                            <h6 class="widget-title">BRAND</h6>
                            <div class="panel-group">
                                <ul class="panel panel-cate">
                                    @forelse($brands as $id => $name)
                                        <li class="check-box">
                                            <input type="checkbox" name="brand[]" id="checkbox{{$id}}" value="{{$id.'-'.$name}}">
                                            <label for="checkbox{{$id}}">{{ $name }} </label>
                                        </li>
                                    @empty
                                        <li>No Records Found</li>
                                    @endforelse
                                </ul>

                            </div>
                        </div>
<!--                        <div class="widget sidebar-widget widget_categories clearfix">
                            <h6 class="widget-title">COLOR</h6>
                            <div class="panel-group">
                                <div class="panel panel-cate">
                                    <div class="cate-heading">
                                        <a data-toggle="collapse" href="#crl1" class="collapsed"> White
                                            <span>(75)</span> </a>
                                    </div>
                                    <div id="crl1" class="panel-collapse collapse">
                                        <ul>
                                            <li class="cat-item"><a href="#">Bike Tours</a> (3)</li>
                                            <li class="cat-item"><a href="#">Featured</a> (1)</li>
                                            <li class="cat-item"><a href="#">Imagination</a> (2)</li>
                                            <li class="cat-item"><a href="#">Inspire</a> (1)</li>
                                            <li class="cat-item"><a href="#">Luxury</a> (1)</li>
                                            <li class="cat-item"><a href="#">Recommended</a> (2)</li>
                                            <li class="cat-item"><a href="#">Travel</a> (1)</li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>-->

                        <div class="widget sidebar-widget woocommerce widget_price_filter clearfix">
                            <h6 class="widget-title">Filter by price</h6>
                            <div class="price search-filter-input">
                                <input id="min_price" type="hidden" name="min_price" value="0">
                                <input id="max_price" type="hidden" name="max_price" value="500">
                                <div id="slider-range2" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"><div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 50%;"></div><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 50%;"></span></div>
                                <p class="show_range" style="text-align: center; margin-top: 10px;">£0.00 - £500.00</p>
                            </div>
                            
<!--                                <div class="price_slider_wrapper">
                                    <div id="price_slider" class="price_slider"></div>
                                    <div class="price_slider_amount">
                                        <input type="text" id="min_price" name="min_price" value="" data-min="10"
                                               placeholder="Min price"/>
                                        <input type="text" id="max_price" name="max_price" value="" data-max="100"
                                               placeholder="Max price"/>
                                        <button type="submit" class="button">Filter</button>
                                        <div class="price_label">
                                            Price: &#36;<span id="label_min" class="from">10</span> &mdash; &#36;<span
                                                id="label_max" class="to">100</span>
                                        </div>

                                        <div class="clear"></div>
                                    </div>
                                </div>-->
                        </div>
                        
                        <div class="form-box">
                            <button type="submit" class="save-to-proceed" style="margin-bottom: 20px">Apply Filters</button>
                        </div>
                        </form>
<!--                        <div class="widget sidebar-widget widget_categories clearfix">
                            <h6 class="widget-title">Size</h6>
                            <ul>
                                <li class="cat-item"><a href="#">Very Small</a> (75)</li>
                                <li class="cat-item"><a href="#"> Small</a> (25)</li>
                                <li class="cat-item"><a href="#">Medium </a> (10)</li>
                                <li class="cat-item"><a href="#">Large</a> (10)</li>
                                <li class="cat-item"><a href="#">Very Large </a> (21)</li>
                            </ul>
                        </div>-->

<!--                        <div class="widget sidebar-widget">
                            <div class="text-box">
                                <h2 class="title-3 fsz-14 blklt-clr"> FREE SHIPPING. FREE RETURN. </h2>
                                <h2 class="sec-title fsz-20 blklt-clr"> ALL THE TIME </h2>
                            </div>
                        </div>-->
                    </div>
                </aside>

                <main class="col-md-9 col-sm-8 shop-wrap">
                    <div class="row spcbt-30">
                        <div class="col-lg-4 col-sm-6 sorter">
                            <ul class="nav-tabs tabination view-tabs">
                                @php $grid ='';
                                     $list='';
                                    if(request()->has('view-type') and request()->{'view-type'} =='grid')
                                        $grid='active';
                                        else
                                            $list ='active';
                                @endphp
                                <li class="{{$grid}}">
                                    <a href="#grid-view" data-toggle="tab" onclick="changeViewType(this)">
                                        <i class="fa fa-th" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li class="{{$list}}">
                                    <a href="#list-view" data-toggle="tab" onclick="changeViewType(this)">
                                        <i class="fa fa-th-list"></i>
                                    </a>
                                </li>
                            </ul>
                            <form action="#" class="sorting-form">
                                <div class="search-selectpicker selectpicker-wrapper">
                                    <select
                                        class="selectpicker input-price" data-live-search="true" data-width="100%"
                                        data-toggle="tooltip" title="Sort By">
                                        <option value="popularity">Sort by popularity</option>
                                        <option value="rating">Sort by average rating</option>
                                        <option value="date">Sort by newness</option>
                                        <option value="price">Sort by price: low to high</option>
                                        <option value="price-desc">Sort by price: high to low</option>
                                    </select>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-4 col-sm-6 woocommerce-result-count"> SHOW 24 ITEMS TOTAL OF 120 ITEMS</div>

                        <div class="col-lg-4 col-sm-12 col-xs-12 view-wrap">
                            <div class="right products-number-selector">
                                <span>View All</span>
                                <span><a href="category2-left-sidebar6efe.html?productnumber=9"
                                         class="highlight-selector">9</a></span>
                                <span><a href="category2-left-sidebar9f95.html?productnumber=12">12</a></span>
                                <span><a href="category2-left-sidebara555.html?productnumber=24">24</a></span>
                            </div>

                        </div>
                    </div>
                    <div id="partial_records"></div>

                </main>
            </div>
        </div>
    </div>
    <div class="clear"></div>

@endsection
@section('scripts')
<script type="text/javascript">

    function make_params_checked(val, current_url) {
        val = val.replace(" ", "");
        if (current_url.indexOf(val)) {
            /*$('.'+val).prop('checked', true);
            $('.'+val).closest(".moreOptons_box").addClass("checked");*/

        }
    }

    $(document).ready(function () {

        const url = "{{ url('get-products') }}";
        let current_url = window.location.href;

        let page_number = getParams('page', current_url);
        if (!page_number) {
            page_number = 1;
        }

        // getting records from url
        let records = getParams('records', current_url);
        if (!records) {
            records = 10;
        }
        $(".per_page_records").val(records);

        // getting order from url
        let ordering = getParams('order', current_url);
        if (!ordering) {
            ordering = 'desc';
        }
        $('.order').val(ordering);

        // append category and view type in url
        let check_view = getParams('category');
        if (!check_view) {
            current_url = current_url + '?category=all&view-type=grid';
        }

        // check view type on window load
        let check_view_type = getParams('view-type');
        if (check_view_type == 'list') {
            $('.list').addClass('active');
            $('.grid').removeClass('active');
        }

        // more options url
        let more_options_url = '';
        if ((current_url.indexOf('filter') != -1)) {
            more_options_url = (current_url).split('page=' + page_number).pop();
        }

        // on browser back button
        window.onpopstate = function () {
            browserBackBtnHandler(url);
        };

        // manage url state with ajax url
        window.history.pushState("", "", current_url);

        getProducts(url + '?page=' + page_number + more_options_url, records, ordering);

        // chagne records per page

        $('body').on('click', '.pagination a', function(e) {
            e.preventDefault();

            var url = $(this).attr('href');
            var current_url = window.location.href;

            pageClick(url, current_url, more_options_url, 'products');
        });
        
        $('body').on('click', '.categoryType', function(e) {
            e.preventDefault();
            let category_id = $(this).attr('id');
            current_url     = window.location.href;
            let selectedCategoryName = (category_id).split('-').pop();
            category_id = category_id.replace(/ & /g, "-");
            category_id = category_id.replace(/, /g, "-");
            category_id = category_id.replace(/ /g, "-");
            category_id = category_id.replace("(", "");
            category_id = category_id.replace(")", "");
            $('#categoryName').text(selectedCategoryName);

            let category_param  = getParams('category');
            let updated_url = current_url.replace("category="+category_param, "category="+category_id);
            window.history.pushState("", "", updated_url);

            getCategoryProducts(category_id, url, current_url, more_options_url, ordering, page_number, records);
        });
        
        let min_price = getParams('min_price', current_url);
        if(!min_price){
            min_price = 0;
        }

        let max_price = getParams('max_price', current_url);
        if(!max_price){
            max_price = 500;
        }

        $('#min_price').val(min_price);
        $('#max_price').val(max_price);
        $('.show_range').text("£" + (parseInt(min_price).toFixed(2)) + " - £" + (parseInt(max_price).toFixed(2)));
        $( "#slider-range2" ).slider({
            range: true,
            min: 0,
            max: 1000,
            step: 5,
            values: [ min_price, max_price ],
            slide: function( event, ui ) {
                // $( "#amount2" ).val( "$" + addCommas(ui.values[ 0 ].toFixed(2)) + " - $" + addCommas(ui.values[ 1 ].toFixed(2)) );
                $('.show_range').text("£" + (ui.values[ 0 ].toFixed(2)) + " - £" + (ui.values[ 1 ].toFixed(2)));
                $("#min_price").val((ui.values[ 0 ]));
                $("#max_price").val((ui.values[ 1 ]));
            }
        });
        
    });

    function changeViewType(obj){
        let current_url     = window.location.href;
        if ($(obj).hasClass("list")) {

            updated_url = current_url.replace("view-type=grid", "view-type=list");
        }else{

            updated_url = current_url.replace("view-type=list", "view-type=grid");
        }
        window.history.pushState("", "", updated_url);
    }

</script>
@endsection
