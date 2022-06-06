<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegisassetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legisassets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('legislation_id')->nullable();
            $table->string('Date_asset')->nullable();               //วันที่เข้าระบบ
            $table->string('Status_asset')->nullable();             //สถานะสืบ
            $table->string('Price_asset')->nullable();              //ค่าใช้จ่าย
            $table->string('propertied_asset')->nullable();         //สถานะทรัพย์  (มี &&ไม่มี)
            $table->string('sequester_asset')->nullable();          //วันสืบครั้งแรก
            $table->string('sendsequester_asset')->nullable();      //ผลสืบ
            $table->string('Dateresult_asset')->nullable();         //วันเลือกผลสืบ
            $table->string('NewpursueDate_asset')->nullable();      //วันที่สืบทรัพย์ใหม่
            $table->string('Notepursue_asset')->nullable();         //หมายเหตุ 
            $table->string('User_asset')->nullable();
            $table->string('DateTakephoto_asset')->nullable();      //วันที่ส่งถ่ายภาพ
            $table->string('DateGetphoto_asset')->nullable();       //วันที่ได้รับภาพ
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
        Schema::dropIfExists('legisassets');
    }
}
