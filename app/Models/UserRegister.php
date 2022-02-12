<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRegister extends Model
{
    protected $connection = 'mysql';
    protected $table = 'patientusers';
    protected $fillable = ['lineid','cid','hn','hn2','hn3','email','tel','consent','isadmin','que_app_flag'];
    protected $primaryKey = 'lineid';
}
