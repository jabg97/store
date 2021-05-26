<?php

namespace Tests\Unit;

use App\Http\Controllers\PlaceToPayController;
use App\Model\Order;
use App\Model\Product;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlaceToPayTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Status update test.
     *
     * @return void
     */
    public function statusUpdateTest()
    {
        $product = new Product;
        $product->name = "Test Producto";
        $product->image_url = "http://example.com/";
        $product->price = 10000;
        $product->save();
        
        $order = new Order;
        $order->costumer_name = "Jaiver";
        $order->costumer_email = "balantajaiver@gmail.com";
        $order->costumer_mobile = "123456789";
        $order->product_id = $product->id;
        $order->status = "PAYED";
        $order->request_id = 1807197;
        $msg = PlaceToPayController::queryOrder(new PlacetoPay(config('p2p')), $order);
        $this->assertEquals($msg, "El status de la orden ha sido actualizado.");
    }

    /**
     * @test
     * Request ID test.
     *
     * @return void
     */
    public function requestIDTest()
    {
        $order = new Order;
        $order->costumer_name = "Jaiver";
        $order->costumer_email = "balantajaiver@gmail.com";
        $order->costumer_mobile = "123456789";
        $order->status = "CREATED";
        $msg = PlaceToPayController::queryOrder(new PlacetoPay(config('p2p')), $order);
        $this->assertEquals($msg, "El Request ID no existe.");
    }
}
