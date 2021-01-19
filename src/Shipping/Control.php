<?php

namespace Shippii\Shipping;

use Shippii\Shippii;
use Shippii\Exceptions\ShippiiValidationException;
use Shippii\Exceptions\ShippiiServerErrorException;
use Shippii\Exceptions\ShippiiEndpointNotFoundException;
use Shippii\Exceptions\Auth\ShippiiAuthorizationException;
use Shippii\Exceptions\Auth\ShippiiAuthenticationException;
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

    public function updateExternalOrderStatus(string $externalStatus, string $yourReference)
    {
        $requestData = new TightencoCollection();
        $requestData->put('query', [
            'external_reference' => $yourReference,
            'external_status' => $externalStatus
        ]);

        return $this->shippii->connector->request('get', 'public/order/external-status', 'v1', $requestData);
    }

    /**
     * @param string $yourReference
     * @return array
     * @throws ShippiiAuthenticationException
     * @throws ShippiiAuthorizationException
     * @throws ShippiiServerErrorException
     * @throws ShippiiValidationException
     * @throws ShippiiEndpointNotFoundException
     */
    public function cancelShipment(string $yourReference): array
    {
        $requestData = new TightencoCollection();
        $requestData->put('query', [
            'external_reference' => $yourReference
        ]);

        return $this->shippii->connector->request('get', 'shipping/cancel', 'v1', $requestData)->toArray();
    }

    /**
     * Close Shipment
     * 
     *
     * @param  string  $yourReference
     * @return array
     * @throws ShippiiAuthenticationException
     * @throws ShippiiAuthorizationException
     * @throws ShippiiEndpointNotFoundException
     * @throws ShippiiServerErrorException
     * @throws ShippiiValidationException
     */
    public function closeShipment(string $yourReference): array
    {
        $requestData = new TightencoCollection();
        $requestData->put('query', [
            'external_reference' => $yourReference
        ]);
        return $this->shippii->connector->request('get', 'shipping/close', 'v1', $requestData)
            ->toArray();
    }
}