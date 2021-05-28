<?php

namespace Shippii\Webhooks;

class WebhookCarrierParcelObject
{
    /** @var array */
    private $payload;

    /** @var string */
    private $carrier_order_number;

    /** @var string */
    private $carrier_tracking_url;

    /** @var array */
    private $parcels = [];

    /**
     * Carrier Parcel Object
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
    protected function parse(): void
    {
        $carrier = $this->payload['data']['carrier'] ?? null;
        $this->carrier_order_number = $carrier['carrier_order_number'] ?? null;
        $this->carrier_tracking_url = $carrier['carrier_tracking_url'] ?? null;
        
        if (isset($carrier['parcels'])) {
            foreach ($carrier['parcels'] as $key => $parcel) {
                array_push($this->parcels, [
                    'line' => $parcel['line'] ?? null,
                    'number' => $parcel['number'] ?? null,
                    'tracking_url' => $parcel['tracking_url'] ?? null
                ]);
            }
        }
    }

    /**
     * Get Carrier Order Number
     * @return string
     */
    public function getCarrierOrderNumber(): string
    {
        return $this->carrier_order_number;
    }


    /**
     * Get Carrier Tracking Url
     * @return string
     */
    public function getCarrierTrackingUlr(): string
    {
        return $this->carrier_tracking_url;
    }

    /**
     * Get Carrier Parcel Data
     * @return array
     */
    public function getCarrierParcels(): array
    {
        return $this->parcels;
    }
}
