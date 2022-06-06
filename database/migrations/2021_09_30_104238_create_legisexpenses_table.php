<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegisexpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legisexpenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('legislation_id')->nullable();
            $table->date('Date_expense')->nullable();
            $table->string('Type_expense')->nullable();
            $table->string('Topic_expense')->nullable();
            $table->string('Amount_expense')->nullable();
            $table->string('Note_expense')->nullable();
            $table->string('Contract_expense')->nullable();
            $table->string('Code_expense')->nullable();
            $table->string('Flag_expense')->nullable();
            $table->string('Useradd_expense')->nullable();
            $table->string('Useredit_expense')->nullable();
            $table->string('Receiptno_expense')->nullable();
            $table->string('Transfer_expense')->nullable();
            $table->string('PayAmount_expense')->nullable();
            $table->string('BalanceAmount_expense')->nullable();
            $table->string('LawyerName_expense')->nullable();
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
        Schema::dropIfExists('legisexpenses');
    }
}
