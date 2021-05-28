<?php

namespace Shippii\Webhooks;

class WebhookOrderReceiver
{
    /**
     * Request Payload
     * @var array
     */
    private $payload;

    /**
     * Receiver First + Last Name
     * @var string
     */
    private $receiverName;

    /**
     * Receiver Email
     * @var string
     */
    private $receiverEmail;

    /**
     * Receiver Mobile
     * @var string
     */
    private $receiverMobile;

    /**
     * Receiver Country Name
     * @var string
     */
    private $receiverCountryName;

    /**
     * Receiver Country Code
     * @var string
     */
    private $receiverCountryCode;

    /**
     * Receiver City
     * @var string
     */
    private $receiverCity;

    /**
     * Receiver Address
     * @var string
     */
    private $receiverAddress;

    /**
     * Receiver Zip Code
     * @var string
     */
    private $receiverZipCode;

    /**
     * Order Receiver
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
        $receiver = $this->payload['order']['receiver'] ?? null;
        $this->receiverName = $receiver['first_name'] ?? null . ' ' . $receiver['last_name'] ?? null;
        $this->receiverEmail = $receiver['email'] ?? null;
        $this->receiverMobile = $receiver['mobile'] ?? null;
        $this->receiverCountryName = $receiver['country']['name'] ?? null;
        $this->receiverCountryCode = $receiver['country']['code'] ?? null;
        $this->receiverCity = $receiver['city'] ?? null;
        $this->receiverAddress = $receiver['address'] ?? null;
        $this->receiverZipCode = $receiver['zip_code'] ?? null;
    }

    /**
     * Return Receiver Full Name
     * @return string
     */
    public function getReceiverName(): string
    {
        return $this->receiverName;
    }

    /**
     * Return Receiver Email
     * @return string
     */
    public function getReceiverEmail(): string
    {
        return $this->receiverEmail;
    }

    /**
     * Return Receiver Mobile
     * @return string
     */
    public function getReceiverMobile(): string
    {
        return $this->receiverMobile;
    }

    /**
     * Return Receiver Country Name
     * @return string
     */
    public function getReceiverCountryName(): string
    {
        return $this->receiverCountryName;
    }

    /**
     * Return Receiver Country Code
     * @return string
     */
    public function getReceiverCountryCode(): string
    {
        return $this->receiverCountryCode;
    }

    /**
     * Return Receiver City
     * @return string
     */
    public function getReceiverCity(): string
    {
        return $this->receiverCity;
    }

    /**
     * Return Receiver Address
     * @return string
     */
    public function getReceiverAddress(): string
    {
        return $this->receiverAddress;
    }

    /**
     * Return Receiver Zip Code
     * @return string
     */
    public function getReceiverZipCode(): string
    {
        return $this->receiverZipCode;
    }
}
