#### SHIPPII - PHP SDK (v1.0.1)

Usage
-----
To Make Order:
```php
use Shippii\Orders\Order;
use Shippii\Orders\OrderItem;
use Shippii\Shippii;

$token = 'YOUR APP TOKEN';
$testMode = true;
$urls = Shippii::APP_URLS;
//Example Response App urls

    /*array:3 [▼
      "live_env" => "https://api.shippii.com/"
      "dev_env" => "https://test-api.shippii.com/"
      "stage_env" => "https://stage-api.shippii.com/"
    ]
    */
$url = $urls['dev_env'];

$shippii = new Shippii($token, $testMode, $url);

$order = new Order();

//The Receiver Data
$order->setReceiverFirstName("John");
$order->setReceiverLastName("Doe");
$order->setReceiverAddress("91 Aleksandur Malinov");
$order->setReceiverEmail("john_doe@vconnect.dk");
$order->setReceiverMobile("00359877111111");
$order->setReceiverCity("Sofia");
$order->setReceiverProvince("Sofia");
$order->setReceiverZipCode(1000);
$order->setReceiverCountryCode("BG");
$order->setBillingAddressSameAsShipment();
    
//HEADS UP !!!
$myUniqueReference = md5($myOrder['id'); // You must provide unique reference to shippii. It does not matter how you are gonna create it. It's totally up to you. It must be UNIQUE!!! Improvise :) P.S There is validation on our side also
$order->setReference($myUniqueReference);

// You will be provided for the suitable rate id. In the near future there will be a method and you will be able to fetch them based on your request;
$order->setShippingRateId("96vyGZ");

$payFromWallet = true; // If you set this to false, Shippii will return redirect url where you should redirect your customer for the payment of the shipment. Otherwise Shippii will deduct the amount of the shipment from your company wallet
$order->setPayFromWallet($payFromWallet)

$items = [
    [
        'name' => 'Man Shoes', // required
        'ean' => '1232131212', // optional
        'price' => 50.00, // float. required This is the price for SINGLE item
        'quantity' => 1, // int/float required This is the quantity shipped.
        'weight' => 3.21, // float required The weight of the SINGLE item
        'sku' => 'My Shop Item Id' // You can put your Item ID here for instance.
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

    try {
        $order->setOrderItem($orderItem);
    } catch (TypeError $error) {
        print $error->getMessage();
    }
}

// Here we do the actual order

try {
    $response = $shippii->setOrder($order)->sendOrder();
    
    //Example Response. Keep in mind the reference will be yours this is just for testing.
    /*array:6 [▼
      "headers" => array:9 [▼
        "Server" => array:1 [▶]
        "Content-Type" => array:1 [▶]
        "Transfer-Encoding" => array:1 [▶]
        "Connection" => array:1 [▶]
        "Cache-Control" => array:1 [▶]
        "Date" => array:1 [▶]
        "X-Frame-Options" => array:1 [▶]
        "X-XSS-Protection" => array:1 [▶]
        "X-Content-Type-Options" => array:1 [▶]
      ]
      "request" => null
      "success" => true
      "http_code" => 201
      "message" => "Order received successfully."
      "data" => array:8 [▼
        "id" => "QR8V6K"
        "shippii_reference" => "SHIPPII-fc6137c0-238f-4f2c-aaae-d63376a20a3b"
        "reference" => "89120"
        "status" => "Queued"
        "urls" => {#136 ▶}
            "labels_scheduled_for_creation" => true
        "labels_scheduled_creation_time" => "2019-08-30 16:51:39"
        "created_at" => "2019-08-30 16:51:29"
      ]
    ]*/
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
}
```

To Make Bulk Orders
```php
use Shippii\Orders\Order;
use Shippii\Orders\OrderItem;
use Shippii\Shippii;

$token = 'YOUR APP TOKEN';
$testMode = true;
$urls = Shippii::APP_URLS;
//Example Response App urls

    /*array:3 [▼
      "live_env" => "https://api.shippii.com/"
      "dev_env" => "https://test-api.shippii.com/"
      "stage_env" => "https://stage-api.shippii.com/"
    ]
    */
$url = $urls['dev_env'];

$shippii = new Shippii($token, $testMode, $url);
$orders = [
    0 => [
        'receiver_first_name' => "John",
        'receiver_last_name' => 'Doe',
        'receiver_email' => 'test-email@gmail.com'
        'receiver_city' => 'Oslo',
        'receiver_mobile' => +475555555,
        'receiver_address' => "Lindebergveien 51 B",
        'receiver_province' => 'Oslo',
        'receiver_country_code' => 'NO',
        'receiver_zip_code' => '1550',
        'items' = [
            [
                'name' => 'Man Shoes', // required
                'ean' => '1232131212', // optional
                'price' => 50.00, // float. required This is the price for SINGLE item
                'quantity' => 1, // int/float required This is the quantity shipped.
                'weight' => 3.21, // float required The weight of the SINGLE item
                'sku' => 'My Shop Item Id' // You can put your Item ID here for instance.
            ]
        ];
    ]
];

$orderToProcess = [];
foreach ($orders as $key => $order) {
    $shippiOrder = new Order();
    $payFromWallet = true; // If you set this to false, Shippii will return redirect url where you should redirect your customer for the payment of the shipment. Otherwise Shippii will deduct the amount of the shipment from your company wallet
    $shippiOrder->setPayFromWallet($payFromWallet);
    //$orderPrepare->setReceiverFirstName($shippingAddress->first_name);
    $shippiOrder->setReceiverFirstName($order['receiver_first_name']);
    $shippiOrder->setReceiverLastName($order['receiver_last_name']);
    $shippiOrder->setReceiverAddress($order['receiver_address']);
    $shippiOrder->setReceiverEmail($order['receiver_email']);
    $shippiOrder->setReceiverCity($order['receiver_city']);
    $shippiOrder->setReceiverMobile($order['receiver_mobile']);
    $shippiOrder->setReceiverProvince($order['receiver_province']);
    //$orderPrepare->setReceiverZipCode($order['receiver_zip_code']);
    $shippiOrder->setReceiverZipCode("1550");
    //$orderPrepare->setReceiverCountryCode($order['receiver_country_code']);
    $shippiOrder->setReceiverCountryCode("NO");
    $shippiOrder->setShippingMethodId("2");
    $shippiOrder->setBillingAddressSameAsShipment(); 
    //HEADS UP !!!
    $myUniqueReference = md5($myOrder['id'); // You must provide unique reference to shippii. It does not matter how you are gonna create it. It's totally up to you. It must be UNIQUE!!! Improvise :) P.S There is validation on our side also
    $shippiOrder->setReference($myUniqueReference);

    // set items 
    foreach ($order['items'] as $item) {
        $orderItem = new OrderItem();
        $orderItem->setName($item['name']);
        $orderItem->setEan($item['ean']);
        $orderItem->setPrice($item['price']);
        $orderItem->setQuantity($item['quantity']);
        $orderItem->setWeight($item['weight']);
        $orderItem->setSku($item['sku']);
        $shippiOrder->setOrderItem($orderItem);
    }
    $orderToProcess[$key] = $shippiOrder;
}

try {
    $shippii->setOrders($orderToProcess);
    $shippii->sendBulkOrders($orderToProcess);
    //Example Response. Keep in mind the order references will be yours this is just for testing.

    /*array:6 [▼
      "headers" => array:6 [▼
        "Server" => array:1 [▶]
        "Content-Type" => array:1 [▶]
        "Transfer-Encoding" => array:1 [▶]
        "Connection" => array:1 [▶]
        "Cache-Control" => array:1 [▶]
        "Date" => array:1 [▶]
      ]
      "request" => null
      "success" => true
      "http_code" => 201
      "message" => "Order received successfully."
      "data" => array:1 [▼
        "orders" => array:1 [▼
          0 => array:8 [▼
            "id" => "6lXO16"
            "shippii_reference" => "SHIPPII-fcf1eba0-226d-4586-b253-5ee8b485ff8b"
            "reference" => "963972431919"
            "status" => "Queued"
            "urls" => array:2 [▼
              "order_url" => "https://frontend.shipii.com/order/6lXO16"
              "debug_order_url" => "http://shippii-api-new.test/order/6lXO16?signature=162d1f100add9eb3e5990d86b3c31c87e59f938b0c9a857547b7b6545312b8f3"
            ]
            "labels_scheduled_for_creation" => true
            "labels_scheduled_creation_time" => "2019-10-15 15:18:39"
            "created_at" => "2019-10-15 15:18:29"
          ]
        ]
      ]
    ]*/
    
    
} catch (ShippiiValidationException $validationException) {
    print_r($validationException->getValidationErrors());
} catch (ShippiiServerErrorException $shippiiServerErrorException) {
  print_r([
          'message' => $shippiiServerErrorException->getMessage(),
          'shippii_event_id' => $shippiiServerErrorException->getEventId()
  ]);
} catch (ShippiiAuthorizationException $authorizationException) {
    print "You're app does not have the needed token scope";
} catch (ShippiiAuthenticationException $shippiiAuthenticationException) {
  print "You are not authenticated. Please check your token";
} catch (ShippiiEndpointNotFoundException $shippiiEndpointNotfound) {
    print $e->getMessage();
}
```
Get All Shipping Methods
```php
use Shippii\Shippii;
use Shippii\Shipping\ShippingMethods;

    $token = 'YOUR APP TOKEN';
    $testMode = true;

    $shippii = new Shippii($token, $testMode);

    $shippingMethod = new ShippingMethod($shippii);

    try {
        $response = $shippingMethods->getShippingMethods();

        // Example Response
        /* array:6 [▼
             "headers" => array:8 [▶]
             "request" => null
             "success" => true
             "http_code" => 200
             "message" => null
             "data" => array:4 [▼
               0 => array:10 [▼
                 "id" => "96vyGZ"
                 "name" => "Flat"
                 "description" => "Testing"
                 "for_return" => false
                 "max_weight" => "200.000"
                 "max_width" => "9999.000"
                 "max_height" => "9999.000"
                 "max_length" => "9999.000"
                 "on_pallet" => false
                 "rates" => array:2 [▼
                   0 => array:5 [▼
                     "id" => "96vyGZ"
                     "name" => "Asendia 0-30 KG"
                     "for_return" => false
                     "on_pallet" => false
                     "shipping_fee" => "100.000"
                   ]
                   1 => array:5 [▶]
                 ]
               ]
               1 => array:10 [▼
                 "id" => "PGgP6q"
                 "name" => "Flat With Service Point Bring"
                 "description" => "Flat By Bring"
                 "for_return" => false
                 "max_weight" => "500.000"
                 "max_width" => "500.000"
                 "max_height" => "500.000"
                 "max_length" => "500.000"
                 "on_pallet" => false
                 "rates" => array:1 [▼
                   0 => array:5 [▼
                     "id" => "PGrjGL"
                     "name" => "Another Cheap Rate No Service Point"
                     "for_return" => false
                     "on_pallet" => false
                     "shipping_fee" => "8.500"
                   ]
                 ]
               ]
               2 => array:10 [▶]
               3 => array:10 [▶]
             ]
           ] */
        } catch (ShippiiValidationException $validationException) {
            print_r($validationException->getValidationErrors());
        } catch (ShippiiServerErrorException $serverErrorException) {
            print_r([
                'message' => $serverErrorException->getMessage(),
                'shippii_event_id' => $serverErrorException->getEventId()
            ]);
        } catch (ShippiiAuthorizationException $authorizationException) {
            print 'Your app does not have the needed token scope';
        } catch (ShippiiAuthenticationException $authenticationException) {
            print "You are not authenticated. Please check your token.";
        }
    }
```

Get All Shipping Rates
```php
use Shippii\Shippii;
use Shippii\Shipping\ShippingRate;

    $token = 'YOUR APP TOKEN';
    $testMode = true;

    $shippii = new Shippii($token, $testMode);

    $shippingRate = new ShippingRate($shippii);

    try {
        $response = $shippingRate->getShippingRates();

        // Example Response
        /* array:6 [▼
            "headers" => array:6 [▶]
            "request" => null
            "success" => true
            "http_code" => 200
            "message" => null
            "data" => array:2 [▼
                0 => array:22 [▼
                "id" => "vq5jon"
                "name" => "Shipping rate demo"
                "shipping_fee" => null
                "shipping_fuel_surcharge" => null
                "from_postcode" => null
                "to_postcode" => null
                "for_return" => false
                "on_pallet" => false
                "max_weight" => null
                "min_weight" => null
                "max_height" => null
                "min_height" => null
                "max_length" => null
                "min_length" => null
                "max_width" => null
                "min_width" => null
                "is_active" => true
                "shipping_method" => array:16 [▶]
                "receiver_countries" => array:1 [▶]
                "sender_countries" => array:1 [▶]
                "created_at" => "2019-09-05T11:01:06.000000Z"
                "updated_at" => "2019-09-05T11:01:06.000000Z"
                ]
                1 => array:22 [▶]
            ]
        ] */
    }
    } catch (ShippiiValidationException $validationException) {
        print_r($validationException->getValidationErrors());
    } catch (ShippiiServerErrorException $serverErrorException) {
        print_r([
            'message' => $serverErrorException->getMessage(),
            'shippii_event_id' => $serverErrorException->getEventId()
        ]);
    } catch (ShippiiAuthorizationException $authorizationException) {
        print 'Your app does not have the needed token scope';
    } catch (ShippiiAuthenticationException $authenticationException) {
        print "You are not authenticated. Please check your token.";
    }
```

####Get Live Price
```php
$testMode = true;
$token = "Your Token Here";

$shippii = new Shippii($token, $testMode);
$livePrice = new LivePrice($shippii);

$cartItems = [
    [
        'weight' => 5.0, // WEIGHT PER SINGLE ITEM !!!
        'quantity' => 3
    ],
    [
        'weight' => 1.0,
        // WEIGHT PER SINGLE ITEM !!!
        'quantity' => 10,
        // You can set your measurement to be converted to kilograms. So if it's not kilograms put the measurement unit so you will be able to get the correct price
        'weight_measurement' => 'grams'
    ]
];
//Set the props
$livePrice->setReceiverCountryCode('NO')
    ->setReceiverZipCode('1063')
    ->setCartItemsFromArray($cartItems);

//Do the actual request
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
```
##### Example Get Live Price Response
```json
{
  "success": true,
  "message": null,
  "http_code": 200,
  "data": {
    "shipping_method_name": "Flat",
    "shipping_method_id": "96vyGZ",
    "shipping_rate_name": "Asendia 0-30 KG",
    "price": "119.00"
  }
}
```

####Get Single Label For Order/s

```php
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
```
##### Example Get Single Label Response Response
   ```text
   array:6 [▼
     "headers" => array:8 [▶]
     "request" => null
     "success" => true
     "http_code" => 200
     "message" => null
     "data" => array:3 [▼
       "label_created" => true
       "label_url" => "https://shippii-api-petyo.s3.eu-central-1.amazonaws.com/orders/ORKkR7/38ad73e7f7d6c458887b9cee57fd837b1249e6748d0c1d3c6768939a38387dbb.pdf?X-Amz-Content-Sha256= ▶"
       "chunked_labels" => array:2 [▼
         0 => array:1 [▼
           "url" => "https://shippii-api-petyo.s3.eu-central-1.amazonaws.com/orders/ORKkR7/SHIPPIIPR-ErzwXD93ljmJLY6-0.pdf?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4 ▶"
         ]
         1 => array:1 [▼
           "url" => "https://shippii-api-petyo.s3.eu-central-1.amazonaws.com/orders/ORKkR7/SHIPPIIPR-ErzwXD93ljmJLY6-1.pdf?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4 ▶"
         ]
       ]
     ]
   ]
   ```
##### Example Get Label for multiple orders Response
```text
array:6 [▼
  "headers" => array:8 [▶]
  "request" => null
  "success" => true
  "http_code" => 200
  "message" => null
  "data" => array:5 [▼
    "print" => "0"
    "format" => "pdf"
    "orders" => array:1 [▼
      "a1" => "Label was requested successfully via Asendia"
    ]
    "label_status" => "QUEUED"
    "label_url" => null
  ]
]
```