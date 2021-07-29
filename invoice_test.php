<?php
include_once 'vendor/autoload.php';

use Shippii\Shippii;
use Shippii\Exceptions\ShippiiValidationException;
use Shippii\Exceptions\ShippiiServerErrorException;
use Shippii\Exceptions\Auth\ShippiiAuthorizationException;
use Shippii\Exceptions\Auth\ShippiiAuthenticationException;

$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiZGZkZGU2ZmE2ZDhhMmIxODI4MGY0MzZhZTA5MTBjNWU2Y2FkOWQ4NTk4NTZhMzNmMzJkZjA3ZDhhYjFhOTVkNmFmMGEzMDVkZmNiMTYxNzkiLCJpYXQiOjE2MTc3MTU0ODkuMDgyNTMzLCJuYmYiOjE2MTc3MTU0ODkuMDgyNTQ0LCJleHAiOjE2NDkyNTE0ODkuMDcyOTI4LCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.fBfL3HSa5jF_YwoUxS07LtkJvvqJhYSJgyXlCbIFPRxfmvCmC2Sg9B3Tx_ULaSOrPEDjgsbE1xSIrW12L9Wu2kOFBOBRDUKl1j9m9MZ1XMw4E88sGQq3gK-R3iQ3feVPwrhAb7VlDngXJ0oZQWQ1TGyYxw-YlAcRGClY_mbAJ4PbmJcR93Xu3aSOB1U44fjvQJn-QsXtMiz6qbiQQEnS3aZum-uOYhOzapJpc0izc3Zs4Wd0uO5ipOu95y9dAqWvGWltonQgqpYEggrU6_P6DbMwRovHkdRxLwcMQENMhRQ58z7jzwCGR9eQqNcFPIovslVeWcAR22sCBcFxZGyEAh3zh7Z2L3c6dL7mqRIJr5eEedol2SidsPuYvByh3NVYqHV4UjzYgTgVmmOBnivSFbS8rvDtAnPktO_50fXxi-ZO3LYcMwUQQiHkW-wd9eSVEbs4ROSISJgTnrfAYPdeu03wESDrjIqI7huGK343LR8acgonUKXIQNGPSUKGgs3VnSnL4SoFaFcIhtajIEH0JiuiCKHiMOTWdWVgMcF3xJAGb3jS3e2JcpXf-umXWPv72fcOCmwTdrj5lEvLHPIjuIrsspL-NfZPfT3nYpw9oYVp0vqaKwTLedp4M4mwfmqke10_xJQEa1NyKlfiSB8iio_W8JTEFavrIwP0eAalVW0";
$testMode = true;
$baseUrl = 'https://test-api.shippii.com/';

$shippii = new Shippii($token, $testMode, $baseUrl);
$invoice = $shippii->invoice();

$data = [
    [
        'order_reference' => '204872',
        'invoice_id' => '2000000003'
    ],
    [
        'order_reference' => '535721',
        'invoice_id' => '2000000004'
    ]
];

foreach ($data as $key => $datum) {
    $invoice->setInvoiceOrderReferences($datum['order_reference'], $datum['invoice_id']);
}

// $invoice->setInvoiceOrderReferences("reference", "invoice_id");
// $invoice->setInvoiceOrderReferences("reference2", "invoice_id2");
$invoice->setInvoiceType("consolidate");
$invoice->setStoreName("BrandHouse UG");
$invoice->setStorePhoneNumber("+46 10 551 62 17");
$invoice->setStoreCountryName("Germany");
$invoice->setStoreRegion("Test Region");
$invoice->setStorePostalCode("24939");
$invoice->setStoreCity("Flensburg");
$invoice->setStoreAddress("Apenrader Straße 41 - 45");
$invoice->setStoreSecondAddress("HRB 14683 FL");
$invoice->setStoreVatNumber("DE338533984");

// Custom Fields from custom field 1 to 3, with custom text from 1 to 6
// $invoice->setCustomField_1_CustomText_1('custom text');
// $invoice->setCustomField_3_CustomText_6('custom text');

try {
    $response = $invoice->getInvoice();
} catch (TypeError $error) {
    print $error->getMessage();
} catch (ShippiiValidationException $shippiiValidationException) {
    print_r($shippiiValidationException->getValidationErrors());
} catch (ShippiiServerErrorException $shippiiServerErrorException) {
    print_r([
        'message' => $shippiiServerErrorException->getMessage(),
        'shippii_event_id' => $shippiiServerErrorException->getEventId()
    ]);
} catch (ShippiiAuthorizationException $authorizationException) {
    print "You're app does not have the needed token scope";
} catch (ShippiiAuthenticationException $shippiiAuthenticationException) {
    print "You are not authenticated. Please check your token";
} catch (\Shippii\Exceptions\ShippiiEndpointNotFoundException $e) {
    print $e->getMessage();
}