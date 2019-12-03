<?php

namespace Shippii\Labels;

use Shippii\Exceptions\Auth\ShippiiAuthenticationException;
use Shippii\Exceptions\Auth\ShippiiAuthorizationException;
use Shippii\Exceptions\ShippiiEndpointNotFoundException;
use Shippii\Exceptions\ShippiiServerErrorException;
use Shippii\Exceptions\ShippiiValidationException;
use Shippii\Shippii;
use Tightenco\Collect\Support\Collection as TightencoCollection;

/**
 * Class Merged
 * @package Shippii\Labels
 */
class Merged
{
    /**
     * @var Shippii
     */
    private $shippii;

    /**
     * Merged constructor.
     * @param Shippii $shippii
     */
    public function __construct(Shippii $shippii)
    {
        $this->shippii = $shippii;
    }

    /**
     * Prepare the request
     *
     * @param array $references
     * @param array $options
     * @return TightencoCollection
     */
    protected function prepareRequest(array $references, array $options = []): TightencoCollection
    {
        $request = new TightencoCollection([
            'json' => $references
        ]);
        $request->put('query', $options);

        return $request;
    }

    /**
     * Get Labels for specific orders
     *
     * @param array $references
     * @param array $options
     * @return array
     * @throws ShippiiAuthenticationException
     * @throws ShippiiAuthorizationException
     * @throws ShippiiEndpointNotFoundException
     * @throws ShippiiServerErrorException
     * @throws ShippiiValidationException
     */
    public function bySelectedOrders(array $references, array $options = []): array
    {
        $options = $this->prepareRequest($references, $options);
        $response = $this->shippii->connector->request(
            'POST',
            'label/get/selected-orders',
            "v1",
            $options
        );
        return $response->toArray();
    }
}