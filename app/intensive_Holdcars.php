<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class intensive_Holdcars extends Model
{
    protected $table = 'intensive_Holdcars';
    protected $primaryKey = 'Hold_id';
    protected $fillable = ['Contno_hold','StatSold_Homecar','StatPark_Homecar','Name_hold','Brandcar_hold','Number_Regist','Year_Product','Date_hold','Dateupdate_hold','Team_hold','Price_hold',
                          'Statuscar','Status_soldcar','Note_hold','Date_came','Amount_hold','Pay_hold','Datecheck_Capital','Datesend_Stockhome',
                          'Datesend_Letter','DateBuyerget_Letter','Barcode_No','Capital_Account','Capital_Topprice','Note2_hold','Letter_hold',
                          'Date_send','Date_SupportGet','Barcode2','Accept_hold','Date_Accept_hold','Soldout_hold',
                          'Idcard_customer','Address_customer','Phone_customer','Name_support','Idcard_support','Phone_support','Address_support'];
}
