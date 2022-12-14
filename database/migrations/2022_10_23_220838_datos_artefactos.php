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
        Schema::create('data_artefactos', function (Blueprint $table) {
            $table->id();
            $table->string('atributo');
            $table->text('descripcion');
            $table->string('tipo');
            $table->string('rango');
            $table->text('excepciones');
            $table->unsignedBigInteger('artefacto');
            $table->foreign('artefacto')->references('id')->on('artefactos')->cascadeOnDelete();
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
        Schema::dropIfExists('data_artefactos');
    }
};
