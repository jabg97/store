<?php

namespace Tests\Unit;

use App\Model\Order;
use App\Model\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Email notify test.
     *
     * @return void
     */
    public function emailNotifyTest()
    {
        $product = new Product;
        $product->name = "Test Producto";
        $product->image_url = "http://example.com/";
        $product->price = 10000;
        $product->save();
        $order = new Order;
        $order->costumer_name = "Jaiver Balanta";
        $order->costumer_email = "balantajaiver@gmail.com";
        $order->status = "CREATED";
        $order->product_id = $product->id;
        $order->product->name = "Test Producto";
        $order->product->image_url = "http://example.com/";
        $order->product->price = 10000;
        $this->assertEquals($order->email("Test Message"), "OK");
    }
}
