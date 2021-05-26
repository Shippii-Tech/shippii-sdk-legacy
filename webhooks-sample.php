<?php

require_once 'vendor/autoload.php';

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$signature = $_SERVER['HTTP_SIGNATURE'];
$wh = new \Shippii\Webhooks\Webhook($signature, '510');

$data = $wh->parse();

file_put_contents('log.txt', json_encode([
    'signature' => $signature,
    'isValid' => $wh->isValid(),
    'contents' => $data
]), FILE_APPEND);

return '200';