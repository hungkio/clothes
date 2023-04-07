<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ip_pos')->nullable();
            $table->bigInteger('parent')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('cut')->nullable();
            $table->integer('receive')->nullable();
            $table->integer('not_receive')->nullable();
            $table->string('note')->nullable();
            $table->string('size')->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->bigInteger('design_id')->nullable();
            $table->integer('produce_id')->nullable();
            $table->integer('produce_quantity')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
         Schema::dropIfExists('products');
    }
}
