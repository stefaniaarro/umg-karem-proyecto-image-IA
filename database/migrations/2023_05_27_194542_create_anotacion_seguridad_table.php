<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnotacionSeguridadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anotacion_seguridad', function (Blueprint $table) {
            $table->id();
            $table->string("adult", 25);
            $table->string("spoof", 25);
            $table->string("medical", 25);
            $table->string("violence", 25);
            $table->string("racy", 25);


            $table->bigInteger('rec_id')->unsigned()->index();
            $table->foreign('rec_id')->references('id')->on('reconocimiento');

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
        Schema::dropIfExists('anotacion_seguridad');
    }
}
