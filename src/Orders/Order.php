<?php

namespace Shippii\Orders;

use Tightenco\Collect\Support\Collection as TightencoCollection;

class Order
{
    /**
     * @var TightencoCollection
     */
    private $receiverData;

    /**
     * @var TightencoCollection $orderItems
     */
    private $orderItems;

    /**
     * @var TightencoCollection
     */
    private $options;

    public function __construct()
    {
        $this->options = new TightencoCollection();
        $this->options->put('meta_data', new TightencoCollection());
        $this->receiverData = new TightencoCollection();
        $this->orderItems = new TightencoCollection();
    }

    /**
     * Set Receiver Data
     *
     * @param string $key
     * @param $value
     * @return Order
     */
    private function setReceiverData(string $key, $value): Order
    {
        $this->receiverData->put($key, $value);
        return $this;
    }

    /**
     * Set Options
     *
     * @param string $key
     * @param $value
     * @return Order
     */
    private function setOptionsData(string $key, $value): Order
    {
        $this->options->put($key, $value);
        return $this;
    }

    /**
     * Set Receiver First Name
     *
     * @param string $name
     * @return Order
     */
    public function setReceiverFirstName(string $name): Order
    {
        $this->setReceiverData('receiver_first_name', $name);
        return $this;

    }

    /**
     *
     * Order Meta Data Setter
     *
     * Using this method you can attach additional data to the order
     *
     * @param array $data
     * @return Order
     */
    public function setMetaData(array $data): Order
    {
        /** @var TightencoCollection $metaData */
        $metaData = $this->options->get('meta_data');
        foreach ($data as $key => $datum) {
            $metaData->put($key, $datum);
        }
        return $this;
    }

    /**
     * Set Service Point ID
     *
     * @param  string  $servicePointId
     * @return $this
     */
    public function setServicePointId(string $servicePointId): Order
    {
        $this->setOptionsData('service_point_id', $servicePointId);
        return $this;
    }

    /**
     * Set Shipping Rate Alias Name
     *
     * @param string $name
     * @return Order
     */
    public function setShippingRateAliasName(string $name): Order
    {
        $struct['shipping_rate_alias_name'] = $name;
        $this->setMetaData($struct);
        return $this;
    }

    /**
     * Set Shipping Rate Alias Name
     *
     * @param float $price
     * @return Order
     */
    public function setShippingRateAliasPrice(float $price): Order
    {
        $struct['shipping_rate_alias_price'] = $price;
        $this->setMetaData($struct);
        return $this;
    }

    /**
     * Set Client Reference
     *
     * @param string $name
     * @return Order
     */
    public function setClientReference(string $name): Order
    {
        $struct['client_reference'] = $name;
        $this->setMetaData($struct);
        return $this;
    }

    /**
     * Set Receiver Last Name
     *
     * @param string $lastName
     * @return Order
     */
    public function setReceiverLastName(string $lastName): Order
    {
        $this->setReceiverData('receiver_last_name', $lastName);
        return $this;
    }

    /**
     * Set Receiver Mobile Phone
     *
     * @param string $mobile
     * @return Order
     */
    public function setReceiverMobile(string $mobile): Order
    {
        $this->setReceiverData('receiver_mobile', $mobile);
        return $this;
    }

    /**
     * Set Receiver Email
     *
     * @param string $email
     * @return Order
     */
    public function setReceiverEmail(string $email): Order
    {
        $this->setReceiverData('receiver_email', $email);
        return $this;
    }

    /**
     * Set Receiver Address
     *
     * @param string $address
     * @return Order
     */
    public function setReceiverAddress(string $address): Order
    {
        $this->setReceiverData('receiver_address', $address);
        return $this;
    }

    /**
     * Set Receiver City
     *
     * @param string $city
     * @return Order
     */
    public function setReceiverCity(string $city): Order
    {
        $this->setReceiverData('receiver_city', $city);
        return $this;
    }

    /**
     * Set Receiver Province
     *
     * @param string $province
     * @return Order
     */
    public function setReceiverProvince(string $province): Order
    {
        $this->setReceiverData('receiver_province', $province);
        return $this;
    }

    /**
     * Set Receiver Destrict
     *
     * @param string $district
     * @return Order
     */
    public function setReceiverDistrict(string $district): Order
    {
        $this->setReceiverData('receiver_district', $district);
        return $this;
    }

    /**
     * Set Receiver Identification
     *
     * @param string $receiverIdentificationNumber
     * @return Order
     */
    public function setReceiverIdentificationNumber(string $receiverIdentificationNumber): Order
    {
        $this->setReceiverData('receiver_personal_identification_number', $receiverIdentificationNumber);
        return $this;
    }

    /**
     * Set Receiver Zip Code
     *
     * @param string $zipCode
     * @return Order
     */
    public function setReceiverZipCode(string $zipCode): Order
    {
        $this->setReceiverData('receiver_zip_code', $zipCode);
        return $this;
    }

    /**
     * Set Receiver Country Code
     *
     * Format: BG, RU, NO, DK
     *
     * @param string $countryCode
     * @return Order
     */
    public function setReceiverCountryCode(string $countryCode): Order
    {
        $this->setReceiverData('receiver_country_code', $countryCode);
        return $this;
    }

    /**
     * Set Receiver Company Name
     * @param string $companyName
     * @return Order
     */
    public function setReceiverCompanyName(string $companyName): Order
    {
        $this->setReceiverData('receiver_company_name', $companyName);
        return $this;
    }

    /**
     * Set Order Item
     * @param OrderItem $orderItem
     * @return Order
     */
    public function setOrderItem(OrderItem $orderItem): Order
    {
        $this->orderItems->push(collect($orderItem->toArray()));
        return $this;
    }

    /**
     * Pay From Wallet
     * @param bool $val
     * @return $this
     */
    public function setPayFromWallet(bool $val)
    {
        $this->setOptionsData('pay_from_company_wallet', $val);
        return $this;
    }

    public function setShippingRateId(string $shippingRateId)
    {
        $this->setOptionsData('shipping_rate_id', $shippingRateId);
    }

    public function setShippingMethodId(string $shippingMethodId)
    {
        $this->setOptionsData('shipping_method_id', $shippingMethodId);
    }

    /**
     * Set Order Reference
     *
     * @param string $reference
     * @return Order
     */
    public function setReference(string $reference): Order
    {
        $this->setOptionsData('reference', $reference);
        return $this;
    }

    /**
     * Set external order to status
     * @param string $externalStatus
     * @return Order
     */
    public function setExternalOrderStatus(string $externalStatus): Order
    {
        $this->setOptionsData('external_status', $externalStatus);
        return $this;
    }

    /**
     * Billing Same As Shipment
     *
     * @param bool $val
     * @return Order
     */
    public function setBillingAddressSameAsShipment(bool $val = true): Order
    {
        $this->setOptionsData('billing_address_same_as_shipment', $val);
        return $this;
    }

    /**
     * Set Comment for metadata.
     * @param string $comment
     * @return Order
     */
    public function setComment(string $comment): Order
    {
        $this->setOptionsData('comment', $comment);
        return $this;
    }

    public function getOrderOptions(): TightencoCollection
    {
        return $this->options;
    }

    /**
     * @return TightencoCollection
     */
    public function getOrderItems(): TightencoCollection
    {
        return $this->orderItems;
    }

    /**
     * Get Receiver Data
     *
     * @return TightencoCollection
     */
    public function getReceiver(): TightencoCollection
    {
        return $this->receiverData;
    }
}