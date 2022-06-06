<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegiscourtcasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legiscourtcases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('legislation_id')->nullable();
            $table->string('Flag_case')->nullable();
            $table->string('dateCertificate_case')->nullable();      //วันที่คัดหนังสือรับรองคดีถึงที่สุด
            $table->string('datePredict_case')->nullable();      //วันที่ทำหนังสือประเมิณ
            $table->string('pricePredict_case')->nullable();      //ราคาประเมิณ
            $table->string('datePublicsell_case')->nullable();      //วันที่ประกาศขายทอดตลาด
            $table->string('datepreparedoc_case')->nullable();      //วันที่คัดฉโหนด
            $table->string('datesetsequester_case')->nullable();    //วันที่ตั้งเรื่องยึดทรัพย์แรกเริ่ม
            $table->string('dateSequester_case')->nullable();       //วันที่ตั้งเรื่องยึดทรัพย์จริง
            $table->string('Status_case')->nullable();              //สถานะบังคับคดี
            $table->string('resultsequester_case')->nullable();     //ประกาศขาย
            $table->string('paidsequester_case')->nullable();       //เงินค่าใช้จ่าย
            $table->string('datenextsequester_case')->nullable();   //วันที่จ่ายเงิน
            $table->string('resultsell_case')->nullable();          //ผลจากการขาย
            $table->string('datesoldout_case')->nullable();         //วันที่ขายได้
            $table->string('amountsequester_case')->nullable();     //จำนวนเงิน
            $table->string('NumAmount_case')->nullable();           //จำนวนประกาศขาย
            $table->string('noteprepare_case')->nullable();         //หมายเหตุ
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
        Schema::dropIfExists('legiscourtcases');
    }
}
