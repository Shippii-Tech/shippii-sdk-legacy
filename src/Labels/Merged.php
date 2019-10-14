<?php

namespace Shippii\Labels;

use Shippii\Shippii;
use Tightenco\Collect\Support\Collection as TightencoCollection;

class Merged
{
    private $shippii;

    public function __construct(Shippii $shippii)
    {
        $this->shippii = $shippii;
    }

    /**
     * Set References
     *
     * @param array $references
     * @return Merged
     */
    public function setReferences(array $ids): TightencoCollection
    {
        $references = ['references' => $ids];
        return new TightencoCollection(['json' => $references]);
    }

    /**
     * Get Labels for specific orders
     *
     * @return array
     */
    public function getMergedLabels($ids = null): array
    {
        $ids = [
            //"q2124122112222",
            //"q212412212",
            "q2124122211323222"
        ];
        $references = $this->setReferences($ids);
        $response = $this->shippii->connector->request('POST', 'label/get/selected-orders', "v1", $references);
        return $response->toArray();
    }
}