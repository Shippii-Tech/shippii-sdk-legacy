<?php

namespace Shippii;

use phpDocumentor\Reflection\Types\Void_;
use Shippii\Orders\Order;
use Shippii\Shipping\ShippingMethod;
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
     * @var Order $order
     */
    protected $orders;

    /**
     * @var ShippingMethod $shippingMethod
     */
    protected $shippingMethod;

    /**
     * @var Connector $connector
     */
    public $connector;

    const APP_URLS = [
        'live_env' => 'https://api.shippii.com/',
        'dev_env'  => 'https://test-api.shippii.com/',
        'stage_env' => 'https://stage-api.shippii.com/',
    ];

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
     * Set the orders array
     *
     * @param Order $order
     * @return Shippii
     */
    public function setOrders(array $orders): Shippii
    {
        $this->orders = $orders;
        return $this;
    }

    /**
     * Prepare The Order
     * @return TightencoCollection
     */
    protected function prepareOrder(): TightencoCollection
    {
        $result = $this->order->getReceiver()->toArray();
        $result += $this->order->getOrderOptions()->toArray();
        $result['items'] = $this->order->getOrderItems()->toArray();
        return new TightencoCollection(['json' => $result]);
    }

    /**
     * Prepare The Order
     * @return TightencoCollection
     */
    protected function prepareBulkOrders(): TightencoCollection
    {
        foreach ($this->orders as $k => $order) {
            $result['orders'][$k] = $order->getReceiver()->toArray();
            $result['orders'][$k] += $order->getOrderOptions()->toArray();
            $result['orders'][$k]['items'] = $order->getOrderItems()->toArray();
        }

        return new TightencoCollection(['json' => $result]);
    }

    /**
     * Send the order
     *
     * @return array
     * @throws Exceptions\Auth\ShippiiAuthenticationException
     * @throws Exceptions\Auth\ShippiiAuthorizationException
     * @throws Exceptions\ShippiiEndpointNotFoundException
     * @throws Exceptions\ShippiiServerErrorException
     * @throws Exceptions\ShippiiValidationException
     */

    public function sendOrder(): array
    {
        $orderData = $this->prepareOrder();
        $response = $this->connector->request('post', 'order', 'v1', $orderData);
        return $response->toArray();
    }

    /**
     * Send the order bulk
     *
     * @return array
     * @throws Exceptions\Auth\ShippiiAuthenticationException
     * @throws Exceptions\Auth\ShippiiAuthorizationException
     * @throws Exceptions\ShippiiEndpointNotFoundException
     * @throws Exceptions\ShippiiServerErrorException
     * @throws Exceptions\ShippiiValidationException
     */

    public function sendBulkOrders($ordersForProcess): array
    {
        $ordersBulkData = $this->prepareBulkOrders();
        $connection = $this->connector;
        $response = $connection->request('post', 'order/store-bulk', 'v1', $ordersBulkData);
        return $response->toArray();
    }
}