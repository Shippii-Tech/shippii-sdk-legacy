<?php

require_once 'vendor/autoload.php';

$client = new \GuzzleHttp\Client();

$contents = [
    "event-type" => "single-order-labels-created",
    "order_id" => "Gogbqe",
    "reference" => "pancho1",
    "order_status" => "Ready for Print",
    "order" => [
        "id" => "Gogbqe",
        "reference" => "pancho1",
        "shipping_method" => "Test method",
        "carrier" => "GLS",
        "created_at" => "2021-02-18 14:19:38",
        "receiver" => [
            "first_name" => "asd",
            "last_name" => "asd",
            "email" => "b.bojkov@vconnect.dk",
            "mobile" => "+4574422385",
            "country" => [
                "name" => "Denmark",
                "code" => "DK",
            ],
            "city" => "nostrum",
            "address" => "true",
            "zip_code" => "8460",
        ],
        "items" => [
            0 => [
                "name" => "Item 0.500kg©",
                "sku" => "123456",
                "ean" => null,
                "weight" => "0.7",
                "volume" => null,
                "quantity" => 3,
            ]
        ]
    ],
    "data" => [
        // "printer" => "",
        // "external_status" => ""
        "event-type" => "single-order-labels-created",
        "order_id" => "Gogbqe",
        "reference" => "pancho1",
        "order_status" => "Ready for Print",
        "data" => [
            "label_url" => "https://shippii-api-bojko.s3.eu-central-1.amazonaws.com/order_Gogbqe/6061b5855b537123cb4e0e91dd46af4a6cc396bb22a0a2f80bd14b2e9ae9ef69.pdf?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAIZ5CLJPOKWUO4IDQ%2F20210526%2Feu-central-1%2Fs3%2Faws4_request&X-Amz-Date=20210526T093922Z&X-Amz-SignedHeaders=host&X-Amz-Expires=86400&X-Amz-Signature=ee771ed23c466aab019dae63b46ba326a70de6bfa6d823d5ddf0627b57b5eded",
            "number_of_labels" => 1,
        ]
    ]
];

$req = $client->request('post', 'http://localhost:1521', [
    'headers' => [
        'Signature' => hash_hmac('sha256', json_encode($contents), '510')
    ],
    'json' => $contents
]);

dd($req->getBody()->getContents());