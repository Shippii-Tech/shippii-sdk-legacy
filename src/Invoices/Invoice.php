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
    /** @var string $store_name */
    private $store_name;
    /** @var string $store_phone_number */
    private $store_phone_number;
    /** @var string $store_country_name */
    private $store_country_name;
    /** @var string $store_region */
    private $store_region;
    /** @var string $store_postal_code */
    private $store_postal_code;
    /** @var string $store_city */
    private $store_city;
    /** @var string $store_address */
    private $store_address;
    /** @var string $store_second_address */
    private $store_second_address;
    /** @var string $store_vat_number */
    private $store_vat_number;

    /** @var string $custom_field_1_custom_text_1 */
    private $custom_field_1_custom_text_1;
    /** @var string $custom_field_1_custom_text_2 */
    private $custom_field_1_custom_text_2;
    /** @var string $custom_field_1_custom_text_3 */
    private $custom_field_1_custom_text_3;
    /** @var string $custom_field_1_custom_text_4 */
    private $custom_field_1_custom_text_4;
    /** @var string $custom_field_1_custom_text_5 */
    private $custom_field_1_custom_text_5;
    /** @var string $custom_field_1_custom_text_6 */
    private $custom_field_1_custom_text_6;

    /** @var string $custom_field_2_custom_text_1 */
    private $custom_field_2_custom_text_1;
    /** @var string $custom_field_2_custom_text_2 */
    private $custom_field_2_custom_text_2;
    /** @var string $custom_field_2_custom_text_3 */
    private $custom_field_2_custom_text_3;
    /** @var string $custom_field_2_custom_text_4 */
    private $custom_field_2_custom_text_4;
    /** @var string $custom_field_2_custom_text_5 */
    private $custom_field_2_custom_text_5;
    /** @var string $custom_field_2_custom_text_6 */
    private $custom_field_2_custom_text_6;

    /** @var string $custom_field_3_custom_text_1 */
    private $custom_field_3_custom_text_1;
    /** @var string $custom_field_3_custom_text_2 */
    private $custom_field_3_custom_text_2;
    /** @var string $custom_field_3_custom_text_3 */
    private $custom_field_3_custom_text_3;
    /** @var string $custom_field_3_custom_text_4 */
    private $custom_field_3_custom_text_4;
    /** @var string $custom_field_3_custom_text_5 */
    private $custom_field_3_custom_text_5;
    /** @var string $custom_field_3_custom_text_6 */
    private $custom_field_3_custom_text_6;

    public function __construct(Shippii $shippii)
    {
        $this->shippii = $shippii;
        $this->references = collect();
    }

    protected function prepareRequest(): Collection
    {
        $result = new Collection();
        return $result->put('json', [
            'order_references' => $this->references,
            'type' => $this->invoice_type,
            'store_name' => $this->store_name,
            'store_phone_number' => $this->store_phone_number,
            'country_name' => $this->store_country_name,
            'region' => $this->store_region,
            'postal_code' => $this->store_postal_code,
            'city' => $this->store_city,
            'address' => $this->store_address,
            'address_2' => $this->store_second_address,
            'vat_number' => $this->store_vat_number,
            // Custom fields
            'custom_field_1_custom_text_1' => $this->custom_field_1_custom_text_1,
            'custom_field_1_custom_text_2' => $this->custom_field_1_custom_text_2,
            'custom_field_1_custom_text_3' => $this->custom_field_1_custom_text_3,
            'custom_field_1_custom_text_4' => $this->custom_field_1_custom_text_4,
            'custom_field_1_custom_text_5' => $this->custom_field_1_custom_text_5,
            'custom_field_1_custom_text_6' => $this->custom_field_1_custom_text_6,
            'custom_field_2_custom_text_1' => $this->custom_field_2_custom_text_1,
            'custom_field_2_custom_text_2' => $this->custom_field_2_custom_text_2,
            'custom_field_2_custom_text_3' => $this->custom_field_2_custom_text_3,
            'custom_field_2_custom_text_4' => $this->custom_field_2_custom_text_4,
            'custom_field_2_custom_text_5' => $this->custom_field_2_custom_text_5,
            'custom_field_2_custom_text_6' => $this->custom_field_2_custom_text_6,
            'custom_field_3_custom_text_1' => $this->custom_field_3_custom_text_1,
            'custom_field_3_custom_text_2' => $this->custom_field_3_custom_text_2,
            'custom_field_3_custom_text_3' => $this->custom_field_3_custom_text_3,
            'custom_field_3_custom_text_4' => $this->custom_field_3_custom_text_4,
            'custom_field_3_custom_text_5' => $this->custom_field_3_custom_text_5,
            'custom_field_3_custom_text_6' => $this->custom_field_3_custom_text_6
        ]);
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
     * Set Store Name
     * @param string $storeName
     * @return Invoice
     */
    public function setStoreName(string $storeName): Invoice
    {
        $this->store_name = $storeName;
        return $this;
    }

    /**
     * Set Store Phone Number
     * @param string $storePhoneNumber
     * @return Invoice
     */
    public function setStorePhoneNumber(string $storePhoneNumber): Invoice
    {
        $this->store_phone_number = $storePhoneNumber;
        return $this;
    }

    /**
     * Set Store Country Name
     * @param string $storeCountryName
     * @return Invoice
     */
    public function setStoreCountryName(string $storeCountryName): Invoice
    {
        $this->store_country_name = $storeCountryName;
        return $this;
    }

    /**
     * Set Store Region
     * @param string $storeRegion
     * @return Invoice
     */
    public function setStoreRegion(string $storeRegion): Invoice
    {
        $this->store_region = $storeRegion;
        return $this;
    }

    /**
     * Set Store Postal Code
     * @param string $storePostalCode
     * @return Invoice
     */
    public function setStorePostalCode(string $storePostalCode): Invoice
    {
        $this->store_postal_code = $storePostalCode;
        return $this;
    }

    /**
     * Set Store City
     * @param string $storeCity
     * @return Invoice
     */
    public function setStoreCity(string $storeCity): Invoice
    {
        $this->store_city = $storeCity;
        return $this;
    }

    /**
     * Set Store Address
     * @param string $storeAddress
     * @return Invoice
     */
    public function setStoreAddress(string $storeAddress): Invoice
    {
        $this->store_address = $storeAddress;
        return $this;
    }

    /**
     * Set Store Second Address
     * @param string $storeSecondAddress
     * @return Invoice
     */
    public function setStoreSecondAddress(string $storeSecondAddress): Invoice
    {
        $this->store_second_address = $storeSecondAddress;
        return $this;
    }

    /**
     * Set Store Vat Number
     * @param string $storeVatNumber
     * @return Invoice
     */
    public function setStoreVatNumber(string $storeVatNumber): Invoice
    {
        $this->store_vat_number = $storeVatNumber;
        return $this;
    }

    /**
     * Set Custom field one with custom text one
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_1_CustomText_1(string $data): Invoice
    {
        $this->custom_field_1_custom_text_1 = $data;
        return $this;
    }

    /**
     * Set Custom field two with custom text two
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_1_CustomText_2(string $data): Invoice
    {
        $this->custom_field_1_custom_text_2 = $data;
        return $this;
    }

    /**
     * Set Custom field three with custom text three
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_1_CustomText_3(string $data): Invoice
    {
        $this->custom_field_1_custom_text_3 = $data;
        return $this;
    }

    /**
     * Set Custom field four with custom text four
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_1_CustomText_4(string $data): Invoice
    {
        $this->custom_field_1_custom_text_4 = $data;
        return $this;
    }

    /**
     * Set Custom field five with custom text five
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_1_CustomText_5(string $data): Invoice
    {
        $this->custom_field_1_custom_text_5 = $data;
        return $this;
    }

    /**
     * Set Custom field six with custom text six
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_1_CustomText_6(string $data): Invoice
    {
        $this->custom_field_1_custom_text_6 = $data;
        return $this;
    }

    /**
     * Set Custom Field 2 with custom text 1
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_2_CustomText_1(string $data): Invoice
    {
        $this->custom_field_2_custom_text_1 = $data;
        return $this;
    }
    
    /**
     * Set Custom field 2 with custom text 2
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_2_CustomText_2(string $data): Invoice
    {
        $this->custom_field_2_custom_text_2 = $data;
        return $this;
    }

    /**
     * Set Custom field 2 with custom text 3
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_2_CustomText_3(string $data): Invoice
    {
        $this->custom_field_2_custom_text_3 = $data;
        return $this;
    }

    /**
     * Set Custom field 2 with custom text 4
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_2_CustomText_4(string $data): Invoice
    {
        $this->custom_field_2_custom_text_4 = $data;
        return $this;
    }
    
    /**
     * Set Custom field 2 with custom text 5
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_2_CustomText_5(string $data): Invoice
    {
        $this->custom_field_2_custom_text_5 = $data;
        return $this;
    }

    /**
     * Set custom field 2 with custom text 6
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_2_CustomText_6(string $data): Invoice
    {
        $this->custom_field_2_custom_text_6 = $data;
        return $this;
    }

    /**
     * Set Custom field 3 with custom text 1
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_3_CustomText_1(string $data): Invoice
    {
        $this->custom_field_3_custom_text_1 = $data;
        return $this;
    }
 
    /**
     * Set Custom field 3 with custom text 2
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_3_CustomText_2(string $data): Invoice
    {
        $this->custom_field_3_custom_text_2 = $data;
        return $this;
    }
 
    /**
     * Set Custom field 3 with custom text 3
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_3_CustomText_3(string $data): Invoice
    {
        $this->custom_field_3_custom_text_3 = $data;
        return $this;
    }
 
    /**
     * Set Custom field 3 with custom text 4
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_3_CustomText_4(string $data): Invoice
    {
        $this->custom_field_3_custom_text_4 = $data;
        return $this;
    }
 
    /**
     * Set custom field 3 with custom text 5
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_3_CustomText_5(string $data): Invoice
    {
        $this->custom_field_3_custom_text_5 = $data;
        return $this;
    }
 
    /**
     * Set custom field 3 with custom text 6
     * @param string $data
     * @return Invoice
     */
    public function setCustomField_3_CustomText_6(string $data): Invoice
    {
        $this->custom_field_3_custom_text_6 = $data;
        return $this;
    }
}
