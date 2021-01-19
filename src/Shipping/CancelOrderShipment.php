<?php

namespace Shippii\Shipping;

use Shippii\Shippii;
use Tightenco\Collect\Support\Collection as TightencoCollection;

class CancelOrderShipment
{
    /**
     * @var Shippii $shippii
     */
    private $shippii;

    /**
     * @var string $order_id
     */
    private $order_id;

    /**
     * @var string $external_reference
     */
    private $external_reference;

    /**
     * Cancel Order Shipment
     * @param Shippii $shippii
     * @return void
     */
    public function __construct(Shippii $shippii)
    {
        $this->shippii = $shippii;
    }

    /**
     * Set Order ID if any.
     * @param string $order_id
     * @return CancelOrderShipment
     */
    public function setOrderId(string $order_id): CancelOrderShipment
    {
        $this->order_id = $order_id;
        return $this;
    }

    /**
     * Set external reference if any
     * @param string $external_reference
     * @return CancelOrderShipment
     */
    public function setExternalReference(string $external_reference): CancelOrderShipment
    {
        $this->external_reference = $external_reference;
        return $this;
    }

    /**
     * Prepare request
     * @return TightencoCollection
     */
    protected function prepareRequest(): TightencoCollection
    {
        $result = new TightencoCollection();
        $result->put('json', [
            'order_id' => $this->order_id,
            'external_reference' => $this->external_reference
        ]);
        return $result;
    }

    public function getCancelShipment(): array
    {
        $request = $this->prepareRequest();
        $response = $this->shippii->connector->request('get', 'shipping/cancel', 'v1', $request);
        return $response->toArray();
    }
}
