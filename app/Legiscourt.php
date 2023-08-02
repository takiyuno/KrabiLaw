<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Legiscourt extends Model
{
  protected $table = 'legiscourts';
  protected $fillable = ['legislation_id','orderdatecourt','fillingdate_court','law_court','bnumber_court','rnumber_court','capital_court','indictment_court','pricelawyer_court','adjudicate_price','SueNote_court',
                        'orderexamiday','examiday_court','fuzzy_court','examinote_court','orderday_court','ordersend_court','checkday_court','checksend_court','buyer_court','support_court','support1_court',
                        'note_court','social_flag','setoffice_court','sendoffice_court','checkresults_court','sendcheckresults_court','received_court','telresults_court','dayresults_court',
                        'propertied_court','sequester_court','sendsequester_court','NewpursueDate_court','Notepursue_court',
                        'DateComplete_court','User_court','SueNote_court ','Consent_court',
                        'latitude_court','longitude_court','latitude_court2','longitude_court2'];


  public function CourtTolegislation()
  {
    return $this->belongsTo(Legislation::class,'legislation_id','id');
  }
}
