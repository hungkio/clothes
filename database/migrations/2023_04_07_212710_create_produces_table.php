<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducesTable extends Migration
{
    public function up()
    {
        Schema::create('produces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
         Schema::dropIfExists('produces');
    }
}
