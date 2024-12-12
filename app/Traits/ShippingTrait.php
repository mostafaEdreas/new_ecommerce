<?php

namespace App\Traits;

use App\Models\ShippingFees;
trait ShippingTrait
{

    private function getShipping()
    {
        $shipping = 0 ;
        switch (config('site_shipping_status')) {
            case 'doesnt_use':
                $shipping = 0;
                break;

            case 'free':
                $shipping = 0;
                break;

            case 'by_place':
                $shipping = $this->getShippingByPlace();
                break;

            case 'one_cost':
                $shipping = config('site_shipping_fees');
                break;

        }
    }

    private function getShippingByPlace(){
        $address = auth()->user()->PrimaryAddress  ;
        if(!$address){
            return __('home.you must have at least one address to calculate shipping');
        }

        $shippingFee = ShippingFees::where('area_id', $address->area_id)->value('fees');

        return $shippingFee ?? config('site_shipping_fees');
    }
}
