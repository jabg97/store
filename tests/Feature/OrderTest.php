<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Store order test.
     *
     * @return void
     */
    public function storeOrderTest()
    {
        $response = $this->withHeaders([
            'X-CSRF-TOKEN' => csrf_token(),
        ])->get('/order', ['costumer_name' => 'Jaiver',
            'costumer_email' => 'balantajaiver@gmail.com',
            'costumer_mobile' => '123456789',
            'product_id' => '1']);
        $response->assertStatus(200);
    }

    /**
     * @test
     * Store form validation test.
     *
     * @return void
     */
    public function orderFormValidation()
    {
        $data = ['costumer_name' => 'Jaiver',
            'costumer_email' => 'error_email@gmail.com',
            'costumer_mobile' => '123456789',
            'product_id' => '1'];
        $response = $this->postJson('/order', $data);

        $response->assertStatus(200)
            ->assertJson(['status' => 500, 'message' => "Error en el formulario"]);
    }
}
