<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegisTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legisTrackings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('legislation_id')->nullable();
            $table->string('Flag_Track')->nullable();
            $table->string('JobPayment_Track')->nullable();
            $table->string('Status_Track')->nullable();
            $table->string('JobNumber_Track')->nullable();
            $table->string('Subject_Track')->nullable();
            $table->string('Detail_Track')->nullable();
            $table->date('DateDue_Track')->nullable();
            $table->string('User_Track')->nullable();
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
        Schema::dropIfExists('legisTrackings');
    }
}
