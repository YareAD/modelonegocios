<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actores_procesos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proceso');
            $table->foreign('proceso')->references('id')->on('procesos')->cascadeOnDelete();;
            $table->unsignedBigInteger('actor');
            $table->foreign('actor')->references('id')->on('actores')->cascadeOnDelete();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actores_procesos');
    }
};
