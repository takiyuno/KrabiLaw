<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class legisasset extends Model
{
  protected $table = 'legisassets';
  protected $fillable = ['legislation_id','Date_asset','Status_asset','Price_asset','propertied_asset','sequester_asset',
                         'sendsequester_asset','Dateresult_asset','NewpursueDate_asset','Notepursue_asset','User_asset',
                         'DateTakephoto_asset','DateGetphoto_asset'];


  public function AssetTolegislation()
  {
    return $this->belongsTo(Legislation::class,'legislation_id','id');
  }
}
