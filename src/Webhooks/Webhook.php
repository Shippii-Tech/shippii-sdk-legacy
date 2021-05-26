<?php

namespace Shippii\Webhooks;

use Tightenco\Collect\Support\Collection as TightencoCollection;

class Webhook
{
    /**
     * @var string
     */
    private $signature;
    
    /**
     * @var string
     */
    private $signingSecret;
    
    /**
     * @var null|string
     */
    private $jsonPayload;

    /**
     * @var null|string
     */
    private $rawInput;

    /**
     * @var bool
     */
    private $isSignatureValid;

    /** @var TightencoCollection */
    private $webhookData;

    public function __construct(string $signature, string $signingSecret, $jsonPayload = null)
    {
        $this->signature = $signature;
        $this->signingSecret = $signingSecret;
        $this->rawInput = is_null($jsonPayload) ? $this->getRawRequestInput() : $jsonPayload;
        $this->jsonPayload = json_decode($this->rawInput, true);
        $this->isSignatureValid = $this->verifySignature();
        $this->webhookData = new TightencoCollection();
    }

    public function parse()
    {
        $this->getOrderInfo($this->jsonPayload);
        $this->getReceiverInfo($this->jsonPayload);
        $this->getOrderItems($this->jsonPayload);
        $this->getAdditionalData($this->jsonPayload);

        return $this->webhookData;
    }

    private function getRawRequestInput(): string
    {
        return file_get_contents('php://input');
    }

    private function verifySignature(): bool
    {
        return hash_hmac('sha256', $this->rawInput, $this->signingSecret) === $this->signature;
    }

    public function isValid(): bool
    {
        return $this->isSignatureValid;
    }

    public function toArray(): array
    {
        return $this->jsonPayload;
    }

    public function event(): ?string
    {
        return $this->jsonPayload['event-type'] ?? null;
    }

    /**
     * Parse Order Information
     * @param array $data
     * @return void
     */
    private function getOrderInfo(array $data): void
    {
        $order = data_get($data, 'order');

        $parsedData = [
            'status' => $data['order_status'],
            'order_id' => $order['id'],
            'reference' => $order['reference'],
            'shipping_method' => $order['shipping_method'],
            'carrier' => $order['carrier']
        ];

        $this->webhookData->put('order', $parsedData);
    }

    /**
     * Parse Order Receiver information
     * @param array $data
     * @return void
     */
    private function getReceiverInfo(array $data): void
    {
        $receiver = data_get($data, 'order.receiver');

        $parsedData = [
            'receiver_name' => $receiver['first_name'] . ' ' . $receiver['last_name'],
            'email' => $receiver['email'],
            'mobile' => $receiver['mobile'],
            'country' => [
                'name' => $receiver['country']['name'],
                'code' => $receiver['country']['code']
            ],
            'city' => $receiver['city'],
            'address' => $receiver['address'],
            'zip_code' => $receiver['zip_code']
        ];

        $this->webhookData->put('receiver', $parsedData);
    }

    /**
     * Parse Order Items Information
     * @param array $data
     * @return void
     */
    private function getOrderItems(array $data): void
    {
        $items = data_get($data, 'order.items');
        $parsedData = [];
        foreach ($items as $key => $item) {
            array_push($parsedData, [
                'name' => $item['name'],
                'sku' => $item['sku'],
                'ean' => $item['ean'],
                'weight' => $item['weight'],
                'volume' => $item['volume'],
                'quantity' => $item['quantity'],
            ]);
        }

        $this->webhookData->put('items', $parsedData);
    }

    /**
     * Parse additional data
     * @param array $data
     * @return void
     */
    private function getAdditionalData(array $data): void
    {
        $additionalData = data_get($data, 'data.data');

        $parsedData = [
            'label_url' => $additionalData['label_url'] ?? null,
            'number_of_labels' => $additionalData['number_of_labels'] ?? null,
            'printer' => $additionalData['printer'] ?? null,
            'external_status' => $additionalData['external_status'] ?? null
        ];

        $this->webhookData->put('data', $parsedData);
    }
}