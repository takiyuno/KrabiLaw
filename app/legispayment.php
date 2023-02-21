<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class legispayment extends Model
{
  protected $table = 'legispayments';
  protected $fillable = ['legislation_id','legisCompro_id','BankIn',
                         'DateDue_Payment','Gold_Payment','Discount_Payment','Type_Payment','Adduser_Payment','Note_Payment',
                         'Flag_Payment','Jobnumber_Payment','Period_Payment','Date_Payment'];


  public function PaymentTolegislation()
  {
    return $this->belongsTo(Legislation::class,'legislation_id','id');
  }
  public function PaymentToCompro()
  {
    return $this->belongsTo(Legiscompromise::class,'legislation_id','legislation_id');
  }
  public function PaymentToTrackings()
  {
    return $this->hasmany(LegisTrackings::class,'legislation_id','legislation_id');
  }
}
