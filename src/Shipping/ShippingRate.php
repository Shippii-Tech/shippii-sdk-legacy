<?php

namespace Shippii\Shipping;

use Shippii\Exceptions\Auth\ShippiiAuthenticationException;
use Shippii\Exceptions\Auth\ShippiiAuthorizationException;
use Shippii\Exceptions\Auth\ShippiiEndpointNotFoundException;
use Shippii\Exceptions\ShippiiServerErrorException;
use Shippii\Exceptions\ShippiiValidationException;
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
     * @throws ShippiiAuthenticationException
     * @throws ShippiiAuthorizationException
     * @throws ShippiiEndpointNotFoundException
     * @throws ShippiiServerErrorException
     * @throws ShippiiValidationException
     */
    public function getShippingRates(): array
    {
        $response = $this->shippii->connector->request('GET', 'shipping-rates');
        return $response->toArray();
    }
}