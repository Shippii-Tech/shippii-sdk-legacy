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

$shippii = new Shippii($token, $testMode);

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
    $order->setOrderItem($orderItem);
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
            "headers" => array:6 [▶]
            "request" => null
            "success" => true
            "http_code" => 200
            "message" => null
            "data" => array:1 [▼
                0 => array:15 [▼
                "id" => "Gogbqe"
                "name" => "Ascendia Shipping Method"
                "description" => "Some shipping method description"
                "fuel_surcharge" => null
                "for_return" => false
                "on_pallet" => false
                "pickup_point" => false
                "pickup_point_id" => null
                "max_weight" => "100.000"
                "max_height" => "100.000"
                "max_length" => "100.000"
                "max_width" => "100.000"
                "is_active" => true
                "created_at" => "2019-09-05T09:16:40.000000Z"
                "updated_at" => "2019-09-05T09:22:43.000000Z"
                ]
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