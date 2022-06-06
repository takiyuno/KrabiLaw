<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegisbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legisbooks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('OrdinalNumber_book')->nullable();
            $table->date('Datecreate_book')->nullable();
            $table->string('Type_book')->nullable();
            $table->string('Title_book')->nullable();
            $table->string('Fromwhere_book')->nullable();
            $table->string('Towhere_book')->nullable();
            $table->string('Note_book')->nullable();
            $table->date('Dateadd')->nullable();
            $table->string('Useradd')->nullable();
            $table->string('Userupdate')->nullable();
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
        Schema::dropIfExists('legisbooks');
    }
}
