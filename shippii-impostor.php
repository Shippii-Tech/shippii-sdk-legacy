<?php

require_once 'vendor/autoload.php';

$client = new \GuzzleHttp\Client();

$contents = [
    'event_type' => 'test',
    'label_url' => 'http://label.com/1.pdf'
];

$req = $client->request('post', 'http://localhost:1520', [
    'headers' => [
      'Signature' =>  hash_hmac('sha256', json_encode($contents), '510')
    ],
    'json' => $contents
]);

dd($req->getBody()->getContents());