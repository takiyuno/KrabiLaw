<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'contents';
    protected $primaryKey = 'Content_id';
    protected $fillable = ['Locat','Contractno','Sname','Fname','Lname','Casenumber','Filepath','Dateadd','Useradd','Userupdate','Usertake','Datetake'];
}
