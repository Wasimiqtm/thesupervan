<?php

namespace App\Http\ViewComposers;

use App\Models\Courier;
use App\Models\CouriersAssignment;
use App\Models\ShoppingCart;
use App\Models\TaxRate;
use Cart;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class CartDetailComposer
{
    private $posts;

    public function __construct( ) {
        
    }

    public function compose(View $view) {
        $count          = (Auth::id())?Cart::session(Auth::id())->getContent()->count():Cart::getContent()->count();
        $cartContents   = (Auth::id())?Cart::session(Auth::id())->getContent():Cart::getContent();
        $subTotal       = (Auth::id())?Cart::session(Auth::id())->getSubTotal():Cart::getSubTotal();
        $subTotal = number_format($subTotal,2);
        $cart=ShoppingCart::where(['user_id' => Auth::id(), 'payment_status' => 'pending'])->first();



        $cartSum = 0;
        $originalPrice = 0;
        $woriginalPrice = 0;
        $wsubtotal = 0;
        $total_shipment_charges = 0;
        $courier =0;
        if($cart)
        {
            $courier_assign = CouriersAssignment::where('cart_id',$cart->id)->first();
            foreach($cartContents as $item){


                $cartSum += $item->getPriceSum();
                $productDetails = getProductDetails($item->id);
                if($productDetails) {
                    $originalPrice += ($productDetails->price * $item->quantity);
                }

                if (Auth::user()->type == 'dropshipper') {
                    $subTotal =0;
                    $total_shipment_charges =  $total_shipment_charges +$item->conditions->getValue() ;

                    $item->courier_id =  $item->conditions->getAttributes()['courier_id'];


                    $courier = $courier+$item->conditions->getValue();
                    $subTotal = $subTotal+($cartSum + $courier);
                } elseif (Auth::user()->type == 'wholesaler') {

                    $this->applyDiscount($cartContents);
                    $originalPrice = $cartContents->orignalPrice;
                    $subTotal = $cartContents->subTotal;

                }

            }

            if(Auth::user()->type == 'dropshipper' && @$courier_assign->status == 2 ) {

                $cartContents = $cartContents->sortBy('courier_id');
                $this->attach_color($cartContents);
                $this->attach_shipment_charges($cartContents);
                $total_shipment_charges=$cartContents->shipment_charges;

            }

            if(Auth::user()->type == 'wholesaler' && Auth::user()->type == 'dropshipper'  ) {

                $cartContents = $cartContents->sortBy('courier_id');
                $this->attach_color($cartContents);
                $this->attach_shipment_charges($cartContents);
                $total_shipment_charges=$cartContents->shipment_charges;

            }


        }

        $couriers= Courier::all();
        $vatCharges=TaxRate::select('rate')->where('id',1)->first();
        $vatCharges=(int)$vatCharges->rate;
        $view->with( compact('vatCharges','couriers','total_shipment_charges','cart','count', 'cartContents', 'subTotal', 'cartSum', 'originalPrice'));
    }
}
