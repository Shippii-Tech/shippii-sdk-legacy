<?php

include_once 'vendor/autoload.php';

use Shippii\Shippii;
use Shippii\Exceptions\ShippiiValidationException;
use Shippii\Exceptions\ShippiiServerErrorException;
use Shippii\Exceptions\Auth\ShippiiAuthorizationException;
use Shippii\Exceptions\Auth\ShippiiAuthenticationException;
use Shippii\Shipping\Control;

$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMGYwZGQ5YzQ3NzFjYzU3NTMxMDRjNTM5MDBlY2FhOGU2ZmYzYTIyODU1NDMzNDZkNTdiNjE4ZDgxZWNhZTU1NDNmYjg1NWI3NjdlZTkxNGUiLCJpYXQiOjE2MTc3OTA0NzIuMTg5NzA0LCJuYmYiOjE2MTc3OTA0NzIuMTg5NzEsImV4cCI6MTY0OTMyNjQ3Mi4xODcxNDEsInN1YiI6IjMiLCJzY29wZXMiOlsiY2FuLWZldGNoLW1ldGhvZHMiLCJjYW4tZmV0Y2gtc2hpcHBpbmctcmF0ZXMiLCJjYW4tZmV0Y2gtY291bnRyaWVzIiwicGF5X2Zyb21fd2FsbGV0IiwiY2FuLWZldGNoLXdhbGxldHMtYmFsYW5jZXMiLCJjcmVhdGUtb3JkZXIiLCJjcmVhdGUtcmV0dXJuLW9yZGVyIiwidXBkYXRlLW93bmVkLW9yZGVyIiwiY2FuY2VsLW93bmVkLW9yZGVyIiwidmlldy1vd25lZC1vcmRlciIsInByaW50LWxhYmVscyIsImZ1bGwtYWNjZXNzLXRvLWNvbXBhbnktb3JkZXJzIiwiY2FuLWNyZWF0ZS1pbnZvaWNlIiwiY2FuLWRlbGV0ZS1pbnZvaWNlIl19.61SKYym-XWDAHdi2fqn2ksVSPCfjuR5rQ-5_nB1Xu86JBOnpSLrrwb9lVWi75ZknJllJorA7UVXA9eWy_T0idpjPA6j4ZvLdJQaMwZAfW_y2TPvnTS9yu7-5fHeWPi4lqTnSvWpcQiLwhKhqyCvhXCHlV4kLI6lJjr96SLg2SU8KXjj7tabbBoscUghmU9kld9TIyYgUQh2FXKgJC9T0oH3R1NZO2KFhq3IxRpoi_EVqCMuF6Pie6xHLXW1Vai4uwsvQiMsvVzCShW-V66WrK426dvAFiq1CqE61joZE5N1Qe6XgV9K80i4CIpef08bTVS8lZlnRksyYdzERxOWuCX-TmegKJibsv02ZRvJsfOcdfwYYMmYCN6cKInbKyeX79Nq6HWmwyFRba2moYawYNRa4nJA5I9XtX_AFtjw9i0TH9zoGvXjN6k7qjaLrRbKO-p87dDIJHwXEw-Oh2eTHY9O3_ay61Moh_i5z4G1TnpfEgCe2mSN0cXhNxgLfTgn5WvBadqKt3Xx2syiRUv12b0JTTqdBcsCzlnIn6mHs6rl4aPCqOnp799JU9uXena1FmC9Ax4R4ELEOm67HwlkV1BZoD0Pv_h6mRscubo7wAOnk6fE4BJbz7CH3Huey8hQXsfuFM0E_-DaHvZ-58X1m-GJFv1FvPfguNVZnwTb-gqg";

$testMode = true;
$url = "https://test-api.shippii.com";
$shippii = new Shippii($token, $testMode, $url);
$control = new Control($shippii);

try {
    $response = $control->testShippiiConnection();
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