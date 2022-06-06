<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegislationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legislations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('TypeDB_Legis')->nullable();     //ฐานข้อมูล
            $table->string('Date_legis')->nullable();
            $table->string('Contract_legis')->nullable();
            $table->string('TypeCon_legis')->nullable();   
            $table->date('DateCon_legis')->nullable();      //วันทำสัญญา
            $table->string('Name_legis')->nullable();
            $table->string('Idcard_legis')->nullable();
            $table->string('Address_legis')->nullable();
            $table->string('Phone_legis')->nullable();
            $table->string('BrandCar_legis')->nullable();
            $table->string('register_legis')->nullable();
            $table->string('YearCar_legis')->nullable();
            $table->string('Category_legis')->nullable();
            $table->string('DateDue_legis')->nullable();
            $table->string('Pay_legis')->nullable();        //เงินต้น
            $table->string('TopPrice_legis')->nullable();   //ยอดทั้งสัญญา
            $table->string('DateSue_legis')->nullable();
            $table->string('DateVAT_legis')->nullable();
            $table->string('NameGT_legis')->nullable();
            $table->string('IdcardGT_legis')->nullable();
            $table->string('AddressGT_legis')->nullable();
            $table->string('Realty_legis')->nullable();
            $table->string('Mile_legis')->nullable();         
            $table->string('Period_legis')->nullable();       //ค่างวดผ่อน
            $table->string('Countperiod_legis')->nullable();  //งวดทั้งสัญญา
            $table->string('Interest_legis')->nullable();     //ดอกเบี้ยต่อปี
            $table->string('Beforeperiod_legis')->nullable(); //ค้างงวดที่
            $table->string('Beforemoey_legis')->nullable();   //ยอดชำระแล้ว
            $table->string('Remainperiod_legis')->nullable(); //จากงวดที่
            $table->string('Staleperiod_legis')->nullable();  //ถึงงวดที่
            $table->string('Realperiod_legis')->nullable();   //จำนวนงวดที่ค้างจริง
            $table->string('Sumperiod_legis')->nullable();    //เหลือเป็นจำนวนเงิน เท่าไร
            $table->string('Note')->nullable();
            $table->string('Flag')->nullable();               //สถานะ Y = งานฟ้อง C = งานประนอมหนี้

            $table->string('Status_legis')->nullable();       //สถานะ
            $table->string('UserStatus_legis')->nullable();   //User เลือกสถานะ
            $table->string('DateStatus_legis')->nullable();   //วันที่ปิดบัญชี
            $table->string('PriceStatus_legis')->nullable();  //ยอดตั้งต้น
            $table->string('txtStatus_legis')->nullable();    //ยอดชำระ
            $table->string('Discount_legis')->nullable();     //ส่วนลด
            $table->string('Paidamount_legis')->nullable();   //ยอดชำระแล้ว
            $table->string('CostPrice_legis')->nullable();    //ต้นทุน
            $table->string('DateUpState_legis')->nullable();  //วันที่ลงสถานะ

            $table->string('Flag_Class')->nullable();               //สถานะลูกหนี้ตามชั้นต่างๆ
            $table->string('Flag_status')->nullable();              //สถานะ 1 = ลูกหนี้เตรียมฟ้อง 2 = ส่งทนาย 3 = ประนอมเก่า
            $table->string('Datesend_Flag')->nullable();            //วันที่ส่งงานให้ทีมทนาย
            $table->string('Noteby_legis')->nullable();             //หมายเหตุจากทีมวิเคราะห์
            $table->string('UserSend1_legis')->nullable();          //ชื่อ user ส่งฟ้อง
            $table->string('UserSend2_legis')->nullable();          //ชื่อ user เตรียมฟ้อง

            $table->string('UseClear_Legiscom')->nullable();                        //ชื่อ user ล้างประนอมหนี้
            $table->date('DateClear_Legiscom')->nullable();                         //วันที่ล้างประนอมหนี้
            $table->integer('CountClear_Legiscom')->default(0)->nullable();         //จำนวนล้างประนอมหนี้

            $table->string('Terminatebuyer_list')->nullable();      //สัญญาบอกเลิกผู้ซื้อ
            $table->string('Terminatesupport_list')->nullable();    //สัญญาบอกเลิกผู้ค้ำ
            $table->string('Acceptbuyerandsup_list')->nullable();   //ใบตอบรับผู้ซื้อ - ผู้ค้ำ
            $table->string('Twodue_list')->nullable();              //หนังสือ 2 งวด
            $table->string('AcceptTwodue_list')->nullable();        //ใบตอบรับหนังสือ 2 งวด
            $table->string('Confirm_list')->nullable();             //หนังสือยืนยันการบอกเลิก
            $table->string('Accept_list')->nullable();              //ใบตอบรับ
            $table->string('Notice_list')->nullable();              //หนังสือโนติสผู้ซื้อ - ผู้ค้ำ
            $table->string('AcceptTwoNotice_list')->nullable();     //ใบตอบรับโนติสผู้ซื้อ - ผู้ค้ำ
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
        Schema::dropIfExists('legislations');
    }
}
