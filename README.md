#### SHIPPII - PHP SDK (v1.8.3)

---
#### You can install the Shippii SDK for PHP:

+ As a dependency via Composer

+ As a ZIP file of the SDK

For complete setup guide please check [Shippii SDK Wiki](https://gitlab.vconnect.systems/shippii-public/sdk/-/wikis/home)

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