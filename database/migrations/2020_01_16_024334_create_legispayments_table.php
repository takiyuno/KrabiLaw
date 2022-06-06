<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegispaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legispayments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('legislation_id')->nullable();
            $table->unsignedBigInteger('legisCompro_id')->nullable();
            $table->string('DateDue_Payment')->nullable();
            $table->integer('Gold_Payment')->nullable();
            $table->integer('Discount_Payment')->nullable();
            $table->string('Type_Payment')->nullable();
            $table->string('Adduser_Payment')->nullable();
            $table->string('Note_Payment')->nullable();
            $table->string('Flag_Payment')->nullable();
            $table->string('Jobnumber_Payment')->nullable();
            $table->string('Period_Payment')->nullable();
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
        Schema::dropIfExists('legispayments');
    }
}
