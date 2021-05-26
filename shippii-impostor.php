<?php

require_once 'vendor/autoload.php';

$client = new \GuzzleHttp\Client();

$client->post('http://localhost:1520', [
    'json' => [
        'event_type' => 'test',
        'label_url' => 'http://label.com/1.pdf'
    ]
]);