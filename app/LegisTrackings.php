<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LegisTrackings extends Model
{
    protected $table = 'legisTrackings';
    protected $fillable = ['legislation_id','Flag_Track','JobPayment_Track','Status_Track',
                           'JobNumber_Track','Subject_Track','Detail_Track','DateDue_Track','User_Track'];
  
    public function TrackTolegislation()
    {
      return $this->belongsTo(Legislation::class,'legislation_id','id');
    }
}
