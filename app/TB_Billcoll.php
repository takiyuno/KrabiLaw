<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_Billcoll extends Model
{
    protected $table = 'TB_Billcoll';
    protected $fillable = [
        'BILLCOLL','BILLCOLL_NAME'
   ];
}
