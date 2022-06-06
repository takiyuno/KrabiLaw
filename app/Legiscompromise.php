<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Legiscompromise extends Model
{
  protected $table = 'legiscompromises';
  protected $fillable = ['legislation_id','Date_Promise','Flag_Promise','Type_Promise','TotalSum_Promise','Sum_Promise','TotalPaid_Promise',
                          'Compen_Promise','P_Compen_Promise','TotalCapital_Promise','Payall_Promise','P_Payall_Promise',
                          'DuePay_Promise','P_DuePay_Promise','TotalCost_Promise','FeePrire_Promise','P_FeePrire_Promise','Total_Promise',
                          'ShowDue_Promise','ShowPeriod_Promise',
                          'CompoundTotal_1','FirstManey_1','Due_1','Period_1','Profit_1','PercentProfit_1',
                          'Due_Promise','Discount_Promise','Sum_FirstPromise','Sum_DuePayPromise','Note_Promise','User_Promise'];

  public function ComproTolegislation()
  {
    return $this->belongsTo(Legislation::class,'legislation_id','id');
  }

  public function ComproToPayment()
  {
    return $this->hasOne(legispayment::class,'legislation_id','legislation_id');
  }
}
