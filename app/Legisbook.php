<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Legisbook extends Model
{
    protected $table = 'legisbooks';
    protected $primaryKey = 'id';
    protected $fillable = ['OrdinalNumber_book','Datecreate_book','Type_book','Title_book','Fromwhere_book','Towhere_book','Note_book','Dateadd','Useradd','Userupdate'];
}
