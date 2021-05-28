<?php

namespace Shippii\Webhooks;

class WebhookLabelObject
{
    /**
     * @var array
     */
    private $payload;

    /**
     * @var array
     */
    private $labelUrl;

    /**
     * @var array
     */
    private $numberOfLabels;

    /**
     * Order Label
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
    private function parse(): void
    {
        $data = $this->payload['data']['data'] ?? null;
        $this->labelUrl = $data['label_url'] ?? null;
        $this->numberOfLabels = $data['number_of_labels'] ?? null;
    }

    /**
     * Get Order Label Url
     * @return mixed
     */
    public function getLabelUrl()
    {
        return $this->labelUrl;
    }

    /**
     * Get Number of Labels
     * @return mixed
     */
    public function getNumberOfLabels()
    {
        return $this->numberOfLabels;
    }

}