<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Legislation extends Model
{
  protected $table = 'legislations';
  protected $fillable = ['TypeDB_Legis','Date_legis','Contract_legis','TypeCon_legis',
                        'DateCon_legis','Name_legis','Idcard_legis','Address_legis','Phone_legis',
                        'BrandCar_legis','register_legis','YearCar_legis','Mile_legis',
                        'Category_legis','DateDue_legis','TopPrice_legis','Pay_legis','DateSue_legis','DateVAT_legis',
                        'NameGT_legis','IdcardGT_legis','AddressGT_legis','Realty_legis',
                        'Period_legis','Countperiod_legis','Interest_legis','Beforeperiod_legis','Beforemoey_legis','Remainperiod_legis','Staleperiod_legis','Realperiod_legis','Sumperiod_legis',
                        'Note','Flag','dateStopRev','dateCutOff',
                        'Status_legis','UserStatus_legis','DateStatus_legis','PriceStatus_legis','txtStatus_legis','Discount_legis','Paidamount_legis','CostPrice_legis','DateUpState_legis',
                        'Flag_Class','Flag_status','Datesend_Flag','Noteby_legis','UserSend1_legis','UserSend2_legis','UseClear_Legiscom','DateClear_Legiscom','CountClear_Legiscom',
                        'Terminatebuyer_list','Terminatesupport_list','Acceptbuyerandsup_list','Twodue_list','AcceptTwodue_list',
                        'Confirm_list','Accept_list','Notice_list','AcceptTwoNotice_list'];


  public function legiscourt()
  {
    return $this->hasOne(Legiscourt::class,'legislation_id','id');
  }

  public function legiscourtCase()
  {
    return $this->hasOne(Legiscourtcase::class,'legislation_id','id');
  }

  public function legisCompromise()
  {
    return $this->hasOne(Legiscompromise::class,'legislation_id','id');
  }

  public function legispayments()
  {
    return $this->hasOne(legispayment::class,'legislation_id','id')->latest();
  }

  public function Legisasset()
  {
    return $this->hasOne(legisasset::class,'legislation_id','id');
  }

  public function LegisImage()
  {
    return $this->hasOne(LegisImage::class,'legislation_id','id');
  }

  public function LegisExpense()
  {
    return $this->hasOne(Legisexpense::class,'legislation_id','id');
  }

  public function LegisPublish()
  {
    return $this->hasOne(LegisPublishsell::class,'legislation_id','id');
  }
  
  public function legisTrackings()
  {
    return $this->hasOne(LegisTrackings::class,'legislation_id','id')->latest();
  }
}
