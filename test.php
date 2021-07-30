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

$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMGYwZGQ5YzQ3NzFjYzU3NTMxMDRjNTM5MDBlY2FhOGU2ZmYzYTIyODU1NDMzNDZkNTdiNjE4ZDgxZWNhZTU1NDNmYjg1NWI3NjdlZTkxNGUiLCJpYXQiOjE2MTc3OTA0NzIuMTg5NzA0LCJuYmYiOjE2MTc3OTA0NzIuMTg5NzEsImV4cCI6MTY0OTMyNjQ3Mi4xODcxNDEsInN1YiI6IjMiLCJzY29wZXMiOlsiY2FuLWZldGNoLW1ldGhvZHMiLCJjYW4tZmV0Y2gtc2hpcHBpbmctcmF0ZXMiLCJjYW4tZmV0Y2gtY291bnRyaWVzIiwicGF5X2Zyb21fd2FsbGV0IiwiY2FuLWZldGNoLXdhbGxldHMtYmFsYW5jZXMiLCJjcmVhdGUtb3JkZXIiLCJjcmVhdGUtcmV0dXJuLW9yZGVyIiwidXBkYXRlLW93bmVkLW9yZGVyIiwiY2FuY2VsLW93bmVkLW9yZGVyIiwidmlldy1vd25lZC1vcmRlciIsInByaW50LWxhYmVscyIsImZ1bGwtYWNjZXNzLXRvLWNvbXBhbnktb3JkZXJzIiwiY2FuLWNyZWF0ZS1pbnZvaWNlIiwiY2FuLWRlbGV0ZS1pbnZvaWNlIl19.61SKYym-XWDAHdi2fqn2ksVSPCfjuR5rQ-5_nB1Xu86JBOnpSLrrwb9lVWi75ZknJllJorA7UVXA9eWy_T0idpjPA6j4ZvLdJQaMwZAfW_y2TPvnTS9yu7-5fHeWPi4lqTnSvWpcQiLwhKhqyCvhXCHlV4kLI6lJjr96SLg2SU8KXjj7tabbBoscUghmU9kld9TIyYgUQh2FXKgJC9T0oH3R1NZO2KFhq3IxRpoi_EVqCMuF6Pie6xHLXW1Vai4uwsvQiMsvVzCShW-V66WrK426dvAFiq1CqE61joZE5N1Qe6XgV9K80i4CIpef08bTVS8lZlnRksyYdzERxOWuCX-TmegKJibsv02ZRvJsfOcdfwYYMmYCN6cKInbKyeX79Nq6HWmwyFRba2moYawYNRa4nJA5I9XtX_AFtjw9i0TH9zoGvXjN6k7qjaLrRbKO-p87dDIJHwXEw-Oh2eTHY9O3_ay61Moh_i5z4G1TnpfEgCe2mSN0cXhNxgLfTgn5WvBadqKt3Xx2syiRUv12b0JTTqdBcsCzlnIn6mHs6rl4aPCqOnp799JU9uXena1FmC9Ax4R4ELEOm67HwlkV1BZoD0Pv_h6mRscubo7wAOnk6fE4BJbz7CH3Huey8hQXsfuFM0E_-DaHvZ-58X1m-GJFv1FvPfguNVZnwTb-gqg";

$testMode = true;
$baseUrl = 'https://test-api.shippii.com/';
$shippii = new Shippii($token, $testMode, $baseUrl);

// $test = $shippii
//     ->getOrders()
//     ->getByReference('SH00007804');
// dda($test);
// $test = $shippii
//     ->getOrders()
//     ->between("24/05/2020 00:00:00", "25/05/2020 00:00:01")
//     ->statuses("Ready For Print")
//     //->include('carrier')
//     //->appends('receiver_data')
//     //->paginated(1, 99999)
//     //->sortBy()
//     ->fetch();
// dda($test);

$faker = Factory::create('nb_NO');
$order = new Order();
$order->setReceiverFirstName($faker->firstName);
$order->setReceiverLastName($faker->lastName);
$order->setReceiverAddress($faker->streetAddress);
$order->setReceiverEmail($faker->email);
$order->setReceiverMobile("+4790000000");
$order->setReceiverCity($faker->city);
$order->setReceiverProvince($faker->city);
$order->setReceiverZipCode(2630);
$order->setReceiverCountryCode('NO');
$order->setShippingRateAliasName("My Custom Rate Name");
$order->setShippingRateAliasPrice(120.0);
$order->setExternalOrderStatus($faker->sentence);
$order->setServicePointId('3891249');
$order->setComment('test comment 30 07 21');

$order->setPayFromWallet(true)
    ->setReference($faker->randomNumber(5))
    ->setBillingAddressSameAsShipment()
    ->setShippingMethodId('dkjzzk');

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
    // $status = $shippii->externalStatus('Status', 'Reference');
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
