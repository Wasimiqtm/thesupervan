@php
    $user = Auth::guard('web')->user();
@endphp
<div class="row collection hvr2">
    @foreach($products as $product)
        <div class="col-md-3 col-sm-6 col-xs-12 isotope-item colltn-1 colltn-2 colltn-3">
            <div class="portfolio-wrapper">
                <div class="portfolio-thumb">
                    <img src="{{ $product->default_image_url }}" alt="">
                    <div class="portfolio-content">
                        <div class="rating">
                            <span class="star active"></span>
                            <span class="star active"></span>
                            <span class="star active"></span>
                            <span class="star"></span>
                            <span class="star"></span>
                        </div>
                        <div class="pop-up-icon">
                            <a  data-toggle="modal" href="#product-preview" class="center-link"><i class="fa fa-search"></i></a>
                            <a href="#" class="left-link"><i class="fa fa-heart"></i></a>
                            <a class="right-link single_add_to_cart_button"  data-id="{{$product->id}}"  href="javascript:void(0)"><i class="cart-icn"> </i></a>
                        </div>
                        <div class="all-view">
                            <a href="{{ route('get.product.detail',['id' =>($product->slug!='')?$product->slug:Hashids::encode(($product->id))]) }}" class="fancy-btn-alt fancy-btn-small">View Product</a>
                        </div>
                    </div>
                </div>
                <div class="product-content">
                    <h3> <a class="title-3 fsz-16" href="{{ route('get.product.detail',['id' =>($product->slug!='')?$product->slug:Hashids::encode(($product->id))]) }}"> {{ ucwords(strtolower($product->name)) }} </a> </h3>
                </div>


                @if(Auth::check() && Auth::guard('web')->check() && @$user->type != 'retailer')
                    <p class="font-3">Price: <span class="thm-clr"> £{{ $product->discountedPrice }}</span></p>
                @else
                    <p class="font-3">Price:
                    @if($product->discount_type>0)
                        <del> £{{ number_format($product->price,2) }}</del>
                    @endif
                       <span class="thm-clr"> £{{ $product->discountedPrice }}</span></p>
                @endif

            </div>
        </div>

    @endforeach

</div>
<div class="row">
    @if($param =='all')
        <a href="{{url('products')}}">View All</a>
    @endif
</div>
