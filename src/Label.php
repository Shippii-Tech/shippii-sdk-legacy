<?php

namespace Shippii;

use Tightenco\Collect\Support\Collection as TightencoCollection;

/**
 * Class Label
 * @package Shippii
 */
class Label
{
    private $shippii;

    /**
     * Label constructor.
     * @param Shippii $shippii
     */
    public function __construct(Shippii $shippii)
    {
        $this->shippii = $shippii;
    }

    /**
     * @param string $yourReference
     * @param bool $print
     * @param string|null $printerId
     * @param string $labelFormat
     * @return array
     * @throws Exceptions\Auth\ShippiiAuthenticationException
     * @throws Exceptions\Auth\ShippiiAuthorizationException
     * @throws Exceptions\ShippiiEndpointNotFoundException
     * @throws Exceptions\ShippiiServerErrorException
     * @throws Exceptions\ShippiiValidationException
     */
    public function getLabelForSingleOrder(
        string $yourReference,
        bool $print = false,
        string $printerId = null,
        string $labelFormat = 'PDF'
    ): array {
        $endPoint = 'label/get/single';

        $requestData = new TightencoCollection();
        $requestData->put('query', [
            'reference' => (string) $yourReference,
            'print' => (int)$print,
            'printer_id' => $printerId,
            'label_format' => $labelFormat
        ]);

        return $this->shippii->connector->request('GET', $endPoint, 'v1', $requestData)->toArray();
    }


    /**
     * Get Labels for selected Order
     *
     * @param array $yourReferences
     * @param bool $print
     * @param null $printerId
     * @param string $labelFormat
     * @param int $dispatchNow
     * @return array
     * @throws Exceptions\Auth\ShippiiAuthenticationException
     * @throws Exceptions\Auth\ShippiiAuthorizationException
     * @throws Exceptions\ShippiiEndpointNotFoundException
     * @throws Exceptions\ShippiiServerErrorException
     * @throws Exceptions\ShippiiValidationException
     */
    public function getLabelsForSelectedOrders(
        array $yourReferences,
        bool $print = false,
        $printerId = null,
        string $labelFormat = 'pdf',
        int $dispatchNow = 0
    ): array {
        $endPoint = 'label/get/selected-orders';
        $requestData = new TightencoCollection();
        $requestData->put('query', [
            'print' => (int)$print,
            'printer_id' => $printerId,
            'label_format' => $labelFormat,
            'dispatch-now' => $dispatchNow
        ]);
        $requestData->put('json', [
            'references' => $yourReferences
        ]);

        return $this->shippii->connector->request('post', $endPoint, 'v1', $requestData)->toArray();
    }
}