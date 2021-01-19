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

$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjFlN2Q5MjM0MDkyODJjZDVjNTZiZjhmYTUyMmM2NTYyMGIzZTY5ZGMyNzViZjA0ZmJiNDdmNWUwYTRmNzZjNjljMzdhOGFlN2Q1ZDBlNmFkIn0.eyJhdWQiOiIxIiwianRpIjoiMWU3ZDkyMzQwOTI4MmNkNWM1NmJmOGZhNTIyYzY1NjIwYjNlNjlkYzI3NWJmMDRmYmI0N2Y1ZTBhNGY3NmM2OWMzN2E4YWU3ZDVkMGU2YWQiLCJpYXQiOjE1OTY3OTM0MzgsIm5iZiI6MTU5Njc5MzQzOCwiZXhwIjoxNjI4MzI5NDM4LCJzdWIiOiIxIiwic2NvcGVzIjpbImNyZWF0ZS1vcmRlciJdfQ.x1EciqIC2W3G7FLz3HLQXLd4xN0xPnU22W6HFntmloKxKlW0KPFQmz-wrn6NoXMnQtbTuUf1We_HqfFRZ9WvoBvfDEY8x5q0Yn4_9QgHEJ2SsqccGwczXwxjrdAU14AXMybOR0k0a69LHaY1j0nEEBrgUzgLlC_hQeSLhII7EZEH96HdOBXJROCeC16ARBVrtGrtLygZMDwpMwk2EkNWeiN3rlQaT-bpiVCqMS0OAKAGkJ6sQklaHPzydmkiySWKgXk_No8-bjEYbavlyR30i84LWmV7hPNFKlioOGBxkVdYIug3a8j_Kf1eXbQe2d8VAzDrCEjF56W6VQr9q9-OW_E2bUIMfHL0vE8NYUBt0Se8VTSzXvQkF07OnfQ1cAERm1FxpbSs-WOg_mIp26XBs64nIbBVIAYO5OHxQbVd8ZShEpuVof5lyBIijmHkUaoQH0hdZsc-hPX5U6F59XpursbKsFAfYfIyJXFTtWQ1Xgt9vesmgM8I6ZY-S6C_dGPSw9_gjQnVToiNjZcDPunfn6AwAw78TOT5WtRwRXq7txdo7UP06oJZGd8Ope-v-nQkqUJ4pgFkI2lyhh59CAh3xHF5y0sl6opa88nagOtstwCPbV_ig_Qr4L3tcmODFAOl3CeCmGhsfdT7ymeJNXja0Cvdvz4lnqjYih3jLGaYQZA';


$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjhjMDUzNzNjNDFkZTJkZWYyOThiNmY3M2MxNzQyZDE0MjUxNzk3OGMzZjZkODk0YjYzNmNiMTMwZDg4OTViMjQxMDYwODU4OWFlMjM1MjhhIn0.eyJhdWQiOiIxIiwianRpIjoiOGMwNTM3M2M0MWRlMmRlZjI5OGI2ZjczYzE3NDJkMTQyNTE3OTc4YzNmNmQ4OTRiNjM2Y2IxMzBkODg5NWIyNDEwNjA4NTg5YWUyMzUyOGEiLCJpYXQiOjE1OTk2NDUyNTAsIm5iZiI6MTU5OTY0NTI1MCwiZXhwIjoxNjMxMTgxMjUwLCJzdWIiOiIxIiwic2NvcGVzIjpbImNhbi1mZXRjaC1tZXRob2RzIiwiY2FuLWZldGNoLXNoaXBwaW5nLXJhdGVzIiwiY2FuLWZldGNoLWNvdW50cmllcyIsInBheV9mcm9tX3dhbGxldCIsImNhbi1mZXRjaC13YWxsZXRzLWJhbGFuY2VzIiwiY3JlYXRlLW9yZGVyIiwiY3JlYXRlLXJldHVybi1vcmRlciIsInVwZGF0ZS1vd25lZC1vcmRlciIsImNhbmNlbC1vd25lZC1vcmRlciIsInZpZXctb3duZWQtb3JkZXIiLCJwcmludC1sYWJlbHMiLCJmdWxsLWFjY2Vzcy10by1jb21wYW55LW9yZGVycyIsImNhbi1jcmVhdGUtaW52b2ljZSIsImNhbi1kZWxldGUtaW52b2ljZSJdfQ.Td-yP_kRHvRhtdzM78_Gba9j9wen37Vkg7T3eNdBJo8odRELaZOfKxTAFi4oLZyL4U0Yddi4V8ny1US1lGOv8Su5RkVudy6ha9_qoHkQWCN5rjhNch8lfQQU4YY6_bRpG8x4vESnTuvqL9IKgb5-ya1tGsOpL_xs3lsUTsHsIWSYQLB4YOXch3btXTqlUQmbzcmPFgCDAtQzU6eQKSaeBFOnzY0N95Cinm8EH1Hagj9hTth5DV78fqk63N50qh7PlkedhUVa9-rCRIv84dnhg9WaZmm6Z8V5Kp6DbYhY8FsjzuVykpEPjBnWgtLY2YHz_H7mRsFaz3pdZQhTJwbbehZN1GW-n3kXHyMskOVdTIwY1rqf500gdIwREip6uGWrkSEH154vGYyHv9Teq93dXvnpx76c2soNSVFl4xQRf3Yc6mnI4rLqZnj9aBVGAyFVfFQFazEAJ_mM_Wv0D8iR0VBrOAEZnlC0JSz_pHZaGPZHfXw_v4c6TxSIj6FrVme70TwnFnf-dNVOsTQP7dp5QaZ2Q4JSMKFfhwNP1mC3iChfbTdRq6uwiAN90zNir3rr4Dh8bXVBEWnEZzWIHrp8QiBX4V1gtzh-1vYnGgBjrSdcfSdfc1oGUBMa8A053SSKHnv8e4wy3IpeNlWI4kQaYoOPPGUY9vARvtbxnZ7M1hE';

$testMode = true;
$baseUrl = 'http://shippii-api.test';

$shippii = new Shippii($token, $testMode, $baseUrl);

$test = $shippii
    ->getOrders()
    ->getByReference('SH00007804');

dda($test);

$test = $shippii
    ->getOrders()
    ->between("24/05/2020 00:00:00", "25/05/2020 00:00:01")
    ->statuses("Ready For Print")
    //->include('carrier')
    //->appends('receiver_data')
    //->paginated(1, 99999)
    //->sortBy()
    ->fetch();

dda($test);

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
$order->setExternalOrderStatus($faker->sentence);

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
    $status = $shippii->externalStatus('Status', 'Reference');
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
