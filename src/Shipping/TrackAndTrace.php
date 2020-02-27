<?php

namespace Shippii\Shipping;

use Shippii\Shippii;
use Tightenco\Collect\Support\Collection as TightencoCollection;

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
        $requestData = new TightencoCollection();
        $requestData->put('query', [
            'external_reference' => $trackingId
        ]);
        $response = $this->shippii->connector->request('GET', 'shipping/track-and-trace', 'v1', $requestData);
    }
}