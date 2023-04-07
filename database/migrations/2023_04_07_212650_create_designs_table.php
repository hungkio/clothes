<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignsTable extends Migration
{
    public function up()
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('progress')->nullable();
            $table->string('duration')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('staff_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
         Schema::dropIfExists('designs');
    }
}
