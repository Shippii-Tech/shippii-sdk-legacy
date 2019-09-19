<?php

namespace Shippii\Shipping;

use Shippii\Exceptions\Auth\ShippiiAuthenticationException;
use Shippii\Exceptions\Auth\ShippiiAuthorizationException;
use Shippii\Exceptions\Auth\ShippiiEndpointNotFoundException;
use Shippii\Exceptions\ShippiiServerErrorException;
use Shippii\Exceptions\ShippiiValidationException;
use Shippii\Shippii;
use Tightenco\Collect\Support\Collection as TightencoCollection;

/**
 * Class Control
 * @package Shippii\Shipping
 */
class Control
{
    /**
     * @var Shippii
     */
    private $shippii;

    /**
     * Control constructor.
     * @param Shippii $shippii
     */
    public function __construct(Shippii $shippii)
    {
        $this->shippii = $shippii;
    }

    /**
     * @param string $yourReference
     * @return array
     * @throws ShippiiAuthenticationException
     * @throws ShippiiAuthorizationException
     * @throws ShippiiServerErrorException
     * @throws ShippiiValidationException
     * @throws \Shippii\Exceptions\ShippiiEndpointNotFoundException
     */
    public function cancelShipment(string $yourReference): array
    {
        $requestData = new TightencoCollection();
        $requestData->put('query', [
            'external_reference' => $yourReference
        ]);

        return $this->shippii->connector->request('get', 'shipping/cancel', 'v1', $requestData)->toArray();
    }

    public function closeShipment(string $yourReference)
    {
        return 'NOT IMPLEMENTED YET';
    }
}