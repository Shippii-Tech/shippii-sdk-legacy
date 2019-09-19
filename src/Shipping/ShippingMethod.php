<?php

namespace Shippii\Shipping;

use Shippii\Exceptions\Auth\ShippiiAuthenticationException;
use Shippii\Exceptions\Auth\ShippiiAuthorizationException;
use Shippii\Exceptions\Auth\ShippiiEndpointNotFoundException;
use Shippii\Exceptions\ShippiiServerErrorException;
use Shippii\Exceptions\ShippiiValidationException;
use Tightenco\Collect\Support\Collection as TightencoCollection;
use Shippii\Shippii;

class ShippingMethod
{
    /**
     * @var Shippii
     */
    protected $shippii;

    public function __construct(Shippii $shippii)
    {
        $this->shippii = $shippii;
    }

    /**
     * Transform Shipping Methods Response
     *
     * @param TightencoCollection $collection
     * @return TightencoCollection
     */
    protected function transform(TightencoCollection $collection): TightencoCollection
    {
        $data = new TightencoCollection($collection->get('data'));
        $data->transform(function ($item) {
            $rates = new TightencoCollection(data_get($item, 'shipping_rates', []));
            $rates = $rates->map(function ($rate) {
                return [
                    'id' => $rate['id'],
                    'name' => $rate['name'],
                    'for_return' => $rate['for_return'],
                    'on_pallet' => $rate['on_pallet'],
                    'shipping_fee' => $rate['shipping_fee'],
                ];
            });
           return [
               'id' => $item['id'],
               'name' => $item['name'],
               'description' => $item['description'],
               'for_return' => $item['for_return'],
               'max_weight' => $item['max_weight'],
               'max_width' => $item['max_width'],
               'max_height' => $item['max_height'],
               'max_length' => $item['max_length'],
               'on_pallet' => $item['on_pallet'],
               'rates' => $rates->toArray()
           ];
        });

        $collection->put('data', $data);

        return $collection;
    }

    /**
     * Get All Shipping Methods
     *
     * @return array
     * @throws ShippiiAuthenticationException
     * @throws ShippiiAuthorizationException
     * @throws ShippiiServerErrorException
     * @throws ShippiiValidationException
     * @throws \Shippii\Exceptions\ShippiiEndpointNotFoundException
     */
    public function getShippingMethods(): array
    {
        $requestData = new TightencoCollection();
        $requestData->put('query', [
            'include' => 'shipping_rates'
        ]);
        $response = $this->shippii->connector->request('GET', 'shipping-methods', 'v1', $requestData);

        return $this->transform($response)->toArray();
    }
}