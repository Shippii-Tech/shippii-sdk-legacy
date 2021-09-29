<?php

namespace Shippii\Shipping;

use Shippii\Shippii;
use Tightenco\Collect\Support\Collection;

class EnableShipment
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
     * @var string $receiver_first_name
     */
    private $receiver_first_name;
    /**
     * @var string $receiver_last_name
     */
    private $receiver_last_name;
    /**
     * @var string $receiver_email
     */
    private $receiver_email;
    /**
     * @var string $receiver_mobile
     */
    private $receiver_mobile;
    /**
     * @var string $receiver_address
     */
    private $receiver_address;
    /**
     * @var string $receiver_city
     */
    private $receiver_city;
    /**
     * @var string $receiver_zip_code
     */
    private $receiver_zip_code;

    public function __construct(Shippii $shippii)
    {
        $this->shippii = $shippii;
    }

    protected function prepareRequest(): Collection
    {
        $result = new Collection();

        $requestData = [];
        $this->order_id ? $requestData['order_id'] = $this->order_id : null;
        $this->external_reference ? $requestData['external_reference'] = $this->external_reference : null;
        $this->receiver_first_name ? $requestData['receiver_first_name'] = $this->receiver_first_name : null;
        $this->receiver_last_name ? $requestData['receiver_last_name'] = $this->receiver_last_name : null;
        $this->receiver_email ? $requestData['receiver_email'] = $this->receiver_email : null;
        $this->receiver_mobile ? $requestData['receiver_mobile'] = $this->receiver_mobile : null;
        $this->receiver_address ? $requestData['receiver_address'] = $this->receiver_address : null;
        $this->receiver_city ? $requestData['receiver_city'] = $this->receiver_city : null;
        $this->receiver_zip_code ? $requestData['receiver_zip_code'] = $this->receiver_zip_code : null;

        return $result->put('json', $requestData);
    }

    /**
     * Send request for Enable Shipment
     *
     * @return array
     */
    public function getEnableShipment(): array
    {
        $request = $this->prepareRequest();
        $response = $this->shippii->connector->request('put', 'shipping/enable', 'v1', $request);
        return $response->toArray();
    }

    /**
     * Set Order ID
     * @param string $orderId
     * @return EnableShipment
     */
    public function setOrderId(string $orderId): EnableShipment
    {
        $this->order_id = $orderId;
        return $this;
    }

    /**
     * Set External Reference
     * @param string $externalReference
     * @return EnableShipment
     */
    public function setExternalReference(string $externalReference): EnableShipment
    {
        $this->external_reference = $externalReference;
        return $this;        
    }

    /**
     * Set Receiver First Name
     *
     * @param string $receiverFirstName
     * @return EnableShipment
     */
    public function setReceiverFirstName(string $receiverFirstName): EnableShipment
    {
        $this->receiver_first_name = $receiverFirstName;
        return $this;
    }

    /**
     * Set Receiver Last Name
     *
     * @param string $receiverLastName
     * @return EnableShipment
     */
    public function setReceiverLastName(string $receiverLastName): EnableShipment
    {
        $this->receiver_last_name = $receiverLastName;
        return $this;
    }

    /**
     * Set Receiver Email
     *
     * @param string $receiverEmail
     * @return EnableShipment
     */
    public function setReceiverEmail(string $receiverEmail): EnableShipment
    {
        $this->receiver_email = $receiverEmail;
        return $this;
    }

    /**
     * Set Receiver Mobile
     *
     * @param string $receiverMobile
     * @return EnableShipment
     */
    public function setReceiverMobile(string $receiverMobile): EnableShipment
    {
        $this->receiver_mobile = $receiverMobile;
        return $this;
    }

    /**
     * Set Receiver Address
     *
     * @param string $receiverAddress
     * @return EnableShipment
     */
    public function setReceiverAddress(string $receiverAddress): EnableShipment
    {
        $this->receiver_address = $receiverAddress;
        return $this;
    }

    /**
     * Set Receiver City
     *
     * @param string $receiverCity
     * @return EnableShipment
     */
    public function setReceiverCity(string $receiverCity): EnableShipment
    {
        $this->receiver_city = $receiverCity;
        return $this;
    }

    /**
     * Set Receiver Zip Code
     *
     * @param string $receiverZipCode
     * @return EnableShipment
     */
    public function setReceiverZipCode(string $receiverZipCode): EnableShipment
    {
        $this->receiver_zip_code = $receiverZipCode;
        return $this;
    }
}
