<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appflag extends Model
{
    protected $fillable = ['id','que_app_flag','que_app_flage_name','clinic','depcode','spclty','doctor','bgcolor','app_image','classcol','classm','active'];
}
