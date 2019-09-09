<?php
include_once 'vendor/autoload.php';

use Shippii\Shippii;
use Shippii\Shipping\ShippingMethod;
use Shippii\Exceptions\ShippiiValidationException;
use Shippii\Exceptions\ShippiiServerErrorException;
use Shippii\Exceptions\Auth\ShippiiAuthorizationException;
use Shippii\Exceptions\Auth\ShippiiAuthenticationException;


$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjRlZmY1MDU5NmFlNmIyZjA1ZDQ0NDQ0YjE1ZWJhMzBmZWVhYTc1M2IyYTVkMmE0MTQ5MDFmZTc3OWQ4MmFkY2ZmNmNjN2RhYjc0MWI3MjQ0In0.eyJhdWQiOiIyIiwianRpIjoiNGVmZjUwNTk2YWU2YjJmMDVkNDQ0NDRiMTVlYmEzMGZlZWFhNzUzYjJhNWQyYTQxNDkwMWZlNzc5ZDgyYWRjZmY2Y2M3ZGFiNzQxYjcyNDQiLCJpYXQiOjE1Njc2MDc0NTMsIm5iZiI6MTU2NzYwNzQ1MywiZXhwIjoxNTk5MjI5ODUzLCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.HY0wbw7wvWuyAEov3bJEhiNeF20VFkxQT5PihPJMRm0IQS1tMV-vkZUAu4vaGgXQhILEJHksGKuRCz6tu_O6Msebgtqrx-Y_Z6mVirPrMMRvJYtegaywbpo3Lu6f2vETb4AjbMhxJJPy3h0CHuh_DV89gSHRHjxmvpd5PIZM3wqVfwQpbC_PhpCZ_rZY28MHA5XeBV2CKsihmGdUOsv1sh3hizljA2JUPCuihnjHm-1BNQ0wEZrL9Ihex7gmm-cIb6OMC4dKby6n_Wry6REjE751q5I0ajaT4Qr4zBran_dmSZf7wWDRh9jWLPFbDg9V7QTpDNoVGxV3EZ1XaWIdxMwI0B9ts3mwMN7enI_CUpcWuypEtiqherB80QNRWhvyQDiDxGzj72kgi3htqsidNGR5h8CvWMTlLCs448nMHdlR1FDU7FH5TBgAkqPkc_eLjdrKg8YHT7OiY1bK0-IYxAuBIxjT51ROkTY5MwyegrNY1F1HvTD6RmtF8qzl4jA7exh_5fsS4uahDdRKxa-BWbLxA5WVbHgMOHdhTCZavgQ1MHwX3pkxgb21LPp9fbGXn2GmoXk1CuFggFSvxRp1GJAJPNyHFbfKhL6YUJfr1C16NmU0wds_yRSb8guNGvumRZ9HkQoS72Z-oj7Dt9F7B0WaMgyMjGTtn1lem7sy1yQ';

$shippii = new Shippii($token, true);

$method = new ShippingMethod($shippii);

try {
    $response = $method->getShippingMethods();

} catch (ShippiiValidationException $validationException) {
    print_r($validationException->getValidationErrors());
} catch (ShippiiServerErrorException $serverErrorException) {
    print_r([
        'message' => $serverErrorException->getMessage(),
        'shippii_event_id' => $serverErrorException->getEventId()
    ]);
} catch (ShippiiAuthorizationException $authorizationException) {
    print 'Your app does not have the need token scope';
} catch (ShippiiAuthenticationException $authenticationException) {
    print "You are not authenticated. Please check your token.";
}

dump($response);
