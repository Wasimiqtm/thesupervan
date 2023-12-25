@extends('layouts.app')
@section('title')
    {{$product->meta_title??''}}
@endsection
@section('description')
    {{$product->meta_description??''}}
@endsection
@section('content')
    
    @php
        $user = Auth::guard('web')->user();
    @endphp

    <div class="main-wrapper clearfix">
        <div class="site-pagetitle jumbotron">
            <div class="container theme-container text-center">
                <h3>Goshop Product</h3>

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
            <main id="main-content" class="main-content">
                <div itemscope itemtype="http://schema.org/Product" class="product has-post-thumbnail product-type-variable">

                    <div class="row">
                        <div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
                            <div id="gallery-2" class="royalSlider rsUni">
                                @foreach($images as $image)
                                    <a class="rsImg" data-rsbigimg="{{ $image->image_url }}" href="{{ $image->image_url }}" data-rsw="500" data-rsh="500"> <img class="rsTmb" src="{{ $image->image_thumb }}" alt=""></a>
                                @endforeach
                            </div>
                        </div>
                        <div class="spc-15 hidden-lg clear"></div>
                        <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                            <div class="summary entry-summary">
                                <div class="woocommerce-product-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                                    <div class="rating">
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star half"></span>
                                    </div>

                                    <div  class="posted_in">
                                        <h3 class="funky-font-2 fsz-20">{{($product->brand)?$product->brand->name:''}}</h3>
                                    </div>
                                </div>

                                <div class="product_title_wrapper">
                                    <div itemprop="name" class="product_title entry-title">
                                        {{ $product->name }} <span class="thm-clr"></span>
                                        
                                        @if(Auth::check() && Auth::guard('web')->check() && @$user->type != 'retailer')
                                            <p class="font-3 fsz-18 no-mrgn price">
                                                <b class="amount fa fa-gbp thm-clr"> {{ $product->discountedPrice }}</b>
                                            </p>
                                        @else
                                            <p class="font-3 fsz-18 no-mrgn price">
                                            @if($product->discount_type>0)
                                                <del> £{{ number_format($product->price,2) }}</del>
                                            @endif
                                               <b class="amount fa fa-gbp thm-clr"> {{ $product->discountedPrice }}</b>
                                            </p>
                                        @endif
                                        
<!--                                        <p class="font-3 fsz-18 no-mrgn price"> 
                                            <b class="amount blk-clr fa fa-gbp"> {{ $product->price }}</b>   
                                        </p>-->
                                    </div>
                                </div>

                                <div itemprop="description" class="fsz-15">
                                    <p>{!! $product->detail !!}</p>
                                </div>

                                <ul class="stock-detail list-items fsz-12">
                                    @if (@$product->category)
                                    <li> <strong> Category : <span class="blk-clr">
                                            {{ $product->category->name }}
                                         </span> </strong> 
                                    </li>
                                    @endif
                                    @if (@$product->sub_category)
                                    <br/><li> <strong> Sub Category : <span class="blk-clr">
                                            {{ $product->sub_category->sub_name }}
                                         </span> </strong> 
                                    </li>
                                    @endif
                                    <li> <strong>  STOCK : <span class="blk-clr"> READY STOCK </span> </strong> </li>
                                </ul>

                                <form class="variations_form cart" method="post">
                                    <div class="row">

                                        <div class="col-sm-4">
                                            <div class="form-group selectpicker-wrapper">
                                                <label class="fsz-15 title-3"> <b> QUANTITY </b> </label>
                                                <input class='selectpicker' type='number' min='0' step="1" value="1" max="{{ $product->quantity }}" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <button    data-id="{{$product->id}}" class="single_add_to_cart_button button alt fancy-button left">Add to cart</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- .summary -->
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="woocommerce-tabs wc-tabs-wrapper row">
                        <ul class="tabs wc-tabs">
                            <li class="description_tab">
                                <a href="#tab-description">Description</a>
                            </li>
                            <li class="additional_information_tab">
                                <a href="#tab-additional_information">Additional Information</a>
                            </li>
                            <li class="reviews_tab">
                                <a href="#tab-reviews">Reviews (3)</a>
                            </li>
                        </ul>

                        <div class="entry-content wc-tab col-lg-4 col-sm-6 col-xs-12" id="tab-description">
                            <h2 class="title-3">Full Description</h2>
                            <hr class="heading-seperator" />
                            <div class="scroll-div">
                                <div class="nano-content">
                                   <p>{!! $product->full_detail !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="entry-content wc-tab col-lg-4 col-sm-6 col-xs-12" id="tab-additional_information">
                            <h2 class="title-3">Technical Requirements</h2>
                            <hr class="heading-seperator" />
                            <div class="scroll-div">
                                <div class="nano-content">
                                    {!! $product->tecnical_specs !!}
                                </div>
                            </div>
                        </div>
                        <div class="entry-content wc-tab col-lg-4 col-sm-6 col-xs-12" id="tab-reviews">
                            <h2 class="title-3">Product Review</h2>
                            <hr class="heading-seperator" />
                            <div class="scroll-div">
                                <div class="nano-content">
                                    <div id="reviews">
                                        <div id="comments">
                                            <ol class="commentlist">
                                                <li itemprop="review" itemscope itemtype="http://schema.org/Review" class="comment even thread-even depth-1">
                                                    <div class="comment_container diblock">
                                                        <img alt="" src="assets/img/extra/review-1.jpg" itemprop="image" class="avatar" height="60" width="60" />
                                                        <div class="comment-text">
                                                            <strong class="name">JOHN LENNON</strong>
                                                            <div class="rating">
                                                                <span class="star active"></span>
                                                                <span class="star active"></span>
                                                                <span class="star active"></span>
                                                                <span class="star active"></span>
                                                                <span class="star half"></span>
                                                            </div>
                                                            <p class="meta">
                                                                <time itemprop="datePublished" datetime="2013-06-07T13:03:29+00:00"> 2 June, 2016</time>:
                                                            </p>
                                                            <div itemprop="description" class="description">
                                                                <p>cute reversitile hand bag  shoulder bag that comes with straps inside it if you choose to wear</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li><!-- #comment-## -->

                                                <li itemprop="review" itemscope itemtype="http://schema.org/Review" class="comment even thread-even depth-1">
                                                    <div class="comment_container diblock">
                                                        <img alt="" src="assets/img/extra/review-1.jpg" itemprop="image" class="avatar" height="60" width="60" />
                                                        <div class="comment-text">
                                                            <strong class="name">JOHN LENNON</strong>
                                                            <div class="rating">
                                                                <span class="star active"></span>
                                                                <span class="star active"></span>
                                                                <span class="star active"></span>
                                                                <span class="star active"></span>
                                                                <span class="star half"></span>
                                                            </div>
                                                            <p class="meta">
                                                                <time itemprop="datePublished" datetime="2013-06-07T13:03:29+00:00"> 2 June, 2016</time>:
                                                            </p>
                                                            <div itemprop="description" class="description">
                                                                <p>cute reversitile hand bag  shoulder bag that comes with straps inside it if you choose to wear</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li><!-- #comment-## -->

                                                <li itemprop="review" itemscope itemtype="http://schema.org/Review" class="comment even thread-even depth-1">
                                                    <div class="comment_container diblock">
                                                        <img alt="" src="assets/img/extra/review-1.jpg" itemprop="image" class="avatar" height="60" width="60" />
                                                        <div class="comment-text">
                                                            <strong class="name">JOHN LENNON</strong>
                                                            <div class="rating">
                                                                <span class="star active"></span>
                                                                <span class="star active"></span>
                                                                <span class="star active"></span>
                                                                <span class="star active"></span>
                                                                <span class="star half"></span>
                                                            </div>
                                                            <p class="meta">
                                                                <time itemprop="datePublished" datetime="2013-06-07T13:03:29+00:00"> 2 June, 2016</time>:
                                                            </p>
                                                            <div itemprop="description" class="description">
                                                                <p>{!! $product->full_detail !!}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li><!-- #comment-## -->
                                            </ol>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>
            </main>
        </div>

        <div class=" light-bg gst-row">
            <div class="fancy-heading text-center">
                <h3> RELATED PRODUCTS </h3>
                <h5 class="funky-font-2"> Customers who viewed this item also viewed </h5>
            </div>

            <!-- Portfolio items -->
            <div class="related-product nav-2 text-center">
                <div class="product">
                    <div class="rel-prod-media">
                        <img src="assets/img/products/rel-prod-1.png" alt="" />
                    </div>
                    <div class="product-content">
                        <h3> <a href="#" class="title-3 fsz-16"> CICLYSMO JACKET </a> </h3>
                        <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                    </div>
                </div>

                <div class="product">
                    <div class="rel-prod-media">
                        <img src="assets/img/products/rel-prod-2.png" alt="" />
                    </div>
                    <div class="product-content">
                        <h3> <a href="#" class="title-3 fsz-16"> LYCRA BITZ MEN CLOTHING </a> </h3>
                        <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                    </div>
                </div>

                <div class="product">
                    <div class="rel-prod-media">
                        <img src="assets/img/products/rel-prod-3.png" alt="" />
                    </div>
                    <div class="product-content">
                        <h3> <a href="#" class="title-3 fsz-16"> CICLYSMO JACKET </a> </h3>
                        <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                    </div>
                </div>

                <div class="product">
                    <div class="rel-prod-media">
                        <img src="assets/img/products/rel-prod-4.png" alt="" />
                    </div>
                    <div class="product-content">
                        <h3> <a href="#" class="title-3 fsz-16"> LYCRA BITZ MEN CLOTHING </a> </h3>
                        <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                    </div>
                </div>

                <div class="product">
                    <div class="rel-prod-media">
                        <img src="assets/img/products/rel-prod-5.png" alt="" />
                    </div>
                    <div class="product-content">
                        <h3> <a href="#" class="title-3 fsz-16"> CICLYSMO JACKET </a> </h3>
                        <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                    </div>
                </div>

                <div class="product">
                    <div class="rel-prod-media">
                        <img src="assets/img/products/rel-prod-6.png" alt="" />
                    </div>
                    <div class="product-content">
                        <h3> <a href="#" class="title-3 fsz-16"> LYCRA BITZ MEN CLOTHING </a> </h3>
                        <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="clear"></div>
    </div>


@endsection
@section('scripts')
    <script type="text/javascript">
        var productID = "{{$product->id}}";
        var authType ="{{Auth::user()?Auth::user()->type:''}}";
        var mark_up =parseInt("{{Auth::user()?Auth::user()->mark_up:0}}");

        $(document).ready(function() {
            getProductReviews(productID);
            $("#addreview").on("click",function(){

                if($("textarea[name='review-text']").val() !='' && $("input[name='name-author']").val() !='' ) {
                    $.ajax({
                        url: '{{ url('add-product-review') }}',
                        method: "POST",
                        data: {
                            product_id: productID,
                            name: $("input[name='name-author']").val(),
                            email: $("input[name='email-author']").val(),
                            description: $("textarea[name='review-text']").val()
                        },
                        success: function (response) {

                            toastr.success(response.message);
                            getProductReviews(productID);
                        }
                    });
                }else{
                    toastr.error("Please Provide Name and Description");
                }
            })
            $(".variants select").on("change",function(){

                var id = $(this).data('id');
                var product_id = $('#product_id').val();
                var variant_id = $(this).val();
                var val = $(this).find('option:selected').text();
                $("#product-variant-"+id).val(val);

                show_loader();
                if(id==1 && variant_id>0){

                    var child_variant_id = $("#product-variant-2").val();
                    $.ajax({
                        url: '{{ url('get-product-variants') }}',
                        method: "POST",
                        data: {id: id, product_id:product_id, child_variant_id:child_variant_id, variant_id:variant_id, val: val},
                        success: function (response) {
                            hide_loader();
                            if(variant_id==0){
                                $(".variant-main-2").hide();
                            }
                            var variants = response.variants;
                            if(variants.length>0){
                                $(".variant-main-2").show();
                                $(".variant-main-2 select").html('<option value="0">Select '+variants[0].variant.name+'</option>');
                                for (x in variants) {
                                    $(".variant-main-2 select").append('<option value='+variants[x].variant_id+'>'+variants[x].name+'</option>');
                                }
                            }
                            activeVariantProduct(response.product);


                        }
                    });
                }else if(id==2 && variant_id>0){
                    var parent_variant_id = $("#product-variant-1").val();
                    $.ajax({
                        url: '{{ url('get-product-variants') }}',
                        method: "POST",
                        data: {id: id, product_id:product_id, parent_variant_id:parent_variant_id, variant_id:variant_id, val: val},
                        success: function (response) {
                            hide_loader();
                            activeVariantProduct(response.product);
                        }
                    });
                }else {

                    var prdQuantity = $(this).find('option:selected').attr('prd-default');

                    if(prdQuantity>0) {
                        $("#available").text('In stock');
                        $("#available").css('background-color', 'green');
                        $(".qty").attr('max',prdQuantity);
                        $(".quanlity").show();
                        $(".add-to-cart").attr('disabled',false);
                    }
                    hide_loader();
                }


            });

            function activeVariantProduct(product){

                if(typeof(product) != "undefined" && product !== null) {
                    $(".title_name").text(product.name);
                    $(".add-to-cart").attr("data-id",product.id);
                    $(".wishlist").attr("onclick","addRemoveWishlist("+product.id+")");

                    if(product.is_variants==1){
                        var price = product.price;

                        $(".regular").text('£'+parseFloat(price).toFixed(2));
                        if(product.discount_type=="1"){
                            var discount = ((parseInt(price)*product.discount)/100);
                            price = parseFloat(price)-discount;
                        }else if(product.discount_type=="2"){
                            price = parseInt(price)-product.discount;
                        }
                    }else{
                        var price =0;

                        var actual_price = product.discountedPrice;
                        if(product.is_main_price==1){
                            price = product.product.price;
                        }else{
                            price = product.price;
                        }
                        if(authType !='' && authType =='wholesaler'){

                            var percent =( mark_up/100);
                            percent = product.cost * percent;
                            var productCost = parseFloat(product.cost);
                            price = parseFloat(percent) + productCost;

                        }else if(authType !='' && authType =='dropshipper'){
                            price = product.discountedPrice;
                        }else{



                            if(product.product.discount_type ==="1"){
                                var discount = ((parseFloat(price)*parseInt(product.product.discount))/100);

                                price = parseFloat(price)-discount;
                            }else if(product.product.discount_type=="2"){
                                price = parseInt(price)-product.product.discount;
                            }
                        }

                        $(".regular").text('£'+parseFloat(actual_price).toFixed(2));
                        $(".sale").text('£'+parseFloat(price).toFixed(2));


                    }

                    $(".sale").text('£'+parseFloat(price).toFixed(2));

                    $(".flex-control-thumbs li").each(function(){
                        if($(this).find('img').attr('src')==product.image_thumb)
                            $(this).find('img').click();
                    });

                    if(product.store_products.length>0){
                        if(product.store_products[0].quantity>0){
                            $("#available").text('In stock');
                            $("#available").css('background-color','green');
                            $(".qty").attr('max',product.store_products[0].quantity);
                            $(".quanlity").show();
                            $(".add-to-cart").attr('disabled',false);
                        }
                    }else{
                        $("#available").text('Out of stock');
                        $("#available").css('background-color','red');
                        $(".quanlity").hide();
                        $(".add-to-cart").attr('disabled',true);
                    }

                }
            }

            //update cart
            $(".single_add_to_cart_button").click(function (e) {

                e.preventDefault();
                if($(this).attr('disabled') =='disabled'){
                    return false;
                }
                var id = $(this).attr('data-id');
                var qty = parseInt($('.selectpicker').val());
                var max = parseInt($('.selectpicker').attr('max'));
                console.log('qty '+qty);
                console.log('max '+max);
                
                if (qty <= max) {
                    // show_loader();
                    $.ajax({
                        url: '{{ url('cart-add') }}',
                        method: "POST",
                        data: {id: id, quantity: qty},
                        success: function (response) {
                            if(response.status){
                                success_message("Item successfully added to your cart");
                                getCartHistory()
                            } else {
                                error_message(response.message);
                            }
                        }
                    });
                } else {
                    $('.selectpicker').val(max);
                    error_message("You have purchase maximum "+max+" quantity");
                }
                
            });



        });

        function addRemoveWishlist(product_id){
            var url = "{{ url('products/get-products') }}";
            var current_url     = window.location.href;
            var post_url        = "{{url('add-to-wishlist')}}";
            var current_url_split = current_url.split('?');
            var category_id = getParams('category_id', current_url);
            var page_number = getParams('page', current_url);
            if(!page_number){
                page_number = 1;
            }
            var records =  getParams('records', current_url);
            if(!records){
                records = 12;
            }
            var ordering=  getParams('order', current_url);
            if(!ordering){
                ordering = 'asc';
            }

            if(current_url_split.length>1){
                url = url+'?'+current_url_split[1];
            }else{
                url = url+'?page='+page_number+'&category_id='+category_id;
            }

            var login_check = "{{Auth::check()}}";

            favoriteRequest(product_id, url, records, ordering, login_check, post_url, true);
        }

        function getProductReviews(id) {

            $.ajax({
                url: '{{ url('get-product-review') }}',
                method: "POST",
                data: {
                    product_id: id,

                },
                success: function (response) {

                    $(".review-list li").remove();
                    if(response.data.length>0){
                        var html = '';

                        $.each(response.data,(index,value)=>{
                            html+='<li>\n' +
                                '                    <div class="review-metadata">\n' +
                                '                        <div class="name">\n' +
                                '                        '+value.name+' <span>'+value.dated+'</span>\n' +
                                '                    </div>\n'+
                                '                    </div><!-- /.review-metadata -->\n' +
                                '                    <div class="review-content">\n' +
                                '                        <p>\n' +
                                '                        '+value.description+'\n' +
                                '                    </p>\n' +
                                '                    </div><!-- /.review-content -->\n' +
                                '                    </li>'
                        });

                        $(".review-list").append(html);
                    }
                }
            });
        }

    </script>
@endsection
