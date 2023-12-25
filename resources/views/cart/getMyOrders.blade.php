<table class="shop_table product-table">
    <thead>
    <tr>
        <th class="product-thumbnail"> img </th>
        <th class="product-name">Product</th>
        <th class="product-price">Price</th>
        <th class="product-quantity">Quantity</th>
        <th class="product-ordid">Status </th>
        <th class="product-dil">Details</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse($myOrders as $myOrder)
        <tble>
            <tr>
                <td> <span style="font-weight: bold;">Order Id : {{$myOrder->paypal_id}}</span></td>
            </tr>
        </tble>
        @forelse($myOrder->purchasedItems as $order_item)
            @if(!$order_item->product)
                @php continue;@endphp

            @endif
    <tr class="cart_item">
        <td class="product-thumbnail">
            <a href="{{ url('products/'.Hashids::encode($order_item->product->id)) }}">
                <img  src="{{ $order_item->product->default_image_url }}" alt="poster_2_up" />
            </a>
        </td>
        <td class="product-name">
            <div class="cart-product-title">
                <a href="single-product.html"> {{$order_item->product->name}} <span class="thm-clr"> {{$order_item->product->code}} </span> </a>
            </div>
        </td>

        <td class="">
            <p class="font-3 fsz-18 no-mrgn"> <b class="amount blk-clr">£{{$myOrder->amount }}</b> </p>
        </td>

        <td class="">
            <p class="font-3 fsz-16 blk-clr no-mrgn">  {{$order_item->quantity}} </p>
        </td>
        <td class="order-id">
            <p class="font-3 fsz-16 blk-clr no-mrgn">   {{$myOrder->cart->delivery_status}} </p>
        </td>
        <td class="diliver-date">
            <a class="transaction-details" href="javascript:void(0)" onclick="transactionDetails('{{$myOrder->paypal_id}}')">Details</a>
        </td>
<!--        <td class="order-status">
            <button class="alt fancy-button" type="submit">Return Order</button>
            <button class="alt fancy-button-blk" type="submit">Re Order</button>
        </td>-->
         </tr>
        @empty
            <tr><td colspan="3">No Records Found</td></tr>
        @endforelse
    @empty
        <tr><td colspan="3">No Records Found</td></tr>
    @endforelse

    </tbody>
</table>



