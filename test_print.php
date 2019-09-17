<?php
include_once 'vendor/autoload.php';

use Shippii\Exceptions\Auth\ShippiiAuthenticationException;
use Shippii\Exceptions\Auth\ShippiiAuthorizationException;
use Shippii\Exceptions\ShippiiEndpointNotFoundException;
use Shippii\Exceptions\ShippiiServerErrorException;
use Shippii\Exceptions\ShippiiValidationException;
use Shippii\Label;
use Shippii\Shippii;

$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjRlZmY1MDU5NmFlNmIyZjA1ZDQ0NDQ0YjE1ZWJhMzBmZWVhYTc1M2IyYTVkMmE0MTQ5MDFmZTc3OWQ4MmFkY2ZmNmNjN2RhYjc0MWI3MjQ0In0.eyJhdWQiOiIyIiwianRpIjoiNGVmZjUwNTk2YWU2YjJmMDVkNDQ0NDRiMTVlYmEzMGZlZWFhNzUzYjJhNWQyYTQxNDkwMWZlNzc5ZDgyYWRjZmY2Y2M3ZGFiNzQxYjcyNDQiLCJpYXQiOjE1Njc2MDc0NTMsIm5iZiI6MTU2NzYwNzQ1MywiZXhwIjoxNTk5MjI5ODUzLCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.HY0wbw7wvWuyAEov3bJEhiNeF20VFkxQT5PihPJMRm0IQS1tMV-vkZUAu4vaGgXQhILEJHksGKuRCz6tu_O6Msebgtqrx-Y_Z6mVirPrMMRvJYtegaywbpo3Lu6f2vETb4AjbMhxJJPy3h0CHuh_DV89gSHRHjxmvpd5PIZM3wqVfwQpbC_PhpCZ_rZY28MHA5XeBV2CKsihmGdUOsv1sh3hizljA2JUPCuihnjHm-1BNQ0wEZrL9Ihex7gmm-cIb6OMC4dKby6n_Wry6REjE751q5I0ajaT4Qr4zBran_dmSZf7wWDRh9jWLPFbDg9V7QTpDNoVGxV3EZ1XaWIdxMwI0B9ts3mwMN7enI_CUpcWuypEtiqherB80QNRWhvyQDiDxGzj72kgi3htqsidNGR5h8CvWMTlLCs448nMHdlR1FDU7FH5TBgAkqPkc_eLjdrKg8YHT7OiY1bK0-IYxAuBIxjT51ROkTY5MwyegrNY1F1HvTD6RmtF8qzl4jA7exh_5fsS4uahDdRKxa-BWbLxA5WVbHgMOHdhTCZavgQ1MHwX3pkxgb21LPp9fbGXn2GmoXk1CuFggFSvxRp1GJAJPNyHFbfKhL6YUJfr1C16NmU0wds_yRSb8guNGvumRZ9HkQoS72Z-oj7Dt9F7B0WaMgyMjGTtn1lem7sy1yQ";
$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjEwNzk0OWI5MTg5OTYyOTAwZWFmZmM0OWY5ZWEzNmRiOWJmMzc4MGQ5MDZiY2VhOTAzMjFkYWE3NzNmYWQxODk5NTI4MjIwNjNhMTcxMWE2In0.eyJhdWQiOiIxIiwianRpIjoiMTA3OTQ5YjkxODk5NjI5MDBlYWZmYzQ5ZjllYTM2ZGI5YmYzNzgwZDkwNmJjZWE5MDMyMWRhYTc3M2ZhZDE4OTk1MjgyMjA2M2ExNzExYTYiLCJpYXQiOjE1Njc2OTU3NTMsIm5iZiI6MTU2NzY5NTc1MywiZXhwIjoxNTk5MzE4MTUzLCJzdWIiOiIxIiwic2NvcGVzIjpbImZ1bGwtYWNjZXNzLXRvLWNvbXBhbnktb3JkZXJzIl19.vOvY_5DEVs1oT2tXijHjMHCOkqXppGmPr-Ncc2cJ-QWLNbmEDA-ppMlMPNDM7kvftWkAbkK1lyhc2vmmY2bRvBsonueQAIG0hvcj7-0WY-AAtuhZ-iKcA3LLlq33Yjcfe0QQKzRjB-StlJSJtFF9s1Fl65cWiqa2-AnSKkqOsCARXzc1jfCceDpGwKIbIpXzueG3aL6J1r-M4xuUyN4yOm4akiK7Nw7oWN_011F5vN7CWhTJTc3Yz-Rf5ggnjTS0zoNvAk9kLKYHMy74KfJNEYnIkZiXjc1_-BN6iPvP8leR0EiDBxO09UhQeH0a78vFVT6Eu1eMiiD27Lc_9Wxrj0swYTckNKIbC_7SjnCHlhXrB7UTHk5x3x7TXD9lfFXNOTcYYZeuJqEowAt6987SQDi4azu4pxVDBLYi5MO-KaAFvaF_PXmDEn5OSGhp0mqd6nUMq-Pob_-OBmhf9qT5gPDhswLTz18v-lgZ3GfUpolbNcaaS3Y3pq17Njnl3rfybhV2yDUuIAfQdWcOxE3FWsVMFzmPBRG8cGOWm5rIwivY4MMOBO35oz2hxFX8YZNtd_iJmjR9rO63ybjxmP7IQFyeelL5smOFee04z5Sn-qj0zLQxggZ-ElL7PHlE3Myc5n1E7fyOB8LjBEc8nYFmi17zVkKG4okoXhhwZ__AI5g";

$shippii = new Shippii($token, true, 'http://shippii-reborn.test');

$label = new Label($shippii);
$references = ['a1'];
try {
    $responseSingle = $label->getLabelForSingleOrder('a1111');
    $responseSelected = $label->getLabelsForSelectedOrders($references);
    dump($responseSingle);
    dump($responseSelected);
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
} catch (ShippiiEndpointNotFoundException $e) {
    print $e->getMessage();
}
