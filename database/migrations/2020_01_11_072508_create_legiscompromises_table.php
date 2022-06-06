<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegiscompromisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legiscompromises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('legislation_id')->nullable();
            $table->string('Date_Promise')->nullable();         //วันที่ประนอม
            $table->string('Flag_Promise')->nullable();
            $table->string('Type_Promise')->nullable();         //ประเภทประนอมหนี้
            $table->string('Sum_Promise')->nullable();          //ยอดคงเหลือ หลังชำระ
            $table->string('TotalSum_Promise')->nullable();     //ยอดคงเหลือ
            $table->string('TotalPaid_Promise')->nullable();    //ยอดชำระแล้ว //
            $table->string('Compen_Promise')->nullable();       //ยอดค่าขาดประโยชน์   //
            $table->string('P_Compen_Promise')->nullable();     //% ยอดค่าขาดประโยชน์   //
            $table->string('TotalCapital_Promise')->nullable(); //ทุนทรัพย์   //
            $table->string('Payall_Promise')->nullable();       //ยอดเงินก้อนแรก
            $table->string('P_Payall_Promise')->nullable();     //% ยอดเงินก้อนแรก    //
            $table->string('DuePay_Promise')->nullable();       //ชำระต่องวด
            $table->string('P_DuePay_Promise')->nullable();     //% ชำระต่องวด    //
            $table->string('TotalCost_Promise')->nullable();    //ต้นทุน    //
            $table->string('FeePrire_Promise')->nullable();     //ค่าธรรมเนียม/ค่าใช้จ่าย    //
            $table->string('P_FeePrire_Promise')->nullable();   //% ค่าธรรมเนียม/ค่าใช้จ่าย    //
            $table->string('Total_Promise')->nullable();        //ยอดประนอมหนี้
            $table->string('ShowDue_Promise')->nullable();      //ยอดรวม ค่างวด  //
            $table->string('ShowPeriod_Promise')->nullable();   //ยอดรวม ระยะเวลาผ่อน  //
            $table->string('CompoundTotal_1')->nullable();      //ยอดประนอมหนี้   //
            $table->string('FirstManey_1')->nullable();         //เงินก้อนแรก     //
            $table->string('Due_1')->nullable();                //ค่างวด     //
            $table->string('Period_1')->nullable();             //ระยะเวลาผ่อน   //
            $table->string('Profit_1')->nullable();             //กำไรไม่หักภาษี    //
            $table->string('PercentProfit_1')->nullable();      //%
            $table->string('Due_Promise')->nullable();          //จำนวนงวด
            $table->string('Discount_Promise')->nullable();     //ส่วนลด
            $table->string('Sum_FirstPromise')->nullable();     //รวมก้อนแรก
            $table->string('Sum_DuePayPromise')->nullable();    //รวมชำชะค่างวด
            $table->string('Note_Promise')->nullable();
            $table->string('User_Promise')->nullable();
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
        Schema::dropIfExists('legiscompromises');
    }
}
