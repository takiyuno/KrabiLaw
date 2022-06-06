<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LegisPublishsell extends Model
{
    protected $table = 'legis_publishsells';
    protected $primaryKey = 'id';
    protected $fillable = ['id','legislation_id','Dateset_publish','Note_publish','Useradd_publish','Round_publish','Flag_publish'];

    public function PublishTolegislation()
    {
        return $this->belongsTo(Legislation::class,'legislation_id','id');
    }
}
