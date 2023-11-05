<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class compromises_firstdue extends Model
{
    protected $table = 'compromises_firstdue';
    protected $primaryKey = 'id';

    protected $fillable = ['legislation_id' ,'legisCompro_id' ,'contno' ,'locat' ,'nopay' ,'date1' ,'ddate' ,'damt' ,'payment' ,'capitalbl' ,'daycalint' ,'intamt' ,'delayday'];

}
