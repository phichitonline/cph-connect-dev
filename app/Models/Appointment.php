<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['id','que_date','que_time','hn','ptname','que_app_flag','que_dep','que_cc','status'];
}
