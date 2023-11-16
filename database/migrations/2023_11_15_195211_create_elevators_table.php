<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('elevators', function (Blueprint $table) {
            $table->id();

            $table->integer('floor')->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('elevators');
    }
};
