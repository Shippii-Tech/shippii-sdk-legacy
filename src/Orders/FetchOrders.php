<?php

namespace Shippii\Orders;

use DateTime;
use Shippii\Exceptions\Auth\ShippiiAuthenticationException;
use Shippii\Exceptions\Auth\ShippiiAuthorizationException;
use Shippii\Exceptions\ShippiiEndpointNotFoundException;
use Shippii\Exceptions\ShippiiSdkException;
use Shippii\Exceptions\ShippiiServerErrorException;
use Shippii\Exceptions\ShippiiValidationException;
use Shippii\Shippii;
use Throwable;
use Tightenco\Collect\Support\Collection as TCollection;

class FetchOrders
{
    /**
     * @var Shippii
     */
    private $shippii;

    /**
     * @var TCollection
     */
    private $query;

    /**
     * FetchOrders constructor.
     * @param  Shippii  $shippii
     */
    public function __construct(Shippii $shippii)
    {
        $this->shippii = $shippii;
        $this->query = collect();
    }

    /**
     * Between Filter
     *
     * @param  string  $start  Format: d/m/Y H:i:s
     * @param  string  $end  Format: d/m/Y H:i:s
     * @param  string  $property created OR updated
     * @return FetchOrders
     * @throws ShippiiSdkException
     */
    public function between(string $start, string $end, string $property = 'created'): self
    {
        foreach ([$start, $end] as $k => $value) {
            try {
                DateTime::createFromFormat('d/m/Y H:i:s', $value);
            } catch (Throwable $exception) {
                throw new ShippiiSdkException("{$value} is not in correct format. Correct is: d/m/Y H:i:s");
            }
        }
        $this->query->put("filter[{$property}_between]", "{$start},{$end}");

        return $this;
    }


    /**
     * Status Filter
     *
     * Available Statuses:
     *  On Hold
     *  Ready For Print
     *  Awaiting Payment
     *  Labels Requested
     *  Merging Labels
     *  Printed/Shipped
     *
     * @param  mixed  ...$statuses
     * @return $this
     */
    public function statuses(...$statuses): self
    {

        $this->query->put('filter[statuses]', implode(',', $statuses));

        return $this;
    }

    /**
     * Carriers Filter
     *
     * @param  mixed  ...$carriers
     * @return $this
     */
    public function carriers(...$carriers): self
    {
        $this->query->put('filter[carriers]', implode(',', $carriers));

        return $this;
    }

    /**
     * Paginated Result
     *
     * @param  int  $currentPage
     * @param  int  $perPage
     * @return $this
     */
    public function paginated(int $currentPage = 1, int $perPage = 50): self
    {
        $this->query->put('perPage', $perPage);
        $this->query->put('page', $currentPage);

        return $this;
    }

    /**
     * Sort Method
     *
     * @param  string  $property
     * @param  string  $direction
     * @return FetchOrders
     * @throws ShippiiSdkException
     */
    public function sortBy(string $property = 'created_at', string $direction = 'desc'): self
    {
        $direction = strtolower($direction);
        $sort = null;
        switch ($direction) {
            case 'desc':
                $sort = "-{$property}";
                break;
            case 'asc':
                $sort = "{$property}";
                break;
            default:
                throw new ShippiiSdkException("Unknown sort direction. asc and desc are allowed");
        }

        $this->query->put('sort', $sort);

        return $this;
    }

    /**
     * Append Additional Fields To Response
     *
     * @param  mixed  ...$appends
     * @return $this
     */
    public function appends(...$appends): self
    {
        $this->query->put('appends', implode(",", $appends));

        return $this;
    }

    /**
     * Include Additional Resources
     *
     * @param  mixed  ...$includes
     * @return $this
     */
    public function include(...$includes): self
    {
        $this->query->put('include', implode(",", $includes));

        return $this;
    }

    public function getByReference(string $reference): array
    {
        return $this
            ->shippii
            ->connector
            ->request('get', 'orders/by-reference/' . $reference, 'v2')
            ->toArray();
    }

    /**
     * @return array
     * @throws ShippiiAuthenticationException
     * @throws ShippiiAuthorizationException
     * @throws ShippiiEndpointNotFoundException
     * @throws ShippiiServerErrorException
     * @throws ShippiiValidationException
     */
    public function fetch(): array
    {
        $requestData = collect();
        $requestData->put('query', $this->query->toArray());

        return $this
            ->shippii
            ->connector
            ->request('get', 'order', 'v1', $requestData)
            ->toArray();
    }
}