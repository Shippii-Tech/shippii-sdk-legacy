<?php

namespace Shippii\Shipping;

use PhpUnitsOfMeasure\Exception\NonNumericValue;
use PhpUnitsOfMeasure\Exception\NonStringUnitName;
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use RuntimeException;
use Shippii\Exceptions\Auth\ShippiiAuthenticationException;
use Shippii\Exceptions\Auth\ShippiiAuthorizationException;
use Shippii\Exceptions\ShippiiEndpointNotFoundException;
use Shippii\Exceptions\ShippiiServerErrorException;
use Shippii\Exceptions\ShippiiValidationException;
use Shippii\Shippii;
use Tightenco\Collect\Support\Collection as TightencoCollection;

/**
 * Class LivePrice
 * @package Shippii\Shipping
 */
class LivePrice
{
    /**
     * @var Shippii
     */
    private $shippii;

    /**
     * @var string $receiverCountryCode
     */
    private $receiverCountryCode;

    /**
     * @var string $receiverZipCode
     */
    private $receiverZipCode;

    /**
     * @var array
     */
    private $cartItems = [];

    /**
     * LivePrice constructor.
     * @param Shippii $shippii
     */
    public function __construct(Shippii $shippii)
    {
        $this->shippii = $shippii;
    }

    /**
     * Set Receiver Country Code
     *
     * @param string $receiverCountryCode
     * @return LivePrice
     */
    public function setReceiverCountryCode(string $receiverCountryCode): LivePrice
    {
        $this->receiverCountryCode = $receiverCountryCode;
        return $this;
    }

    /**
     * Set Receiver Zip Code
     *
     * @param string $receiverZipCode
     * @return LivePrice
     */
    public function setReceiverZipCode(string $receiverZipCode): LivePrice
    {
        $this->receiverZipCode = $receiverZipCode;
        return $this;
    }

    /**
     * Set Cart Items From Array
     * @param array $items
     * @return LivePrice
     */
    public function setCartItemsFromArray(array $items): LivePrice
    {
        foreach ($items as $item) {
            if (!isset($item['weight']) and !isset($item['quantity'])) {
                throw new RuntimeException("Cart item weight and quantity must be set !");
            }
            if (!isset($item['weight_measurement'])) {
                $item['weight_measurement'] = 'kg';
            }
            $this->setCartItem($item['quantity'], $item['weight'], $item['weight_measurement']);
        }

        return $this;
    }

    /**
     * Set Cart Item
     *
     * @param float $quantity
     * @param float $weight
     * @param string $weightMeasurement
     * @return LivePrice
     */
    public function setCartItem(float $quantity, float $weight, string $weightMeasurement = 'kg'): LivePrice
    {
        try {
            //$weight = ($weight * $quantity);
            $mass = new Mass($weight, strtolower($weightMeasurement));
        } catch (NonNumericValue $e) {
            throw new RuntimeException("Cart item weight must be float / integer");
        } catch (NonStringUnitName $e) {
            throw new RuntimeException("Weight Measurement must be string");
        }
        $arr = [
            'quantity' => $quantity,
            'weight' => $mass->toUnit('kg')
        ];
        array_push($this->cartItems, $arr);
        return $this;
    }

    /**
     * Prepare the request
     *
     * @return TightencoCollection
     */
    protected function prepareTheRequest(): TightencoCollection
    {
        $result = new TightencoCollection();
        $result->put('json', [
            'receiver_country_code' => $this->receiverCountryCode,
            'receiver_zip_code' => $this->receiverZipCode,
            'items' => $this->cartItems
        ]);

        return $result;
    }

    /**
     * Do the actual Request
     *
     * @return array
     * @throws ShippiiAuthenticationException
     * @throws ShippiiAuthorizationException
     * @throws ShippiiEndpointNotFoundException
     * @throws ShippiiServerErrorException
     * @throws ShippiiValidationException
     */
    public function getLivePrice(): array
    {
        $request = $this->prepareTheRequest();
        $response = $this->shippii->connector->request('post', 'shipping/live-prices', 'v1', $request);
        return $response->toArray();
    }
}