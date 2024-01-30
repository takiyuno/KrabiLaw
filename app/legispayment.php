<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class legispayment extends Model
{
  protected $table = 'legispayments';
  protected $fillable = ['legislation_id','legisCompro_id','BankIn',
                         'DateDue_Payment','Gold_Payment','Payintamt','Disintamt','Discount_Payment','Type_Payment','Adduser_Payment','Note_Payment',
                         'Flag_Payment','Flag','Jobnumber_Payment','Period_Payment','Date_Payment','LPAYD'];


  public function PaymentTolegislation()
  {
    return $this->belongsTo(Legislation::class,'legislation_id','id');
  }
  public function PaymentToCompro()
  {
    return $this->belongsTo(Legiscompromise::class,'legisCompro_id','id');
  }
  public function PaymentToTrackings()
  {
    return $this->hasmany(LegisTrackings::class,'legislation_id','legislation_id');
  }
}
