<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * A basic test example.
     *
     * @return void
     */
    public function basicTest()
    {
        $this->assertTrue(true);
    }
}
