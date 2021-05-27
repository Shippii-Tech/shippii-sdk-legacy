<?php

namespace Shippii\Webhooks;

class WebhookOrderItems
{
    /** 
     * @var array
     */
    private $payload;
    /** 
     * @var array
     */
    private $itemNames = [];
    /** 
     * @var array
     */
    private $itemSkus = [];
    /** 
     * @var array
     */
    private $itemEans = [];
    /** 
     * @var array
     */
    private $itemWeights = [];
    /** 
     * @var array
     */
    private $itemVolumes = [];
    /** 
     * @var array
     */
    private $itemQuantities = [];

    /**
     * Order Items
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
    private function parse()
    {
        $items = $this->payload['order']['items'];

        foreach ($items as $item) {
            array_push($this->itemNames, $item['name'] ?? null);
            array_push($this->itemSkus, $item['sku'] ?? null);
            array_push($this->itemEans, $item['ean'] ?? null);
            array_push($this->itemWeights, $item['weight'] ?? null);
            array_push($this->itemVolumes, $item['volume'] ?? null);
            array_push($this->itemQuantities, $item['quantity'] ?? null);
        }
    }

    /**
     * Get Item Names
     * @return array
     */
    public function getItemNames(): array
    {
        return $this->itemNames;
    }
    
    /**
     * Get Item Skus
     * @return array
     */
    public function getItemSkus(): array
    {
        return $this->itemSkus;
    }

    /**
     * Get Item Eans
     * @return array
     */
    public function getItemEans(): array
    {
        return $this->itemEans;
    }

    /**
     * Get Item Weights
     * @return array
     */
    public function getItemWeights(): array
    {
        return $this->itemWeights;
    }

    /**
     * Get Item Volumes
     * @return array
     */
    public function getItemVolumes(): array
    {
        return $this->itemVolumes;
    }

    /**
     * Get Item Quantities
     * @return array|null
     */
    public function getItemQuantities()
    {
        return $this->itemQuantities;
    }
}
