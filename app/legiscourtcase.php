<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class legiscourtcase extends Model
{
  protected $table = 'legiscourtcases';
  protected $fillable = ['legislation_id','Flag_case','orderDatepreparedoc','datepreparedoc_case',
                          'ordeDateSequester','datesetsequester_case','Status_case','dateSequester_case',
                         'resultsequester_case','paidsequester_case','datenextsequester_case','orderDatePublish','resultsell_case',
                         'dateCertificate_case','datePredict_case','pricePredict_case','datePublicsell_case',
                         'datesoldout_case','amountsequester_case','NumAmount_case','noteprepare_case'];

  public function legislationCourtcase()
  {
    return $this->belongsTo(Legislation::class,'legislation_id');
  }
}