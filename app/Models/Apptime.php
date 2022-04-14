<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apptime extends Model
{
    protected $fillable = ['id','que_time','que_app_flag','que_time_name','que_time_start','que_time_end','limitcount','statusday'];
}
