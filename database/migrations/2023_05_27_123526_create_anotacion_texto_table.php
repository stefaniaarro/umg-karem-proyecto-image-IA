<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnotacionTextoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anotacion_texto', function (Blueprint $table) {
            $table->id();
            $table->string("locale", 5);
            $table->longText("description");


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
        Schema::dropIfExists('anotacion_texto');
    }
}
