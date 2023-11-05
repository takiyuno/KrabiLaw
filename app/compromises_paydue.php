<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class compromises_paydue extends Model
{
    protected $table = 'compromises_paydue';
    protected $primaryKey = 'id';

    protected $fillable = ['legislation_id' ,'legisCompro_id' ,'contno' ,'locat' ,'nopay' ,'date1' ,'ddate' ,'damt' ,'payment' ,'capitalbl' ,'daycalint' ,'intamt' ,'delayday'];

}
