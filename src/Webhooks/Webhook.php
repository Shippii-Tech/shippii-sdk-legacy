<?php

namespace Shippii\Webhooks;

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

    public function __construct(string $signature, string $signingSecret, $jsonPayload = null)
    {
        $this->signature = $signature;
        $this->signingSecret = $signingSecret;
        $this->rawInput = is_null($jsonPayload) ? $this->getRawRequestInput() : $jsonPayload;
        $this->jsonPayload = json_decode($this->rawInput, true);
        $this->isSignatureValid = $this->verifySignature();
    }

    /**
     * Get Order Object
     * @param mixed $data
     * @return WebhookOrderObject
     */
    public function getOrderObject($data): WebhookOrderObject
    {
        return new WebhookOrderObject($data);
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
}