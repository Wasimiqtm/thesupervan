

<a id="miniCartDropdown" href="{{url('/cart-data')}}">
    My Cart
    <span class="cart-item-num">{{$cartContents->count()}}</span>
</a>

<div id="miniCartView" class="cartView">
    <ul id="minicartHeader" class="product_list_widget list-unstyled">

        @forelse($cartContents as $product)
            <li>
                <div class="media clearfix">
                    <div class="media-lefta">
                        <a href="javascript:void(0)">
                            <img src="{{ getProductDefaultImage($product->id) }}"  alt="hoodie_5_front"/>
                        </a>
                    </div>
                    <div class="media-body">
                        <a href="javascript:void(0)">  {{$product->name}}</a>
                        <span class="price"><span class="amount"><span class="fa fa-gbp"></span>{{$product->quantity . ' x £' . $product->price." "}}@if(@$product->cprice > $product->price)<s>{{"(".$product->cprice.")"}}</s>@endif</span></span>
                        <span class="quantity">Qty:  {{$product->quantity}}</span>
                    </div>
                </div>

                <div class="product-remove">
                    <a href="javascript:void(0)" class="btn-remove header-remove" onclick="deleteItems(this)"  data-id="{{$product->id}}" title="Remove this item"><i class="fa fa-close"></i></a>
                </div>
            </li>

        @empty
            <tr><td colspan="4">No Record Found</td></tr>
        @endforelse


    </ul>

    <div class="cartActions">
        <span class="pull-left">Subtotal</span>
        <span class="pull-right"><span class="amount"><span class="fa fa-gbp"></span>{{number_format($subTotal+($subTotal*$vatCharges)/100,2)}}</span></span>
        <div class="clearfix"></div>

        <div class="minicart-buttons">
            <div class="col-lg-6">
                <a href="{{url('/cart-data')}}">Your Cart</a>
            </div>
            <div class="col-lg-6">
                <a  href="{{url('make-payment')}}" class="minicart-checkout">Checkout</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>


