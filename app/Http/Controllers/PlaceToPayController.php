<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\PlaceToPay;
use Illuminate\Support\Facades\Redirect;

class PlaceToPayController extends Controller
{
    public function __construct()
    {
    }

    public function sync()
    {
        PlaceToPay::sync();
    }

    public function session($id)
    {
        try {
            $order = Order::findOrFail($id);
            $place_to_pay = PlaceToPay::init();
            $request = PlaceToPay::getTestRequest($order);
            $response = $place_to_pay->request($request);
            if ($response->isSuccessful()) {
                $order->request_id = $response->requestId;
                $order->process_url = $response->processUrl;
                $order->save();
                return response()->json(['status' => 200,
                 'url' => $response->processUrl,
                  'message' => $response->toArray()["status"]["message"]]);
            } else {
                return response()->json(['status' => 500,
                 'message' => $response->toArray()["status"]["message"]]);
            }
        } catch (Throwable $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}
