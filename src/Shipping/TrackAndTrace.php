<?php

namespace Shippii\Shipping;

use Shippii\Shippii;

class TrackAndTrace
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
     * Get Track and trace data
     *
     * @return array
     * @throws ShippiiAuthenticationException
     * @throws ShippiiAuthorizationException
     * @throws ShippiiServerErrorException
     * @throws ShippiiValidationException
     * @throws \Shippii\Exceptions\ShippiiEndpointNotFoundException
     */

    public function trackAndTrace($trackingId)
    {
        $response = $this->shippii->connector->request('GET', 'track-and-trace/'. $trackingId, 'v1');
        return $response;
    }
}