@php
    $user = Auth::guard('web')->user();
@endphp
<div class="tab-content">
    <!-- Product Grid View -->
    <div id="grid-view" class="tab-pane fade active in" role="tabpanel">
        <div class="row text-center hvr2 clearfix">
            @foreach($products as $product)
                <?php $slug = (!empty($product->slug)) ? $product->slug : Hashids::encode($product->id); ?>
                <div class="col-md-4 col-sm-6">
                    <div class="portfolio-wrapper">
                        <div class="portfolio-thumb">
                            <a href="{{ url('products/'.$slug) }}">
                                <img src="{{ $product->default_image_url }}" alt="{{$product->name}}">
                            </a>


                            <div class="portfolio-content">
                                <div class="rating">
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star"></span>
                                    <span class="star"></span>
                                </div>
                                <div class="pop-up-icon">
                                    <a data-toggle="modal" href="#product-preview"
                                       class="center-link"><i class="fa fa-search"></i></a>
                                    <a href="#" class="left-link"><i class="fa fa-heart"></i></a>
                                    <a class="right-link single_add_to_cart_button" data-id="{{$product->id}}"
                                       href="javascript:void(0)"><i class="cart-icn"> </i></a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3><a class="title-3 fsz-16" href="{{ url('products/'.$slug) }}"
                                   title="{{ $product->name }}">{{ ucwords(strtolower(str_limit($product->name,25))) }} </a></h3>
                            
                            @if(Auth::check() && Auth::guard('web')->check() && @$user->type != 'retailer')
                                <p class="font-3">Price:
                                    <span class="thm-clr"> £{{ $product->discountedPrice }}</span>
                                </p>
                            @else
                                <p class="font-3">Price:
                                @if($product->discount_type>0)
                                    <del> £{{ number_format($product->price,2) }}</del>
                                @endif
                                   <span class="thm-clr"> £{{ $product->discountedPrice }}</span>
                                </p>
                            @endif
                            
                            
<!--                            @if(Auth::check() && Auth::guard('web')->check() && Auth::user()->type != 'retailer')
                                @if(Auth::user()->type == 'wholesaler')
                                    <p class="font-3">Price:
                                        <?php $totalPercent = ($product->cost * Auth::user()->mark_up / 100);?>
                                        <span
                                            class="thm-clr">£{{number_format(($product->cost + $totalPercent),2,'.','') }}</span>
                                        @else
                                            <del>£{{ $product->discountedPrice }}</del>
                                        @endif
                                    </p>
                                @else
                                    <p class="font-3">Price:
                                        @if($product->discount_type>0)
                                            <span
                                                class="thm-clr">£{{ number_format($product->price,2) }}</span>
                                        @endif
                                        <del>£{{ $product->discountedPrice }}</del>
                                        @endif
                                    </p>-->


                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <nav class="woocommerce-pagination">
            {{$products->render()}}
        </nav>
    </div>

    <div id="list-view" class="tab-pane fade" role="tabpanel">
        <div class="cat-list-view">
            @foreach($products as $product)
                <?php $slug = (!empty($product->slug)) ? $product->slug : Hashids::encode($product->id); ?>
                <div class="hvr2 row">
                    <div class="portfolio-wrapper">
                        <div class="col-md-4 col-sm-6">
                            <div class="portfolio-thumb">
                                <a href="{{ url('products/'.$slug) }}">
                                    <img src="{{ $product->default_image_url }}" alt="{{$product->name}}">
                                </a>

                                <div class="portfolio-content">
                                    <div class="pop-up-icon">
                                        <a class="center-link" href="{{ url('products/'.$slug) }}"
                                           data-toggle="modal"><i class="fa fa-search"></i></a>
                                        <a class="left-link" href="#"><i class="fa fa-heart"></i></a>
                                        <a class="right-link single_add_to_cart_button" data-id="{{$product->id}}"
                                           href="javascript:void(0)"><i class="cart-icn"> </i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-6">
                            <div class="product-content">
                                <a class="title-3 fsz-16" href="{{ url('products/'.$slug) }}"
                                   title="{{ $product->name }}"> {{ str_limit($product->name,25) }} </a>
                                <div class="rating">
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star"></span>
                                    <span class="star"></span>
                                </div>
                                <p class="font-3">Price: <span
                                        class="thm-clr"> £{{ number_format($product->price,2) }} </span></p>

                                <a data-id="{{$product->id}}"
                                   class="fancy-btn fancy-btn-small single_add_to_cart_button">Add to
                                    Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <nav class="woocommerce-pagination">
            {{$products->render()}}
        </nav>
    </div>
    <!-- / Product List View -->
</div>

<script>
    $(".single_add_to_cart_button").click(function (e) {

        e.preventDefault();
        if ($(this).attr('disabled') == 'disabled') {
            return false;
        }
        var id = $(this).attr('data-id');
        var qty = 1;
        console.log(qty);
        // show_loader();
        $.ajax({
            url: '{{ url('cart-add') }}',
            method: "POST",
            data: {id: id, quantity: qty},
            success: function (response) {
                if (response.status) {
                    success_message("Item successfully added to your cart");
                    getCartHistory()
                } else {
                    error_message(response.message);
                }
            }
        });
    });
</script>
