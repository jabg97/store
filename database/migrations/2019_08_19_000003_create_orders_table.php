<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('costumer_name', 80);
            $table->string('costumer_email', 120);
            $table->string('costumer_mobile', 40);
            $table->string('status', 20);
            $table->unsignedBigInteger('product_id');
            $table->string('request_id', 20)->nullable()->unique();
            $table->string('process_url', 200)->nullable()->unique();
            $table->foreign('product_id')->references('id')->on('products');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
