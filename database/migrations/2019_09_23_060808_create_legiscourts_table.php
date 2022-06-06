<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegiscourtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legiscourts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('legislation_id')->nullable();   
            $table->string('fillingdate_court')->nullable();            //วันฟ้อง
            $table->string('law_court')->nullable();                    //ศาล
            $table->string('bnumber_court')->nullable();                //เลขคดีดำ
            $table->string('rnumber_court')->nullable();                //เลขคดีแดง
            $table->string('capital_court')->nullable();                //ทุนทรัพย์
            $table->string('indictment_court')->nullable();             //ค่าฟ้อง
            $table->string('pricelawyer_court')->nullable();            //ค่าทนาย
            $table->string('examiday_court')->nullable();
            $table->string('fuzzy_court')->nullable();
            $table->string('examinote_court')->nullable();
            $table->string('orderday_court')->nullable();
            $table->string('ordersend_court')->nullable();
            $table->string('checkday_court')->nullable();
            $table->string('checksend_court')->nullable();
            $table->string('buyer_court')->nullable();
            $table->string('support_court')->nullable();
            $table->string('support1_court')->nullable();
            $table->string('note_court')->nullable();
            $table->string('social_flag')->nullable();
            $table->string('setoffice_court')->nullable();
            $table->string('sendoffice_court')->nullable();
            $table->string('checkresults_court')->nullable();
            $table->string('sendcheckresults_court')->nullable();
            $table->string('received_court')->nullable();
            $table->string('telresults_court')->nullable();
            $table->string('dayresults_court')->nullable();
            $table->string('DateComplete_court')->nullable();   //วันที่ฟ้อง
            $table->string('User_court')->nullable();           //user ลงระบบ
            $table->string('Consent_court')->nullable();        //ลูกหนี้ยินยอม
            $table->string('SueNote_court')->nullable();
            $table->string('latitude_court')->nullable();       //ค่า ละติจุต แผนที
            $table->string('longitude_court')->nullable();      //ค่า ลองติจุต แผนที
            $table->string('latitude_court2')->nullable();      //ค่า ละติจุต แผนที
            $table->string('longitude_court2')->nullable();     //ค่า ลองติจุต แผนที
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
        Schema::dropIfExists('legiscourts');
    }
}
