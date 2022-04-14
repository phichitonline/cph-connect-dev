<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appflag extends Model
{
    protected $fillable = ['id','que_date','que_time','hn','que_app_flag','que_dep','que_cc','status'];
}
