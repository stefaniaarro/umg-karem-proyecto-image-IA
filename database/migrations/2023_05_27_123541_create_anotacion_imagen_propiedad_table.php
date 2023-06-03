<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnotacionImagenPropiedadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anotacion_imagen_propiedad', function (Blueprint $table) {
            $table->id();
            $table->string("color", 100);
            $table->string("score", 25);
            $table->string("pixelFraction", 25);


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
        Schema::dropIfExists('anotacion_imagen_propiedad');
    }
}
