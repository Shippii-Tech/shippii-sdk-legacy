<?php

namespace Shippii\Shipping;

use Shippii\Shippii;

class ShippingMethod
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
     * Get All Shipping Methods
     *
     * @return array
     */
    public function getShippingMethods(): array
    {
        $response = $this->shippii->connector->request('GET', 'shipping-methods');
        return $response->toArray();
    }
}