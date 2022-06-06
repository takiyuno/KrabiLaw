<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegisPublishsellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legis_publishsells', function (Blueprint $table) {
            $table->Integer('id');
            $table->unsignedBigInteger('legislation_id')->nullable();
            $table->date('Dateset_publish')->nullable();
            $table->string('Note_publish')->nullable();
            $table->string('Useradd_publish')->nullable();
            $table->Integer('Round_publish')->nullable();
            $table->string('Flag_publish')->nullable();
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
        Schema::dropIfExists('legis_publishsells');
    }
}
