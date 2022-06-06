<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('Content_id');
            $table->integer('Locat')->nullable();
            $table->string('Contractno')->nullable();
            $table->string('Sname')->nullable();
            $table->string('Fname')->nullable();
            $table->string('Lname')->nullable();
            $table->string('Casenumber')->nullable();
            $table->string('Filepath')->nullable();
            $table->date('Dateadd')->nullable();
            $table->string('Useradd')->nullable();
            $table->string('Userupdate')->nullable();
            $table->string('Usertake')->nullable();
            $table->date('Datetake')->nullable();
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
        Schema::dropIfExists('contents');
    }
}
