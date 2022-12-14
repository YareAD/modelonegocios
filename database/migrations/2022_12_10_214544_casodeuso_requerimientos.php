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
        Schema::create('casos_de_uso_requerimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('caso_de_uso_id');
            $table->foreign('caso_de_uso_id')->references('id')->on('casos_de_uso')->cascadeOnDelete();
            $table->unsignedBigInteger('requerimiento_id');
            $table->foreign('requerimiento_id')->references('id')->on('requerimientos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
