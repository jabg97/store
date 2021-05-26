<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Order;
use Carbon\Carbon;
use Dnetix\Redirection\PlaceToPay;
use Illuminate\Support\Facades\Redirect;

class PlaceToPayController extends Controller
{
    public function __construct()
    {
    }

    public function sync()
    {
        try {
            $place_to_pay = new PlaceToPay(config('p2p'));
            $orders = Order::whereNotNull('request_id')
                ->where('status', 'PENDING')->get();
            foreach ($orders as $key => $order) {
                try {
                    self::queryOrder($place_to_pay, $order);
                } catch (Throwable $e) {
                }
            }
            return response()->json("OK");
            //return response()->json($status." == ".$message." == ".$response->payment);
        } catch (Throwable $e) {
            return response()->json($e->getMessage());
        }
    }
    public function update($id)
    {
        try {
            $order = Order::findOrFail($id);
            $place_to_pay = new PlaceToPay(config('p2p'));
            self::queryOrder($place_to_pay, $order);
        } catch (Throwable $e) {
        }
        return Redirect::route('order.show', ['order' => $id]);
    }

    public function session($id)
    {
        try {
            $order = Order::findOrFail($id);
            $place_to_pay = new PlaceToPay(config('p2p'));
            $request = self::createTestRequest($order);
            $response = $place_to_pay->request($request);
            if ($response->isSuccessful()) {
                $order->request_id = $response->requestId;
                $order->process_url = $response->processUrl;
                $order->status = "PENDING";
                $order->request_expiration = Carbon::now()
                    ->addMinutes(config('p2p.rest.timeout'));
                $order->save();
                return response()->json(['status' => 200,
                    'url' => $response->processUrl,
                    'message' => $response->status()->message()]);
            } else {
                return response()->json(['status' => 500,
                    'message' => $response->status()->message()]);
            }
        } catch (Throwable $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
    private function createTestRequest($order)
    {

        $faker = \Faker\Factory::create();
        return [
            "locale" => "es_CO",
            "payer" => [
                "name" => $order->costumer_name,
                "surname" => $faker->lastName,
                "email" => $order->costumer_email,
                "mobile" => $order->costumer_mobile,
                "documentType" => "CC",
                "document" => 123456789,
            ],
            "payment" => [
                "reference" => $order->id,
                "description" => $order->product->name,
                "amount" => [
                    "currency" => "COP",
                    "total" => $order->product->price,
                ],
                "items" => [
                    [
                        "sku" => $faker->ean13,
                        "name" => $order->product->name,
                        "category" => "physical",
                        "qty" => 1,
                        "price" => $order->product->price,
                        "tax" => 0.0,
                    ],
                ],
                "allowPartial" => false,
            ],
            "expiration" => date('c', strtotime('+' . config('p2p.rest.timeout') . ' minutes')),
            "ipAddress" => $faker->ipv4,
            "userAgent" => $faker->userAgent,
            "returnUrl" => url('/') . "/api/p2p/update/" . $order->id,
            "cancelUrl" => url('/') . "/api/p2p/update/" . $order->id,
            "skipResult" => false,
            "noBuyerFill" => false,
            "captureAddress" => false,
            "paymentMethod" => null,
        ];
    }
    public static function queryOrder($place_to_pay, $order)
    {
        try {
            if (!$order->request_id) {
                return "El Request ID no existe.";
            }
            $response = $place_to_pay->query($order->request_id);
            $status = $response->status()->status();
            $message = $response->status()->message();
            if ($status == "APPROVED") {
                $status = "PAYED";
            }
            if ($order->status != $status) {
                $order->status = $status;
                $order->save();
                $order->notify($message);
            }
            return "El status de la orden ha sido actualizado.";
        } catch (Throwable $e) {
            return $e->getMessage();
        }
    }
}
