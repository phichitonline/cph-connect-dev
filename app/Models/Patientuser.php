<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patientuser extends Model
{
    protected $fillable = ['lineid','cid','hn','hn2','hn3','email','tel','isadmin','que_app_flag','consent','pincode','created_at','updated_at'];
}
