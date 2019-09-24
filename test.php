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

$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjkwMDBkZDljYThkNzdlMGQ0NTRjODBmMzIxMjhlYjY0OGFlYTQ1YzM3OGYyYjEwOTY0YTI0ODM4ZTI3YjRjNmY1YTc3NTRjMjgzNDU4ZGI5In0.eyJhdWQiOiIxIiwianRpIjoiOTAwMGRkOWNhOGQ3N2UwZDQ1NGM4MGYzMjEyOGViNjQ4YWVhNDVjMzc4ZjJiMTA5NjRhMjQ4MzhlMjdiNGM2ZjVhNzc1NGMyODM0NThkYjkiLCJpYXQiOjE1NjgxODQ1NDMsIm5iZiI6MTU2ODE4NDU0MywiZXhwIjoxNTk5ODA2OTQzLCJzdWIiOiI0Iiwic2NvcGVzIjpbImNhbi1mZXRjaC1tZXRob2RzIiwiZnVsbC1hY2Nlc3MtdG8tY29tcGFueS1vcmRlcnMiXX0.gDfBfXKUd-o57nSzCzf2urX8P6lEHfSAkkK5XUGCamZbFAFy0gtvJw3DpDqtbNikbyngNv3XSkfY6KoUWF_ylBN0u59yz3PQ3q_83-fEt-jk_tE4fuEcvmmQ_VCQe1BmGaV4iKnQRKyZECb6IyppE-it2Rp4u5Rlp73eAnqJZMOIubBTvC2vNR5KDEWkXzSxAO4nkY1MJ0ikg1EbiOMXKrupUaQdhZpqmrm2VNVnHe2ItJTeaPywNceBo7fM96if58y-rWgVq4vZqDKKX3A-hsIJcQx2KwRoYnA3wp5y69UvMJ5Fg1wWVdrqpwghEd8ZCt3xFFy4Tn5pu5FqUgoL0WsWaCiROiq4dTr13XiFaiHYyicTvh-TIVNsapw88XFhe_jvWphnH_Vjo33S27TKheIOMQbKkwewdk6qTSPvp0LwiS5ekZxY4SNu94xRV4OPtgzBjy6m0_Uf8_6dyohq_FXHnKkCxc_Ab1vtA76Q8d0q3aWypuhqGyH6Mm5pIcxuUcbU7vuStZJ59uLjv_kTQdzXbq-yD7kP3Sy8OkRZwfNAv4TLG59Nj8oiUWrHc50W-f-sQktXPxNg4ZZZv1B50GYuWXjDzBjzdUec_dBA3l18tRNg74yy_y1HEoYdrUX7-8fOQNY4xdToEOwKLMgURDMlswDFcfThA46WUPyowt4";

$testMode = true;
$baseUrl = 'http://shippii-core.test/';

$shippii = new Shippii($token, $testMode, $baseUrl);

$faker = Factory::create('nb_NO');

$order = new Order();
$order->setReceiverFirstName($faker->firstName);
$order->setReceiverLastName($faker->lastName);
$order->setReceiverAddress($faker->streetAddress);
$order->setReceiverEmail($faker->email);
$order->setReceiverMobile($faker->randomNumber(8));
$order->setReceiverCity($faker->city);
$order->setReceiverProvince($faker->country);
$order->setReceiverZipCode($faker->postcode);
$order->setReceiverCountryCode('DK');

$order->setPayFromWallet(true)
    ->setReference($faker->randomNumber(5))
    ->setBillingAddressSameAsShipment()
    ->setShippingMethodId('9oN23o')
    ->setShippingRateId("1oLOlq");

dump($order);

$items = [ // items
    [
        'name' => 'Man Shoes', // required
        'ean' => '1232131212', // optional
        'price' => 50.00, // float. required This is the price for SINGLE item
        'quantity' => 1, // int/float required This is the quantity shipped.
        'weight' => 3.21, // float required The weight of the SINGLE item
        'sku' => 'ITEM123213' // You can put your Item ID here for instance.
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
    
    try {
        $order->setOrderItem($orderItem);
    } catch (TypeError $error) {
        print $error->getMessage();
    }
}

try {
    $response = $shippii->setOrder($order)->sendOrder();

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
