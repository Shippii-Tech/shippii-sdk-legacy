<?php

namespace Shippii\Shipping;

use Shippii\Shippii;

class ShippingRate
{
    /**
     * @var Shippii
     */
    protected $shippii;

    public function __construct(Shippii $shippii)
    {
        $this->shippii = $shippii;
    }

    /**
     * Get All Shipping Rates
     *  
     * @return array
     */
    public function getShippingRates(): array
    {
        $response = $this->shippii->connector->request('GET', 'shipping-rates');
        return $response->toArray();
    }
}