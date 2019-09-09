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

$shippii = new Shippii(
    'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjFiMGYzODBiZTU1MDQzODk2NTJkNzA2NmE5ZjUxNzBmNDQyZTY3MjNkMzBjODRmMjEwNjZlYmFhZGE1ZjlhMDRlYTNkNjBlOTkyYTEzZTM1In0.eyJhdWQiOiIxIiwianRpIjoiMWIwZjM4MGJlNTUwNDM4OTY1MmQ3MDY2YTlmNTE3MGY0NDJlNjcyM2QzMGM4NGYyMTA2NmViYWFkYTVmOWEwNGVhM2Q2MGU5OTJhMTNlMzUiLCJpYXQiOjE1NjY4MjI4MzksIm5iZiI6MTU2NjgyMjgzOSwiZXhwIjoxNTk4NDQ1MjM5LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.ApotxOjKNJv-OkrWJZ5aNmvk6Ks7nEXOIGrXezhN3gFQKPgMrBP709ov_6Gpphu4DJqaIw73AoaqOry1n4pL6QaeYD1jYF21_ZSgmLdhkN26BD7LorSBviDuQzlXMpTuy4aQW2sVccRnEnjaEBddQ4_zfaGoRGgYOYsEN0Ti4Gnd4p-uI7udSTMVzXB0Py4ZeBRPO3KEqPsAiDeSOfy1ZhY0tKr8GkY5w5BiAtrxzK-mCPDAukH_MMCyCgwenP8xrzTbeKz88Wcy3D2nk655x0Lj357rvWSMJB5HmCOgMcftxrMpUAE6Q6qj2tlNbbPw75YUjLD3-aNM7EYret8I6It5c3gbP0sqMCPR2d9YTnmkumk__InVJBFgt5kRGs8vlcIBYrWNE0DTj5LqZOhrCWUcX_YxQHLSWbqfqSUSlthzZE6df30q5upiqEGgm2ja33OTAZgSfF_Ma5ZOqnYzOpgvk2F6piJxMgINFOUpysdIoaOmfvqJHgYLStYBl8_FUeAoTH79KPEFIxNUdrBIKvSqi8vLmr0hKd5AQBtm4RhJ1qqK9J4PQX7fGpo5DdmO6k9uB-cmfef-AgfKSxA1X6ryFZiKUez23oafs4K47PjjP7Ftv4mFYzdmhkhY0HAkk07UB8DPQr-espf7RO9rZSGdjR9Fv0rUhx2kJrNu7Z4',
    true
);

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
$order->setReceiverCountryCode('NO');
$order->setPayFromWallet(true)
    ->setReference($faker->randomNumber(5))
    ->setBillingAddressSameAsShipment()
    ->setShippingRateId("96vyGZ");

dump($order);

$items = [
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
    $order->setOrderItem($orderItem);
}

try {
    $response = $shippii->setOrder($order)->sendOrder();

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
}
