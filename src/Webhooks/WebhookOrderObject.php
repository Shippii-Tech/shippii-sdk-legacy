<?php

namespace Shippii\Webhooks;

class WebhookOrderObject
{
    /**
     * @var array
     */
    private $payload;

    /**
     * @var string
     */
    private $orderStatus;

    /**
     * @var string
     */
    private $orderId;

    /**
     * @var string
     */
    private $orderReference;

    /**
     * @var string
     */
    private $orderShippingMethod;

    /**
     * @var string
     */
    private $orderCarrier;

    /**
     * Order Object
     * @param array $payload
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
        $this->parse();
    }

    /**
     * Parse the request data
     * @return void
     */
    private function parse(): void
    {
        $this->orderStatus = $this->payload['order_status'] ?? null;
        $this->orderId = $this->payload['order_id'] ?? null;
        $this->orderReference = $this->payload['reference'] ?? null;
        $this->orderShippingMethod = $this->payload['order']['shipping_method'] ?? null;
        $this->orderCarrier = $this->payload['order']['carrier'] ?? null;
    }

    /**
     * Get Order Status
     * @return string
     */
    public function getOrderStatus(): string
    {
        return $this->orderStatus;
    }

    /**
     * Get Order ID
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * Get Order Reference
     * @return string
     */
    public function getOrderReference(): string
    {
        return $this->orderReference;
    }

    /**
     * Get Order Shipping Method
     * @return string
     */
    public function getOrderShippingMethod(): string
    {
        return $this->orderShippingMethod;
    }

    /**
     * Get Order Carrier
     * @return string
     */
    public function getOrderCarrier(): string
    {
        return $this->orderCarrier;
    }

    /**
     * Get Order Receiver Object
     * @return WebhookOrderReceiver
     */
    public function getOrderReceiverObject(): WebhookOrderReceiver
    {
        return new WebhookOrderReceiver($this->payload);
    }

    /**
     * Get Order Items Object
     * @return WebhookOrderItems
     */
    public function getOrderItemsObject(): WebhookOrderItems
    {
        return new WebhookOrderItems($this->payload);
    }

    /**
     * Get Order Labels Object
     * @return WebhookLabelObject
     */
    public function getOrderLabelObject(): WebhookLabelObject
    {
        return new WebhookLabelObject($this->payload);
    }

    /**
     * Get Carrier Parcel Object
     * @return WebhookCarrierParcelObject
     */
    public function getCarrierParcelObject(): WebhookCarrierParcelObject
    {
        return new WebhookCarrierParcelObject($this->payload);
    }
}
