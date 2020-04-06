<?php
namespace Shippii\Support;

use Shippii\Shippii;
use Tightenco\Collect\Support\Collection as TightencoCollection;

/**
 * Class Shopify
 * @package Shippii\Support
 */
class Shopify
{
    /**
     * @var Shippii
     */
    private $shippii;

    /**
     * Shopify constructor.
     * @param  Shippii  $shippii
     */
    public function __construct(Shippii $shippii)
    {
        $this->shippii = $shippii;
    }

    /**
     * @param  int  $shopifyOrderId
     * @return array
     * @throws \Shippii\Exceptions\Auth\ShippiiAuthenticationException
     * @throws \Shippii\Exceptions\Auth\ShippiiAuthorizationException
     * @throws \Shippii\Exceptions\ShippiiEndpointNotFoundException
     * @throws \Shippii\Exceptions\ShippiiServerErrorException
     * @throws \Shippii\Exceptions\ShippiiValidationException
     * @deprecated
     */
    public function notifyShopifyForFailedImport(int $shopifyOrderId): array
    {
        $requestData = new TightencoCollection();
        $requestData->put('json', [
            'shopify_order_id' => $shopifyOrderId
        ]);

        $response = $this->shippii->connector->request(
            'post',
            'temporary/handle-magento-shopify-failed',
            'v2',
            $requestData
        );

        return $response->toArray();
    }
}