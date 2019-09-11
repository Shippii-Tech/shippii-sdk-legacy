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
    'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjlkOWYyOGIwNGU1ODQxOTI2NmMyY2U5YjQzNTc5MDhmZjI2ZWU4NjE5YTRmNGI3ZTdkNDBmYzY2ZjBjMGQ2NWY2MmVmNTU5NGJkZWUwNGI2In0.eyJhdWQiOiIxIiwianRpIjoiOWQ5ZjI4YjA0ZTU4NDE5MjY2YzJjZTliNDM1NzkwOGZmMjZlZTg2MTlhNGY0YjdlN2Q0MGZjNjZmMGMwZDY1ZjYyZWY1NTk0YmRlZTA0YjYiLCJpYXQiOjE1NjgxMDAyOTYsIm5iZiI6MTU2ODEwMDI5NiwiZXhwIjoxNTk5NzIyNjk2LCJzdWIiOiI4Iiwic2NvcGVzIjpbImZ1bGwtYWNjZXNzLXRvLWNvbXBhbnktb3JkZXJzIiwiY2FuLWZldGNoLW1ldGhvZHMiLCJjYW4tZmV0Y2gtc2hpcHBpbmctcmF0ZXMiXX0.hKPRJEqXZgFuyOSe8bn544U86jQh13uRBfcUBXziJkP9-WmiDiowfFj-hPBag2F3qalpYQPbymRjUbSuFodZj3y003e466hTY1TrDE3ylJHWjUw23a1XJkJotP83vVauEiyDIH_fUyqyrS1q8bGw8-iPMsS7P2ZPeXa-YG9KS2k6Ywt6DlNXq0YjMcjT1mgLQ-SMUS75T8tCHwwh78iKfSGqjkBq2eRfsSgAEg1AJtQR8smWu6SG17XcyEmN1JmMH5qc1mEHbwxCT8CSXeFLeR3Vtp3RJGi2v-nrALwSn5Y3NCw_BoD8mZBArtEiaxUVvIqrK74L34MNkr8t-jiDcILEw_Buw-t_8rBvFtbBNS08madWKuuvTWFikYEDpqKlUC6qIDzNcVYlx1DkahWVCuCvhUfV11-SC4ik9YDMTURNWa7dSvwsi10X74clA0qljNzFb3RwYtI3-2k8B_hT0prYRgDADYle1xDtTrOiIn_DysM2c2rE6gq0bojv6KERxYT7OOw4ZjXvI0xbHmaCirWJ_BEtx1YrxQt796AkSHamhJbI5owamBxdeFyXrazuHoYk6cjcOciGhoKHcFiltC1W3Fdkl5J4eFMYQvNswnaL_BbI-Ux-uF9wFQ3bry6yTJA3Ohhs11LGkWeI-_CK5EwwVO203uT2iePqVbGFn88',
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
$order->setPayFromWallet(false)
    ->setReference($faker->randomNumber(5))
    ->setBillingAddressSameAsShipment();

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

dump($order);

try {
    $response = $shippii->setOrder($order)->sendOrder();
    dump($response);
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
