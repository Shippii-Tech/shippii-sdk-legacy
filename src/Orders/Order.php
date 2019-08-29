<?php

namespace Shippii\Orders;

use Tightenco\Collect\Support\Collection;

class Order
{
    /**
     * @var Collection
     */
    private $receiverData;

    /**
     * @var Collection $orderItems
     */
    private $orderItems;


    public function __construct()
    {
        $this->receiverData = collect();
        $this->orderItems = collect();
    }

    /**
     * @param string $key
     * @param $value
     * @return Order
     */
    private function setReceiverData(string $key, $value)
    {
        $this->receiverData = $this->receiverData->put($key, $value);
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
     * @return Collection
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    /**
     * Get Receiver Data
     *
     * @return Collection
     */
    public function getReceiver(): Collection
    {
        return $this->receiverData;
    }

}