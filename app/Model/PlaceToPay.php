<?php

namespace App\Model;

use Dnetix\Redirection\PlacetoPay as PlacetoPayLibrary;
use App\Model\Order;

class PlaceToPay
{
    public function __construct()
    {
    }

    public static function init()
    {
        return new PlacetoPayLibrary([
            'login' => config('p2p.login'),
            'tranKey' => config('p2p.tran_key'),
            'url' => config('p2p.url'),
            'rest' => [
                'timeout' => 45,
                'connect_timeout' => 30,
            ]
        ]);
    }

    public static function sync()
    {
        $place_to_pay = self::init();
        $orders = Order::whereNotNull('request_id')->whereIn('status', ['PENDING','CREATED'])->get();
        foreach ($orders as $key => $order) {
            try {
                $response = $place_to_pay->query($order->request_id);
                $status = $response->toArray()["status"]["status"];
                $message = $response->toArray()["status"]["message"];
                if ($response->payment || $status == "PENDING") {
                    if ($status == "APPROVED") {
                        $status = "PAYED";
                    }
                    if ($order->status != $status) {
                        $order->status = $status;
                        $order->save();
                        $order->send($message);
                    }
                }
            } catch (Throwable $e) {
            }
        }
    }

    public static function getTestRequest($order)
    {
        return [
            "locale" => "es_CO",
            "payer" => [
                "name" => $order->costumer_name,
                "surname" => "apellido",
                "email" => $order->costumer_email,
                "documentType" => "CC",
                "document" => "1848839248",
                "mobile" => $order->costumer_mobile,
                "address" => [
                    "street" => "703 Dicki Island Apt. 609",
                    "city" => "North Randallstad",
                    "state" => "Antioquia",
                    "postalCode" => "46292",
                    "country" => "US",
                    "phone" => "363-547-1441 x383"
                ]
            ],
            "buyer" => [
                "name" => "Kellie Gerhold",
                "surname" => "Yost",
                "email" => "flowe@anderson.com",
                "documentType" => "CC",
                "document" => "1848839248",
                "mobile" => "3006108300",
                "address" => [
                    "street" => "703 Dicki Island Apt. 609",
                    "city" => "North Randallstad",
                    "state" => "Antioquia",
                    "postalCode" => "46292",
                    "country" => "US",
                    "phone" => "363-547-1441 x383"
                ]
            ],
            "payment" => [
                "reference" => $order->id,
                "description" => $order->product->name,
                "amount" => [
                    "taxes" => [
                        [
                            "kind" => "ice",
                            "amount" => 56.4,
                            "base" => 470
                        ],
                        [
                            "kind" => "valueAddedTax",
                            "amount" => 89.3,
                            "base" => 470
                        ]
                    ],
                    "details" => [
                        [
                            "kind" => "shipping",
                            "amount" => 47
                        ],
                        [
                            "kind" => "tip",
                            "amount" => 47
                        ],
                        [
                            "kind" => "subtotal",
                            "amount" => 940
                        ]
                    ],
                    "currency" => "COP",
                    "total" => $order->product->price
                ],
                "items" => [
                    [
                        "sku" => 26443,
                        "name" => $order->product->name,
                        "category" => "physical",
                        "qty" => 1,
                        "price" => $order->product->price,
                        "tax" => 89.3
                    ]
                ],
                "shipping" => [
                    "name" => "Kellie Gerhold",
                    "surname" => "Yost",
                    "email" => "flowe@anderson.com",
                    "documentType" => "CC",
                    "document" => "1848839248",
                    "mobile" => "3006108300",
                    "address" => [
                        "street" => "703 Dicki Island Apt. 609",
                        "city" => "North Randallstad",
                        "state" => "Antioquia",
                        "postalCode" => "46292",
                        "country" => "US",
                        "phone" => "363-547-1441 x383"
                    ]
                ],
                "allowPartial" => false
            ],
            "expiration" => date('c', strtotime('+1 hour')),
            "ipAddress" => "127.0.0.1",
            "userAgent" => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36",
            "returnUrl" => url('/')."/order/".$order->id,
            "cancelUrl" => url('/')."/order/".$order->id,
            "skipResult" => false,
            "noBuyerFill" => false,
            "captureAddress" => false,
            "paymentMethod" => null
        ];
    }
}
