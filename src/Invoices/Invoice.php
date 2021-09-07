<?php

namespace Shippii\Invoices;

use Shippii\Shippii;
use Tightenco\Collect\Support\Collection;

class Invoice
{
    /** @var Shippii $shippii */
    private $shippii;

    /** @var Collection $references */
    private $references;
    /** @var string $invoice_type */
    private $invoice_type;
    /** @var float $discount */
    private $discount;
    /** @var array $sender_data */
    private $sender_data;
    /** @var array $vat_agent */
    private $vat_agent;
    /** @var array $footer_field_1 */
    private $footer_field_1;
    /** @var array $footer_field_2 */
    private $footer_field_2;
    /** @var array $footer_field_3 */
    private $footer_field_3;


    public function __construct(Shippii $shippii)
    {
        $this->shippii = $shippii;
        $this->references = collect();
    }

    protected function prepareRequest(): Collection
    {
        $result = new Collection();

        $requestData = [];
        $this->references ? $requestData['order_references'] = $this->references : null;
        $this->invoice_type ? $requestData['type'] = $this->invoice_type : null;
        $this->discount ? $requestData['discount'] = $this->discount : null;
        $this->sender_data ? $requestData['custom_fields']['sender_data'] = $this->sender_data : null;
        $this->vat_agent ? $requestData['custom_fields']['vat_agent'] = $this->vat_agent : null;
        $this->footer_field_1 ? $requestData['custom_fields']['footer_field_1'] = $this->footer_field_1 : null;
        $this->footer_field_2 ? $requestData['custom_fields']['footer_field_2'] = $this->footer_field_2 : null;
        $this->footer_field_3 ? $requestData['custom_fields']['footer_field_3'] = $this->footer_field_3 : null;

        return $result->put('json', $requestData);
    }

    /**
     * Send request
     * @return array
     */
    public function getInvoice(): array
    {
        $request = $this->prepareRequest();
        $response = $this->shippii->connector->request('post', 'invoices', 'v1', $request);
        return $response->toArray();
    }

    /**
     * Set Order Reference and Invoice ID
     * @param string $orderReference
     * @param string $invoiceId
     * @return Invoice
     */
    public function setInvoiceOrderReferences(string $orderReference, string $invoiceId): Invoice
    {
        $this->references->push(collect(['order_reference' => $orderReference, 'invoice_id' => $invoiceId]));
        return $this;
    }

    /**
     * Set Invoice Type - Order/Consolidate
     * @param string $invoiceType
     * @return Invoice
     */
    public function setInvoiceType(string $invoiceType): Invoice
    {
        $this->invoice_type = $invoiceType;
        return $this;
    }

    /**
     * Set Discount for Consolidate Invoice
     * @param float $discount
     * @return Invoice
     */
    public function setDiscount(float $discount): Invoice
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * Set Sender Data
     * Up to 10 parameters
     * @param array $data
     * @return Invoice
     */
    public function setSenderData(array $data): Invoice
    {
        $this->sender_data = $data;
        return $this;
    }
    
    /**
     * Set Vat Agent Data
     * Up to 10 parameters
     * @param array $data
     * @return Invoice
     */
    public function setVatAgent(array $data): Invoice
    {
        $this->vat_agent = $data;
        return $this;
    }

    /**
     * Set First Footer Field
     * Up to 10 parameters
     * @param array $data
     * @return Invoice
     */
    public function setFirstFooterField(array $data): Invoice
    {
        $this->footer_field_1 = $data;
        return $this;
    }

    /**
     * Set Second Footer Field
     * Up to 10 parameters
     * @param array $data
     * @return Invoice
     */
    public function setSecondFooterField(array $data): Invoice
    {
        $this->footer_field_2 = $data;
        return $this;
    }

    /**
     * Set Third Footer Field
     * Up to 10 parameters
     * @param array $data
     * @return Invoice
     */
    public function setThirdFooterField(array $data): Invoice
    {
        $this->footer_field_3 = $data;
        return $this;
    }
}
