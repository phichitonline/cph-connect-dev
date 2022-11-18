<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // protected $connection = 'mysql';
    // protected $table = 'settings';
    protected $fillable = ['id','hos_name','hos_url','hos_tel','hos_facebook','hos_youtube','slide_1_text','slide_2_text','slide_3_text','slide_1_more','slide_2_more',
    'slide_3_more','slide_1_picture','slide_2_picture','slide_3_picture','pr_1','pr_2','pr_3','pr_status','slide_status','dm_status','ext_q_name','ext_q_url',
    'ext_q_img','ext_q_status','module_8','module_7','module_6','module_5','module_4','module_3','module_2','module_1','hoslocation','modulecustom','pinlogin',
    'active_ptregister','active_checkin','created_at','updated_at'];
    // protected $primaryKey = 'lineid';
}
