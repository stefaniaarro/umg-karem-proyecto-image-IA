<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnotacionFacialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anotacion_facial', function (Blueprint $table) {
            $table->id();
            $table->decimal("rollAngle", 18, 9);
            $table->decimal("panAngle", 18, 9);
            $table->decimal("tiltAngle", 18, 9);
            $table->decimal("detectionConfidence", 18, 9);
            $table->decimal("landmarkingConfidence", 18, 9);
            $table->string("joyLikelihood", 25);
            $table->string("sorrowLikelihood", 25);
            $table->string("angerLikelihood", 25);
            $table->string("surpriseLikelihood", 25);
            $table->string("underExposedLikelihood", 25);
            $table->string("blurredLikelihood", 25);
            $table->string("headwearLikelihood", 25);

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
        Schema::dropIfExists('anotacion_facial');
    }
}
