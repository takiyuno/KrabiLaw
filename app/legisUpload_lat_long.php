<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class legisUpload_lat_long extends Model
{
    protected $table = 'legisUpload_lat_longs';
    protected $primaryKey = 'Use_id';
    protected $fillable = ['Use_id','Buyer_latlong','Support_latlong','Buyer_note','Support_note'];

    public function Buyerupload()
    {
      return $this->belongsTo(Buyer::class,'Use_id');
    }
}
