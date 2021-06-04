# Webhooks
## Initialize Webhook class
`$signature = $_SERVER['HTTP_SIGNATURE'];`
`$wh = new \Shippii\Webhooks\Webhook($signature, '510');`
- From there you can validate the request.
```
$wh->isValid();
```
- Also check the event type coming
```
$wh->event()
```
- After this access the main Order Object. ($payload being the request - which is described bellow)
```
$orderObject = $wh->getOrderObject($payload)
```
---
## the $orderObject has these available methods
- getOrderStatus()
- getOrderId()
- getOrderReference()
- getOrderShippingMethod()
- getOrderCarrier()
- getOrderLabelObject()
    - getLabelUlr()
    - getNumberOfLabels()
- getOrderReceiverObject()
    - getReceiverName()
    - getReceiverEmail()
    - getReceiverMobile()
    - getReceiverCountryName()
    - getReceiverCountryCode()
    - getReceiverCity()
    - getReceiverAddress()
    - getReceiverZipCode()
- getOrderItemsObject()
    - getItemNames()
    - getItemSkus()
    - getItemEans()
    - getItemWeights()
    - getItemVolumes()
    - getItemQuantities()
- getCarrierParcelObject()
    - getCarrierOrderNumber()
    - getCarrierTrackingUrl()
    - getCarrierParcels()
---
## Example Event Data
## single-order-labels-created
### This event is triggered when an order label is created.
```
{
    "event-type": "single-order-labels-created",
    "order_id": "Gogbqe",
    "reference": "pancho1",
    "order_status": "Ready for Print",
    "order": {
        "id": "Gogbqe",
        "reference": "pancho1",
        "shipping_method": "Test method",
        "carrier": "Budbee",
        "created_at": "2021-02-18 14:19:38",
        "receiver": {
            "first_name": "John",
            "last_name": "Smith",
            "email": "email@vconnect.dk",
            "mobile": "+4574422385",
            "country": {
                "name": "Denmark",
                "code": "DK"
            },
            "city": "nostrum",
            "address": "true",
            "zip_code": "8460"
        },
        "items": [{
            "name": "Item 0.500kg",
            "sku": "123456",
            "ean": null,
            "weight": "0.7",
            "volume": null,
            "quantity": 3
        }]
    },
    "data": {
        "event-type": "single-order-labels-created",
        "order_id": "Gogbqe",
        "reference": "pancho1",
        "order_status": "Ready for Print",
        "data": {
            "label_url": "https:\/\/shippii-api-bojko.s3.eu-central-1.amazonaws.com\/order_Gogbqe\/6061b5855b537123cb4e0e91dd46af4a6cc396bb22a0a2f80bd14b2e9ae9ef69.pdf?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAIZ5CLJPOKWUO4IDQ%2F20210527%2Feu-central-1%2Fs3%2Faws4_request&X-Amz-Date=20210527T122901Z&X-Amz-SignedHeaders=host&X-Amz-Expires=86400&X-Amz-Signature=d47ba5cda45091a663d4b1ba77327231691f441e93696b32e678c00ad59790e3",
            "number_of_labels": 1
        },
        "carrier": {
            "carrier_order_number": "YMGM6LMS",
            "carrier_tracking_url": "https:\/\/bdb.ee\/1y7Za1",
            "parcels": [{
                "line": "1",
                "number": "373501099216022394",
                "tracking_url": https://sporing.posten.no/sporing/70722150620943466
            }, {
                "line": "2",
                "number": "373501099216022400",
                "tracking_url": https://sporing.posten.no/sporing/70722150620943466
            }, {
                "line": "3",
                "number": "373501099216022417",
                "tracking_url": https://sporing.posten.no/sporing/70722150620943466
            }, {
                "line": "4",
                "number": "373501099216022424",
                "tracking_url": https://sporing.posten.no/sporing/70722150620943466
            }, {
                "line": "5",
                "number": "373501099216022431",
                "tracking_url": https://sporing.posten.no/sporing/70722150620943466
            }]
        }
    }
}
```
---
## external-order-paid
### This event is triggered when an order from outside of Shippii is paid (for example: from magento)
```
{
    "event-type": "external-order-paid",
    "order_id": "Gogbqe",
    "reference": "pancho1",
    "order_status": "Ready for Print",
    "order": {
        "id": "Gogbqe",
        "reference": "pancho1",
        "shipping_method": "Test method",
        "carrier": "Budbee",
        "created_at": "2021-02-18 14:19:38",
        "receiver": {
            "first_name": "asd",
            "last_name": "asd",
            "email": "b.bojkov@vconnect.dk",
            "mobile": "+4574422385",
            "country": {
                "name": "Denmark",
                "code": "DK"
            },
            "city": "nostrum",
            "address": "true",
            "zip_code": "8460"
        },
        "items": [{
            "name": "Item 0.500kg",
            "sku": "123456",
            "ean": null,
            "weight": "0.7",
            "volume": null,
            "quantity": 3
        }]
    },
    "data": []
}
```
---
## order-printed
### This event is triggered when an order is printed.
```
{
    "event-type": "order-printed",
    "order_id": "Gogbqe",
    "reference": "pancho1",
    "order_status": "Ready for Print",
    "order": {
        "id": "Gogbqe",
        "reference": "pancho1",
        "shipping_method": "Test method",
        "carrier": "Budbee",
        "created_at": "2021-02-18 14:19:38",
        "receiver": {
            "first_name": "asd",
            "last_name": "asd",
            "email": "b.bojkov@vconnect.dk",
            "mobile": "+4574422385",
            "country": {
                "name": "Denmark",
                "code": "DK"
            },
            "city": "nostrum",
            "address": "true",
            "zip_code": "8460"
        },
        "items": [{
            "name": "Item 0.500kg",
            "sku": "123456",
            "ean": null,
            "weight": "0.7",
            "volume": null,
            "quantity": 3
        }]
    },
    "data": {
        "printer": "printer"
    }
}
```
---
## external-status-changed
### This event is triggered when the order status is changed outside of Shippii (For Example: From Magento)
```
{
    "event-type": "external-status-changed",
    "order_id": "Gogbqe",
    "reference": "pancho1",
    "order_status": "Ready for Print",
    "order": {
        "id": "Gogbqe",
        "reference": "pancho1",
        "shipping_method": "Test method",
        "carrier": "Budbee",
        "created_at": "2021-02-18 14:19:38",
        "receiver": {
            "first_name": "asd",
            "last_name": "asd",
            "email": "b.bojkov@vconnect.dk",
            "mobile": "+4574422385",
            "country": {
                "name": "Denmark",
                "code": "DK"
            },
            "city": "nostrum",
            "address": "true",
            "zip_code": "8460"
        },
        "items": [{
            "name": "Item 0.500kg",
            "sku": "123456",
            "ean": null,
            "weight": "0.7",
            "volume": null,
            "quantity": 3
        }]
    },
    "data": {
        "external_status": "status"
    }
}
```
---
## single-order-labels-failed
### This event is triggered when creation of the labels for an order fails.
```
{
    "event-type": "single-order-labels-failed",
    "order_id": "Gogbqe",
    "reference": "pancho1",
    "order_status": "Ready for Print",
    "order": {
        "id": "Gogbqe",
        "reference": "pancho1",
        "shipping_method": "Test method",
        "carrier": "Budbee",
        "created_at": "2021-02-18 14:19:38",
        "receiver": {
            "first_name": "asd",
            "last_name": "asd",
            "email": "b.bojkov@vconnect.dk",
            "mobile": "+4574422385",
            "country": {
                "name": "Denmark",
                "code": "DK"
            },
            "city": "nostrum",
            "address": "true",
            "zip_code": "8460"
        },
        "items": [{
            "name": "Item 0.500kg",
            "sku": "123456",
            "ean": null,
            "weight": "0.7",
            "volume": null,
            "quantity": 3
        }]
    },
    "data": {
        "order_labels_failed": "status"
    }
}
```