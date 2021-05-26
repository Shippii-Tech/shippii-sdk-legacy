<?php

namespace Shippii\Webhooks;

class WebhookLabelObject
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }


}