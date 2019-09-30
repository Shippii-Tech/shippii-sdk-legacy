<?php

use Shippii\Shippii;
use Shippii\Shipping\LivePrice;

include_once 'vendor/autoload.php';

$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjRlZmY1MDU5NmFlNmIyZjA1ZDQ0NDQ0YjE1ZWJhMzBmZWVhYTc1M2IyYTVkMmE0MTQ5MDFmZTc3OWQ4MmFkY2ZmNmNjN2RhYjc0MWI3MjQ0In0.eyJhdWQiOiIyIiwianRpIjoiNGVmZjUwNTk2YWU2YjJmMDVkNDQ0NDRiMTVlYmEzMGZlZWFhNzUzYjJhNWQyYTQxNDkwMWZlNzc5ZDgyYWRjZmY2Y2M3ZGFiNzQxYjcyNDQiLCJpYXQiOjE1Njc2MDc0NTMsIm5iZiI6MTU2NzYwNzQ1MywiZXhwIjoxNTk5MjI5ODUzLCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.HY0wbw7wvWuyAEov3bJEhiNeF20VFkxQT5PihPJMRm0IQS1tMV-vkZUAu4vaGgXQhILEJHksGKuRCz6tu_O6Msebgtqrx-Y_Z6mVirPrMMRvJYtegaywbpo3Lu6f2vETb4AjbMhxJJPy3h0CHuh_DV89gSHRHjxmvpd5PIZM3wqVfwQpbC_PhpCZ_rZY28MHA5XeBV2CKsihmGdUOsv1sh3hizljA2JUPCuihnjHm-1BNQ0wEZrL9Ihex7gmm-cIb6OMC4dKby6n_Wry6REjE751q5I0ajaT4Qr4zBran_dmSZf7wWDRh9jWLPFbDg9V7QTpDNoVGxV3EZ1XaWIdxMwI0B9ts3mwMN7enI_CUpcWuypEtiqherB80QNRWhvyQDiDxGzj72kgi3htqsidNGR5h8CvWMTlLCs448nMHdlR1FDU7FH5TBgAkqPkc_eLjdrKg8YHT7OiY1bK0-IYxAuBIxjT51ROkTY5MwyegrNY1F1HvTD6RmtF8qzl4jA7exh_5fsS4uahDdRKxa-BWbLxA5WVbHgMOHdhTCZavgQ1MHwX3pkxgb21LPp9fbGXn2GmoXk1CuFggFSvxRp1GJAJPNyHFbfKhL6YUJfr1C16NmU0wds_yRSb8guNGvumRZ9HkQoS72Z-oj7Dt9F7B0WaMgyMjGTtn1lem7sy1yQ";
$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjlkOWYyOGIwNGU1ODQxOTI2NmMyY2U5YjQzNTc5MDhmZjI2ZWU4NjE5YTRmNGI3ZTdkNDBmYzY2ZjBjMGQ2NWY2MmVmNTU5NGJkZWUwNGI2In0.eyJhdWQiOiIxIiwianRpIjoiOWQ5ZjI4YjA0ZTU4NDE5MjY2YzJjZTliNDM1NzkwOGZmMjZlZTg2MTlhNGY0YjdlN2Q0MGZjNjZmMGMwZDY1ZjYyZWY1NTk0YmRlZTA0YjYiLCJpYXQiOjE1NjgxMDAyOTYsIm5iZiI6MTU2ODEwMDI5NiwiZXhwIjoxNTk5NzIyNjk2LCJzdWIiOiI4Iiwic2NvcGVzIjpbImZ1bGwtYWNjZXNzLXRvLWNvbXBhbnktb3JkZXJzIiwiY2FuLWZldGNoLW1ldGhvZHMiLCJjYW4tZmV0Y2gtc2hpcHBpbmctcmF0ZXMiXX0.hKPRJEqXZgFuyOSe8bn544U86jQh13uRBfcUBXziJkP9-WmiDiowfFj-hPBag2F3qalpYQPbymRjUbSuFodZj3y003e466hTY1TrDE3ylJHWjUw23a1XJkJotP83vVauEiyDIH_fUyqyrS1q8bGw8-iPMsS7P2ZPeXa-YG9KS2k6Ywt6DlNXq0YjMcjT1mgLQ-SMUS75T8tCHwwh78iKfSGqjkBq2eRfsSgAEg1AJtQR8smWu6SG17XcyEmN1JmMH5qc1mEHbwxCT8CSXeFLeR3Vtp3RJGi2v-nrALwSn5Y3NCw_BoD8mZBArtEiaxUVvIqrK74L34MNkr8t-jiDcILEw_Buw-t_8rBvFtbBNS08madWKuuvTWFikYEDpqKlUC6qIDzNcVYlx1DkahWVCuCvhUfV11-SC4ik9YDMTURNWa7dSvwsi10X74clA0qljNzFb3RwYtI3-2k8B_hT0prYRgDADYle1xDtTrOiIn_DysM2c2rE6gq0bojv6KERxYT7OOw4ZjXvI0xbHmaCirWJ_BEtx1YrxQt796AkSHamhJbI5owamBxdeFyXrazuHoYk6cjcOciGhoKHcFiltC1W3Fdkl5J4eFMYQvNswnaL_BbI-Ux-uF9wFQ3bry6yTJA3Ohhs11LGkWeI-_CK5EwwVO203uT2iePqVbGFn88';
$testMode = true;

$shippii = new Shippii($token, $testMode);
$livePrice = new LivePrice($shippii);

$cartItems = [
    [
        'weight' => 500.0, // WEIGHT PER SINGLE ITEM !!!
        'quantity' => 3,
        'weight_measurement' => 'grams'
    ],
    [
        'weight' => 1000.0,
        // WEIGHT PER SINGLE ITEM !!!
        'quantity' => 10,
        // You can set your measurement to be converted to kilograms. So if it's not kilograms put the measurement unit so you will be able to get the correct price
        'weight_measurement' => 'grams'
    ]
];

$livePrice->setReceiverCountryCode('NO')
    ->setReceiverZipCode('1063')
    ->setCartItemsFromArray($cartItems);
try {
    $response = $livePrice->getLivePrice();
} catch (\Shippii\Exceptions\Auth\ShippiiAuthenticationException $e) {
    print "Could not authenticate";
} catch (\Shippii\Exceptions\Auth\ShippiiAuthorizationException $e) {
    print "Action not allowed by Shippii";
} catch (\Shippii\Exceptions\Auth\ShippiiEndpointNotFoundException $e) {
    print "Endpoint not found 404 !";
} catch (\Shippii\Exceptions\ShippiiServerErrorException $e) {
    print "Shippii returned 500 - The problem is in their machine :)";
} catch (\Shippii\Exceptions\ShippiiValidationException $e) {
    print "Validation Exception please fix the following errors";
    dump($e->getValidationErrors());
}