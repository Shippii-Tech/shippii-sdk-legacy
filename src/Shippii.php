<?php

namespace Shippii;

use Shippii\Orders\Order;
use Tightenco\Collect\Support\Collection as TightencoCollection;

/**
 * Class Shippii
 * @package Shippii
 */
class Shippii
{
    /**
     * @var bool
     */
    protected $testMode = true;

    /**
     * @var string $token
     */
    protected $token;

    /**
     * @var Order $order
     */
    protected $order;

    /**
     * @var Connector $connector
     */
    public $connector;

    /**
     * Shippii constructor.
     * @param string $token
     * @param bool $testMode
     * @param string|null $baseUrl
     */
    public function __construct(string $token, bool $testMode, string $baseUrl = null)
    {
        $this->connector = new Connector($token, $testMode, $baseUrl);
        $this->testMode = $testMode;
        $this->token = $token;
    }

    /**
     * Get The authorization Token
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Set The authorization Token
     * @param string $token
     * @return Shippii
     */
    public function setToken(string $token): Shippii
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Set the order object
     *
     * @param Order $order
     * @return Shippii
     */
    public function setOrder(Order $order): Shippii
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Prepare The Order
     * @return TightencoCollection
     */
    protected function prepareOrder()
    {
        $result = $this->order->getReceiver()->toArray();
        $result += $this->order->getOrderOptions()->toArray();
        $result['items'] = $this->order->getOrderItems()->toArray();
        return new TightencoCollection(['json' => $result]);
    }

    /**
     * Send the order
     *
     * @return array
     * @throws Exceptions\Auth\ShippiiAuthenticationException
     * @throws Exceptions\Auth\ShippiiAuthorizationException
     * @throws Exceptions\Auth\ShippiiEndpointNotFoundException
     * @throws Exceptions\ShippiiServerErrorException
     * @throws Exceptions\ShippiiValidationException
     */
    public function sendOrder(): array
    {
        $orderData = $this->prepareOrder();
        $connection = new Connector($this->token);
        $response = $connection->request('post', 'order', 'v1', $orderData);
        return $response->toArray();
    }

}