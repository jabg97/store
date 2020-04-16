<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codes', function (Blueprint $table) {
            //LLave compuesta por el codigo y el grupo al que pertenece
            $table->string('id', 50);
            $table->string('group', 50);
            $table->string('name', 50);
            $table->string('css', 50)->nullable();
            $table->string('icon', 50)->nullable();
            $table->primary(['id', 'group']);
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
        Schema::dropIfExists('codes');
    }
}
