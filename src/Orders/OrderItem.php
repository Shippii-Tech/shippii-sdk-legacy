<?php

namespace Shippii\Orders;

use PhpUnitsOfMeasure\Exception\NonNumericValue;
use PhpUnitsOfMeasure\Exception\NonStringUnitName;
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use Tightenco\Collect\Support\Collection;

/**
 * Class OrderItem
 * @package Shippii\Orders
 */
class OrderItem
{
    /**
     * @var Collection
     */
    protected $items;

    /**
     * OrderItem constructor.
     */
    public function __construct()
    {
        $this->items = collect();
    }

    /**
     * Set Order Item
     *
     * @param string $key
     * @param $value
     */
    private function setOrderItem(string $key, $value)
    {
        $this->items->put($key, $value);
    }

    /**
     * Set Order Item Name
     *
     * @param string $name
     * @return OrderItem
     */
    public function setName(string $name): OrderItem
    {
        $this->setOrderItem('name', $name);
        return $this;
    }

    /**
     * Set Quantity of the item
     *
     * @param float $quantity
     * @return OrderItem
     */
    public function setQuantity(float $quantity): OrderItem
    {
        $this->setOrderItem('quantity', $quantity);
        return $this;
    }

    /**
     * Set Order Item Price
     *
     * @param float $price
     * @return OrderItem
     */
    public function setPrice(float $price): OrderItem
    {
        $this->setOrderItem('price', $price);
        return $this;
    }

    /**
     * Set Order Item SKU/SHOP number
     *
     * @param string $sku
     * @return OrderItem
     */
    public function setSku(string $sku): OrderItem
    {
        $this->setOrderItem('sku', $sku);
        return $this;
    }

    /**
     * Set Order Item Sku
     * @param string $ean
     * @return OrderItem
     */
    public function setEan(string $ean): OrderItem
    {
        $this->setOrderItem('ean', $ean);
        return $this;
    }

    /**
     * Set Order Item Weight
     *
     * @param float $weight
     * @param string $measurement
     * @return $this
     * @throws NonNumericValue
     * @throws NonStringUnitName
     */
    public function setWeight(float $weight, $measurement = 'KG')
    {
        $weight = new Mass($weight, strtolower($measurement));
        $this->setOrderItem('weight', $weight->toUnit('kg'));
        return $this;
    }

    public function toArray(): array
    {
        return $this->items->toArray();
    }

}