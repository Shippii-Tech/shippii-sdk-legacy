<?php

use Shippii\Webhooks\WebhookOrderObject;

require_once 'vendor/autoload.php';

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$signature = $_SERVER['HTTP_SIGNATURE'];
$wh = new \Shippii\Webhooks\Webhook($signature, '510');

// Order
$order = $wh->getOrderObject($data);
var_dump($order->getOrderStatus());
var_dump($order->getOrderId());
var_dump($order->getOrderReference());
var_dump($order->getOrderShippingMethod());
var_dump($order->getOrderCarrier());

// Order Label
$label = $order->getOrderLabelObject();
var_dump($label->getLabelUrl());
var_dump($label->getNumberOfLabels());

// Order Receiver
$receiver = $order->getOrderReceiverObject();
var_dump($receiver->getReceiverName());
var_dump($receiver->getReceiverEmail());
var_dump($receiver->getReceiverMobile());
var_dump($receiver->getReceiverCountryName());
var_dump($receiver->getReceiverCountryCode());
var_dump($receiver->getReceiverCity());
var_dump($receiver->getReceiverAddress());
var_dump($receiver->getReceiverZipCode());

// Order Items
$items = $order->getOrderItemsObject();
var_dump($items->getItemNames());
var_dump($items->getItemSkus());
var_dump($items->getItemEans());
var_dump($items->getItemWeights());
var_dump($items->getItemVolumes());
var_dump($items->getItemQuantities());


file_put_contents('log.txt', json_encode([
    'signature' => $signature,
    'isValid' => $wh->isValid(),
    'contents' => $data
]), FILE_APPEND);

return '200';