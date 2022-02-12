<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'que_card';
    protected $fillable = ['id','que_n','que_r','que_flag','que_date','que_time','call_time','cid','hn','pname','content','que_app_flag','que_source','que_insert','que_dep','que_time_text','que_cc','screen_status','screen_type','screen_other','speak_count','status','created_at','updated_at'];
}
