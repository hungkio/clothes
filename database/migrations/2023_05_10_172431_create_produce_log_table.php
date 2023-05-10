<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduceLogTable extends Migration
{
    public function up()
    {
        Schema::create('produce_log', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('produce_id');
            $table->integer('increase');
            $table->timestamps();
        });
    }

    public function down()
    {
         Schema::dropIfExists('produce_log');
    }
}
