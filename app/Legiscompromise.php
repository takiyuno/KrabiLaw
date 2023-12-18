<?php

namespace App;

use App\compromises_firstdue;
use App\compromises_paydue;
use App\Legislation;
use App\legispayment;
use Illuminate\Database\Eloquent\Model;

class Legiscompromise extends Model
{
  protected $table = 'legiscompromises';
  protected $fillable = ['legislation_id','Date_Promise','fdate','Flag_PromiseDT','Flag_Promise','Type_Promise','TotalSum_Promise','Sum_Promise','TotalPaid_Promise',
                          'Compen_Promise','P_Compen_Promise','TotalCapital_Promise','Payall_Promise','P_Payall_Promise',
                          'DuePay_Promise','P_DuePay_Promise','TotalCost_Promise','FeePrire_Promise','P_FeePrire_Promise','Total_Promise',
                          'ShowDue_Promise','ShowPeriod_Promise',
                          'CompoundTotal_1','FirstManey_1','FDue_1','FPeriod_1','Due_1','Period_1','Profit_1','PercentProfit_1',
                          'Due_Promise','Discount_Promise','Sum_FirstPromise','Sum_DuePayPromise','Note_Promise','User_Promise','Flag_PromiseDT','LPAYD','LPAYA','HLDNO','EXP_AMT'];

  public function ComproTolegislation()
  {
    return $this->belongsTo(Legislation::class,'legislation_id','id');
  }

  public function ComproToPayment()
  {
    return $this->hasOne(legispayment::class,'legisCompro_id','id')->latest();
  }
  public function ComproToPaymentAll()
  {
    return $this->hasMany(legispayment::class,'legisCompro_id','id');
  }
  public function legisToDue(){
    return $this->hasMany(compromises_paydue::class,'legisCompro_id','id');
  }
  public function legisToFDue(){
    return $this->hasMany(compromises_firstdue::class,'legisCompro_id','id');
  }

  public function promisesToDue(){
    return $this->hasOne(compromises_paydue::class,'legisCompro_id','id')->whereRaw("FORMAT (cast(ddate as date), 'yyyy-MM') = '".date('Y-m',strtotime(date('Y-m') . "+0 month"))."'");
  }
  public function promisesToFDue(){
    return $this->hasOne(compromises_firstdue::class,'legisCompro_id','id')->whereRaw("FORMAT (cast(ddate as date), 'yyyy-MM') = '".date('Y-m',strtotime(date('Y-m') . "+0 month"))."'");
  }
}
