<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LegisImage extends Model
{
  protected $table = 'legisimages';
  protected $fillable = ['legislation_id','name_image','size_image','type_image','useradd_image'];
  

  public function ImageTolegislation()
  {
    return $this->belongsTo(Legislation::class,'legislation_id','id');
  }
}
