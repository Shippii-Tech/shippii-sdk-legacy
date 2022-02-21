<?php

namespace Shippii\Orders;

use Shippii\Shippii;
use Tightenco\Collect\Support\Collection as TightencoCollection;

class UpdateStoreOrder
{
    /** @var Shippii $shippii */
    private $shippii;
    /** @var string $order_id */
    private $order_id;
    /** @var string $externalReference */
    private $externalReference;
    /** @var string $receiver_first_name */
    private $receiver_first_name;
    /** @var string $receiver_last_name */
    private $receiver_last_name;
    /** @var string $receiver_email */
    private $receiver_email;
    /** @var string $receiver_mobile */
    private $receiver_mobile;
    /** @var string $receiver_address */
    private $receiver_address;
    /** @var string $receiver_city */
    private $receiver_city;
    /** @var string $receiver_province */
    private $receiver_province = null;
    /** @var string $receiver_zip_code */
    private $receiver_zip_code;
    /** @var string $receiver_company_name */
    private $receiver_company_name;
    /** @var string $shipping_group */
    private $shipping_group;

    public function __construct(Shippii $shippii)
    {
        $this->shippii = $shippii;
    }

    /**
     * Set Order ID - which is for update.
     * @param string $order_id
     * @return UpdateStoreOrder
     */
    public function setOrderId(string $order_id): UpdateStoreOrder
    {
        $this->order_id = $order_id;
        return $this;
    }

    /**
     * Set External Reference
     * @param string $externalReference
     * @return UpdateStoreOrder
     */
    public function setExternalReference(string $externalReference): UpdateStoreOrder
    {
        $this->externalReference = $externalReference;
        return $this;
    }

    /**
     * Set Receiver First Name
     * @param string $receiver_first_name
     * @return UpdateStoreOrder
     */
    public function setReceiverFirstName(string $receiver_first_name): UpdateStoreOrder
    {
        $this->receiver_first_name = $receiver_first_name;
        return $this;
    }

    /**
     * Set Receiver Last Name
     * @param string $receiver_last_name
     * @return UpdateStoreOrder
     */
    public function setReceiverLastName(string $receiver_last_name): UpdateStoreOrder
    {
        $this->receiver_last_name = $receiver_last_name;
        return $this;
    }

    /**
     * Set Receiver Email
     * @param string $receiver_email
     * @return UpdateStoreOrder
     */
    public function setReceiverEmail(string $receiver_email): UpdateStoreOrder
    {
        $this->receiver_email = $receiver_email;
        return $this;
    }

    /**
     * Set Receiver Mobile
     * @param string $receiver_mobile
     * @return UpdateStoreOrder
     */
    public function setReceiverMobile(string $receiver_mobile): UpdateStoreOrder
    {
        $this->receiver_mobile = $receiver_mobile;
        return $this;
    }

    /**
     * Set Receiver Address
     * @param string $receiver_address
     * @return UpdateStoreOrder
     */
    public function setReceiverAddress(string $receiver_address): UpdateStoreOrder
    {
        $this->receiver_address = $receiver_address;
        return $this;
    }

    /**
     * Set Receiver City
     * @param string $receiver_city
     * @return UpdateStoreOrder
     */
    public function setReceiverCity(string $receiver_city): UpdateStoreOrder
    {
        $this->receiver_city = $receiver_city;
        return $this;
    }

    /**
     * Set Receiver Province
     * @param string $receiver_province
     * @return UpdateStoreOrder
     */
    public function setReceiverProvince(string $receiver_province): UpdateStoreOrder
    {
        $this->receiver_province = $receiver_province;
        return $this;
    }

    /**
     * Set Receiver Zip Code
     * @param string $receiver_zip_code
     * @return UpdateStoreOrder
     */
    public function setReceiverZipCode(string $receiver_zip_code): UpdateStoreOrder
    {
        $this->receiver_zip_code = $receiver_zip_code;
        return $this;
    }

    /**
     * Set Receiver Company Name
     * @param string $receiver_company_name
     * @return UpdateStoreOrder
     */
    public function setReceiverCompanyName(string $receiver_company_name): UpdateStoreOrder
    {
        $this->receiver_company_name = $receiver_company_name;
        return $this;
    }

    /**
     * Set Order Shipping Group
     * @param string $shipping_group
     * @return UpdateStoreOrder
     */
    public function setShippingGroup(string $shipping_group): UpdateStoreOrder
    {
        $this->shipping_group = $shipping_group;
        return $this;
    }

    protected function prepareRequest(): TightencoCollection
    {
        $result = new TightencoCollection();
        if ($this->order_id) {
            return $result->put('json', [
                'order_id' => $this->order_id,
                'receiver_first_name' => $this->receiver_first_name,
                'receiver_last_name' => $this->receiver_last_name,
                'receiver_email' => $this->receiver_email,
                'receiver_mobile' => $this->receiver_mobile,
                'receiver_address' => $this->receiver_address,
                'receiver_city' => $this->receiver_city,
                'receiver_province' => $this->receiver_province,
                'receiver_zip_code' => $this->receiver_zip_code,
                'receiver_company_name' => $this->receiver_company_name,
                'shipping_group' => $this->shipping_group
            ]);
        }
        return $result->put('json', [
            'external_reference' => $this->externalReference,
            'receiver_first_name' => $this->receiver_first_name,
            'receiver_last_name' => $this->receiver_last_name,
            'receiver_email' => $this->receiver_email,
            'receiver_mobile' => $this->receiver_mobile,
            'receiver_address' => $this->receiver_address,
            'receiver_city' => $this->receiver_city,
            'receiver_province' => $this->receiver_province,
            'receiver_zip_code' => $this->receiver_zip_code,
            'receiver_company_name' => $this->receiver_company_name,
            'shipping_group' => $this->shipping_group
        ]);
    }

    public function getUpdateStoreOrder(): array
    {
        $request = $this->prepareRequest();
        $response = $this->shippii->connector->request('put', 'public/store-update', 'v1', $request);
        return $response->toArray();
    }
}
