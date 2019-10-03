<?php
include_once 'vendor/autoload.php';

use Faker\Factory;
use Shippii\Exceptions\Auth\ShippiiAuthenticationException;
use Shippii\Exceptions\Auth\ShippiiAuthorizationException;
use Shippii\Exceptions\ShippiiServerErrorException;
use Shippii\Exceptions\ShippiiValidationException;
use Shippii\Orders\Order;
use Shippii\Orders\OrderItem;
use Shippii\Shippii;

$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjEwNzk0OWI5MTg5OTYyOTAwZWFmZmM0OWY5ZWEzNmRiOWJmMzc4MGQ5MDZiY2VhOTAzMjFkYWE3NzNmYWQxODk5NTI4MjIwNjNhMTcxMWE2In0.eyJhdWQiOiIxIiwianRpIjoiMTA3OTQ5YjkxODk5NjI5MDBlYWZmYzQ5ZjllYTM2ZGI5YmYzNzgwZDkwNmJjZWE5MDMyMWRhYTc3M2ZhZDE4OTk1MjgyMjA2M2ExNzExYTYiLCJpYXQiOjE1Njc2OTU3NTMsIm5iZiI6MTU2NzY5NTc1MywiZXhwIjoxNTk5MzE4MTUzLCJzdWIiOiIxIiwic2NvcGVzIjpbImZ1bGwtYWNjZXNzLXRvLWNvbXBhbnktb3JkZXJzIl19.vOvY_5DEVs1oT2tXijHjMHCOkqXppGmPr-Ncc2cJ-QWLNbmEDA-ppMlMPNDM7kvftWkAbkK1lyhc2vmmY2bRvBsonueQAIG0hvcj7-0WY-AAtuhZ-iKcA3LLlq33Yjcfe0QQKzRjB-StlJSJtFF9s1Fl65cWiqa2-AnSKkqOsCARXzc1jfCceDpGwKIbIpXzueG3aL6J1r-M4xuUyN4yOm4akiK7Nw7oWN_011F5vN7CWhTJTc3Yz-Rf5ggnjTS0zoNvAk9kLKYHMy74KfJNEYnIkZiXjc1_-BN6iPvP8leR0EiDBxO09UhQeH0a78vFVT6Eu1eMiiD27Lc_9Wxrj0swYTckNKIbC_7SjnCHlhXrB7UTHk5x3x7TXD9lfFXNOTcYYZeuJqEowAt6987SQDi4azu4pxVDBLYi5MO-KaAFvaF_PXmDEn5OSGhp0mqd6nUMq-Pob_-OBmhf9qT5gPDhswLTz18v-lgZ3GfUpolbNcaaS3Y3pq17Njnl3rfybhV2yDUuIAfQdWcOxE3FWsVMFzmPBRG8cGOWm5rIwivY4MMOBO35oz2hxFX8YZNtd_iJmjR9rO63ybjxmP7IQFyeelL5smOFee04z5Sn-qj0zLQxggZ-ElL7PHlE3Myc5n1E7fyOB8LjBEc8nYFmi17zVkKG4okoXhhwZ__AI5g';

$testMode = true;
$baseUrl = 'http://shippii-reborn.test/';

$shippii = new Shippii($token, $testMode, $baseUrl);

$faker = Factory::create('nb_NO');

$order = new Order();
$order->setReceiverFirstName($faker->firstName);
$order->setReceiverLastName($faker->lastName);
$order->setReceiverAddress($faker->streetAddress);
$order->setReceiverEmail($faker->email);
$order->setReceiverMobile($faker->randomNumber(8));
$order->setReceiverCity($faker->city);
$order->setReceiverProvince($faker->city);
$order->setReceiverZipCode(2630);
$order->setReceiverCountryCode('DK');
$order->setShippingRateAliasName("My Custom Rate Name");
$order->setShippingRateAliasPrice(120.0);

$order->setPayFromWallet(true)
    ->setReference($faker->randomNumber(5))
    ->setBillingAddressSameAsShipment()
    ->setShippingMethodId('96vyGZ');

$items = [ // items
    [
        'name' => 'Man Shoes', // required
        'ean' => '1232131212', // optional
        'price' => 50.00, // float. required This is the price for SINGLE item
        'quantity' => 1, // int/float required This is the quantity shipped.
        'weight' => 3.21, // float required The weight of the SINGLE item
        'sku' => 'ITEM123213',  // You can put your Item ID here for instance.
        'country_of_origin' => 'BG', // Needed For The Customs
        'tariff_code' => 'TARIFF-123ASD-1Q' // Needed For The customs
    ]
];

foreach ($items as $item) {
    $orderItem = new OrderItem();
    $orderItem->setName($item['name']);
    $orderItem->setEan($item['ean']);
    $orderItem->setPrice($item['price']);
    $orderItem->setQuantity($item['quantity']);
    $orderItem->setWeight($item['weight']);
    $orderItem->setSku($item['sku']);
    $orderItem->setCountryOfOrigin($item['country_of_origin']);
    $orderItem->setTariffCode($item['tariff_code']);
    
    try {
        $order->setOrderItem($orderItem);
    } catch (TypeError $error) {
        print $error->getMessage();
    }
}

try {
    $response = $shippii->setOrder($order)->sendOrder();
    dd($response);
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
