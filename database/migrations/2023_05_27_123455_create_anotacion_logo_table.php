<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnotacionLogoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anotacion_logo', function (Blueprint $table) {
            $table->id();
            $table->string("description", 500);
            $table->decimal("score", 18, 9);


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
        Schema::dropIfExists('anotacion_logo');
    }
}
