<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegisImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legisimages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('legislation_id')->nullable();
            $table->string('name_image')->nullable();
            $table->string('size_image')->nullable();
            $table->string('type_image')->nullable();
            $table->string('useradd_image')->nullable();
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
        Schema::dropIfExists('legisimages');
    }
}
