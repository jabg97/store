<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $orders = Order::all();
        return View::make('order.index')->with(compact('orders'));
    }

    public function create($id)
    {
        $product = Product::find($id);
        $products = null;
        if (!$product) {
            $products = Product::all();
        }
        return View::make('order.create')->with(compact('product', 'products'));
    }

    public function store(Request $request)
    {
        try {
            $rules = array(
                'costumer_name' => 'required|max:80',
                'costumer_email' => 'required|email|max:120',
                'costumer_mobile' => 'required|max:40',
                'product_id' => 'required|exists:products,id'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => 500, 'message' => "Error en el formulario", 'messageJSON' => $validator]);
            } else {
                $order = new Order;
                $product = Product::findOrFail($request->product_id);
                $order->costumer_name = $request->costumer_name;
                $order->costumer_email = $request->costumer_email;
                $order->costumer_mobile = $request->costumer_mobile;
                $order->status = "CREATED";
                $order->product()->associate($product);
                $order->save();
                return response()->json(['status' => 200,'url' => route('order.show', [$order->id]), 'message' => 'La orden #' . $order->id . ' ha sido registrada.']);
            }
        } catch (Throwable $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }


    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $products = Product::all();
        return View::make('order.edit')->with(compact('order','products'));
    }

    public function update($id,Request $request)
    {
        try {
            $rules = array(
                'costumer_name' => 'required|max:80',
                'costumer_email' => 'required|email|max:120',
                'costumer_mobile' => 'required|max:40',
                'product_id' => 'required|exists:products,id'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => 500, 'message' => "Error en el formulario", 'messageJSON' => $validator]);
            } else {
                $order = Order::findOrFail($id);
                $product = Product::findOrFail($request->product_id);
                $order->costumer_name = $request->costumer_name;
                $order->costumer_email = $request->costumer_email;
                $order->costumer_mobile = $request->costumer_mobile;
                $order->product()->associate($product);
                $order->save();
                return response()->json(['status' => 200,'url' => route('order.show', [$order->id]), 'message' => 'La orden #' . $order->id . ' ha sido actualizada.']);
            }
        } catch (Throwable $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);    
        return View::make('order.show')->with(compact('order'));
    }

    
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        Alert::success('Exito', 'La orden #' . $order->id . ' ha sido eliminada.');
        return Redirect::to('grados');
    }
}
