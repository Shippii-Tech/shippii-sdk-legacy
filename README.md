#### SHIPPII - PHP SDK (v1.9.2)

---
#### You can install the Shippii SDK for PHP:

+ As a dependency via Composer

+ As a ZIP file of the SDK

For complete setup guide please check [Shippii SDK Wiki](https://gitlab.vconnect.systems/shippii-public/sdk/-/wikis/home)

---
## 21.02.2022 - 1.9.2
> Added new fields for create and update order. Also added new endpoint for test connection. It returns full information about the token that is used, i.e. Company, Company Object, Token scopes, Application webhooks, etc. Also updated "order-updated" webhook documentation - added missing info in "data" about service_point_id.

> Create order - additions - setReceiverCompanyName method

`$order = new Shippii\Orders\Order();`

`$order->setReceiverCompanyName('Company Name Co');`

> Update Order - additions - setReceiverCompanyName and setShippingGroup methods. Both fields can be left null if nothing needs to be updated.

`$shippii = new Shippii($token, $testMode, $url);`

`$order = $shippii->updateOrder();`

`$order->setReceiverCompanyName('Company Name and Co'); // nullable`

`$order->setShippingGroup('DHL'); // nullable`

> Endpoint for test connection.

`$shippii = new Shippii($token, $testMode, $url);`

`$control = new Control($shippii);`

`$response = $control->testShippiiConnection();`

> Full code examples are in test_shippii_connection.php, test.php, update_store_order.php files.

---
## 29.09.2021 - 1.9.1
> Breaking changes on how to call Enable Shipment
- Check enable-shipment.php for full code example
---
## 07.09.2021 - ~~v1.8.5~~ v1.8.6
> Fixed Invoice request to send only data that is passed.
---
## 30.08.2021 - v1.8.4
> Removed all previous changes in 1.8.3, removed all "store" information and all custom fields

> Added 4 new fields for custom data. All methods are optional, and each one of them can accept from 1 up to 10 array parameters.

> For complete code example check "invoice_test.php"
-  setSenderData(array)
    - ex.: $invoice->setSenderData([param1, param2, param3]);
- setVatAgent(array)
    - ex.: $invoice->setVatAgent([param1, param2, param3]);
- setFirstFooterField(array)
    - ex.: $invoice->setFirstFooterField([param1, param2, param3]);
- setSecondFooterField(array)
    - ex.: $invoice->setSecondFooterField([param1, param2, param3]);
- setThirdFooterField(array)
    - ex.: $invoice->setThirdFooterField([param1, param2, param3]);
---
## 25.08.2021 - v1.8.3
#### 9 new fields to Invoice - For Complete Code Example - check "invoice_test.php"
- discount: `$invoice->setDiscount(1.23);`
    - Expected param: **float**
- sender name: `$invoice->setSenderDetailsName("name");`
- sender phone number: `$invoice->setSenderDetailsPhoneNumber("+4900000000");`
    - Expected param: **string**
- sender city: `$invoice->setSenderDetailsCity("city");`
- sender country name: `$invoice->setSenderDetailsCountryName("Germany");`
- sender postal code: `$invoice->setSenderDetailsPostalCode("2344");`
    - Expected param: **string**
- sender address: `$invoice->setSenderDetailsAddress("address");`
- sender email: `$invoice->setSenderDetailsEmail("email");`