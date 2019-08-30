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